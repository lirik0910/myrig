/**
 * Base manager methods
 * @class Manager
 * @author Ihor Bielchenko
 */
class Manager {

	/**
	 * Manager URL adreess
	 * @type {String}
	 * @inner
	 */
	url = '/manager'

	/**
	 * Base class props
	 * @type {Object} 
	 * @inner
	 * @property {Object} root Core container DOM object 
	 */
	props = {
		root: document.getElementById('root')
	}

	/**
	 * Create XMLHttpRequest object
	 * @return XMLHttpRequest object
	 */
	xhr() {
		let XHR = ('onload' in new XMLHttpRequest()) ? XMLHttpRequest : XDomainRequest;
		return new XHR();
	}

	/**
	 * Define all URL props
	 * @return {Object}
	 */
	getLocationProps() {
		return window.location.search.replace('?', '').split('&').reduce((p, e) => {
			var a = e.split('=')
			p[decodeURIComponent(a[0])] = decodeURIComponent(a[1])
			return p
		}, {});
	}

	/**
	 * Define array of resorce tree
	 * @return {Array}
	 */
	defineResourceProps() {
		var a = [];
		window.location.pathname.split('/').reduce((p, e) => {
			if(e !== '') {
				a.push(e);
			}
			return true;
		}, []);
		return a;
	}

	/**
	 * Get token
	 * @return {String}
	 */
	csrf() {
		let csrf = document.getElementById('csrf_token');
		if(csrf) {
			return csrf.content;
		}
	}

	/**
	 * Check object is empty
	 * @param {Object}
	 * @return {Boolean}
	 */
	isEmpty(obj) {
		for(var key in obj) {
			if (obj.hasOwnProperty(key))
				return false;
		}
		return true;
	}
};

export default new Manager();