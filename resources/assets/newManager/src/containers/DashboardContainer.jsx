/**
 * Dashboard page module
 * @requires react
 * @requires react#PureComponent
 * @requires react#Fragment
 * @requires components/Header
 * @requires components/AsideNav
 * @requires components/TablePages
 * @requires components/ProgressDefault
 * @requires @material-ui/core/Snackbar
 */
import React, { PureComponent, Fragment } from 'react';

import Header from 'components/Header';
import AsideNav from 'components/AsideNav';
import ProgressDefault from 'components/ProgressDefault';
import Snackbar from '@material-ui/core/Snackbar';

/**
 * Dashboard page container
 * @extends PureComponent
 */
class DashboardContainer extends PureComponent {
	
	/**
	 * Current component state object
	 * @type {object}
	 * @property {boolean} completed All the elements of the container got the parameters
	 * @property {boolean} snackbar Show alert box
	 * @property {string} snackbarMsg Alert message
	 */
	state = {
		completed: false,
		snackbar: false,
		snackbarMsg: ''
	}

	/**
	 * Get AsideNav rendered component
	 * @param {object} node
	 */
	createDrawerRef = (node) => {
		this._asideNav = node;
	}

	/**
	 * Render component
	 * @return {object} jsx object
	 */
	render() {
		return <Fragment>
			<ProgressDefault
				{...this.state.completed} />

			<Header
				title="appBarDashboardTitle"
				onAsideNavButtonClicked={(e) => {
					this._asideNav.setState({
						drawer: !this._asideNav.drawer
					});
				}} />

			<AsideNav
				getInstanceLink={this.createDrawerRef} />

			<Snackbar
				anchorOrigin={{ 
					vertical: 'top', 
					horizontal: 'right'
				}}
				open={this.state.snackbar}
				onClose={(e) => this.setState({
					snackbar: false
				})}
				ContentProps={{
					'aria-describedby': 'message-id'
				}}
				message={<span>{this.state.snackbarMsg}</span>}/>
		</Fragment>
	}
}

export default DashboardContainer;