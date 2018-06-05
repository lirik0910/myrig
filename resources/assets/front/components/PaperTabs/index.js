import Base from '../../Base.js';

/**
 * Tabs block
 * @extends Base
 */
export default class PaperTabs extends Base {
	/**
	 * Get and save DOM elements
	 * @param {Object} e
	 */
	initDOMElements(e) {
		this.els = {
			_tabItem: $('.tab__item')
		};
	}

	/**
	 * Invoked when DOM becomes safe to manipulate
	 * @param {Object} e
	 */
	onDOMReady(e) {
		this.els = {
			_tabItem: $('.tab__item')
		};

		this.els._tabItem.on('click', (e) => this.switchTabs(e));
	}

	/**
	 * Switch tabs
	 * @param {Object} e
	 */
	switchTabs(e) {
		let target = $(e.currentTarget);

		this.els._tabItem.removeClass('active');
		target.addClass('active');

		$('.content__container.active').removeClass('active');
		$('.content__container[data-id='+ target.data('id') +']').addClass('active');	
	}
}