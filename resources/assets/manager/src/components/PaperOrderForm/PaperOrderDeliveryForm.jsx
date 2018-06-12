/**
 * Select page module
 * @module PriceField
 * @author Ihor Bielchenko
 * @requires react
 */

import React, { Component } from 'react';

import Paper from 'material-ui/Paper';
import InputPrice from '../FormControl/InputPrice/InputPrice.jsx';
import InputWarranty from '../FormControl/InputWarranty/InputWarranty.jsx';
import SelectContext from '../FormControl/SelectContext/SelectContext.jsx';
import CheckboxActive from '../FormControl/CheckboxActive/CheckboxActive.jsx';
import InputSelectPage from '../FormControl/InputSelectPage/InputSelectPage.jsx';
import SelectDelivery from '../FormControl/SelectDelivery/SelectDelivery.jsx';
import SelectCountry from '../FormControl/SelectCountry/SelectCountry.jsx';
import InputDatePicker from '../FormControl/InputDatePicker/InputDatePicker.jsx';
import SelectUser from '../FormControl/SelectUser/SelectUser.jsx';
import Button from 'material-ui/Button';
import TextField from 'material-ui/TextField';


import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Component for selecting page
 * @extends Component
 */
class PaperOrderDeliveryForm extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		deliveryDefaultValue: 5,
		priceDefaultValue: '',
		statusDefaultValue: 0,
		userDefaultValue: 0,
		createDefaultValue: new Date(),
		activeDefaultValue: true,
		onUserSelected: () => {},
		onUserLoaded: () => {},
		onDateSelected: () => {},
		onStatusSelected: () => {},
		onDeliverySelected: () => {},
		onCountrySelected: () => {},
		classes: PropTypes.object.isRequired,
	}

	/**
	 * Get categories
	 * @param {Array} data
	 * @return {String}
	 */
	getCategoriesLine(data = []) {
		var i,
			line = '';

		if (data) {
			for (i = 0; i < data.length; i++) {
				line += data[i].id +',';
			}

			if (line !== '') {
				line = line.substring(0, line.length - 1);
			}
		}
		return line;
	}

	componentWillMount() {
		let {deliveryDefaultValue} = this.props;
		this.props.onDeliverySelected(deliveryDefaultValue);

	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { 
			classes,
			userDefaultValue,
			createDefaultValue,
			contextDefaultValue,
			statusDefaultValue,
			deliveryDefaultValue,
		} = this.props;

		return <Paper className={classes.paper}>
			<Button className={classes.right}
				onClick={e => {
					let fields = ['_first_name', '_last_name', '_email', '_phone', '_city', '_state', '_address', '_country'];
					fields.forEach((f) => {
						if(document.getElementById('d'+f) && document.getElementById('p'+f))
							document.getElementById('d'+f).value = document.getElementById('p'+f).value;
					});
				}}
				className={classes.button} 
				variant="raised">
					{"fetch from previous form"}
			</Button>
			<SelectDelivery
				required
				defaultValue={deliveryDefaultValue}
				onItemSelected={value => this.props.onDeliverySelected(value)} />

			<TextField
				id="d_first_name"
				label="First name"
				type="text"
				name="d_first_name"
				className={classes.textField}
				InputLabelProps={{
					shrink: true
				}} />

			<TextField
				id="d_last_name"
				label="Last name"
				type="text"
				name="d_last_name"
				defaultValue=""
				className={classes.textField}
				InputLabelProps={{
					shrink: true
				}} />
			

			<SelectCountry
				required
				onItemSelected={value => this.props.onCountrySelected(value)} />

			<TextField
				id="d_email"
				label="Email"
				type="email"
				name="d_email"
				defaultValue=""
				className={classes.textField}
				InputLabelProps={{
					shrink: true
				}} />
		
			<TextField
				id="d_phone"
				label="Phone"
				type="phone"
				name="d_phone"
				defaultValue=""
				className={classes.textField}
				InputLabelProps={{
					shrink: true
				}} />
		
			<TextField
				id="d_city"
				label="City"
				type="city"
				name="d_city"
				defaultValue=""
				className={classes.textField}
				InputLabelProps={{
					shrink: true
				}} />
		
			<TextField
				id="d_state"
				label="State"
				type="state"
				name="d_state"
				defaultValue=""
				className={classes.textField}
				InputLabelProps={{
					shrink: true
				}} />
		
			<TextField
				id="d_address"
				label="Address"
				type="address"
				name="d_address"
				defaultValue=""
				className={classes.textField}
				InputLabelProps={{
					shrink: true
				}} />

			<TextField
				id="d_office"
				label="office"
				type="office number"
				name="d_office"
				defaultValue=""
				className={classes.textField}
				InputLabelProps={{
					shrink: true
				}} />

			<TextField
				id="d_passport"
				label="passport"
				type="passport"
				name="d_passport"
				defaultValue=""
				className={classes.textField}
				InputLabelProps={{
					shrink: true
				}} />

			<TextField
				id="d_zendesk"
				label="zendesk"
				type="zendesk"
				name="d_zendesk"
				defaultValue=""
				className={classes.textField}
				InputLabelProps={{
					shrink: true
				}} />

			<TextField
				id="d_warranty"
				label="warranty"
				type="warranty"
				name="d_warranty"
				defaultValue=""
				className={classes.textField}
				InputLabelProps={{
					shrink: true
				}} />

			<TextField
				id="d_waybill"
				label="Waybill (ТТН)"
				type="Waybill"
				name="d_waybill"
				defaultValue=""
				className={classes.textField}
				InputLabelProps={{
					shrink: true
				}} />
		

		</Paper>
	}
}

export default withStyles(styles)(PaperOrderDeliveryForm);