/**
 * Select page module
 * @module PriceField
 * @author Ihor Bielchenko
 * @requires react
 */

import React, { Component } from 'react';

import { connect } from 'react-redux';

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
		data: {},
		deliveryDefaultValue: 5,
		priceDefaultValue: '',
		statusDefaultValue: 0,
		userDefaultValue: 0,
		createDefaultValue: new Date(),
		activeDefaultValue: true,
		countryDefaultValue: 4,
		onUserSelected: () => {},
		onUserLoaded: () => {},
		onDateSelected: () => {},
		onStatusSelected: () => {},
		onDeliverySelected: () => {},
		onCountrySelected: () => {},
		classes: PropTypes.object.isRequired,
	}

	state = {
		countryDefaultValue: ''
	};

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
			data,
			classes,
			userDefaultValue,
			createDefaultValue,
			contextDefaultValue,
			statusDefaultValue,
			deliveryDefaultValue,
		} = this.props;

		let {
			countryDefaultValue
		} = this.state;

		return <Paper className={classes.paper}>
			<Button className={classes.right}
				onClick={e => {
					let fields = ['_first_name', '_last_name', '_email', '_phone', '_city', '_state', '_address', '_country'];
					countryDefaultValue = document.getElementById('select-country').value;
					this.setState({ countryDefaultValue });

					//document.getElementById('select-country').value = countryDefaultValue;
					fields.forEach((f) => {
						if(document.getElementById('d'+f) && document.getElementById('p'+f))
							document.getElementById('d'+f).value = document.getElementById('p'+f).value;
					});
				}}
				className={classes.button} 
				variant="raised">
					{this.props.lexicon.fetch_previous_form}
			</Button>
			<SelectDelivery
				required
				title={this.props.lexicon.select_delivery_type}
				defaultValue={deliveryDefaultValue}
				value={countryDefaultValue}
				onItemSelected={value => this.props.onDeliverySelected(value)} />

			<TextField
				id="d_first_name"
				label={this.props.lexicon.first_name}
				type="text"
				name="d_first_name"
				className={classes.textField}
				InputLabelProps={{
					shrink: true
				}} />

			<TextField
				id="d_last_name"
				label={this.props.lexicon.last_name}
				type="text"
				name="d_last_name"
				defaultValue=""
				className={classes.textField}
				InputLabelProps={{
					shrink: true
				}} />

			<SelectCountry
				title={this.props.lexicon.select_country}
				defaultValue={countryDefaultValue}
				required
				value={countryDefaultValue}
				onItemSelected={value => this.props.onCountrySelected(value)} />

			<TextField
				id="d_email"
				label={this.props.lexicon.table_email}
				type="email"
				name="d_email"
				defaultValue=""
				className={classes.textField}
				InputLabelProps={{
					shrink: true
				}} />
		
			<TextField
				id="d_phone"
				label={this.props.lexicon.phone_label}
				type="phone"
				name="d_phone"
				defaultValue=""
				className={classes.textField}
				InputLabelProps={{
					shrink: true
				}} />
		
			<TextField
				id="d_city"
				label={this.props.lexicon.city_label}
				type="city"
				name="d_city"
				defaultValue=""
				className={classes.textField}
				InputLabelProps={{
					shrink: true
				}} />
		
			<TextField
				id="d_state"
				label={this.props.lexicon.state_label}
				type="state"
				name="d_state"
				defaultValue=""
				className={classes.textField}
				InputLabelProps={{
					shrink: true
				}} />
		
			<TextField
				id="d_address"
				label={this.props.lexicon.address_label}
				type="address"
				name="d_address"
				defaultValue=""
				className={classes.textField}
				InputLabelProps={{
					shrink: true
				}} />

			<TextField
				id="d_office"
				label={this.props.lexicon.office_label}
				type="office number"
				name="d_office"
				defaultValue=""
				className={classes.textField}
				InputLabelProps={{
					shrink: true
				}} />

			<TextField
				id="d_passport"
				label={this.props.lexicon.passport_label}
				type="passport"
				name="d_passport"
				defaultValue=""
				className={classes.textField}
				InputLabelProps={{
					shrink: true
				}} />

			<TextField
				id="d_zendesk"
				label={this.props.lexicon.zendesk_label}
				type="zendesk"
				name="d_zendesk"
				defaultValue=""
				className={classes.textField}
				InputLabelProps={{
					shrink: true
				}} />

			<TextField
				id="d_warranty"
				label={this.props.lexicon.warranty_label}
				type="warranty"
				name="d_warranty"
				defaultValue=""
				className={classes.textField}
				InputLabelProps={{
					shrink: true
				}} />

			<TextField
				id="d_waybill"
				label={this.props.lexicon.waybill_label}
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

/**
 * Init redux states
 * @param {Object} state
 * @return {Object}
 */
function mapStateToProps(state) {
	return {
		lexicon: state.lexicon
	}
}

export default connect(mapStateToProps)(withStyles(styles)(PaperOrderDeliveryForm));