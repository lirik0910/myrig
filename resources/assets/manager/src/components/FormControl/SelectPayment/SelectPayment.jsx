/**
 * Select context module
 * @module SelectContext
 * @author Ihor Bielchenko
 * @requires react
 */

import App from '../../../App.js';

import { connect } from 'react-redux';

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
class SelectPayment extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		defaultValue: 0,
		title: 'Select payment type',
		inputID: 'select-payment',
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
			this.viewDataGetRequest(data => this.props.onDataLoaded(data));
			this.props.onItemSelected(this.props.defaultValue);
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
			model: 'payment',
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
				input={<Input name="payment_type_id" id={inputID} />}>

				{data.map((item, i) => {
					return <MenuItem 
						key={i}
						value={item.id}>
							{this.props.lexicon['payment_'+ item.title]}
					</MenuItem>
				})}
			</Select>
		</FormControl>
	}
}

/**
 * Init redux states
 * @param {Object} state
 * @return {Object}
 */
function mapStateToProps(state) {
	return {
		lexicon: state.lexicon
	}
}

export default connect(mapStateToProps)(withStyles(styles)(SelectPayment));