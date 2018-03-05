/**
 * @file Manager entry point
 * @requires react
 * @requires containers/App.jsx
 * @requires react-dom#render
 * @requires react-redux#Provider
 * @requires store/configureStore.js
 */

import React from 'react';
import App from './App.js';

import { render } from 'react-dom';
import { Provider } from 'react-redux';
import configureStore from './store/configureStore.js';
import { BrowserRouter, Switch, Route } from 'react-router-dom';
import EditPageContainer from './containers/EditPageContainer.jsx';
import ListUsersContainer from './containers/ListUsersContainer.jsx';
import ListPagesContainer from './containers/ListPagesContainer.jsx';
import ListOrdersContainer from './containers/ListOrdersContainer.jsx';
import CreatePageContainer from './containers/CreatePageContainer.jsx';
import FileManagerContainer from './containers/FileManagerContainer.jsx';
import EditProductContainer from './containers/EditProductContainer.jsx';
import ListProductsContainer from './containers/ListProductsContainer.jsx';
import CreateProductContainer from './containers/CreateProductContainer.jsx';

import './index.css';

/** 
 * Redux store configuration
 * @const
 * @type {Object}
 * @global
 */
const store = configureStore();

/** Render all application to root container
 */
render (<BrowserRouter>
			<Provider store={store}>
				<Switch>
					<Route exact path={App.name() +'/pages'} component={ListPagesContainer} />
					<Route exact path={App.name() +'/pages/create'} component={CreatePageContainer} />
					<Route exact path={App.name() +'/pages/:number'} component={EditPageContainer} />
					<Route exact path={App.name() +'/users'} component={ListUsersContainer} />
					<Route exact path={App.name() +'/files'} component={FileManagerContainer} />
					<Route exact path={App.name() +'/orders'} component={ListOrdersContainer} />
					<Route exact path={App.name() +'/products'} component={ListProductsContainer} />
					<Route exact path={App.name() +'/products/create'} component={CreateProductContainer} />
					<Route exact path={App.name() +'/products/:number'} component={EditProductContainer} />
				</Switch>
			</Provider>
		</BrowserRouter>, document.getElementById('root'));