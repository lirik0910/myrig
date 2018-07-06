
/**
 * Get all orders from server
 * @param {number} limit
 * @param {number} start
 * @param {string} query
 */
export function allOrders(limit = 10, start = 1, query = '') {
	return fetch(window.server +'/order?limit='+ limit +'&start='+ start + query, {
		credentials: 'include',
		headers: {
			'Content-type': 'application/x-www-form-urlencoded',
			'X-Requested-With': 'XMLHttpRequest',
			'X-CSRF-Token': window.Base.DOMCached.csrf
		}
	}).then((res) => {
		if (res.status === 200) {
			return res.json();
		}
		else throw new Error(`Response server status: ${res.status}`);
	});
}

/**
 * Get one order from server
 * @param {number} limit
 * @param {number} start
 */
export function oneOrder(id = 0) {
	return fetch(window.server +'/order/'+ id, {
		credentials: 'include',
		headers: {
			'Content-type': 'application/x-www-form-urlencoded',
			'X-Requested-With': 'XMLHttpRequest',
			'X-CSRF-Token': window.Base.DOMCached.csrf
		}
	}).then((res) => {
		if (res.status === 200) {
			return res.json();
		}
		else throw new Error(`Response server status: ${res.status}`);
	});
}

export function updateOrder(cart = [], id = null, callback = () => {}) {
	let query = '',
		form = new FormData(document.getElementById('form-order'));

	form.forEach((value, name) => {
		query += '&'+ name +'='+ value;
	});
	query += '&cart='+ JSON.stringify(cart);

	return fetch(window.server +'/order/'+ id +'?'+ query, {
		credentials: 'include',
		method: 'POST',
		headers: {
			'Content-type': 'application/x-www-form-urlencoded',
			'X-Requested-With': 'XMLHttpRequest',
			'X-CSRF-Token': window.Base.DOMCached.csrf
		}
	}).then((res) => {
		if (res.status === 200) {
			callback();
			return res.json();
		}

		else {
			throw res.json();
		}
	});
}

export function createOrder(cart = [], callback = () => {}) {
	let query = '',
		form = new FormData(document.getElementById('form-order'));

	form.forEach((value, name) => {
		query += '&'+ name +'='+ value;
	});
	query += '&cart='+ JSON.stringify(cart);

	return fetch(window.server +'/order/?'+ query, {
		credentials: 'include',
		method: 'POST',
		headers: {
			'Content-type': 'application/x-www-form-urlencoded',
			'X-Requested-With': 'XMLHttpRequest',
			'X-CSRF-Token': window.Base.DOMCached.csrf
		}
	}).then((res) => {
		if (res.status === 200) {
			callback();
			return res.json();
		}

		else {
			throw res.json();
		}
	});
}

export function postComment(query = '') {
	return fetch(window.server +'/note?'+ query, {
        credentials: 'include',
        method: 'POST',
        headers: {
            'Content-type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-Token': window.Base.DOMCached.csrf
        }
    }).then((res) => {
        if (res.status === 200) {
            return res.json();
        }
        else throw new Error(`Response server status: ${res.status}`);
    });
}

export function trashOrder(query = '', callback = () => {}) {
	return fetch(window.server +'/order/trash?'+ query, {
		credentials: 'include',
		method: 'PUT',
		headers: {
			'Content-type': 'application/x-www-form-urlencoded',
			'X-Requested-With': 'XMLHttpRequest',
			'X-CSRF-Token': window.Base.DOMCached.csrf
		}
	}).then((res) => {
		if (res.status === 200) {
			callback();
			return res.json();
		}
		else throw new Error(`Response server status: ${res.status}`);
	});
}

export function clearOrders(callback = () => {}) {
	return fetch(window.server +'/order/trash', {
		credentials: 'include',
		method: 'DELETE',
		headers: {
			'Content-type': 'application/x-www-form-urlencoded',
			'X-Requested-With': 'XMLHttpRequest',
			'X-CSRF-Token': window.Base.DOMCached.csrf
		}
	}).then((res) => {
		if (res.status === 200) {
			callback();
			return res.json();
		}
		else throw new Error(`Response server status: ${res.status}`);
	});
}