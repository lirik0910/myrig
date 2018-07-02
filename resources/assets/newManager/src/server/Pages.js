export function getPages() {
	return fetch('/api/manager/pages', {
		method: 'GET',
		mode: 'cors'
	});
}