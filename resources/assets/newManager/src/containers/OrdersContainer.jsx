/**
 * Orders page module
 * @requires react
 * @requires react#PureComponent
 * @requires react#Fragment
 * @requires components/Header
 * @requires components/AsideNav
 * @requires components/TableOrders
 * @requires components/ProgressDefault
 * @requires @material-ui/core/Snackbar
 */
import React, { PureComponent, Fragment } from 'react';

import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';

import Header from 'components/Header';
import AsideNav from 'components/AsideNav';
import TableOrders from 'components/TableOrders';
import ProgressDefault from 'components/ProgressDefault';
import EditOrder from 'components/EditOrder';
import Snackbar from '@material-ui/core/Snackbar';

import * as StateLangsAction from 'actions/StateLangsAction.js';

/**
 * Orders page container
 * @extends PureComponent
 */
class OrdersContainer extends PureComponent {
	constructor(props) {
		super(props);

		window.Base.defineCurrentLang(this.props.StateLangsAction.get, 'orders');
		document.addEventListener('optionOrderEditAction', this.getEditOrderId);
	}
	
	/**
	 * Current component state object
	 * @type {object}
	 * @property {boolean} completed All the elements of the container got the parameters
	 * @property {boolean} snackbar Show alert box
	 * @property {string} snackbarMsg Alert message
	 */
	state = {
		editOrderId: null,
		completed: false,
		snackbar: false,
		snackbarMsg: '',
		orderUpdated: null
	}

	/**
	 * Get AsideNav rendered component
	 * @param {object} node
	 */
	createDrawerRef = (node) => {
		this._asideNav = node;
	}

	/**
	 * Get the id of the resource being edited
	 * @param {object} e
	 */
	getEditOrderId = (e) => {
		this.setState({ editOrderId: e.detail.id });
	}

	/**
	 * Render component
	 * @return {object} jsx object
	 */
	render() {
		let { editOrderId, orderUpdated } = this.state;

		return <Fragment>
			<ProgressDefault
				completed={this.state.completed} />

			<Header
				title="appBarOrdersTitle"
				onAsideNavButtonClicked={(e) => {
					this._asideNav.setState({
						drawer: !this._asideNav.drawer
					});
				}} />

			<AsideNav
				getInstanceLink={this.createDrawerRef} />

			<TableOrders
				completed={this.state.completed}
				orderUpdated={orderUpdated}
				onOrdersLoaded={(completed) => this.setState({ completed })}
				onRowUpdated={() => this.setState({ 
					orderUpdated: null 
				})}
				toolbareOrdersCreate={(e) => this.setState({
					editOrderId: 0
				})} />

			<EditOrder
				id={editOrderId}
				handleDialogClose={(e) => this.setState({ 
					editOrderId: null
				})}
				onOrdersLoaded={(completed) => this.setState({ completed })}
				onUpdatedOrder={(orderUpdated) => this.setState({ orderUpdated })}
				onCreatedOrder={(order) => this.setState({ 
					editOrderId: order.id, 
					orderUpdated: order 
				})} />

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
				message={<span>{this.state.snackbarMsg}</span>} />
		</Fragment>
	}
}

/**
 * Init redux states
 * @param {Object} state
 * @return {Object}
 */
function mapStateToProps(state) {
	return {
		langs: state.langs
	}
}

/**
 * Init redux actions
 * @param {Function} dispatch
 * @return {Object}
 */
function mapDispatchToProps(dispatch) {
	return {
		StateLangsAction: bindActionCreators(StateLangsAction, dispatch)
	}
}

export default connect(mapStateToProps, mapDispatchToProps)(OrdersContainer);