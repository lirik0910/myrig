import Base from '../../Base.js';

/**
 * Product promo slider
 * @extends Base
 */
export default class SliderPromo extends Base {
	constructor(props) {
		super(props);

		this.state = {
			currentSlidePreview: null,
			preventMobileRegime: false
		}
	}

	/**
	 * Get and save DOM elements
	 * @param {Object} e
	 */
	initDOMElements(e) {
		this.els = {
			_singleSliderContainer: $('.single-slider__container'),
			_verticalSliderContainer: $('.vertical-slider__container'),
		};
	}

	/**
	 * Runs after window size changes
	 * @param {Object} e
	 */
	onResized(e) {
		let mobileFlag = this.checkIsMobileRegime();

		if (this.state.preventMobileRegime !== mobileFlag) {
			this.els._singleSliderContainer.trigger('destroy.owl.carousel');

			mobileFlag === true ?
				this.createSliderForMobile(e => this.changePreventMobileRegimeState(mobileFlag)) :
				this.createSliderForDesctop(e => this.changePreventMobileRegimeState(mobileFlag));
		}
	}

	/**
	 * Runs after the DOM tree is ready
	 * @param {Object} e
	 */
	onDOMReady(e) {
		this.initSingleSlider();
		this.els._verticalSliderContainer.on('click', '.slide__item', e => this.onSlideChange(e));
	}

	/**
	 * Сheck that the mobile version is now enabled
	 * @return {Boolean}
	 */
	checkIsMobileRegime() {
		return this.baseDOM._window.width() <= 991;
	}

	/**
	 * Change prevent regime state
	 * @return {Boolean}
	 */
	changePreventMobileRegimeState(flag = false) {
		return this.state.preventMobileRegime = flag;
	}

	/**
	 * Initialize sliders depending on the current display mode
	 * @param {Object}
	 */
	initSingleSlider() {
		return this.checkIsMobileRegime() === true ? 
			this.createSliderForMobile() :
			this.createSliderForDesctop();
	}

	/**
	 * Create slider for desktop version
	 * @param {Function} callback
	 * @return {Object}
	 */
	createSliderForDesctop(callback = () => {}) {
		return this.els._singleSliderContainer.owlCarousel({
			items : 1,
			nav: false,
			dots: false,
			loop: false,
			navRewind:false,
			touchDrag: false,
			mouseDrag: false,
			dragEndSpeed: 880,
			slideSpeed : 2000,
			onInitialized: e => callback(e),
		}).on('changed.owl.carousel', e => this.onSlideChanged(e));
	}

	/** 
	 * Create slider for mobile version
	 * @param {Function} callback
	 * @return {Object}
	 */
	createSliderForMobile(callback = () => {}) {
		return this.els._singleSliderContainer.owlCarousel({
			items: 1,
			nav: false,
			dots: true,
			dotsData: true,
			dragEndSpeed: 880,
			slideSpeed : 2000,
			onInitialized: e => callback(e),
		});
	}

	/**
	 * Runs when the slide switch event is called
	 * @param {Object} e
	 */
	onSlideChange(e) {
		let currentTarget = this.state.currentSlidePreview = $(e.currentTarget),
			currentSlider = currentTarget.parent().next('.single-slider__container');

		currentSlider.trigger('to.owl.carousel', [ currentTarget.index(), 300, true ]);
			
		let position = currentSlider.find('.owl-item').eq(currentTarget.index()).position();
		currentSlider.find('.owl-stage').css('transform', 'translate3d(0,-'+ position.top+ 'px,0)');
	}

	/**
	 * Runs after changed slide
	 * @param {Object} e
	 */
	onSlideChanged(e) {
		$(e.currentTarget).prev().children('.slide__item.active').removeClass('active');
		
		if (this.state.currentSlidePreview) {
			this.state.currentSlidePreview.addClass('active');
		}
	}
}