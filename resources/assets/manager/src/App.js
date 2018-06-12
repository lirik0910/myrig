import Api from './Api.json';

/**
 * Base manager methods
 * @class App
 * @author Ihor Bielchenko
 */
class App {

	/**
	 * Base class props
	 * @type {Object} 
	 * @inner
	 * @property {Object} root Core container DOM object 
	 */
	el = {
		root: document.getElementById('root')
	}

	name() {
		return '/manager';
	}

	uploads() {
		return window.global.app.uploadsUrl +'/';
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
	 * Define array of resource tree
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

		return null;
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

	/**
	 * Build and do requset to api
	 * @param {Object} opt Query options
	 */
	api(opt = {}) {
		if (this.isEmpty(opt)) {
			return false;
		}

		var query = '',
			data = '',
			i;
		let xhr = this.xhr();

		if (!Api[opt.model] || !opt.type || !opt.name) {
			return false;
		}

		query += '/'+ opt.model;
		query += '/'+ Api[opt.model][opt.type][opt.name];

		if (opt.resource) {
			query = query.replace(/{id}/gi, opt.resource);
		}

		if (query[query.length - 1] === '/') {
			query = query.substring(0, query.length - 1);
		}
		query = window.global.app.managerApiUrl + query;

		if (typeof opt.formData !== 'undefined') {
			data = opt.formData;
		}

		else if (typeof opt.data !== 'undefined') {
			for (i in opt.data) {
				if (typeof opt.data[i] !== 'object') {
					data += i +'='+ encodeURIComponent(opt.data[i]) +'&';
				}
			}
			data = data.substring(0, data.length - 1);
		}

		if (opt.type === 'GET' && data !== '') {
			query += '?'+ data;
		}
		
		xhr.open(opt.type, query, typeof opt.async === 'boolean' ? opt.async : true);

		if (typeof opt.headers === 'undefined') {
			xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
			xhr.setRequestHeader('X-CSRF-Token', this.csrf());
		}

		else {
			for (i in opt.headers) {
				xhr.setRequestHeader(i, opt.headers[i]);
			}
		}

		xhr.send((data !== '' && opt.type !== 'GET') ? data : null);
		xhr.onreadystatechange = () => {
			if (xhr.readyState === 4) {
				if (xhr.status === 200 || xhr.status === 201) {
					typeof opt.success === 'function' &&
						opt.success(xhr);
				}

				else typeof opt.error === 'function' && 
					opt.error(xhr);
			}
		}
	}
};

export default new App();