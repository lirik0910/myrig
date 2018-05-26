/**
 * @file Include reducers
 * @author Ihor Bielchenko
 * @requires redux#combineReducers
 * @requires reducers/config.js
 * @requires reducers/elements.js
 */

import { combineReducers } from 'redux';
import config from './config.js';
import elements from './elements.js';
export default combineReducers({
	config,
	elements
});