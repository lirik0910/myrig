/**
 * @module Shop page
 * @author ihor bielchenko
 * @requires ../../App.js
 * @requires pages/index/index.css
 */

import './shop.css';
import App from '../../App.js';

/**
 * Index page entry point
 *
 * @class Index
 * @extends Component
 */
new (class Shop extends App {

	/**
	 * It runs when window was loaded
	 * @fires load
	 * @param {Object} e
	 */
	onReady(e) {
		this.countWidth();

		/**
		 * 
		 */
		$('.btn-count.btn-count-plus').on('click', (el) => {
			console.log(el)
		});
	}

	/**
	 * Define mobile size
	 */
	countWidth() {
		var width = this.dom.width(),
			cont = $('.container').outerWidth();

		var margin = (width - cont) / 2,
			vM = cont * 33.333333 / 100 + margin;

		if (width > 767) {
			$('.main-back').css('left', wM +'px');
		}

		else $('.main-back').css('left', '0px');
	}

	/**
	 * Add product to cart
	 * @fires click
	 */
	addToCart() {

	}
})();