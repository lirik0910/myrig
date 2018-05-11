/**
 * Select page module
 * @module InputPrice
 * @author Ihor Bielchenko
 * @requires react
 */

import React, { Component } from 'react';
import { FormControl } from 'material-ui/Form';
import Input, { InputLabel } from 'material-ui/Input';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Component for selecting page
 * @extends Component
 */
class InputLink extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		name: 'price',
		title: 'Page link',
		defaultValue: '',
		inputID: 'link-field',
		onDataLoaded: () => {},
		onFieldInputed: () => {},
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
		value: 0
	}

	/**
	 * Invoked just before mounting occurs
	 * @fires componentWillMount
	 */
	componentWillMount() {
		let { defaultValue } = this.props;

		this.setState({ value: defaultValue }, () => {
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
		this.setState({ value: target.value }, () => {
			this.props.onFieldInputed(target.value);
		});
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { value } = this.state;
		let { 
			name, 
			title,
			classes, 
			inputID, 
			placeholder
		} = this.props;

		return <FormControl fullWidth className={classes.formControl}>
				<InputLabel htmlFor={inputID}>
					{title}
				</InputLabel>
				
				<Input
					name={name}
					id={inputID}
					value={value}
					placeholder={placeholder}
					onChange={this.handleInputField} />
        	</FormControl>
	}
}

export default withStyles(styles)(InputLink);