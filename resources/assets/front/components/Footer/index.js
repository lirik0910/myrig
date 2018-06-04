import Base from '../../Base.js';

/**
 * Footer block
 * @extends Base
 */
export default class Footer extends Base {
	constructor(props) {
		super(props);
		this.setModuleProps(props);
	}

	/**
	 * Get and save DOM elements
	 * @param {Object} e
	 */
	initDOMElements(e) {
		this.els = {
			_footerContactsItem: $('#footer-contacts__list > .list__item'),
			_connectButton: $('#connect__button'),
			_availabilityCartButton: $('.availability-cart__button')
		};
	}

	/**
	 * Invoked when DOM becomes safe to manipulate
	 * @param {Object} e
	 */
	onDOMReady(e) {
		this.els._footerContactsItem.on('click', (e) => this.switchContactItems(e));

		/** Open callback dialog
		 */
		this.els._connectButton.on('click', (e) => {
			e.preventDefault();
			this.props.dialogCallback.open('#contacts__dialog', e);
		});

		/** Open product availability callback form
		 */
		this.els._availabilityCartButton.on('click', (e) => {
			e.preventDefault();
			this.props.dialogAvailability.open('#availability__dialog', e);
		});
	}

	/**
	 * Switch contact list items
	 * @param {Object} e
	 */
	switchContactItems(e) {
		let target = $(e.target);

		if (target.hasClass('list__item') && !target.hasClass('active')) {
			$('#footer-contacts__list > .list__item.active').removeClass('active');
			target.addClass('active');
		}
	}
}