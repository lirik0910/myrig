import DOMCached from './DOMCached.js';
import Cookies from 'js-cookie';
import { langsOrders } from 'server/Langs.js';

/**
 * Base helper class
 * @class App
 */
export default class Base {

	/**
	 * Cached DOM items
	 * @type {Object}
	 */
	static DOMCached = DOMCached;

	/**
	 * Define all URL props
	 * @return {Object}
	 */
	static getLocationProps() {
		return window.location.search.replace('?', '').split('&').reduce((p, e) => {
			let a = e.split('=');
			if (typeof a[1] !== 'undefined') {
				p[decodeURIComponent(a[0])] = decodeURIComponent(a[1]);
			}
			return p;
		}, {});
	}

	/**
	 * Add properties to URL
	 * @param {String} Key name
	 * @param {String} Value
	 * @retrun {String}
	 */
	static setLocationProp(key, value) {
		key = encodeURI(key);
		value = encodeURI(value);

		let currentValues = document.location.search.substr(1).split('&');
		if (currentValues === '') {
			document.location.search = '?'+ key +'='+ value;
			return document.location.search;
		}

		let i = currentValues.length,
			a;
		while (i--) {
			a = currentValues[i].split('=');

			if (a[0] === key) {
				a[1] = value;
				currentValues[i] = a.join('=');
				break;
			}
		}

		if (i < 0) {
			currentValues[currentValues.length] = [key, value].join('=');
		}

		document.location.search = currentValues.join('&');
		return document.location.search;
	}

	/**
	 * Define array of resource tree
	 * @return {Array}
	 */
	static defineResourceProps() {
		let a = [];
		window.location.pathname.split('/').reduce((p, e) => {
			if(e !== '') {
				a.push(e);
			}
			return true;
		}, []);

		return a;
	}

	static defineCurrentLang(callback = () => {}, part = '') {
		let current = Cookies.get('lang');

		if (typeof current === 'undefined') {
			let lang = window.location.host.split('.')[0];

			if (lang === 'ua' || lang === 'ru') {
				current = lang;
				Cookies.set('lang', lang);
			}

			else {
				current = 'en';
				Cookies.set('lang', 'en');
			}
		}

		return langsOrders(current, part).then(callback);
	}

	/**
	 * Check object is empty
	 * @param {Object}
	 * @return {Boolean}
	 */
	static isEmpty(obj) {
		for(var key in obj) {
			if (obj.hasOwnProperty(key)) {
				return false;
			}
		}
		return true;
	}
}