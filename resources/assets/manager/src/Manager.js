/**
 * Base manager methods
 * @class Manager
 * @author Ihor Bielchenko
 */
class Manager {

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

	getLocationProps() {
		return params = location.search.replace('?', '').split('&').reduce((p, e) => {
			var a = e.split('=')
				p[decodeURIComponent(a[0])] = decodeURIComponent(a[1])
				return p
			}, {});
	}
};

export default new Manager();