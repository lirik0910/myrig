import Base from '../../Base.js';

/**
 * Header block
 * @extends Base
 */
export default class Header extends Base {
	constructor(props) {
		super(props);
	}

	/**
	 * Get and save DOM elements
	 * @param {Object} e
	 */
	initDOMElements(e) {
		this.els = {
			_mobileHeaderContainer: $('#mobile-header__container'),
			_navigationToggleButton: $('#navigation-toggle__button'),
			_linkCartContainer: $('#link-cart__container')
		};
	}

	/**
	 * Invoked when DOM becomes safe to manipulate
	 * @param {Object} e
	 */
	onDOMReady(e) {
		/** Remove loading container
		 */
		this.baseDOM._loadingContainer.remove();

		this.els._navigationToggleButton.on('click', (e) => this.onClickedToggleButton(e));
		this.els._linkCartContainer.on('click', (e) => this.checkCartIsEmpty(e));

		this.els._linkCartContainer.on('addProducts', (e, params) => 
			this.addProductsToCart(e, params));
		this.els._linkCartContainer.on('deleteProducts', (e, params) => 
			this.deleteProductsToCart(e, params));

		this.getCartContent();
	}

	/**
	 * Display the menu for the mobile regime
	 * @param {Object} e
	 */
	onClickedToggleButton(e) {
		$(e.currentTarget).toggleClass('hide-toggle__button');
		this.els._mobileHeaderContainer.toggleClass('display-mobile__container');
	}

	/**
	 * Open the shopping cart page if the shopping cart is not empty
	 * @param {Object} e
	 */
	checkCartIsEmpty(e) {
		let currentTarget = $(e.currentTarget),
			counterContainer = currentTarget.find('.cart__counter');

		if (Number(counterContainer.text()) <= 0) {
			e.preventDefault();
		}
	}

	/**
	 * Get cart data from server
	 */
	getCartContent() {
		$.get(window.global.app.connector +'/cart', (r) => {
			let i,
				data,
				a = [],
				counter = 0,
				cartCounter = this.els._linkCartContainer.find('.cart__counter');

			if (r === '' || r === null) {
				sessionStorage['cart'] = JSON.stringify(a);
			}

			else {
				if (typeof r === 'string') {
					data = JSON.parse(data);
				}

				else {
					data = r;
				}

				for (i in data) {
					a.push({ id: i, count: data[i] });
					counter += Number(data[i])
				}

				sessionStorage['cart'] = JSON.stringify(a);
				cartCounter.text(counter);
			}
		});
	}

	/**
	 * Produce products amount in cart
	 * @param {Object} e
	 * @param {Object} params
	 */
	addProductsToCart(e, params) {
		let cartCounter = this.els._linkCartContainer.find('.cart__counter');
		cartCounter.text(Number(cartCounter.text()) + Number(params.count));
	}

	/**
	 * Reduce products amount in cart
	 * @param {Object} e
	 * @param {Object} params
	 */
	deleteProductsToCart(e, params) {
		let cartCounter = this.els._linkCartContainer.find('.cart__counter'),
			newCount = Number(cartCounter.text()) - Number(params.count);

		newCount = newCount > 0 ?
			newCount :
			0;
		cartCounter.text(newCount);
	}
}