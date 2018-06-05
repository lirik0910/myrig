import Base from '../../Base.js';

/**
 * Dialog for availability of goods
 * @extends Base
 */
export default class DialogAvailability extends Base {
	constructor(props) {
		super(props);
		this.setModuleProps(props);

		window.onloadCallback = (e) => {
			let captcha = grecaptcha.render('g-recaptcha', {
				'sitekey' : '6LdY_VMUAAAAANIypbzQz5mga0NnT-PJyASZbJOQ',
				'callback' : this.verifyCallback
			});
		};

		this.state = {
			products: []
		}
	}

	/**
	 * Verified user by recaptcha
	 * @param {String} r
	 */
	verifyCallback(r) {
		$(document).find('#g-recaptcha-response').text(r);
	}

	/**
	 * Get and save DOM elements
	 * @param {Object} e
	 */
	initDOMElements(e) {
		this.els = {
			_selector: $(this.props.selector),
			_callbackForm: $('#availability__form'),
			_callbackSuccess: $(this.props.selector).find('.callback-success__container'),
			_addProductButton: $('#add-product__button'),
			_deleteProductButton: $('#delete-product__button'),
			_productsSelectContainer: $('#products-select__container'),
			_firstProductItemContainer: $('#products-select__container').children('.product-item__container-1'),
			_errorCaptchaContainer: $('#error-captcha__container')
		};
	}

	/**
	 * Invoked when DOM becomes safe to manipulate
	 * @param {Object} e
	 */
	onDOMReady(e) {
		this.els._selector.on('click', (e) => this.onClose(e));
		this.els._addProductButton.on('click', (e) => this.addSelectContainer(e));
		this.els._deleteProductButton.on('click', (e) => this.deleteSelectContainer(e));
		this.els._callbackForm.on('submit', (e) => this.onSubmit(e));
	}

	/**
	 * Show dialog container
	 * @param {String} id
	 * @param {Object} e
	 */
	open(id, e) {
		this.baseDOM._html.css('overflow', 'hidden');
		this.els._selector.fadeIn();

		if (this.state.products.length === 0) {
			this.getProductsList(id, e);
		}
	}

	/**
	 * Hide dialog container
	 * @param {Object} e
	 */
	hide(e) {
		this.baseDOM._html.css('overflow', 'auto');
		this.els._selector.fadeOut();
	}

	/**
	 * Event when the window is closed
	 * @param {Object} e
	 */
	onClose(e) {
		if ($(e.target).attr('class') === 'center__container') {
			this.hide(e);
		}
	}

	/**
	 * Called when the form is submitted
	 * @param {object} e
	 */
	onSubmit(e) {
		e.preventDefault();

		let captcha = $('#g-recaptcha-response').text(),
			currentTarget = $(e.currentTarget),
			button = currentTarget.find('.submit__button');

		if (captcha.length > 0) {
			button.toggleClass('loading');
			this.els._errorCaptchaContainer.hide();

			$.ajax({
				url: window.global.url +'create_report',
				method: 'POST',
				headers: {
					'X-CSRF-TOKEN': this.baseDOM._csrfToken
				},
				data: currentTarget.serialize(),
				success: (r) => {
					button.toggleClass('loading');
				},
			});
		}

		else {
			this.els._errorCaptchaContainer.show();
		}
	}

	/**
	 * Get products list from server
	 * @param {String} id
	 * @param {Object} e
	 */
	getProductsList(id, e) {
		let productId = $(e.currentTarget).data('product-id');

		$.ajax({
			url: window.global.url +'rep-avail',
			method: 'POST',
			headers: {
				'X-CSRF-TOKEN': this.baseDOM._csrfToken
			},
			data: {
				id: productId
			},
			success: (data) => {
				this.state.products = data;

				let i = 0;
				while (i < data.length) {

					/** Render current product to container and set product id
					 */
					if (productId === data[i].id) {
						$('.product-item__container-1 .selected__product').text(data[i].title);
						$('.product-selected__input').val(productId);
					}

					/** Render product list
					 */
					$('.product-item__container-1 .products__list')
						.append('<li class="list__item" data-id="'+ data[i].id +'">'+ data[i].title +'</li>');

					i++;
				}
			}
		});
	}

	/**
	 * Add new select container
	 * @param {Object} e
	 */
	addSelectContainer(e) {
		e.preventDefault();

		let count = this.els._productsSelectContainer.children('.product-item__container').length + 1,
			newForm = this.els._firstProductItemContainer.clone();

		newForm.removeClass('product-item__container-1').addClass('product-item__container-'+ count);
		newForm.appendTo('#products-select__container');
		newForm.find('.toggle__input').val('');
		newForm.find('.toggle__current').text('');
		newForm.find('.product-selected__input').attr('name', 'products['+ count +'][id]');
		newForm.find('.cart-count__input').attr('name', 'products['+ count +'][count]').val('1');

		this.els._deleteProductButton.show();
		this.props.toggleList.newFormEventListener(newForm);
		this.props.inputProductsCount.newFormEventListener(newForm);
	}

	/**
	 * Delete last select container
	 * @param {Object} e
	 */
	deleteSelectContainer(e) {
		e.preventDefault();

		let count = this.els._productsSelectContainer.children('.product-item__container').length;

		if (count > 1) {
			this.els._productsSelectContainer.children('.product-item__container').last().remove();
		}

		if (count === 2) {
			$(e.currentTarget).hide();
		}
	}
}