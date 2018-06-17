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
		this.createDots();
		this.initSlider();
	}

	/**
	 * Add dots items
	 */
	createDots() {
		let slidesCount = this.els._relatedSliderContainer.children().length,
			dotsCount = Math.ceil(slidesCount / 3),
			i = 0;

		while (i < dotsCount) {
			this.els._relatedDotsContainer.append('<div class="owl-dot owl-dot__container">'
				+'<button class="slide-dot__button padding__collapse" data-id="'+ i +'">'
					+'<div class="slide-item__progress"></div>'
				+'</button>'
			+'</div>');
			i++;
		}
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
			onInitialized: this.initDotsClick.bind(this),
			onChanged: this.defineCurrentDots,
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
	 * Hang the handler when clicking on the slide button
	 * @param {Object} e
	 */
	initDotsClick(e) {
		$('.slide-dot__button').click((e) => this.changeDot(e));
	}

	/**
	 * Toggle the active slide button
	 * @param {Object} e
	 */
	changeDot(e) {
		let target = $(e.target);

		this.els._relatedSliderContainer.trigger('to.owl.carousel', target.data('id'));

		$('.owl-dot__container').removeClass('active');
		target.parent('.owl-dot__container').addClass('active');
	}

	/**
	 * Define the hidden navigation elements and 
	 * switch the active class to the nearest visible element
	 * @param {Object} e
	 */
	defineCurrentDots(e) {
		let slide = null,
			owlDots = $('.owl-dot__container');
		
		owlDots.each((i, target) => {
			if ($(target).hasClass('active')) {
				
				slide = i + 1;
				$(target).removeClass('active');
			}

			if (i === slide) {
				$(target).addClass('active');
			}
		});

		if (owlDots.length === slide) {
			slide = null;
		}

		if (slide === null) {
			$('.owl-dot__container:first').addClass('active');
		}
	}
}