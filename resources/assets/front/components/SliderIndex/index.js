import Base from '../../Base.js';
import 'owl.carousel';

/**
 * Slider on the main page
 * @extends Base
 */
export default class IndexSlider extends Base {
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
			_sliderIndex: $('#index-slider__container'),
			_footerContainer: $('#footer__container')
		};
	}

	/**
	 * Invoked when DOM becomes safe to manipulate
	 * @param {Object} e
	 */
	onDOMReady(e) {
		this.initSlider(e => this.sliderHeightAlign());
	}

	/**
	 * Invoked when window has resized
	 * @param {Object} e
	 */
	onResized(e) {
		this.sliderHeightAlign();
	}

	/**
	 * Initialize slider
	 * @param {Object} baseDOM cached DOM elements
	 * @return {Object}
	 */
	initSlider(callback = () => {}) {
		return this.els._sliderIndex.owlCarousel({
			items: 1,
			nav: false,
			dots: true,
			loop: true,
			dotsData: true,
			autoplay: 4000,
			smartSpeed: 1000,
			slideSpeed: 4000,
			animateIn: 'fadeIn',
			animateOut: 'fadeOut',
			onResized: e => callback(e),
			onInitialized: e => callback(e)
		});
	}

	/**
	 * Leveling of slides in height
	 */
	sliderHeightAlign() {
		let bottomDistance = this.baseDOM._window.height() - this.els._footerContainer.height();
		this.els._sliderIndex.css('minHeight', bottomDistance);
	}
}