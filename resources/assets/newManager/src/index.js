/**
 * @index.js
 *
 * Copyright(c) 2018 ohmycode.studio LLC. All rights reserved.
 * ohmycode.studio proprietary/confidential use.
 */

import Base from 'Base.js';
import React from 'react';
import { render } from 'react-dom';

/** Components for connecting the redux store
 */
import { Provider } from 'react-redux';
import configureStore from 'store/configureStore.js';

/** Components for implementing the application routing
 */
import { BrowserRouter, Switch, Route } from 'react-router-dom';

/** Importing app containers
 */
import IndexContainer from 'containers/IndexContainer.jsx';
import DashboardContainer from 'containers/DashboardContainer.jsx';
import OrdersContainer from 'containers/OrdersContainer.jsx';

import Theme from 'Theme.js';
import { MuiThemeProvider } from '@material-ui/core/styles';
import DateFnsUtils from 'material-ui-pickers/utils/date-fns-utils';
import MuiPickersUtilsProvider from 'material-ui-pickers/utils/MuiPickersUtilsProvider';

/**
 * Get helper class
 * @type {Object}
 */
window.Base = Base;

/** 
 * Collect app containers
 * @const
 * @type {Object}
 */
const containers = [{ 
		name: 'IndexContainer',
		component: IndexContainer
	}, { 
		name: 'DashboardContainer',
		component: DashboardContainer 
	}, { 
		name: 'OrdersContainer',
		component: OrdersContainer
	}];

/** Render app containers
 */
render (<BrowserRouter>
	<MuiThemeProvider theme={Theme}>
		<MuiPickersUtilsProvider utils={DateFnsUtils}>
			<Provider store={configureStore()}>
				<Switch>
					{containers.map((item, i) => {
						return <Route key={i} exact
							path={window.routes[item.name]} 
							component={item.component} />
					})}
				</Switch>
			</Provider>
		</MuiPickersUtilsProvider>
	</MuiThemeProvider>
</BrowserRouter>, Base.DOMCached.root);