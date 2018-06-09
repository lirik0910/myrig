import { createStore, applyMiddleware } from 'redux';
import rootReducer from '../reducers';
import  thunk  from 'redux-thunk';
import { ping } from './middleware/ping';

export default function configureStore(initialState) {
	const store = createStore(
		rootReducer, 
		initialState, 
		applyMiddleware(thunk, ping)
	);

	if (module.hot) {
		module.hot.accept('../reducers', () => {
			const nextRootReducer = require('../reducers');
			store.replaceReducer(nextRootReducer);
		})
	}
	return store;
}