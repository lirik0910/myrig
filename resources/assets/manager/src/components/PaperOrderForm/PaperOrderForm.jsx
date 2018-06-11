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
import CheckboxActive from '../FormControl/CheckboxActive/CheckboxActive.jsx';
import InputSelectUser from '../FormControl/InputSelectUser/InputSelectUser.jsx';
import SelectOrderStatus from '../FormControl/SelectOrderStatus/SelectOrderStatus.jsx';
import InputDatePicker from '../FormControl/InputDatePicker/InputDatePicker.jsx';
import SelectUser from '../FormControl/SelectUser/SelectUser.jsx';
import SelectPayment from '../FormControl/SelectPayment/SelectPayment.jsx';
import SelectContext from '../FormControl/SelectContext/SelectContext.jsx';


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
		statusDefaultValue: 1,
		userDefaultValue: 0,
		paymentDefaultValue: 2,
		createDefaultValue: new Date(),
		sendDefaultValue: false,
		onUserSelected: () => {},
		onUserLoaded: () => {},
		onPaymentSelected: () => {},
		onDateSelected: () => {},
		onStatusSelected: () => {},
		onContextSelected: () => {},
        onActiveChanged: () => {},
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
			classes,
			userDefaultValue,
			createDefaultValue,
			contextDefaultValue,
			paymentDefaultValue,
			statusDefaultValue,
			sendDefaultValue
		} = this.props;

		return <Paper className={classes.paper}>
				<InputDatePicker
					defaultValue={createDefaultValue}
					onDateFieldChanged={value => this.props.onDateSelected(value)} />

				<InputSelectUser
					onDataLoaded = {data => this.props.onUserLoaded(data)}
					onItemSelected={value => this.props.onUserSelected(value)}
				/>

				<SelectContext
					required={true}
					defaultValue={contextDefaultValue}
					onItemSelected={value => this.props.onContextSelected(value)}
				/>

				<SelectOrderStatus
					required={true}
					defaultValue={statusDefaultValue}
					onItemSelected={value => this.props.onStatusSelected(value)} />

				<SelectPayment
					required={true}
					defaultValue={paymentDefaultValue}
					onItemSelected={value => this.props.onPaymentSelected(value)}
				/>

				<CheckboxActive
					name="send-regime"
					title="Send to table"
					defaultValue={sendDefaultValue}
					onCheckboxValueChanged={value => {
						this.props.onActiveChanged(value);
					}} />

			</Paper>
	}
}

export default withStyles(styles)(PaperOrderForm);