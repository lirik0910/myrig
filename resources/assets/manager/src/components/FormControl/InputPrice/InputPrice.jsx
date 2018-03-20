/**
 * Select page module
 * @module InputPrice
 * @author Ihor Bielchenko
 * @requires react
 */

import React, { Component } from 'react';
import { FormControl } from 'material-ui/Form';
import Menu, { MenuItem } from 'material-ui/Menu';
import Input, { InputLabel, InputAdornment } from 'material-ui/Input';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Component for selecting page
 * @extends Component
 */
class InputPrice extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		name: 'price',
		currencyID: 0,
		currencies: [],
		title: 'Price',
		defaultValue: '',
		inputID: 'price-field',
		onDataLoaded: () => {},
		onFieldInputed: () => {},
		onCurencySelected: () => {},
		classes: PropTypes.object.isRequired,
	}

	/**
	 * State object of component
	 * @type {Object} 
	 * @inner
	 * @property {Object} data Component data
	 * @property {Number} defaultValue Component data
	 */
	state = {
		value: 0,
		anchorEl: null,
		currency: this.props.currencies.length > 0 ? this.props.currencies[0] : {
			name: 'USD',
			symbol: '$'
		}
	}

	/**
	 * Invoked just before mounting occurs
	 * @fires componentWillMount
	 */
	componentWillMount() {
		let { defaultValue, currencies, currencyID } = this.props;
		var i,
			current = this.state.currency;

		for (i in currencies) {
			if (currencies[i].id === currencyID) {
				current = currencies[i];
			}
		}

		this.setState({ value: defaultValue, currency: current }, () => {
			this.props.onDataLoaded(defaultValue)
		});
	}

	/**
	 * Get value that inputed to field
	 * @fires input
	 * @param {Object} e
	 */
	handleInputField = e => {
		var target = e.target;
		target.value = target.value.replace(/[^\d.]/g, '');

		/*if (target.value === '')
			target.value = 0;*/
		
		this.setState({ value: target.value }, () => {
			this.props.onFieldInputed(target.value);
		});
	}

	/**
	 * Open currency menu
	 * @param {Object} event
	 */
	handleCurrenyClick = event => {
		this.setState({ anchorEl: event.currentTarget });
	}

	/**
	 * Close currency menu
	 * @param {Object} event
	 */
	handleCurrenyClose = (event, item) => {
		this.setState({ anchorEl: null, currency: item }, () => {
			this.props.onCurencySelected(item);
		});
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { value, anchorEl, currency } = this.state;
		let { 
			name, 
			title,
			classes, 
			inputID,
			currencies,
			placeholder
		} = this.props;

		return <FormControl fullWidth className={classes.formControl}>
				<InputLabel htmlFor={inputID}>
					{title}
				</InputLabel>
				
				<Input
					disabled={typeof this.props.disabled === 'undefined' ? false : !this.props.disabled}
					name={name}
					id={inputID}
					value={value}
					placeholder={placeholder}
					onChange={this.handleInputField}
					startAdornment={
						<InputAdornment 
							aria-owns={anchorEl ? 
								'simple-menu' : 
								null}
							aria-haspopup="true"
							onClick={this.handleCurrenyClick}
							position="start">
								{currency.symbol}
						</InputAdornment>
					} />

				{(this.props.disabled && currencies.length) > 0 && <Menu
					anchorEl={anchorEl}
					open={Boolean(anchorEl)}
					onClose={e => this.setState({ anchorEl: null })}>

					{currencies.map((item, i) => {
						return <MenuItem 
									key={i}
									onClick={e => this.handleCurrenyClose(e, item)}>
										{item.symbol}
								</MenuItem>
					})}
				</Menu>}
        	</FormControl>
	}
}

export default withStyles(styles)(InputPrice);