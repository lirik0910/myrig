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
import SelectCountry from '../FormControl/SelectCountry/SelectCountry.jsx';
import InputDatePicker from '../FormControl/InputDatePicker/InputDatePicker.jsx';
import SelectUser from '../FormControl/SelectUser/SelectUser.jsx';
import { FormControl } from 'material-ui/Form';

import TextField from 'material-ui/TextField';


import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Component for selecting page
 * @extends Component
 */
class PaperOrderForm extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		priceDefaultValue: '',
		data: {},
		statusDefaultValue: 0,
		userDefaultValue: 0,
		createDefaultValue: new Date(),
		activeDefaultValue: true,
		onFNameInputed: () => {},
		onUserLoaded: () => {},
		onDateSelected: () => {},
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


	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let {
			data,
			classes,
			userDefaultValue,
			createDefaultValue,
			contextDefaultValue,
			statusDefaultValue,
		} = this.props;
		data.attributes = data.attributes || {};

		return <Paper className={classes.paper}>
				<TextField
					id="p_first_name"
					label="First name"
					type="text"
					name="p_first_name"
					value={data.attributes.fname}
					className={classes.textField}
					InputLabelProps={{
						shrink: true
					}} />

				<TextField
					id="p_last_name"
					label="Last name"
					type="text"
					name="p_last_name"
					value={data.attributes.lname}
					defaultValue=""
					className={classes.textField}
					InputLabelProps={{
						shrink: true
					}} />
				

				<SelectCountry
					required
					onItemSelected={value =>
						this.props.onCountrySelected(value)}
				/>

				<TextField
					id="p_email"
					label="Email"
					type="email"
					name="p_email"
					defaultValue=""
					value={data.email}
					className={classes.textField}
					InputLabelProps={{
						shrink: true
					}} />
			
				<TextField
					id="p_phone"
					label="Phone"
					type="phone"
					name="p_phone"
					defaultValue=""
					value={data.attributes.phone}
					className={classes.textField}
					InputLabelProps={{
						shrink: true
					}} />
			
				<TextField
					id="p_city"
					label="City"
					type="city"
					name="p_city"
					defaultValue=""
					className={classes.textField}
					InputLabelProps={{
						shrink: true
					}} />
			
				<TextField
					id="p_state"
					label="State"
					type="state"
					name="p_state"
					defaultValue=""
					className={classes.textField}
					InputLabelProps={{
						shrink: true
					}} />
			
				<TextField
					id="p_address"
					label="Address"
					type="address"
					name="p_address"
					defaultValue=""
					value={data.attributes.address}
					className={classes.textField}
					InputLabelProps={{
						shrink: true
					}} />
			</Paper>
	}
}

export default withStyles(styles)(PaperOrderForm);