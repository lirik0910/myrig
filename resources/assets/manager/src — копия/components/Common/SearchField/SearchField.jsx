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

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';
import Button from 'material-ui/Button';
import TextField from 'material-ui/TextField';
import IconButton from 'material-ui/IconButton';
import Search from 'material-ui-icons/Search';

/**
 * Header block
 * @extends Component
 */
class SearchField extends Component {

	/**
	 * State object of component
	 * @type {Object} 
	 * @inner
	 * @property {Array} contexts
	 * @property {String} currentID 
	 */
	state = {
		searchText: ''
	}

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		classes: PropTypes.object.isRequired,
		placeholder: 'Search field',
		defaultText: '',
		onInputed: () => {},
		onSubmited: () => {},
	}

	/**
	 * Invoked just before mounting occurs
	 * @fires componentWillMount
	 */
	componentWillMount() {
		this.setState({ 
			placeholder: this.props.placeholder,
			searchText: this.props.defaultText
		});
	}

	/**
	 * Get query for search users
	 * @fires input
	 * @param {Object} e
	 */
	getSearchText(e) {
		var target = e.target;
		this.setState({ searchText: target.value }, () => {
			this.props.onInputed(target.value);
		});
	}

	/**
	 * Render 
	 */
	render() {
		let { classes, placeholder } = this.props;
		let { searchText } = this.state;

		return <form onSubmit={e => this.props.onSubmited(searchText)}>
			<TextField
				placeholder={placeholder}
				onInput={this.getSearchText.bind(this)}
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

				<IconButton className={classes.button} aria-label="Search">
					<Search />
				</IconButton>
		</form>
	}
}

export default withStyles(styles)(SearchField);