
/**
 * Get all product categories  from server
 */
export function allCategories() {
	return fetch(window.server +'/category', {
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

export function findProduct(query = '') {
	return fetch(window.server +'/product' + query, {
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