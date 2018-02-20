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
};

export default new Manager();