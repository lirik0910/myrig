import Base from '../../Base.js';
import 'owl.carousel';

/**
 * Product slider block
 * @extends Base
 */
export default class SliderProduct extends Base {
	constructor(props) {
		super(props);

		this.state = {
			dotClickedFlag: false
		};
	}

	/**
	 * Get and save DOM elements
	 * @param {Object} e
	 */
	initDOMElements(e) {
		this.els = {
			_dotsSliderContainer: $('#dots-slider__container'),
			_productSliderContainer: $('#product-slider__container'),
		};
		this.els['_dotsSlidesCount'] = this.els._dotsSliderContainer.children().length;
	}

	/**
	 * Runs after the DOM tree is ready
	 * @param {Object} e
	 */
	onDOMReady(e) {
		this.initProductSlider();
		this.initDotsSlider(e => this.setFirstSlide(e));
	}

	/**
	 * Init product slider
	 * @param {Function} callback
	 */
	initProductSlider(callback = () => {}) {
		this.els._productSliderContainer.owlCarousel({
			margin: 0,
			nav: false,
			dots: false,
			dotsData: true,
			loop: false,
			smartSpeed: 1000,
			responsiveClass: true,
			responsive: {
				0: {
					items: 1,
					dots:true
				},
				600: {
					items: 1,
					dots:true
				},
				1000: {
					items: 1,
					dots:false
				}
			},
			onInitialized: e => callback(e)
		})
		.on('changed.owl.carousel', (e) => {
			let target = $(e.currentTarget),
				index = e.relatedTarget._current;
			
			if (!this.state.dotClickedFlag) {
				this.els._dotsSliderContainer.
					find('.slide__item.active').
					removeClass('active');
				$(this.els._dotsSliderContainer.find('.slide__item')[index]).addClass('active');

				this.els._dotsSliderContainer.trigger('to.owl.carousel', [index, 300, true]);
			}
		});
	}

	/**
	 * Init slider for dots
	 * @param {Function} callback
	 */
	initDotsSlider(callback = () => {}) {
		this.els._dotsSliderContainer.owlCarousel({
			items: 4,
			nav: false,
			margin: 10,
			loop: false,
			dots: false,
			onInitialized: e => callback(e)
		})
		.on('click', '.owl-item', (e) => {
			let target = $(e.currentTarget),
				index = target.index() + 1,
				remainder = this.els._dotsSlidesCount - index;

			if (this.els._dotsSlidesCount - Math.ceil(index / 4) * 4 <= 0) {
				this.state.dotClickedFlag = true;
			}

			this.els._productSliderContainer.trigger('to.owl.carousel', [target.index(), 300, true]);

			this.els._dotsSliderContainer.find('.slide__item.active').removeClass('active');
			target.children('.slide__item').addClass('active');
		});
	}

	/**
	 * Highlight the first dots slide
	 * @param {Object} e
	 */
	setFirstSlide(e) {
		this.els._dotsSliderContainer
			.find('.owl-item.active')
			.first()
			.children('.slide__item')
			.addClass('active');
	}
}