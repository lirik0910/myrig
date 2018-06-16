import Base from '../../Base.js';
import 'owl.carousel';

export default class SliderRelated extends Base {
	
	/**
	 * Get and save DOM elements
	 * @param {Object} e
	 */
	initDOMElements(e) {
		this.els = {
			_relatedSliderContainer: $('#related-slider__container'),
		};
	}

	/**
	 * Invoked when DOM becomes safe to manipulate
	 * @param {Object} e
	 */
	onDOMReady(e) {
		this.initSlider();
	}

	/**
	 * Init related products slider
	 */
	initSlider() {
		this.els._relatedSliderContainer.owlCarousel({
			items: 3,
			nav: false,
			dots: true,
			loop: true,
			margin: 20,
			slideBy: 3,
			autoplay: 500,
			dotsData: true,
			// slideSpeed: 500,
			// smartSpeed: 200,
			// animateIn: 'fadeIn',
			// animateOut: 'fadeOut',
			onInitialized: this.redistributeDots,
			// responsiveClass: true,
			responsive:{
				0: {
					items: 1,
					dots: true
				},
				768: {
					items: 2,
					dots: true
				},
				1000: {
					items: 3
				}
			}
		});
	}

	/**
	 * Distribute dots one for each group of slides
	 * @param {Object} e
	 */
	redistributeDots(e) {
		$('#related-slider__container .owl-dots').removeClass('disabled');
		$('#related-slider__container .slide-dot__button').each((i, el) => {
			let target = $(el),
				id = target.data('id');
			
			if(id % 3 !== 0 ){
				target.parent('.owl-dot').hide();
			}
		});
	}
}