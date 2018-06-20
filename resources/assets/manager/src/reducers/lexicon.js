import initialState from './initialStates/lexicon.js';

/**
 * Return new state
 * @param {Object} initialState Start state object
 * @param {Object} action New state object
 * @return {Object}
 */
export default function lexicon(state = initialState, action) {
	switch(action.type) {

		/** Update
		 */
		case 'LEXICON_GET':
			return { ...action.payload }

		default:
			return { ...state }
	}
}