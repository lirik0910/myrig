/**
 * Select page module
 * @module PriceField
 * @author Ihor Bielchenko
 * @requires react
 */

import App from '../../App.js';
import React, { Component } from 'react';

import Grid from 'material-ui/Grid';
import Button from 'material-ui/Button';
import TextField from 'material-ui/TextField';
import { FormControl } from 'material-ui/Form';
import Typography from 'material-ui/Typography';
import Slide from 'material-ui/transitions/Slide';
import TabOptions from '../TabOptions/TabOptions.jsx';
import Input, { InputLabel } from 'material-ui/Input';
import InputNumber from '../FormControl/InputNumber/InputNumber.jsx';
import SelectStatus from '../FormControl/SelectStatus/SelectStatus.jsx';
import SelectPayment from '../FormControl/SelectPayment/SelectPayment.jsx';
import SelectContext from '../FormControl/SelectContext/SelectContext.jsx';
import SelectDelivery from '../FormControl/SelectDelivery/SelectDelivery.jsx';
import Dialog, {
	DialogActions,
	DialogContent,
	DialogContentText,
	DialogTitle,
} from 'material-ui/Dialog';

import Assignment from 'material-ui-icons/Assignment';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Animate opening dialog
 * @param {Object} props
 * @return {Object} JSX object
 */
function Transition(props) {
	return <Slide direction="up" {...props} />;
}

/**
 * Component for selecting page
 * @extends Component
 */
class DialogOrder extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		defaultValue: false,
		classes: PropTypes.object.isRequired,
		onDialogSaved: () => {},
		onDialogClosed: () => {}
	}

	/**
	 * State object of component
	 * @type {Object} 
	 * @inner
	 */
	state = {
		tab: 0,
		open: this.props.defaultValue,
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { tab, open } = this.state;
		let { classes, order } = this.props;

		return <Dialog
				open={open}
				transition={Transition}
				keepMounted
				aria-labelledby="dialog-order-slide-title"
				aria-describedby="dialog-order-slide-text">

				<DialogTitle id="dialog-order-slide-title">
					{'Edit # '+ order.number}
				</DialogTitle>

				<DialogContent>
					<Grid container spacing={24}>
						<Grid item xs={12}>
							<TabOptions
								defaultValue={tab}
								onTabButtonClicked={tab => this.setState({ tab })}
								data={[
									'Order',
									'Customer',
									//'History',
								]} />
						</Grid>
					</Grid>

					{tab === 0 && <Grid container spacing={24}>
						<Grid item xs={12}>
							<Typography style={{
								padding: '12px 0', 
								borderBottom: '1px solid #DDD'
							}}>Order cost: 
								<span style={{fontSize: 24}}>{order.cost.toFixed(2)}</span>
							</Typography>
						</Grid>
					</Grid>}

					<Grid container spacing={24}
						style={{
							display: tab === 0 ?
								'flex':
								'none'
						}}>
						<Grid item xs={7}>

							{order.carts && order.carts.map((item, i) => {
							return <Grid key={i} container spacing={24}>
								<Grid item xs={3}>
									{typeof item.product.images[0] !== 'undefined' ?
										<img src={App.uploads() +'/'+ item.product.images[0].name} 
											alt={item.product.id}
											style={{
												maxWidth: '100%',
												maxHeight: '82px'
										}} /> : 
										<Assignment />}
								</Grid>
				
								<Grid item xs={9}>
									<Typography style={{fontSize: '15px'}}>
										{item.product.title}
									</Typography>

									<div style={{maxWidth: '124px'}}>
										<InputNumber 
											name={'count'}
											inputID={'count'}
											title={'Items count:'}
											defaultValue={item.count} />
									</div>

									<Button size="small" color="secondary" className={classes.button}>
										Delete
									</Button>
								</Grid>
							</Grid>
							})}
						</Grid>

						<Grid item xs={5}>
							<SelectContext
								title={'Order context'}
								defaultValue={order.context_id} />

							<SelectStatus
								title={'Order status'}
								defaultValue={order.status_id} />

							<SelectPayment
								title={'Order payment type'}
								defaultValue={order.payment_type_id} />

							<SelectDelivery
								title={'Order delivery type'}
								defaultValue={order.order_deliveries.delivery_id} />
							</Grid>
					</Grid>

					<Grid container spacing={24} className={classes.root} 
						style={{
							display: tab === 1 ? 
								'flex':
								'none'
					}}>
						<Grid item xs={12}>
							<FormControl fullWidth className={classes.formControl}>
								<InputLabel htmlFor="fist-name">
									Custemer first name
								</InputLabel>
								
								<Input
									name="first_name"
									id="fist-name"
									defaultValue={order.order_deliveries.first_name} />
							</FormControl>

							<FormControl fullWidth className={classes.formControl}>
								<InputLabel htmlFor="last-name">
									Custemer last name
								</InputLabel>
								
								<Input
									name="last_name"
									id="last-name"
									defaultValue={order.order_deliveries.last_name} />
							</FormControl>

							<FormControl fullWidth className={classes.formControl}>
								<InputLabel htmlFor="phone">
									Custemer phone
								</InputLabel>
								
								<Input
									type="phone"
									name="phone"
									id="phone"
									defaultValue={order.order_deliveries.phone} />
							</FormControl>

							<FormControl fullWidth className={classes.formControl}>
								<InputLabel htmlFor="email">
									Custemer email
								</InputLabel>
								
								<Input
									type="email"
									name="email"
									id="email"
									defaultValue={order.order_deliveries.email} />
							</FormControl>

							<FormControl fullWidth className={classes.formControl}>
								<InputLabel htmlFor="country">
									Customer country
								</InputLabel>
								
								<Input
									type="country"
									name="country"
									id="country"
									defaultValue={order.order_deliveries.country} />
							</FormControl>

							<FormControl fullWidth className={classes.formControl}>
								<InputLabel htmlFor="city">
									Customer city
								</InputLabel>
								
								<Input
									type="city"
									name="city"
									id="city"
									defaultValue={order.order_deliveries.city} />
							</FormControl>

							<FormControl fullWidth className={classes.formControl}>
								<InputLabel htmlFor="address">
									Customer address
								</InputLabel>
								
								<Input
									type="address"
									name="address"
									id="address"
									defaultValue={order.order_deliveries.address} />
							</FormControl>

							<TextField
								id="comment"
								name="comment"
								label={'Customer comment'}
								multiline={true}
								rows={4}
								defaultValue={order.order_deliveries.comment}
								className={classes.textArea}
								onChange={e => {
									
								}}
								InputLabelProps={{
									shrink: true
								}} />
						</Grid>
					</Grid>
				</DialogContent>

				<DialogActions>
					<Button color="primary"
						onClick={e => this.props.onDialogClosed()}>
						Cancel
					</Button>
					<Button color="primary"
						onClick={e => this.props.onDialogSaved()}>
						Save
					</Button>
				</DialogActions>
			</Dialog>
	}
}

export default withStyles(styles)(DialogOrder);