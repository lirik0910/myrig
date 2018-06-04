import Base from '../../Base.js';

/**
 * Callback dialog block
 * @extends Base
 */
export default class DialogCallback extends Base {
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
			_selector: $(this.props.selector),
			_callbackForm: $('#callback__form'),
			_callbackSuccess: $(this.props.selector).find('.callback-success__container')
		};
	}

	/**
	 * Invoked when DOM becomes safe to manipulate
	 * @param {Object} e
	 */
	onDOMReady(e) {
		this.els._selector.on('click', (e) => this.onClose(e));
		this.els._callbackForm.on('submit', (e) => this.onSubmit(e));
	}

	/**
	 * Show dialog container
	 * @param {Object} e
	 */
	open(e) {
		this.baseDOM._html.css('overflow', 'hidden');
		this.els._selector.fadeIn();
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

		let target = $(e.target);
		$.ajax({
			url: target.attr('action'),
			type: target.attr('method'),
			data: target.serialize(),
			processData: false,
			success: (e) => {
				target.hide();
				this.els._callbackSuccess.show();
			}
		});
	}
}