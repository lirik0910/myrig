
/**
 * Get all users from server
 * @param {number} query
 */
export function findUsers(query = '') {
	return fetch(window.server +'/user?limit=10&start=1&search='+ query, {
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
 * Get all users from server
 * @param {number} query
 */
export function userData(id = 1) {
	return fetch(window.server +'/user/'+ id, {
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