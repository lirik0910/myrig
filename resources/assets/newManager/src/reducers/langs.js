import initialState from './initialStates/langs.js';

/**
 * Return new state
 * @param {Object} initialState Start state object
 * @param {Object} action New state object
 * @return {Object}
 */
export default function langs(state = initialState, action) {
	switch(action.type) {

		/** Update
		 */
		case 'LANGS_GET':
			return { ...action.payload }

		default:
			return { ...state }
	}
}