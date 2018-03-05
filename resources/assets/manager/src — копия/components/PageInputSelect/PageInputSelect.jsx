/**
 * Select page with autocomplete module
 * @module PageInputSelect
 * @author Ihor Bielchenko
 * @requires react
 */

import Manager from '../../Manager.js';
import React, { Component } from 'react';

import { MenuItem } from 'material-ui/Menu';
import { FormControl } from 'material-ui/Form';
import Typography from 'material-ui/Typography';
import Input, { InputLabel } from 'material-ui/Input';
import SelectContainer from './SelectContainer/SelectContainer.jsx';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Component for selecting page with autocomplete
 * @extends Component
 */
class PageInputSelect extends Component {

	/**
	 * State object of component
	 * @type {Object} 
	 * @inner
	 * @property {Object} data Component data
	 * @property {Number} defaultValue Component data
	 */
	state = {
		data: [],
		value: null
	}

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		parentID: 0,
		defaultValue: null,
		title: 'Select page',
		inputID: 'page-select',
		placeholder: 'Product page link',
		onDataLoaded: () => {},
		onItemSelected: () => {},
		classes: PropTypes.object.isRequired,
	}

	/**
	 * Invoked just before mounting occurs
	 * @fires componentWillMount
	 */
	componentWillMount() {
		let { defaultValue } = this.props;

		this.setState({ value: defaultValue }, () => {
			this.pageDataGetRequest(data => this.props.onDataLoaded(data));
		});
	}

	/**
	 * Request to server for getting page data
	 * @param {Function} callback
	 */
	pageDataGetRequest(callback = () => {}) {
		let { parentID } = this.props;
		let xhr = Manager.xhr();

		/** Check load all pages or childs by parent_id
		 */
		var query;
		if (parentID === 0) {
			query = Manager.url +'/api/page';
		}

		else {
			query = Manager.url +'/api/page/childs/'+ parentID;
		}

		xhr.open('GET', query, true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xhr.setRequestHeader('X-CSRF-Token', Manager.csrf());
		xhr.send();

		var r;
		xhr.onreadystatechange = () => {
			if((xhr.status === 200 || xhr.status === 201) && xhr.readyState === 4) {
				r = JSON.parse(xhr.response);
				if(r) {
					this.setState({ data: r.map(item => ({
						value: item.id,
						label: item.link,
						...item
					})) }, () => callback(r));
				}
			}
		}
	}

	/**
	 * Select item
	 * @fores click
	 * @param {Number} value
	 */
	handleChangeSingle = value => {
		this.setState({ value }, () => this.props.onItemSelected(value));
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { data, value } = this.state;
		let { classes, title, inputID, placeholder } = this.props;

		return <FormControl className={classes.formControl}>
				<Typography className={classes.label}>
					{title}
				</Typography>

				<Input
					fullWidth
					inputComponent={SelectContainer}
					inputProps={{
						value,
						classes,
						placeholder,
						id: inputID,
						options: data,
						simpleValue: true,
						onChange: this.handleChangeSingle,
					}} />
			</FormControl>
	}
}

export default withStyles(styles)(PageInputSelect);