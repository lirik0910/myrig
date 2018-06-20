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
					title={this.props.lexicon.select_context_label}
					defaultValue={contextDefaultValue}
					onItemSelected={value => this.props.onContextSelected(value)} />

				<SelectProductStatus
					required
					title={this.props.lexicon.select_product_status}
					defaultValue={statusDefaultValue}
					onItemSelected={value => this.props.onStatusSelected(value)} />

				<InputSelectPage
					title={this.props.lexicon.page_select}
					defaultValue={pageDefaultValue}
					placeholder={this.props.lexicon.page_select_placeholder}
					onItemSelected={value => this.props.onPageSelected(value)} />

				<InputPrice
					title={this.props.lexicon.price_label}
					disabled={typeof this.props.activePriceField === 'undefined' ? 
						false : 
						!this.props.activePriceField}
					defaultValue={priceDefaultValue}
					onFieldInputed={value => this.props.onPriceInputed(value)} />

				<InputWarranty
					title={this.props.lexicon.warranty_label}
					defaultValue={warrantyDefaultValue}
					onFieldInputed={value => this.props.onWarrantyInputed(value)} />

				<InputProductCategory
					title={this.props.lexicon.select_category}
					defaultValue={this.getCategoriesLine(categoriesDefaultValue)}
					onItemSelected={value => this.props.onCategoryInputed(value)} />

				<InputDatePicker
					title={this.props.lexicon.publish_date_label}
					defaultValue={createDefaultValue}
					onDateFieldChanged={value => this.props.onDateSelected(value)} />

				<CheckboxActive
					title={this.props.lexicon.active_label}
					defaultValue={activeDefaultValue}
					onCheckboxValueChanged={value => this.props.onActiveChanged(value)} />
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

export default connect(mapStateToProps)(withStyles(styles)(PaperProductForm));