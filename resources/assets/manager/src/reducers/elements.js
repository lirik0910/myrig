import initialState from './initialStates/elements.js';

/**
 * Return new state
 * @param {Object} initialState Start state object
 * @param {Object} action New state object
 * @return {Object}
 */
export default function elements(state = initialState, action) {
	switch(action.type) {

		/** Update
		 */
		case 'VISIBLE_ELEMENTS':
			return {...action.payload}

		default:
			return {...state}
	}
}