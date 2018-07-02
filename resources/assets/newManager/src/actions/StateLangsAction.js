/** 
 * Set langs array to state
 * @param {Array} langs
 * @param {Function} callback
 * @return {Function}
 */
export function get(langs = {}, callback = () => {}) {
	return (dispatch) => {
		dispatch({
			type: 'LANGS_GET',
			payload: langs
		});
		callback();
	}
}