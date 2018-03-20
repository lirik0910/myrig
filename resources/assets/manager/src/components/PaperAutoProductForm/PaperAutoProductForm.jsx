/**
 * Select page module
 * @module PriceField
 * @author Ihor Bielchenko
 * @requires react
 */

import React, { Component } from 'react';

import Paper from 'material-ui/Paper';
import InputPrice from '../FormControl/InputPrice/InputPrice.jsx';
import CheckboxActive from '../FormControl/CheckboxActive/CheckboxActive.jsx';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Component for selecting page
 * @extends Component
 */
class PaperAutoProductForm extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		data: {},
		currencies: [],
		priceDefaultValue: '',
		activeDefaultValue: true,
		onDataUpdated: () => {},
		onActiveChanged: () => {},
		classes: PropTypes.object.isRequired,
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { 
			data,
			classes,
			currencies,
			priceDefaultValue,
			activeDefaultValue,
		} = this.props;

		if (data === null) {
			data = {
				fes_price: '',
				fes_price_currency: 1,
				prime_price: '',
				prime_price_currency: 1,
				delivery_price: '',
				delivery_price_currency: 1,
				profit_price: '',
				profit_price_currency: 1
			};
		}

		return <Paper className={classes.paper}>
				<CheckboxActive
					name="auto-regime"
					title="Auto price regime"
					defaultValue={activeDefaultValue}
					onCheckboxValueChanged={value => this.props.onActiveChanged(value)} />

				<InputPrice
					name="fes"
					title="FES"
					inputID="fes-field"
					currencies={currencies}
					disabled={activeDefaultValue}
					defaultValue={data.fes_price}
					currencyID={data.fes_price_currency}
					onFieldInputed={value => {
						data.fes_price = parseFloat(value);
						this.props.onDataUpdated(data);
					}}
					onCurencySelected={value => {
						data.fes_price_currency = value.id;
						this.props.onDataUpdated(data);
					}} />

				<InputPrice
					name="prime-cost"
					title="Prime cost"
					currencies={currencies}
					inputID="prime-cost-field"
					disabled={activeDefaultValue}
					defaultValue={data.prime_price}
					currencyID={data.prime_price_currency}
					onCurencySelected={value => {
						data.prime_price_currency = value.id;
						this.props.onDataUpdated(data);
					}}
					onFieldInputed={value => {
						data.prime_price = parseFloat(value);
						this.props.onDataUpdated(data);
					}} />

				<InputPrice
					name="delivery-cost"
					title="Delivery cost"
					currencies={currencies}
					inputID="delivery-cost-field"
					disabled={activeDefaultValue}
					defaultValue={data.delivery_price}
					currencyID={data.delivery_price_currency}
					onCurencySelected={value => {
						data.delivery_price_currency = value.id;
						this.props.onDataUpdated(data);
					}}
					onFieldInputed={value => {
						data.delivery_price = parseFloat(value);
						this.props.onDataUpdated(data);
					}} />

				<InputPrice
					name="profit-cost"
					title="Profit"
					currencies={currencies}
					inputID="profit-cost-field"
					disabled={activeDefaultValue}
					defaultValue={data.profit_price}
					currencyID={data.profit_price_currency}
					onCurencySelected={value => {
						data.profit_price_currency = value.id;
						this.props.onDataUpdated(data);
					}}
					onFieldInputed={value => {
						data.profit_price = parseFloat(value);
						this.props.onDataUpdated(data);
					}} />
			</Paper>
	}
}

export default withStyles(styles)(PaperAutoProductForm);