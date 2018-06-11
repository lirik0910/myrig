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
			_withoutDeliveryMethod: $('.without-delivery__method'),
			_postCheckoutForm: $('#post-checkout__form')
		};
	}

	/**
	 * Invoked when DOM becomes safe to manipulate
	 * @param {Object} e
	 */
	onDOMReady(e) {
		this.els._countrySelect.select2();
		this.els._countrySelect.on('change', (e) => this.displayDeliveryMethods($(e.currentTarget)));
		
		this.els._postCheckoutForm.on('submit', (e) => this.submitCheckoutForm(e));

		this.displayDeliveryMethods(this.els._countrySelect);
	}

	/**
	 * Check and send form
	 * @fires submit
	 * @param {Object} e
	 */
	submitCheckoutForm(e) {
		e.preventDefault();

		let currentTarget = $(e.currentTarget);
		$.ajax({
			url: '/checkout',
			method: 'post',
			headers: {
				'X-CSRF-TOKEN': this.baseDOM._csrfToken
			},
			data: currentTarget.serialize(),
			success: (r) => {
				/** If user not authorized send to login 
				 */
				if (r.session === false) {
					location.href = 'https://pancheckout/order_success/el.myrig.com/login/sso/'+ location.protocol +'//'+ location.host +'/sso-login';
				}

				/** Send to success page
				 */
				if (r.success === true) {
					location.href = location.protocol +'//'+ location.host +'/checkout/order_success/'+ r.order.number;
				}
			}
		});
	}

	/**
	 * display delivery methods
	 * @param {Object} currentTarget
	 */
	displayDeliveryMethods(currentTarget) {
		switch (currentTarget.val()) {
			case 'UA':
                this.els._uaDeliveryMethod.show();
                this.els._uaDeliveryMethod.find('input').prop('checked', true);

                this.els._selfmentDeliveryMethod.show();
                this.els._ruDeliveryMethod.hide();
                this.els._ruDeliveryMethod.find('input').prop('checked', false);

                this.els._withoutDeliveryMethod.val(0);
                this.els._withoutDeliveryMethod.hide();
                break;
			case 'RU':
				this.els._ruDeliveryMethod.show();
				this.els._ruDeliveryMethod.find('input').prop('checked', true);

				this.els._selfmentDeliveryMethod.show();
				this.els._uaDeliveryMethod.hide();
				this.els._uaDeliveryMethod.find('input').prop('checked', false);

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