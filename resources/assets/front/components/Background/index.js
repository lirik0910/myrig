import Base from '../../Base.js';

/**
 * Gray block on the background
 * @extends Base
 */
export default class Background extends Base {
	constructor(props) {
		super(props);
	}

	/**
	 * Get and save DOM elements
	 * @param {Object} e
	 */
	initDOMElements(e) {
		this.els = {
			_darkContainer: $('#dark__container'),
			_darkHelperContainer: $('#dark-helper__container'),
		};
	}

	/**
	 * Invoked when DOM becomes safe to manipulate
	 * @param {Object} e
	 */
	onDOMReady(e) {
		this.getDarkContainerLeftDistance();
	}

	/**
	 * Invoked when window has resized
	 * @param {Object} e
	 */
	onResized(e) {
		this.getDarkContainerLeftDistance();
	}

	/**
	 * Calculate the distance from the left side of the screen for the gray block
	 * @param {Object} baseDOM cached DOM elements
	 * @return {Array}
	 */
	getDarkContainerLeftDistance() {
		return this.els._darkContainer.css({
			left: this.baseDOM._window.width() > 767 ?
				this.els._darkHelperContainer.offset().left :
				0
		});
	}
}