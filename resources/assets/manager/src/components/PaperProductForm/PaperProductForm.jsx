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
import InputDatePicker from '../FormControl/InputDatePicker/InputDatePicker.jsx';
import SelectProductStatus from '../FormControl/SelectProductStatus/SelectProductStatus.jsx';
import InputProductCategory from '../FormControl/InputProductCategory/InputProductCategory.jsx';

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
		statusDefaultValue: 0,
		warrantyDefaultValue: null,
		categoriesDefaultValue: null,
		createDefaultValue: new Date(),
		activeDefaultValue: true,
		onPageSelected: () => {},
		onPriceInputed: () => {},
		onDateSelected: () => {},
		onActiveChanged: () => {},
		onStatusSelected: () => {},
		onContextSelected: () => {},
		onWarrantyInputed: () => {},
		onCategoryInputed: () => {},
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
			pageDefaultValue,
			priceDefaultValue,
			createDefaultValue,
			activeDefaultValue,
			contextDefaultValue,
			statusDefaultValue,
			warrantyDefaultValue,
			categoriesDefaultValue,
		} = this.props;

		return <Paper className={classes.paper}>
				<SelectContext
					required
					defaultValue={contextDefaultValue}
					onItemSelected={value => this.props.onContextSelected(value)} />

				<SelectProductStatus
					required
					defaultValue={statusDefaultValue}
					onItemSelected={value => this.props.onStatusSelected(value)} />

				<InputSelectPage
					title={'Page select'}
					defaultValue={pageDefaultValue}
					placeholder={'Input page link for current product'}
					onItemSelected={value => this.props.onPageSelected(value)} />

				<InputPrice
					disabled={typeof this.props.activePriceField === 'undefined' ? 
						false : 
						!this.props.activePriceField}
					defaultValue={priceDefaultValue}
					onFieldInputed={value => this.props.onPriceInputed(value)} />

				<InputWarranty
					defaultValue={warrantyDefaultValue}
					onFieldInputed={value => this.props.onWarrantyInputed(value)} />

				<InputProductCategory
					defaultValue={this.getCategoriesLine(categoriesDefaultValue)}
					onItemSelected={value => this.props.onCategoryInputed(value)} />

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