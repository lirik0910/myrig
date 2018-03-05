/**
 * Select page module
 * @module PriceField
 * @author Ihor Bielchenko
 * @requires react
 */

import React, { Component } from 'react';

import Paper from 'material-ui/Paper';
import InputPrice from '../FormControl/InputPrice/InputPrice.jsx';
import SelectContext from '../FormControl/SelectContext/SelectContext.jsx';
import CheckboxActive from '../FormControl/CheckboxActive/CheckboxActive.jsx';
import InputSelectPage from '../FormControl/InputSelectPage/InputSelectPage.jsx';
import InputDatePicker from '../FormControl/InputDatePicker/InputDatePicker.jsx';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Component for selecting page
 * @extends Component
 */
class PaperProductForm extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		priceDefaultValue: '',
		pageDefaultValue: null,
		contextDefaultValue: 0,
		createDefaultValue: new Date(),
		activeDefaultValue: true,
		onPageSelected: () => {},
		onPriceInputed: () => {},
		onDateSelected: () => {},
		onActiveChanged: () => {},
		onContextSelected: () => {},
		classes: PropTypes.object.isRequired,
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { 
			classes,
			pageDefaultValue,
			priceDefaultValue,
			createDefaultValue,
			activeDefaultValue,
			contextDefaultValue
		} = this.props;

		return <Paper className={classes.paper}>
				<SelectContext
					defaultValue={contextDefaultValue}
					onItemSelected={value => this.props.onContextSelected(value)} />

				<InputSelectPage
					title={'Page select'}
					defaultValue={pageDefaultValue}
					placeholder={'Input page link for current product'}
					onItemSelected={value => this.props.onPageSelected(value)} />

				<InputPrice
					defaultValue={priceDefaultValue}
					onFieldInputed={value => this.props.onPriceInputed(value)} />

				<InputDatePicker
					defaultValue={createDefaultValue}
					onDateFieldChanged={value => this.props.onDateSelected(value)} />

				<CheckboxActive
					defaultValue={activeDefaultValue}
					onCheckboxValueChanged={value => this.props.onActiveChanged(value)} />
			</Paper>
	}
}

export default withStyles(styles)(PaperProductForm);