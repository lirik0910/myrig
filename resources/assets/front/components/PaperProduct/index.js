import Base from '../../Base.js';
import 'owl.carousel';

/**
 * Product item container
 * @extends Base
 */
export default class PaperProduct extends Base {
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
			_sliderContainer: $('.slider__container'),
			_productContentContainer: $('.product-content__container'),
		};
	}

	/**
	 * Runs after window size changes
	 * @param {Object} e
	 */
	onResized(e) {
		this.setTopBorder();
	}

	/**
	 * Invoked when DOM becomes safe to manipulate
	 * @param {Object} e
	 */
	onDOMReady(e) {
		this.setTopBorder();
	}

	/**
	 * Building the upper border of the block
	 */
	setTopBorder() {
		let width = this.els._sliderContainer.offset().left,
			border = this.els._sliderContainer.children('.border__container');

		border.css({
			width: border.width() + width,
			left: -width,
			backgroundColor: '#F2F2F2'
		});

		this.els._productContentContainer.children('.border__container').css({
			right: -width,
			backgroundColor: '#FFF'
		});
	}
}