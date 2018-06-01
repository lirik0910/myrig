import Base from '../../Base.js';
import 'select2';

export default class FormCheckout extends Base {
	/**
	 * Get and save DOM elements
	 * @param {Object} e
	 */
	initDOMElements(e) {
		this.els = {
			_countrySelect: $('#country__select'),
		};
	}

	/**
	 * Invoked when DOM becomes safe to manipulate
	 * @param {Object} e
	 */
	onDOMReady(e) {
		this.els._countrySelect.select2();
	}
}