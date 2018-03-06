/**
 * @module Shop page
 * @author ihor bielchenko
 * @requires ../../App.js
 * @requires pages/index/index.css
 */

import './shop.css';
import 'jquery.session';
import App from '../../App.js';

/**
 * Index page entry point
 *
 * @class Index
 * @extends Component
 */
new (class Shop extends App {

	constructor(props) {
		super(props);

		this.state = {
			click: false
		}
	}

	/**
	 * It runs when window was loaded
	 * @fires load
	 * @param {Object} e
	 */
	onReady(e) {
		this.countWidth();
		this.createOrGetSession();

		/**
		 * 
		 */
		$('.btn-count.btn-count-plus').on('click', (e) => this.plusProduct(e));
		$('.btn-count.btn-count-minus').on('click', (e) => this.minusProduct(e));
		$('.form-number.count.add-to-cart-count').on('input', (e) => this.inputCountProducts(e));
		$('.addtocarts').on('click', (e) => this.addToCart(e));
	}

	createOrGetSession() {
		if (typeof $.session.get('cart') === 'undefined' || !$.session.get('cart')) {
			$.session.set('cart', JSON.stringify([]));
		}
	}

	/**
	 * Define mobile size
	 */
	countWidth() {
		var width = this.dom.window.width(),
			cont = $('.container').outerWidth();

		var margin = (width - cont) / 2,
			wM = cont * 33.333333 / 100 + margin;

		if (width > 767) {
			$('.main-back').css('left', wM +'px');
		}

		else $('.main-back').css('left', '0px');
	}

	inputCountProducts(e) {
		if (e.target.value.length > 6) {
			e.target.value = e.target.value.substr(0, 6);
		}

		if (e.target.value.length <= 0) {
			e.target.value = 1;
		}
		e.target.value = e.target.value.replace(/[^\d]/g, '');
	}

	addToCart(e) {
		e.preventDefault();

		if (this.state.click === false) {
			this.state.click = true;

			var id = e.currentTarget.dataset['id'],
				input,
				cart,
				i,
				a = false;

			if (id) {
				input = $('#count-products-'+ id);
				var session = $.session.get('cart');

				if (input && session) {
					session = JSON.parse(session);
					cart = {};
					for (i = 0; i < session.length; i++) {
						if (Number(session[i].id) === Number(id)) {
							cart = session[i];
							a = i;
							break;
						}
					}

					cart['id'] = id;
					cart['count'] = Number(input.val());

					if (a === false) {
						session.push(cart);
					}
					else session[a] = cart;

					cart['_token'] = window.global.app.csrf;
					$.post(window.global.app.connector +'/cart', cart, () => {
						$.session.set('cart', JSON.stringify(session));
						this.countProducts(session, () => this.state.click = false);
					});
				}
			}
		}
	}

	countProducts(session, callback = () => {}) {
		var count = 0,
			i;

		console.log(session)
		for (i = 0; i < session.length; i++) {
			count += session[i].count;
		}

		$('#cart-count-label').html(count);
		callback();
	}

	/**
	 * Add product to cart
	 * @fires click
	 */
	plusProduct(e) {
		if (this.state.click === false) { 
			this.state.click = true;

			var id = e.currentTarget.dataset['id'],
				current,
				input,
				count;

			if (id) {
				input = $('#count-products-'+ id);
				
				if (input) {
					current = Number(input.val());
					count = current + 1;
					input.val(count);
				}
				this.state.click = false;
			}
		}
	}

	minusProduct(e) {
		if (this.state.click === false) { 
			this.state.click = true;

			var id = e.currentTarget.dataset['id'],
				current,
				input,
				count;

			if (id) {
				input = $('#count-products-'+ id);
				
				if (input) {
					current = Number(input.val());
					count = current - 1;

					if (count > 0) {
						input.val(count);
					}
				}
				this.state.click = false;
			}
		}
	}
})();