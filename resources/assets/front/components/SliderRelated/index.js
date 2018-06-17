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
			_relatedDotsContainer: $('#related-dots__container')
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
			dots: false,
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
			// onChanged: this.defineCurrentDots,
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
		console.log(this.els._relatedSliderContainer.children())

		/*$('#related-slider__container .owl-dots').removeClass('disabled');
		$('#related-slider__container .slide-dot__button').each((i, el) => {
			let target = $(el),
				id = target.data('id');
			
			if(id % 3 !== 0 ) {
				target.parent('.owl-dot').hide();
			}
		});*/
	}

	/**
	 * Define the hidden navigation elements and 
	 * switch the active class to the nearest visible element
	 * @param {Object} e
	 */
	defineCurrentDots(e) {
		console.log('wejfowej')
	}
}