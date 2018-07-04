/**
 * EditOrder module
 * @requires react
 * @requires react#PureComponent
 */

import React, { PureComponent } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';

import cloneDeep from 'clone-deep';
import Grid from '@material-ui/core/Grid';
import AppBar from '@material-ui/core/AppBar';
import Toolbar from '@material-ui/core/Toolbar';
import IconButton from '@material-ui/core/IconButton';
import Typography from '@material-ui/core/Typography';
import CloseIcon from '@material-ui/icons/Close';
import Button from '@material-ui/core/Button';
import Dialog from '@material-ui/core/Dialog';
import DialogContent from '@material-ui/core/DialogContent';
import Snackbar from '@material-ui/core/Snackbar';
import Slide from '@material-ui/core/Slide';
import EditOrderCommonData from 'components/EditOrderCommonData';
import EditOrderPaymentData from 'components/EditOrderPaymentData';
import EditOrderDeliveryData from 'components/EditOrderDeliveryData';
import EditOrderProductsData from 'components/EditOrderProductsData';
import OrderHistory from 'components/OrderHistory';

import { oneOrder, updateOrder, createOrder } from 'server/Orders.js';
import { userData } from 'server/Users.js';
import { allCountries } from 'server/Countries.js';

import styles from './styles.js';
import { withStyles } from '@material-ui/core/styles';

function Transition(props) {
	return <Slide direction="up" {...props} />
}

/**
 * EditOrder block
 * @extends PureComponent
 */
class EditOrder extends PureComponent {
	constructor(props) {
		super(props);

		this.fetchCountries = allCountries()
			.then((countries) => this.setState({ countries }));
	}

	/**
	 * Props validators
	 * @type {object}
	 * @property {function} classes
	 */
	static propTypes = {
		classes: PropTypes.object.isRequired
	}

	/**
	 * Default properties
	 * @type {object}
	 * @property {number} id Current order
	 */
	static defaultProps = {
		id: null,
		onOrdersLoaded: (flag) => {},
		onUpdatedOrder: (order) => {},
		onCreatedOrder: (order) => {}
	}

	/**
	 * Current component state object
	 * @type {object}
	 * @property {object} data
	 */
	state = {
		data: {},
		countries: [],
		orderGot: false,
		responseStatus: false,
		responseMessage: ''
	}

	willPropsId = '';

	/**
	 * @method componentWillReceiveProps
	 */
	componentWillReceiveProps(willProps) {
		this.willPropsId = willProps.id;

		if (willProps.id > 0 && this.state.orderGot === false) {
			this.setState({ orderGot: true }, () => {
				this.fetchOrder = oneOrder(willProps.id)
					.then(this.setOrderData)
					.then(() => this.setState({ orderGot: false }));
			});
		}

		else if (willProps.id === 0) {
			let now = new Date(),
				date = now.toISOString();

			this.setOrderData({
				id: 0,
				number: 0,
				carts: [],
				context_id: '',
				cost: 0,
				btc_price: 0,
				created_at: date,
				delete: 0,
				logs: [],
				paid: 0,
				status_id: '',
				user_id: null,
				prepayment: 0,
				payment_type_id: '',
				order_deliveries: {
					address: '',
					city: '',
					comment: '',
					country: '',
					created_at: date,
					delivery_id: '',
					email: '',
					first_name: '',
					last_name: '',
					office: '',
					passport: '',
					phone: '',
					state: '',
					warranty: '',
					waybill: '',
					zendesk: ''
				},
				order_payments: {
					city: '',
					country: '',
					first_name: '',
					last_name: '',
					id: 0,
				},
				payment_type: {}
			});
		}
	}

	/**
	 * Set order data to state
	 * @param {object} data
	 */
	setOrderData = (data) => {
		let i = 0,
			a = [];

		while (i < data['carts'].length) {
			data['carts'][i]['product_id'] = typeof data['carts'][i]['product_id'] === 'undefined' ?
				typeof data['carts'][i]['product']['product_id'] === 'undefined' ?
					data['carts'][i]['product']['id'] :
					data['carts'][i]['product']['product_id'] : 
				data['carts'][i]['product_id'];
			a.push(cloneDeep(data['carts'][i]));
			i++;
		}
		data['carts'] = a;

		this.setState({ data });
	}

	/**
	 *
	 */
	userChanged = (value, item) => {
		this.fetchUserData = userData(item.id)
			.then(this.fillUserData)
	}

	fillUserData = (user) => {
		console.log(user, user.orders)
		if (typeof user.orders[0] !== 'undefined') {
			let { data } = this.state,
				a = cloneDeep(data);

			a['order_deliveries'] = user.orders[0]['order_deliveries'];
			a['order_payments'] = user.orders[0]['order_deliveries'];

			console.log(a)
			this.setState({ data: a });
		}
	}

