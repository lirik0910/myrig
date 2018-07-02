export function get(lexicon, callback = () => {}) {
	return (dispatch) => {
		dispatch({
			type: 'LEXICON_GET',
			payload: lexicon
		});
		callback();
	}
}