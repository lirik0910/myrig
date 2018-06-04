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
			_uaDeliveryMethod: $('.ua-delivery__method'),
			_ruDeliveryMethod: $('.ru-delivery__method'),
			_selfmentDeliveryMethod: $('.selfment-delivery__method'),
			_withoutDeliveryMethod: $('.without-delivery__method')
		};
	}

	/**
	 * Invoked when DOM becomes safe to manipulate
	 * @param {Object} e
	 */
	onDOMReady(e) {
		this.els._countrySelect.select2();
		this.els._countrySelect.on('change', (e) => this.displayDeliveryMethods($(e.currentTarget)));

		this.displayDeliveryMethods(this.els._countrySelect);
	}

	/**
	 * display delivery methods
	 * @param {Object} currentTarget
	 */
	displayDeliveryMethods(currentTarget) {
		switch (currentTarget.val()) {
			case 'UA':
			case 'RU':
				this.els._uaDeliveryMethod.show();
				this.els._uaDeliveryMethod.find('input').prop('checked', true);

				this.els._selfmentDeliveryMethod.show();
				this.els._ruDeliveryMethod.hide();
				this.els._ruDeliveryMethod.find('input').prop('checked', false);

				this.els._withoutDeliveryMethod.val(0);
				this.els._withoutDeliveryMethod.hide();
				break;

			default:
				this.els._uaDeliveryMethod.hide();
				this.els._ruDeliveryMethod.hide();
				this.els._selfmentDeliveryMethod.hide();

				this.els._withoutDeliveryMethod.show();
				this.els._uaDeliveryMethod.find('input').prop('checked', false);
				this.els._ruDeliveryMethod.find('input').prop('checked', false);

				this.els._withoutDeliveryMethod.val(1);
				this.els._selfmentDeliveryMethod.find('input').prop('checked', false);
				break;
		}
	}
}