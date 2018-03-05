/**
 * Base module of manager users container
 * @module ProductContainers
 * @author Ihor Bielchenko
 * @requires react
 * @requires react#Component
 * @requires redux#bindActionCreators
 * @requires react-redux#connect
 */

import App from '../App.js';
import React, { Component } from 'react';

import Grid from 'material-ui/Grid';
import Menu from '../components/Menu/Menu.jsx';
import Header from '../components/Header/Header.jsx';
import { LinearProgress } from 'material-ui/Progress';
import PaperTable from '../components/PaperTable/PaperTable.jsx';
import DialogError from '../components/DialogError/DialogError.jsx';
import DialogDelete from '../components/DialogDelete/DialogDelete.jsx';
import PaperToolBar from '../components/PaperToolBar/PaperToolBar.jsx';
import ControlOptions from '../components/ControlOptions/ControlOptions.jsx';

import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Users base container
 * @extends Component
 */
class ListOrdersContainer extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		classes: PropTypes.object.isRequired,
	}

	state = {
		data: [], 
		start: 0, 
		limit: 10, 
		total: 0,
		dateTo: '',
		dateFrom: '',
		statusID: 0,
		paymentID: 0,
		contextID: 0,
		deliveryID: 0,
		searchText: '',
		completed: 100,
		deleteOrderId: 0,
		deleteDialog: false,
		resultDialog: false,
		resultDialogTitle: '',
		resultDialogMessage: ''
	}

	/**
	 * Invoked just before mounting occurs
	 * @fires componentWillMount
	 */
	componentWillMount() {
		this.ordersGetDataRequest();
	}

	/**
	 * Get orders from server
	 * @param {Function} callback
	 */
	ordersGetDataRequest(callback = () => {}) {
		let { 
			start, 
			limit, 
			dateTo,
			dateFrom,
			contextID, 
			searchText, 
			statusID, 
			paymentID,
			deliveryID } = this.state;

		this.setState({ completed: 0 }, () => {
			var data = {
				limit,
				start: start + 1,
			};

			/** Set string query
			 */
			if (searchText && searchText.length > 0) {
				data['search'] = searchText;
			}

			/** Set filter by context
			 */
			if (contextID && contextID > 0) {
				data['context_id'] = contextID;
			}

			/** Set filter by status
			 */
			if (statusID && statusID > 0) {
				data['status_id'] = statusID;
			}

			/** Set filter by payment
			 */
			if (paymentID && paymentID > 0) {
				data['payment_type_id'] = paymentID;
			}

			/** Set filter by delivery
			 */
			if (deliveryID && deliveryID > 0) {
				data['delivery_id'] = deliveryID;
			}

			/** Set filter by created date
			 */
			if (dateFrom) {
				data['created_at_from'] = dateFrom;
			}

			/** Set filter by created date
			 */
			if (dateTo) {
				data['created_at_to'] = dateTo;
			}

			App.api({
				type: 'GET',
				name: 'all',
				model: 'order',
				data: data,
				success: (r) => {
					r = JSON.parse(r.response);
					if (r) {
						this.setState({ 
							data: r.data,
							total: r.total,
							completed: 100,
							deleteOrderId: 0
						}, () => callback(r));
					}
				}
			});
		});
	}

	/**
	 * Delete order
	 * @param {Function} callback
	 */
	ordersDelteRequest(callback = () => {}) {
		let { deleteOrderId } = this.state;

		this.setState({ completed: 0 }, () => {
			App.api({
				name: 'one',
				type: 'DELETE',
				model: 'order',
				resource: deleteOrderId,
				success: (r) => {
					r = JSON.parse(r.response);
					if (r) {
						this.setState({ 
							completed: 100,
							deleteOrderId: 0,
							deleteDialog: false,
						}, () => callback(r));
					}
				},
				error: (r) => {
					r = JSON.parse(r.response);
					if (r.message) {
						this.setState({ 
							completed: 100,
							deleteOrderId: 0,
							resultDialog: true,
							deleteDialog: false,
							resultDialogTitle: 'Error',
							resultDialogMessage: r.message
						});
					}
				}
			});
		});
	}

	/**
	 * Stylize table data
	 */
	stylizeRows(data = []) {
		let { classes } = this.props

		return data.map((item, i) => {
			return {
				id: item.id,
				numberRow: <div className={classes.numberCell}>
						<span className={classes.numberItem}># {item.number}</span>
						<span className={classes.statusItem}
							style={{color: item.status.color}}>{item.status.title}</span>

						<div className={classes.fieldItem}>
							context {item.context.title}
						</div>
					</div>,
				deliveryRow: <div className={classes.deliveryCell}>
						<div className={classes.fieldItem}>
							{item.order_deliveries.first_name} {item.order_deliveries.last_name}
						</div>

						{item.order_deliveries.email ? <div className={classes.fieldItem}>
							{item.order_deliveries.email}
						</div> : null}

						{item.order_deliveries.phone ? <div className={classes.fieldItem}>
							{item.order_deliveries.phone}
						</div> : null}

						{item.order_deliveries.city || item.order_deliveries.address ? 
							<div className={classes.fieldItem}>
								{item.order_deliveries.city} {item.order_deliveries.address}
							</div> : null}

						{item.order_deliveries.delivery ? 
							<div className={classes.fieldItem} style={{
								marginTop: '8px',
								paddingTop: '8px',
								borderTop: '1px solid #d6d6d6',
								color: item.order_deliveries.delivery.color
							}}>
								<b>{item.order_deliveries.delivery.title}</b>
							</div> : null}
					</div>,
				costRow: <div className={classes.costCell}>
						<div>
							<span className={classes.fieldItem}>Order cost:</span>
							<span className={classes.costItem}>{item.cost.toFixed(2)}</span>
						</div>

						<div>
							<span className={classes.fieldItem}>Prepayment cost:</span>
							<span className={classes.costItem}>{item.prepayment.toFixed(2)}</span>
						</div>

						{item.payment_type ? 
							<div className={classes.fieldItem} style={{
								marginTop: '8px',
								paddingTop: '8px',
								borderTop: '1px solid #d6d6d6',
							}}>
								<b>{item.payment_type.title}</b>
							</div> : null}
					</div>,
				dateRow: <div className={classes.dateCell}>
						<span className={classes.dateItem}>{item.created_at}</span>
					</div>,
				control: <ControlOptions
							item={item}
							editButton={true}
							onDeleteButtonClicked={item => {
								this.setState({
									deleteDialog: true,
									deleteOrderId: item.id,
								});
							}} />
			};
		});
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { classes } = this.props;
		let { 
			data, 
			start, 
			limit, 
			total, 
			dateTo,
			dateFrom,
			statusID,
			paymentID,
			contextID, 
			deliveryID,
			searchText, 
			deleteDialog,
			resultDialog,
			resultDialogTitle,
			resultDialogMessage,
			completed } = this.state;

		return <div className="pages-list__container">
				{completed === 0 && 
					<LinearProgress color="secondary" variant="determinate" value={completed} />}
					
				<Header
					title={'Orders list'} />
				<Menu />

				<Grid container spacing={24} className={classes.root}>
					<Grid item xs={12}>
						<PaperToolBar
							statusShow
							paymentShow
							deliveryShow
							orderActionShow
							dateCreatedShow
							statusTitle={'Filter by status'}
							contextTitle={'Filter by context'}
							paymentTitle={'Filter by payment type'}
							deliveryTitle={'Filter by delivery type'}
							dateFromTitle={'Filter by order create date from'}
							dateToTitle={'to date'}
							contextDefaultValue={contextID}
							onContextSelected={contextID => {
								this.setState({ contextID }, () => {
									this.ordersGetDataRequest();
								});
							}}
							searchDefaultValue={searchText}
							onSearchFieldSubmited={searchText => {
								this.setState({ searchText }, () => {
									this.ordersGetDataRequest();
								});
							}}
							statusDefaultValue={statusID}
							onStatusSelected={statusID => {
								this.setState({ statusID }, () => {
									this.ordersGetDataRequest();
								});
							}}
							paymentDefaultValue={paymentID}
							onPaymentSelected={paymentID => {
								this.setState({ paymentID }, () => {
									this.ordersGetDataRequest();
								});
							}}
							deliveryDefaultValue={deliveryID}
							onDeliverySelected={deliveryID => {
								this.setState({ deliveryID }, () => {
									this.ordersGetDataRequest();
								});
							}}
							dateFromDefaultValue={dateFrom}
							onDateFromSelected={dateFrom => {
								dateFrom = dateFrom._d.toString();
								this.setState({ dateFrom }, () => {
									this.ordersGetDataRequest();
								});
							}}
							dateToDefaultValue={dateTo}
							onDateToSelected={dateTo => {
								dateTo = dateTo._d.toString();
								this.setState({ dateTo }, () => {
									this.ordersGetDataRequest();
								});
							}} />
					</Grid>
				</Grid>

				<Grid container spacing={24} className={classes.root}>
					<Grid item xs={12}>
						{completed ? <PaperTable
							data={this.stylizeRows(data)}
							except={['id']}
							page={start}
							limit={limit}
							total={total}
							columns={[{
								id: 'number', 
								numeric: false, 
								disablePadding: true, 
								label: 'Number'
							}, {
								id: 'delivery', 
								numeric: false, 
								disablePadding: true, 
								label: 'Delivery data'
							}, {
								id: 'cost', 
								numeric: false, 
								disablePadding: true, 
								label: 'Payment'
							}, {
								id: 'created_at', 
								numeric: false, 
								disablePadding: true, 
								label: 'Date'
							}, {
								id: 'control', 
								numeric: false, 
								disablePadding: true, 
								label: 'Control'
							}]}
							onRowsSelected={selected => this.setState({ selected })}
							onStartValueChanged={start => {
								this.setState({ 
									start,
								}, () => this.productsGetDataRequest());
							}}
							onLimitValueChanged={limit => this.setState({ limit })} /> : null}
					</Grid>
				</Grid>

				{resultDialog === true && <DialogError 
					title={resultDialogTitle}
					defaultValue={resultDialog}
					message={resultDialogMessage}
					onDialogClosed={() => this.setState({
						resultDialog: false
					})} />}

				{deleteDialog === true && <DialogDelete
					defaultValue={deleteDialog}
					onDialogClosed={() => this.setState({
						deleteDialog: false
					})}
					onDialogConfirmed={() => this.ordersDelteRequest(() => {
						this.ordersGetDataRequest();
					})} />}
			</div>
	}
}

let styles = theme => ({
	root: {
		width: '100%',
		margin: 0,
		padding: 0,
	},
	numberCell: {
		margin: '12px 0',
	},
	numberItem: {
		fontSize: 32,
		marginLeft: 8,
		marginRight: 8
	},
	statusItem: {
		fontSize: 15,
		marginLeft: 4,
		marginRight: 4 
	},
	costItem: {
		fontSize: 18,
		marginLeft: 4
	},
	fieldItem: {
		fontSize: 13,
		margin: '6px 0'
	},
});

export default withStyles(styles)(ListOrdersContainer);