	/**
	 * Render component
	 * @return {object} jsx object
	 */
	render() {
		let { classes, id, langs } = this.props,
			{ data, countries } = this.state;

		return <Dialog 
			fullScreen
			open={id === null ? false : true}
			TransitionComponent={Transition}
			onClose={this.props.handleDialogClose}>

			<Snackbar
				anchorOrigin={{ 
					vertical: 'top', 
					horizontal: 'center'
				}}
				open={this.state.responseStatus}
				message={this.state.responseMessage}
				onClose={(e) => {
					let i = 0,
						a = [
							'el_user_id', 
							'el_context_id',
							'el_status_id',
							'el_delivery_id',
							'el_payment_type_id', 
							'el_d_first_name', 
							'el_d_last_name',
							'el_d_email',
							'el_d_phone',
							'el_p_first_name',
							'el_p_last_name'
						];

					while (i < a.length) {
						document.getElementById(a[i]).style['backgroundColor'] = 'transparent';
						i++;
					}

					this.setState({ responseStatus: false });
				}} />

			<AppBar className={classes.appBar}>
				<Toolbar>
					<IconButton 
						className={classes.iconButton} 
						onClick={this.props.handleDialogClose}>

						<CloseIcon />
					</IconButton>

					<Typography 
						variant="headline"
						className={classes.flex}>

						{langs['dialogEditOrderTitle']}
					</Typography>

					<Button 
						className={classes.iconButton}
						onClick={(e) => { 
							this.props.onOrdersLoaded(false);
							let i = 0,
								cart = [];

							while (i < data['carts'].length) {
								cart.push({
									id: data['carts'][i]['id'],
									btcCost: data['carts'][i]['btcCost'],
									cost: data['carts'][i]['cost'],
									count: data['carts'][i]['count'],
									discount: data['carts'][i]['discount'],
									serials_number: data['carts'][i]['serials_number'],
									product: {
										id: typeof data['carts'][i]['product_id'] === 'undefined' ?
											data['carts'][i]['product']['product_id'] : 
											data['carts'][i]['product_id']
									}
								});
								i++;
							}

							if (id === 0) {
								createOrder(cart)
									.then(this.setOrderData)
									.then((e) => {
										this.setState({ responseStatus: true }, () => {
											this.props.onCreatedOrder(this.state.data);
											this.props.onOrdersLoaded(true);
										});
									})
									.catch((promise) => {
										promise.then((data) => {
											let i,
												el;

											for (i in data.errors) {
												el = document.getElementById('el_'+ i);
												el.style['backgroundColor'] = 'rgba(255, 0, 0, 0.1)';
											}

											this.setState({ 
												responseStatus: true,
												responseMessage: data.message
											}, () => {
												this.props.onOrdersLoaded(true);
											});
										});
									});
							}
							
							else {
								updateOrder(cart, id)
									.then(this.setOrderData)
									.then((e) => {
										this.setState({ responseStatus: true }, () => {
											this.props.onUpdatedOrder(this.state.data);
											this.props.onOrdersLoaded(true);
										});
									})
									.catch((promise) => {
										promise.then((data) => {
											let i,
												el;

											for (i in data.errors) {
												el = document.getElementById('el_'+ i);
												el.style['backgroundColor'] = 'rgba(255, 0, 0, 0.1)';
											}

											this.setState({ 
												responseStatus: true,
												responseMessage: data.message
											}, () => {
												this.props.onOrdersLoaded(true);
											});
										});
									});;
							}
						}}>

						{langs['dialogButtonSave']}
					</Button>
				</Toolbar>
			</AppBar>

			{(typeof data.id !== 'undefined' && this.willPropsId === data.id) && <DialogContent>
				<form id="form-order">
					<Grid container spacing={24} style={{ width: '100%', margin: 0 }}>
						<Grid item xs={12} sm={6}>
							<EditOrderCommonData 
								order={data}
								onUserSelected={this.userChanged}
								onOrdersLoaded={this.props.onOrdersLoaded} />

							<EditOrderDeliveryData 
								order={data}
								countries={countries} />
						</Grid>

						<Grid item xs={12} sm={6}>
							<EditOrderPaymentData 
								order={data}
								countries={countries} />

							<EditOrderProductsData
								order={data}
								onCartUpdated={(cart) => {
									data['carts'] = cart;
									this.setState({ data });
								}} />

							<OrderHistory
								total={data.logs.length}
								data={data.logs} />
						</Grid>
					</Grid>
				</form>
			</DialogContent>}
		</Dialog>
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

export default connect(mapStateToProps)(withStyles(styles)(EditOrder));