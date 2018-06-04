import Base from '../../Base.js';

/**
 * Send cart button
 * @extends Base
 */
export default class ButtonSendToCart extends Base {
	constructor(props) {
		super(props);

		this.state = {
			click: false
		};
	}

	/**
	 * Get and save DOM elements
	 * @param {Object} e
	 */
	initDOMElements(e) {
		this.els = {
			_cartContainer: this.baseDOM._linkCartContainer.find('.cart__counter'),
			_defaultPriceContainer: $('#default-price__container'),
			_bitcoinPriceContainer: $('#bitcoin-price__container')
		};
	}

	/**
	 * Invoked when DOM becomes safe to manipulate
	 * @param {Object} e
	 */
	onDOMReady(e) {
		this.baseDOM._cartButton.on('click', (e) => this.clickProductCartButton(e));
		this.baseDOM._cartButton.on('updateCounter', (e) => this.updateCounterIfAdded(e));
		this.baseDOM._cartButton.on('deleteProduct', (e) => {
			this.clickProductCartButton(e);
		});
	}

	/**
	 * Check button click available state
	 * @param {Object} e
	 */
	changeClickState(e) {
		return this.state.click = !this.state.click;
	}

	/**
	 * Send ptoduct to cart
	 * @fires click
	 * @param {Object} e
	 */
	clickProductCartButton(e) {
		e.preventDefault();

		if (this.state.click === false) {
			this.changeClickState(e);

			let currentTarget = $(e.currentTarget),
				input = currentTarget.siblings('.counter__container').find('.cart-count__input'),
				session = sessionStorage['cart'];

			/** If object cart exists in session
			 */
			if (session) {
				session = JSON.parse(session);

				/** Remove product item container in cart page
				 */
				$('#product-item__container-'+ currentTarget.data('product-id')).remove();

				if (currentTarget.hasClass('add-cart__button')) {
					this.sendProductsToCart(currentTarget, input, session, (r) => 
						this.changeClickState(r));
				}

				else if (currentTarget.hasClass('added-cart__button')) {
					this.deleteProductFromCart(currentTarget, input, session, (r) => 
						this.changeClickState(r));
				}

				else this.changeClickState({});
			}
		}
	}

	/** 
	 * Send products to cart
	 * @param {Object} currentTarget
	 * @param {Object} input
	 * @param {Array} session
	 * @param {Function} callback
	 */
	sendProductsToCart(currentTarget, input, session = [], callback = () => {}) {
		/** Save session on server
		 */
		$.post(window.global.app.connector +'/cart', {
			id: currentTarget.data('product-id'),
			count: input.val(),
			_token: this.baseDOM._csrfToken,
		}, 
		(r) => {
			/** Add product to session
			 */
			session.push({
				id: currentTarget.data('product-id'),
				count: input.val()
			});
			sessionStorage['cart'] = JSON.stringify(session);

			/** Change current button state
			 */
			currentTarget.removeClass('add-cart__button').addClass('added-cart__button');
			currentTarget.html('<span>'+ currentTarget.data('added-text') +'</span>');

			this.baseDOM._linkCartContainer.trigger('addProducts', { count: input.val() });
			callback(r);
		});
	}

	/**
	 * Delete products from cart
	 * @param {Object} currentTarget
	 * @param {Object} input
	 * @param {Array} session
	 * @param {Function} callback
	 */
	deleteProductFromCart(currentTarget, input, session = [], callback = () => {}) {
		let i = 0,
			el,
			defaultPrice = 0,
			bitcoinPrice = 0;
		
		while (i < session.length) {
			if (Number(session[i].id) === Number(currentTarget.data('product-id'))) {
				session.splice(i, 1);
			}

			/** Count amount
			 */
			if (this.els._defaultPriceContainer.length === 1) {
				el = $('#count-products-'+ session[i].id);

				defaultPrice += el.data('default-price') * session[i].count;
				bitcoinPrice += el.data('bitcoin-price') * session[i].count;
			}

			i++;
		}

		/** Send request to server for deleting products from cart
		 */
		$.ajax({
			url: window.global.app.connector +'/cart',
			type: 'DELETE',
			data: {
				id: currentTarget.data('product-id'),
				_token: this.baseDOM._csrfToken
			},
			success: (r) => {
				sessionStorage['cart'] = JSON.stringify(session);

				/** Change current button state
				 */
				currentTarget.removeClass('added-cart__button').addClass('add-cart__button');
				currentTarget.html('<span>'+ currentTarget.data('adding-text') +'</span>');

				this.baseDOM._linkCartContainer.trigger('deleteProducts', { count: input.val() });

				/** Update amount block
				 */
				this.els._defaultPriceContainer.text(defaultPrice.toFixed(2));
				this.els._bitcoinPriceContainer.text(bitcoinPrice.toFixed(4));

				callback(r);
			}
		});
	}

	/**
	 * Count cart counter if product has already added
	 * @fires updateCounter
	 * @param {Object} e
	 */
	updateCounterIfAdded(e) {
		let currentTarget = $(e.currentTarget),
			input = currentTarget.siblings('.counter__container').find('.cart-count__input'),
			session = sessionStorage['cart'];

		if (session) {
			session = JSON.parse(session);

			let i = 0,
				el,
				price = 0,
				counter = 0,
				defaultPrice = 0,
				bitcoinPrice = 0;

			while (i < session.length) {
				if (Number(currentTarget.data('product-id')) === Number(session[i].id)) {
					session[i].count = input.val();
				}
				counter += Number(session[i].count);

				/** Count amount
				 */
				if (this.els._defaultPriceContainer.length === 1) {
					el = $('#count-products-'+ session[i].id);

					defaultPrice += el.data('default-price') * session[i].count;
					bitcoinPrice += el.data('bitcoin-price') * session[i].count;
				}
				i++;
			}

			/** Save session on server
			 */
			$.post(window.global.app.connector +'/cart', {
				id: currentTarget.data('product-id'),
				count: input.val(),
				_token: this.baseDOM._csrfToken,
			}, 
			(r) => {
				this.els._cartContainer.text(counter);
				sessionStorage['cart'] = JSON.stringify(session);

				/** Update amount block
				 */
				this.els._defaultPriceContainer.text(defaultPrice.toFixed(2));
				this.els._bitcoinPriceContainer.text(bitcoinPrice.toFixed(4));
			});
		}
	}
}