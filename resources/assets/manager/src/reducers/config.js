import initialState from './initialStates/config.js';

/**
 * Return new state
 * @param {Object} initialState Start state object
 * @param {Object} action New state object
 * @return {Object}
 */
export default function config(state = initialState, action) {
	switch(action.type) {

		/** Update
		 */
		case 'UPDATE_CONFIG':
			return {...action.payload}

		default:
			return {...state}
	}
}