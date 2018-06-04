/**
 * Select context module
 * @module SelectContext
 * @author Ihor Bielchenko
 * @requires react
 */

import App from '../../../App.js';
import React, { Component } from 'react';

import Input from 'material-ui/Input';
import { FormControl } from 'material-ui/Form';
import Typography from 'material-ui/Typography';
import SelectContainer from '../SelectContainer/SelectContainer.jsx';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';


/**
 * Component for selecting context
 * @extends Component
 */
class InputSelectUser extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		defaultValue: null,
		title: 'Select user',
		inputID: 'select-user',
		placeholder: 'Select user',
		onDataLoaded: () => {},
		onItemSelected: () => {},
		classes: PropTypes.object.isRequired,
	}

	/**
	 * State object of component
	 * @type {Object} 
	 * @inner
	 * @property {Array} data
	 * @property {String} currentID 
	 */
	state = {
		data: [],
		value: 0
	}

	/**
	 * Invoked just before mounting occurs
	 * @fires componentWillMount
	 */
	componentWillMount() {
		this.setState({ 
			value: this.props.defaultValue,
		}, () => {
			this.usersDataGetRequest(data => this.props.onDataLoaded(data));
		});
	}

	/**
	 * Get data about contexts
	 * @param {Function} callback
	 */
	usersDataGetRequest(callback = () => {}) {
		App.api({
			type: 'GET',
			name: 'all',
			model: 'user',
			//data: data,
			success: (r) => {
				r = JSON.parse(r.response);
				if (r) {
					this.setState({ data: r.data.map(item => ({
						value: item.id,
						label: item.name,
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
	handleChangeMulti = value => {
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
						multi: true,
						placeholder,
						options: data,
						simpleValue: true,
						id: 'react-select-chip',
						name: 'react-select-chip',
						instanceId: 'react-select-chip',
						onChange: this.handleChangeMulti,
					}} />
			</FormControl>
	}
}

export default withStyles(styles)(InputSelectUser);