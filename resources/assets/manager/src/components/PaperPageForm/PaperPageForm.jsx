/**
 * Select page module
 * @module PriceField
 * @author Ihor Bielchenko
 * @requires react
 */

import React, { Component } from 'react';

import Paper from 'material-ui/Paper';
import InputLink from '../FormControl/InputLink/InputLink.jsx';
import SelectContext from '../FormControl/SelectContext/SelectContext.jsx';
import SelectView from '../FormControl/SelectView/SelectView.jsx';
import InputSelectPage from '../FormControl/InputSelectPage/InputSelectPage.jsx';
import InputDatePicker from '../FormControl/InputDatePicker/InputDatePicker.jsx';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Component for selecting page
 * @extends Component
 */
class PaperPageForm extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		parentDefaultValue: null,
		viewDefaultValue: 0,
		linkDefaultValue: '',
		contextDefaultValue: 0,
		createDefaultValue: new Date(),
		onLinkInputed: () => {},
		onDateSelected: () => {},
		onViewSelected: () => {},
		onParentSelected: () => {},
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
			linkDefaultValue,
			viewDefaultValue,
			parentDefaultValue,
			createDefaultValue,
			contextDefaultValue
		} = this.props;

		return <Paper className={classes.paper}>
				<SelectContext
					defaultValue={contextDefaultValue}
					onItemSelected={value => this.props.onContextSelected(value)} />

				<SelectView
					defaultValue={viewDefaultValue}
					onItemSelected={value => this.props.onViewSelected(value)} />

				<InputSelectPage
					title={'Parent select'}
					defaultValue={parentDefaultValue}
					placeholder={'Input parent page'}
					onItemSelected={value => this.props.onParentSelected(value)} />

				<InputLink
					defaultValue={linkDefaultValue}
					onFieldInputed={value => this.props.onLinkInputed(value)} />

				<InputDatePicker
					defaultValue={createDefaultValue}
					onDateFieldChanged={value => this.props.onDateSelected(value)} />
			</Paper>
	}
}

export default withStyles(styles)(PaperPageForm);