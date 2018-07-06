import Base from '../../Base.js';

/**
 * Callback dialog block
 * @extends Base
 */
export default class DialogTicket extends Base {
	constructor(props) {
		super(props);
		this.setModuleProps(props);

		this.state = {
			click: false
		};
	}

	/**
	 * Get and save DOM elements
	 * @param {Object} e
	 */
	initDOMElements(e) {
		this._ticketButton = $('#ticket__button');
		this._ticketDialog = $('#ticket__dialog');
		this._ticketForm = $('#ticket__form');
		this._callbackSuccess = this._ticketDialog.find('.callback-success__container');
		this._fileField = $('#file__field');
		this._seletedFileContainer = $('#seleted-file__container');
	}

	/**
	 * Invoked when DOM becomes safe to manipulate
	 * @param {Object} e
	 */
	onDOMReady(e) {
		this._ticketButton.on('click', (e) => this.open(e));
		this._ticketForm.on('submit', (e) => this.onSubmit(e));
		this._ticketDialog.on('click', (e) => this.onClose(e));
		this._fileField.on('change', (e) => this.onFileFieldChanged(e));
	}

	onFileFieldChanged(e) {
		this._seletedFileContainer.html(e.currentTarget.value);
	}

	/**
	 * Show dialog container
	 * @param {object} e
	 */
	open(e) {
		this.baseDOM._html.css('overflow', 'hidden');
		this._ticketDialog.fadeIn();
	}

	/**
	 * Hide dialog container
	 * @param {Object} e
	 */
	hide(e) {
		this.baseDOM._html.css('overflow', 'auto');
		this._ticketDialog.fadeOut();
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
	 * Check button click available state
	 * @param {Object} e
	 */
	changeClickState(e) {
		return this.state.click = !this.state.click;
	}

	/**
	 * Called when the form is submitted
	 * @param {object} e
	 */
	onSubmit(e) {
		e.preventDefault();

		let target = $(e.target),
			button = target.find('.submit__button');

		let data = {};
		target.find('input').each((i, el) => {
			data[$(el).attr('name')] = $(el).val();
		});
		data['message'] = target.find('textarea').val();

		button.toggleClass('loading');
		if (this.state.click === false) {
			this.changeClickState();
		
			$.ajax({
				url: target.attr('action'),
				type: target.attr('method'),
				data: data,
				headers: {
					'X-CSRF-TOKEN': this.baseDOM._csrfToken,
					'cache-control' : 'no-cache'
				},
				success: (e) => {
					target.hide();
					button.toggleClass('loading');
					this._callbackSuccess.show();
					this.changeClickState();
				},
				error: (r) => {
					target.hide();
					button.toggleClass('loading');
					this.changeClickState();
				}
			});
		}
	}
}