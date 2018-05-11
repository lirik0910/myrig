/**
 * Select page with autocomplete module
 * @module PageInputSelect
 * @author Ihor Bielchenko
 * @requires react
 */

import App from '../../../App.js';
import React, { Component } from 'react';

import Input from 'material-ui/Input';
import { FormControl } from 'material-ui/Form';
import Typography from 'material-ui/Typography';
import SelectContainer from './SelectContainer/SelectContainer.jsx';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Component for selecting page with autocomplete
 * @extends Component
 */
class InputSelectPage extends Component {

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
		
		var data = {};
		if (parentID > 0) {
			data['parent_id'] = parentID;
		}

		App.api({
			type: 'GET',
			model: 'page',
			name: 'all',
			data: data,
			success: (r) => {
				r = JSON.parse(r.response);
				if(r) {
					r.data.push({
						value: 0,
						label: <em>NONE</em>
					});
					
					this.setState({ data: r.data.map(item => ({
						value: item.id,
						label: item.link,
						...item
					})) }, () => callback(r));
				}
			}
		});
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

export default withStyles(styles)(InputSelectPage);