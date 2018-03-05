/**
 * Select page module
 * @module CheckBoxActive
 * @author Ihor Bielchenko
 * @requires react
 */

import React, { Component } from 'react';
import Checkbox from 'material-ui/Checkbox';
import { FormControlLabel } from 'material-ui/Form';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Component for selecting page
 * @extends Component
 */
class CheckboxActive extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		name: 'active',
		title: 'Active',
		defaultValue: true,
		onCheckboxValueChanged: () => {},
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
		value: this.props.defaultValue
	}

	/**
	 * Change selected flag
	 * @param {Object} event
	 */
	handleChange = event => {
		var target = event.target;
		this.setState({ value: target.checked }, () => {
			this.props.onCheckboxValueChanged(target.checked);
		});
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { value } = this.state;
		let { name, title } = this.props;

		return <FormControlLabel
					control={
						<Checkbox
							checked={value}
							onChange={this.handleChange}
							value={name}
							color="primary" />
					}
					label={title} />
	}
}

export default withStyles(styles)(CheckboxActive);