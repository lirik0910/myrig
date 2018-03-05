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
import Manager from './Manager.js';
import { BrowserRouter, Switch, Route } from 'react-router-dom';
import configureStore from './store/configureStore.js';
import './index.css';

import DashboardContainer from './containers/DashboardContainer.jsx';
import UsersContainer from './containers/UsersContainer.jsx';
import PagesContainer from './containers/PagesContainer.jsx';
import PageEditContainer from './containers/PageEditContainer.jsx';
import FilesContainer from './containers/FilesContainer.jsx';
import OrdersContainer from './containers/OrdersContainer.jsx';
import ProductsContainer from './containers/ProductsContainer.jsx';
import CreateProductContainer from './containers/CreateProductContainer.jsx';

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
					<Route exact path={Manager.url} component={DashboardContainer} />
					<Route exact path={Manager.url +'/pages'} component={PagesContainer} />
					<Route exact path={Manager.url +'/pages/:number'} component={PageEditContainer} />
					<Route exact path={Manager.url +'/users'} component={UsersContainer} />
					<Route exact path={Manager.url +'/settings'} component={DashboardContainer} />
					<Route exact path={Manager.url +'/orders'} component={OrdersContainer} />
					<Route exact path={Manager.url +'/products'} component={ProductsContainer} />
					<Route exact path={Manager.url +'/products/create'} component={CreateProductContainer} />
					<Route exact path={Manager.url +'/tickets'} component={DashboardContainer} />
					<Route exact path={Manager.url +'/files'} component={FilesContainer} />
				</Switch>
			</Provider>
		</BrowserRouter>, document.getElementById('root'));