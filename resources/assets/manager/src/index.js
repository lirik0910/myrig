/**
 * @file Manager entry point
 * @requires react
 * @requires react-dom#render
 * @requires react-redux#Provider
 * @requires containers/Manager.jsx
 * @requires store/configureStore.js
 */

import React from 'react';
import { render } from 'react-dom';
import { Provider } from 'react-redux';
import { BrowserRouter, Switch, Route } from 'react-router-dom';
import configureStore from './store/configureStore.js';
import './index.css';

import DashboardContainer from './containers/DashboardContainer.jsx';
import UsersContainer from './containers/UsersContainer.jsx';
import PagesContainer from './containers/PagesContainer.jsx';

/** 
 * Redux store configuration
 * @const
 * @type {Object}
 * @global
 */
const store = configureStore();

/*var socket = io(':3001');
socket.on('message', (data) => {
	console.log(data)
});*/

/** 
 * Render all application to root container
 */
render (<BrowserRouter>
			<Provider store={store}>
				<Switch>
					<Route exact path='/' component={DashboardContainer} />
					<Route exact path='/pages' component={PagesContainer} />
					<Route exact path='/users' component={UsersContainer} />
					<Route exact path='/settings' component={DashboardContainer} />
					<Route exact path='/orders' component={DashboardContainer} />
					<Route exact path='/products' component={DashboardContainer} />
					<Route exact path='/tickets' component={DashboardContainer} />
				</Switch>
			</Provider>
		</BrowserRouter>, document.getElementById('root'));