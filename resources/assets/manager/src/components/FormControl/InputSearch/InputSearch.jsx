/**
 * Header block module
 * @module Users
 * @author Ihor Bielchenko
 * @requires react
 * @requires react#Component
 * @requires redux#bindActionCreators
 * @requires react-redux#connect
 */

import React, { Component } from 'react';

import TextField from 'material-ui/TextField';
import IconButton from 'material-ui/IconButton';

import Search from 'material-ui-icons/Search';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Header block
 * @extends Component
 */
class InputSearch extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		defaultValue: '',
		placeholder: 'Search field',
		classes: PropTypes.object.isRequired,
		onFieldInputed: () => {},
		onFieldSubmited: () => {},
	}

	/**
	 * State object of component
	 * @type {Object} 
	 * @inner
	 */
	state = {
		searchText: this.props.defaultValue
	}

	/**
	 * Get query for search users
	 * @fires input
	 * @param {Object} e
	 */
	getSearchText = e => {
		var target = e.target;
		this.setState({ searchText: target.value }, () => {
			this.props.onFieldInputed(target.value);
		});
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { searchText } = this.state;
		let { classes, placeholder } = this.props;

		return <form onSubmit={e => {
				e.preventDefault();
				this.props.onFieldSubmited(searchText);
			}}>
			<TextField
				placeholder={placeholder}
				onChange={this.getSearchText}
				InputProps={{
					disableUnderline: true,
					classes: {
						root: classes.textFieldRoot,
						input: classes.textFieldInput,
					},
				}}
				defaultValue={searchText}
				InputLabelProps={{
					shrink: true,
					className: classes.textFieldFormLabel,
				}} />

			<IconButton type="submit" className={classes.button} aria-label="Search">
				<Search />
			</IconButton>
		</form>
	}
}

export default withStyles(styles)(InputSearch);