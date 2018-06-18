import Base from '../../Base.js';

/**
 * Product counter field to add to the cart
 * @extends Base
 */
export default class InputProductCount extends Base {
	/**
	 * Get and save DOM elements
	 * @param {Object} e
	 */
	initDOMElements(e) {
		this.els = {
			_plusIconButton: $('.plus-icon__button'),
			_minusIconButton: $('.minus-icon__button'),
			_cartCountInput: $('.cart-count__input'),
			_deleteButton: $('.delete__button')
		};
	}

	/**
	 * Invoked when DOM becomes safe to manipulate
	 * @param {Object} e
	 */
	onDOMReady(e) {
		this.els._plusIconButton.on('click', (e) => this.produceCounter(e));
		this.els._minusIconButton.on('click', (e) => this.reduceCounter(e));
		this.els._cartCountInput.on('input', (e) => this.inputCounter(e));
		this.els._cartCountInput.on('blur', (e) => this.setDefaultCounter(e));
		this.els._deleteButton.on('click', (e) => {
			$(e.currentTarget)
				.siblings('.cart-count__container')
				.find('.cart__button')
				.trigger('deleteProduct');

			this.baseDOM._footerContainer.trigger('onFooterAlign');
		});
	}

	/**
	 * Add event listeners for new form container
	 * @param {Object} e
	 */
	newFormEventListener(el) {
		let cartCountInput = el.find('.cart-count__input');

		el.find('.plus-icon__button').on('click', (e) => this.produceCounter(e));
		el.find('.minus-icon__button').on('click', (e) => this.reduceCounter(e));
		
		cartCountInput.on('input', (e) => this.inputCounter(e));
		cartCountInput.on('blur', (e) => this.setDefaultCounter(e));
	}

	/**
	 * Increment counter
	 * @fires click
	 * @param {Object} e
	 */
	produceCounter(e) {
		e.preventDefault();

		let currentTarget = $(e.currentTarget),
			input = currentTarget.siblings('.cart-count__input'),
			button = currentTarget.parent('.counter__container').siblings('.cart__button'),
			currentCount = Number(input.val()) + 1;

		input.val(currentCount);

		if (button.hasClass('added-cart__button')) {
			button.trigger('updateCounter');
		}

		this.updatePriceContainers(currentCount, input);
	}

	/**
	 * Decrement counter
	 * @fires click
	 * @param {Object} e
	 */
	reduceCounter(e) {
		e.preventDefault();

		let currentTarget = $(e.currentTarget),
			input = currentTarget.siblings('.cart-count__input'),
			currentCount = Number(input.val()),
			button = currentTarget.parent('.counter__container').siblings('.cart__button');

		if (currentCount > 1) {
			currentCount--;
			input.val(currentCount);

			if (button.hasClass('added-cart__button')) {
				button.trigger('updateCounter');
			}

			this.updatePriceContainers(currentCount, input);
		}
	}

	updatePriceContainers(currentCount, input) {
		let defaultPrice = input.data('default-price');
		if (typeof defaultPrice !== 'undefined') {
			
			let bitcoinPrice = input.data('bitcoin-price'),
				defaultPriceContainer = $('#default-price__container-'+ input.data('id')),
				bitcoinPriceContainer = $('#bitcoin-price__container-'+ input.data('id'));

			defaultPriceContainer.text((currentCount * defaultPrice).toFixed(2));
			bitcoinPriceContainer.text((currentCount * bitcoinPrice).toFixed(4));
		}
	}

	/**
	 * Validate inputed values
	 * @fires input
	 * @param {Object} e
	 */
	inputCounter(e) {
		let regex = /[0-9]|\./,
			currentTarget = $(e.currentTarget);

		if (!regex.test(Number(currentTarget.val()))) {
			currentTarget.val(1);
		}
	}

	/**
	 * Set dfault value if current value isn't property
	 * @fires blur
	 * @param {Object} e
	 */
	setDefaultCounter(e) {
		let currentTarget = $(e.currentTarget),
			currentVal = currentTarget.val(),
			button = currentTarget.parent('.counter__container').siblings('.cart__button');

		if (currentVal === null || currentVal === '' || Number(currentVal) === 0) {
			currentTarget.val(1);
		}

		if (button.hasClass('added-cart__button')) {
			button.trigger('updateCounter');
			this.updatePriceContainers(currentVal, currentTarget);
		}
	}
}