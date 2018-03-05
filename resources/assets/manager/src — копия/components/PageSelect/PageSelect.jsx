/**
 * Select page module
 * @module PageSelect
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
 * Component for selecting page
 * @extends Component
 */
class PageSelect extends Component {

	/**
	 * State object of component
	 * @type {Object} 
	 * @inner
	 * @property {Object} data Component data
	 * @property {Number} defaultValue Component data
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
		parentID: 0,
		defaultValue: 0,
		title: 'Select page',
		inputID: 'page-select',
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
		let { value } = this.state;

		value = e.target.value;
		this.setState({ value }, () => {
			this.props.onItemSelected(value);
		});
	};

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { data, value } = this.state;
		let { classes, title, inputID } = this.props;

		return <FormControl className={classes.formControl}>
				<InputLabel htmlFor={inputID}>
					{title}
				</InputLabel>
				
				<Select
					value={value}
					onChange={this.handleChangeSelect}
					input={<Input name="page_id" id={inputID} />}>

					<MenuItem value={0}>
						<em>{'None'}</em>
					</MenuItem>

					{data.map((item, i) => {
						return <MenuItem 
							key={i}
							value={item.id}>
								{item.link}
						</MenuItem>
					})}
				</Select>
			</FormControl>
	}
}

export default withStyles(styles)(PageSelect);