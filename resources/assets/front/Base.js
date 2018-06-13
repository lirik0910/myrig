export default class Base {
	constructor(baseDOM) {
		this.baseDOM = {
			_html: $('html'),
			_body: $('body'),
			_window: $(window),
			_document: $(document),
			_rootContainer: $('#root_container'),
			_linkCartContainer: $('#link-cart__container'),
			_cartButton: $('.cart__button'),
			_csrfToken: $('meta[name="csrf-token"]').attr('content'),
			_loadingContainer: $('#loading__container'),
			_footerContainer: $('#footer__container'),
		}

		this.baseDOM._document.ready(e => {
			this.initDOMElements(e);
			this.onDOMReady(e);
		});
		this.baseDOM._window.on('load', e => this.onLoaded(e));
		this.baseDOM._window.on('resize', e => this.onResized(e));
	}

	initDOMElements(e) {
	}

	onDOMReady(e) {
	}

	onLoaded(e) {
	}

	onResized(e) {
	}

	call(callback = () => {}) {
		callback(this);
	}

	setModuleProps(props = {}) {
		return this.props = props;
	}
}