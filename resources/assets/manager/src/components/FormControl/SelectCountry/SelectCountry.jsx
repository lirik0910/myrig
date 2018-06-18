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
class SelectOrderStatus extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		defaultValue: 0,
		required: false,
		title: 'Select country',
		inputID: 'select-country',
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
		data: [
			'Azerbaijan',
			'Armenia',
			'Belarus',
			'Georgia',
			'Kazakhstan',
			'Kyrgyzstan',
			'Turkmenistan',
			'Uzbekistan',
			'Ukraine',
			'Russia',
			],
		value: 0
	}

	/**
	 * Invoked just before mounting occurs
	 * @fires componentWillMount
	 */
	componentWillMount() {
		// this.setState({ 
		// 	value: this.defaultprops.defaultValue,
		// }, () => {
		// 	this.countryDataGetRequest(data => this.props.onDataLoaded(data));
		// });
	}

    componentDidUpdate(prevProps, prevState){
		let value = this.props.defaultValue;
		this.state.data.forEach(function (item, index) {
			if(item === value){
				value = index;
			}
			//console.log(item, index);
        });
		//console.log(value);
		this.props.defaultValue = value;
		console.log(prevProps.defaultValue, this.props.defaultValue);
        if(prevProps.defaultValue !== this.props.defaultValue){
            //console.log(value);
        	this.setState({ value });
            //this.componentWillMount();
        }
    }

	/**
	 * Get data about contexts
	 * @param {Function} callback
	 */
	countryDataGetRequest(callback = () => {}) {
		
	}

	/**
	 * Change select fields
	 * @fires click
	 * @param {Object} e
	 */
	handleChangeSelect = e => {
		var target = e.target;
		this.setState({ value: target.value }, () => {
			this.props.onItemSelected(target.value);
		});
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { data, value } = this.state;
		let { classes, inputID, title, required } = this.props;
		return <FormControl className={classes.formControl}>
			<InputLabel htmlFor={inputID}>
				{title}
			</InputLabel>
			
			<Select
				value={value}
				required={required}
				onChange={this.handleChangeSelect}
				input={<Input name="country" id={inputID} />}>

				{data.map((item, i) => {
					return <MenuItem 
						key={i}
						value={item}>
							{item}
					</MenuItem>
				})}
			</Select>
		</FormControl>
	}
}

export default withStyles(styles)(SelectOrderStatus);