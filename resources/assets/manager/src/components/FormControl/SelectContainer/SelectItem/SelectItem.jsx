/**
 * Select page with autocomplete module
 * @module SelectItem
 * @author Ihor Bielchenko
 * @requires react
 */

import React, { Component } from 'react';
import { MenuItem } from 'material-ui/Menu';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Component for selecting page with autocomplete
 * @extends Component
 */
class SelectItem extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		classes: PropTypes.object.isRequired,
	}

	handleClick = event => {
		this.props.onSelect(this.props.option, event);
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { children, isFocused, isSelected, onFocus } = this.props;

		return <MenuItem
			onFocus={onFocus}
			selected={isFocused}
			onClick={this.handleClick}
			component="div"
			style={{
				fontWeight: isSelected ? 500 : 400,
			}}>
				{children}
		</MenuItem>
	}
}

export default withStyles(styles)(SelectItem);