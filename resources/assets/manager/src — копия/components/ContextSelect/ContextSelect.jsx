/**
 * Select context module
 * @module ContextSelect
 * @author Ihor Bielchenko
 * @requires react
 */

import Manager from '../../Manager.js';
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
class ContextSelect extends Component {

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
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		defaultValue: 0,
		title: 'Select context',
		inputID: 'context-select',
		onDataLoaded: () => {},
		onItemSelected: () => {},
		classes: PropTypes.object.isRequired,
	}

	/**
	 * Invoked just before mounting occurs
	 * @fires componentWillMount
	 */
	componentWillMount() {
		this.setState({ 
			value: this.props.defaultValue,
		}, () => {
			this.getContextData(data => this.props.onDataLoaded(data));
		});
	}

	/**
	 * Get data about contexts
	 * @param {Function} callback
	 */
	getContextData(callback = () => {}) {
		let xhr = Manager.xhr();

		xhr.open('GET', Manager.url +'/api/context', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xhr.setRequestHeader('X-CSRF-Token', Manager.csrf());
		xhr.send();

		var r;
		xhr.onreadystatechange = () => {
			if((xhr.status === 200 || xhr.status === 201) && xhr.readyState === 4) {
				r = JSON.parse(xhr.response);
				if(r) {
					this.setState({ data: r }, () => callback(r));
				}
			}
		}
	}

	/**
	 * Change select fields
	 * @fires click
	 * @param {Object} e
	 */
	handleChangeSelect = e => {
		var target = e.target;
		this.setState({ currentID: target.value }, () => {
			this.props.onItemSelected(target.value);
		});
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { data, value } = this.state;
		let { classes, inputID, title } = this.props;

		return <FormControl className={classes.formControl}>
			<InputLabel htmlFor={inputID}>
				{title}
			</InputLabel>
			
			<Select
				value={value}
				onChange={this.handleChangeSelect}
				input={<Input name="context_id" id={inputID} />}>

				<MenuItem value={0}>
					<em>{'None'}</em>
				</MenuItem>

				{data.map((item, i) => {
					return <MenuItem 
						key={i}
						value={item.id}>
							{item.title}
					</MenuItem>
				})}
			</Select>
		</FormControl>
	}
}

export default withStyles(styles)(ContextSelect);