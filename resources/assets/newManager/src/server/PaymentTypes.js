
/**
 * Get all payment types from server
 * @param {number} query
 */
export function allPaymentTypes(query = '') {
	return fetch(window.server +'/payment', {
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