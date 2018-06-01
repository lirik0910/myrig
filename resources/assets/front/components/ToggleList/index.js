import Base from '../../Base.js';

/**
 * Default drop-down list
 * @extends Base
 */
export default class ToggleList extends Base {
	/**
	 * Get and save DOM elements
	 * @param {Object} e
	 */
	initDOMElements(e) {
		this.els = {
			_toggleCurrent: $('.toggle__current'),
			_toggleList: $('.toggle__list')
		};
	}

	/**
	 * Invoked when DOM becomes safe to manipulate
	 * @param {Object} e
	 */
	onDOMReady(e) {
		this.els._toggleCurrent.on('click', (e) => this.openToggleList(e));
		this.els._toggleList.on('click', (e) => this.selectItem(e));
	}

	/**
	 * Add event listeners for new form container
	 * @param {Object} e
	 */
	newFormEventListener(formEl) {
		formEl.find('.toggle__current').on('click', (e) => this.openToggleList(e));
		formEl.find('.toggle__list').on('click', (e) => this.selectItem(e));
	}

	/**
	 * Open the drop-down list
	 * @param {Object} e
	 */
	openToggleList(e) {
		let currentTarget = $(e.currentTarget);

		currentTarget.siblings('.toggle__list').toggle();
		currentTarget.toggleClass('show');
	}

	/**
	 * Select element
	 * @param {Object} e
	 */
	selectItem(e) {
		let target = $(e.target),
			currentTarget = $(e.currentTarget),
			currentToggle = currentTarget.siblings('.toggle__current');

		currentTarget.toggle();
		currentToggle.text(target.text());

		currentTarget.siblings('.toggle__input').val(target.data('id'));
		currentToggle.toggleClass('show');
	}
}