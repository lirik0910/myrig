/**
 * Select context module
 * @module SelectContext
 * @author Ihor Bielchenko
 * @requires react
 */

import App from '../../../App.js';
import React, { Component } from 'react';
import Select from 'material-ui/Select';
import { MenuItem } from 'material-ui/Menu';
import { FormControl } from 'material-ui/Form';
import Input, { InputLabel } from 'material-ui/Input';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';


/**
 * Component for selecting context
 * @extends Component
 */
class SelectLang extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		defaultValue: 0,
		title: 'Select lang',
		inputID: 'select-lang',
		onDataLoaded: () => {},
		onItemSelected: () => {},
		titleStyle: {},
		selectStyle: {},
		selectClassName: 'lang-select__container',
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
		let value = this.props.defaultValue;

		this.setState({ value }, () => {
			this.viewDataGetRequest(data => {
				if (typeof this.props.defaultValueContent !== 'undefined') {
					
					let i = 0;
					while (i < data.length) {
						if (data[i] === this.props.defaultValueContent) {
							this.setState({ value: i });
							break;
						}
						i++;
					}
				}

				this.props.onDataLoaded(data);
			});
		});
	}

	/**
	 * Get data about contexts
	 * @param {Function} callback
	 */
	viewDataGetRequest(callback = () => {}) {
		App.api({
			type: 'GET',
			name: 'all',
			model: 'lang',
			success: (r) => {
				r = JSON.parse(r.response);
				if (r) {
					this.setState({ data: r }, () => callback(r));
				}
			}
		});
	}

	/**
	 * Change select fields
	 * @fires click
	 * @param {Object} e
	 */
	handleChangeSelect = e => {
		var target = e.target;
		this.setState({ value: target.value }, () => {
			this.props.onItemSelected(target.value, this.state.data);
		});
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { data, value } = this.state;
		let { classes, inputID, title, titleStyle, selectStyle, selectClassName } = this.props;

		return <FormControl className={classes.formControl}>
			<InputLabel htmlFor={inputID}>
				<span style={titleStyle}>{title}</span>
			</InputLabel>
			
			<Select
				value={value}
				onChange={this.handleChangeSelect}
				input={<Input name="lang" id={inputID} />}
				style={selectStyle}
				className={selectClassName}>

				{data.map((item, i) => {
					return <MenuItem 
						key={i}
						value={i}>
							{item}
					</MenuItem>
				})}
			</Select>
		</FormControl>
	}
}

export default withStyles(styles)(SelectLang);