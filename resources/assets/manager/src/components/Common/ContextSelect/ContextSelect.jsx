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

import Manager from '../../../Manager.js';
import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';
import { MenuItem } from 'material-ui/Menu';
import TextField from 'material-ui/TextField';
import IconButton from 'material-ui/IconButton';
import { FormControl, FormHelperText } from 'material-ui/Form';
import Input, { InputLabel } from 'material-ui/Input';
import Select from 'material-ui/Select';


/**
 * Header block
 * @extends Component
 */
class ContextSelect extends Component {

	/**
	 * State object of component
	 * @type {Object} 
	 * @inner
	 * @property {Array} contexts
	 * @property {String} currentID 
	 */
	state = {
		contexts: [],
		currentID: 1
	}

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		classes: PropTypes.object.isRequired,
		currentID: 1,
		inputID: 'context-select',
		onLoaded: () => {},
		onSelected: () => {},
	}

	/**
	 * Invoked just before mounting occurs
	 * @fires componentWillMount
	 */
	componentWillMount() {
		this.setState({ 
			inputID: this.props.inputID,
			currentID: this.props.currentID,
		}, () => {
			this.getContextData((data) => {
				this.props.onLoaded(data);
			});
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
					this.setState({ contexts: r }, () => callback(r));
				}
			}
		}
	}

	/**
	 * Change select fields
	 * @fires click
	 * @param {Object} item
	 * @apram {String} param
	 * @param {Object} e
	 */
	handleChangeSelect(e) {
		var target = e.target;
		this.setState({ currentID: target.value }, () => {
			this.props.onSelected(target.value);
		});
	}

	/**
	 * Render 
	 */
	render() {
		let { classes, inputID } = this.props;
		let { contexts, currentID } = this.state;

		return <FormControl className={classes.formControl}>
			<InputLabel htmlFor={inputID}>Product context</InputLabel>
			<Select
				value={currentID}
				onChange={this.handleChangeSelect.bind(this)}
				input={<Input name="context_id" id={inputID} />}>
					{contexts.map((item, i) => {
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