/**
 * Select page module
 * @module PriceField
 * @author Ihor Bielchenko
 * @requires react
 */

import React, { Component } from 'react';

import { connect } from 'react-redux';

import App from '../../App.js';
import Paper from 'material-ui/Paper';
import InputPrice from '../FormControl/InputPrice/InputPrice.jsx';
import CheckboxActive from '../FormControl/CheckboxActive/CheckboxActive.jsx';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Component for sele
 * cting page
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
		btc: 0,
		onDataUpdated: () => {},
		onActiveChanged: () => {},
		classes: PropTypes.object.isRequired,
	}

	/**
	 * State object of component
	 */
	state = {
		totalAutoPrice: 0,
	}

	/**
	 * Invoked just before mounting occurs
	 * @fires componentWillMount
	 */
	componentWillMount() {
		if(this.props.data !== null){
			this.calcAutoPrice();
		}
	}

	calcAutoPrice(){

		let data = App.isEmpty(this.props.data) ? {
				fes_price: 0,
				fes_price_currency: 1,
				prime_price: 0,
				prime_price_currency: 1,
				delivery_price: 0,
				delivery_price_currency: 1,
				profit_price: 0,
				profit_price_currency: 1,
				warranty_price: 0,
				warranty_price_currency: 1,
			} :
			this.props.data;
		let {
			fes_price,
			fes_price_currency,
			warranty_price,
			warranty_price_currency,
			prime_price,
			prime_price_currency,
			delivery_price,
			delivery_price_currency,
			profit_price,
			profit_price_currency
		} = data;

		let btc = parseFloat(this.props.btc);
		//let { totalAutoPrice } = this.state;

		if (prime_price_currency == 2){
			prime_price = prime_price * btc;
		} else {
		 //   $prime_price = $params->prime_price;
		}

		if (delivery_price_currency == 2){
			delivery_price = delivery_price * btc;
		} else {
		//    delivery_price = delivery_price;
		}

		if (fes_price_currency == 2){
			fes_price = fes_price * btc;
		} else if (fes_price_currency == 3){
			fes_price = prime_price * fes_price / 100;
		} else{
			//fes_price = fes_price;
		}

		if (profit_price_currency == 2){
			profit_price = profit_price * btc;
		} else if (profit_price_currency == 3){
			profit_price = prime_price * profit_price / 100;
		} else{
		  //  $profit_price = $params->profit_price;
		}

		if (warranty_price_currency == 2){
			warranty_price = warranty_price * btc;
		} else if (warranty_price_currency == 3){
			warranty_price = prime_price * warranty_price / 100;
		} else{
			//$warranty_price = $params->warranty_price;
		}

		let total = prime_price + delivery_price + fes_price + profit_price + warranty_price;

		this.setState({
			totalAutoPrice: total
		});
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

		let { totalAutoPrice } = this.state;

		if (data === null) {
			data = {
				fes_price: 0,
				fes_price_currency: 1,
				prime_price: 0,
				prime_price_currency: 1,
				delivery_price: 0,
				delivery_price_currency: 1,
				profit_price: 0,
				profit_price_currency: 1,
				warranty_price: 0,
				warranty_price_currency: 1,
			};
		}

		return <Paper className={classes.paper}>
			<CheckboxActive
				name="auto-regime"
				title={this.props.lexicon.auto_price_regime}
				defaultValue={activeDefaultValue}
				onCheckboxValueChanged={value => {
					this.props.onActiveChanged(value);
					this.calcAutoPrice()
				}} />

			<InputPrice
				name="fes"
				title={this.props.lexicon.fes}
				inputID="fes-field"
				currencies={currencies}
				disabled={activeDefaultValue}
				defaultValue={data.fes_price}
				currencyID={data.fes_price_currency}
				onFieldInputed={value => {
					//console.log(value);
					value = value === '' ? 0 : value;

					data.fes_price = Number(value);
					this.props.onDataUpdated(data);
					this.calcAutoPrice();
				}}
				onCurencySelected={value => {
					data.fes_price_currency = value.id;
					this.props.onDataUpdated(data);
				}} />

			<InputPrice
				name="warranty"
				title={this.props.lexicon.warranty_label}
				inputID="warranty-field"
				currencies={currencies}
				disabled={activeDefaultValue}
				defaultValue={data.warranty_price}
				currencyID={data.warranty_price_currency}
				onFieldInputed={value => {
					value = value === '' ? 0 : value;
					data.warranty_price = parseFloat(value);
					this.props.onDataUpdated(data);
					this.calcAutoPrice();
					//console.log('inputed');
				}}
				onCurencySelected={value => {
					data.warranty_price_currency = value.id;
					this.props.onDataUpdated(data);
					//this.calcAutoPrice();
				}} />

			<InputPrice
				name="prime-cost"
				title={this.props.lexicon.prime_cost}
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
					value = value === '' ? 0 : value;
					data.prime_price = parseFloat(value);
					this.props.onDataUpdated(data);
					this.calcAutoPrice();
				}} />

			<InputPrice
				name="delivery-cost"
				title={this.props.lexicon.delivery_cost}
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
					value = value === '' ? 0 : value;
					data.delivery_price = parseFloat(value);
					this.props.onDataUpdated(data);
					this.calcAutoPrice();
				}} />

			<InputPrice
				name="profit-cost"
				title={this.props.lexicon.profit_label}
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
					value = value === '' ? 0 : value;
					data.profit_price = parseFloat(value);
					this.props.onDataUpdated(data);
					this.calcAutoPrice();
				}} />

			<InputPrice
				name="total_cost"
				title={this.props.lexicon.total_cost}
				currencies={currencies}
				inputID="total-cost-field"
				disabled={false}
				defaultValue={totalAutoPrice}
				currencyID={1} />
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

export default connect(mapStateToProps)(withStyles(styles)(PaperAutoProductForm));