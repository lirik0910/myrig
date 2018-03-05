export function show(elements, item, callback = () => {}) {
	return (dispatch) => {
		if (typeof elements[item] !== 'undefined') {
			elements[item] = !elements[item];
		}

		dispatch({
			type: 'VISIBLE_ELEMENTS',
			payload: elements
		});

		callback();
	}
}