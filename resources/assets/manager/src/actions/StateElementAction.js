export function show(elements, item) {

	if(typeof elements[item] !== 'undefined') {
		elements[item] = !elements[item];
	}

	return {
		type: 'VISIBLE_ELEMENTS',
		payload: elements
	}
}
