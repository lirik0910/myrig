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
class SelectUser extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		defaultValue: 0,
		title: 'Select user',
		inputID: 'select-user',
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
		//console.log(this.props.defaultValue);
		this.setState({ 
			value: this.props.defaultValue,
		}, () => {
			this.usersDataGetRequest(null, data => this.props.onDataLoaded(data));
		});
	}

    /*
	 * Get users from server
	 *
	 */
    usersDataGetRequest(data, callback = () => {}){
        App.api({
            type: 'GET',
            name: 'all',
            model: 'user',
            //data: data,
            success: (r) => {
                r = JSON.parse(r.response);
                if (r) {
                	//console.log(r.data);
                    this.setState({
                        data: r.data,
                    }, () => callback(r));
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
				input={<Input name="user_id" id={inputID} />}>

				<MenuItem value={0}>
					<em>{'None'}</em>
				</MenuItem>

				{data.map((item, i) => {
					return <MenuItem 
						key={i}
						value={item.id}>
							{item.attributes !== null && typeof item.attributes.fname !== 'undefined' && typeof item.attributes.lname !== 'undefined' ? item.attributes.fname + ' ' + item.attributes.lname : item.email}
					</MenuItem>
				})}
			</Select>
		</FormControl>
	}
}

export default withStyles(styles)(SelectUser);