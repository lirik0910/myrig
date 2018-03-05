/**
 * Select page with autocomplete module
 * @module PageInputSelect
 * @author Ihor Bielchenko
 * @requires react
 */

import React, { Component } from 'react';

import Select from 'react-select';
import Typography from 'material-ui/Typography';
import SelectItem from './SelectItem/SelectItem.jsx';

import Chip from 'material-ui/Chip';
import ClearIcon from 'material-ui-icons/Clear';
import CancelIcon from 'material-ui-icons/Cancel';
import ArrowDropUpIcon from 'material-ui-icons/ArrowDropUp';
import ArrowDropDownIcon from 'material-ui-icons/ArrowDropDown';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Component for selecting page with autocomplete
 * @extends Component
 */
class SelectContainer extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		classes: PropTypes.object.isRequired,
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { classes, ...other } = this.props;

		return <Select
				optionComponent={SelectItem}
				noResultsText={<Typography>{'No results found'}</Typography>}
				arrowRenderer={arrowProps => {
					return arrowProps.isOpen ? 
						<ArrowDropUpIcon /> : 
						<ArrowDropDownIcon />
				}}
				clearRenderer={() => null}
				valueComponent={valueProps => {
					let { children } = valueProps;

					return <div className="Select-value">{children}</div>
				}}
				{...other} />
	}
}

export default withStyles(styles)(SelectContainer);