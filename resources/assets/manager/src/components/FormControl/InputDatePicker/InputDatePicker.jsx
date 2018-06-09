/**
 * Select page module
 * @module CheckBoxActive
 * @author Ihor Bielchenko
 * @requires react
 */

import React, { Component } from 'react';

import { Typography } from 'material-ui';
import { DateTimePicker } from 'material-ui-pickers';

import DateRange from 'material-ui-icons/DateRange';
import AccessTime from 'material-ui-icons/AccessTime';
import KeyboardArrowLeft from 'material-ui-icons/KeyboardArrowLeft';
import KeyboardArrowRight from 'material-ui-icons/KeyboardArrowRight';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Component for selecting page
 * @extends Component
 */
class InputDatePicker extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		title: 'Publish date',
		defaultValue: new Date(),
		onDataLoaded: () => {},
		onDateFieldChanged: () => {},
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
		value: new Date(),
	}

	/**
	 * Invoked just before mounting occurs
	 * @fires componentWillMount
	 */
	componentWillMount() {
		let { defaultValue } = this.props;

		this.setState({ value: defaultValue }, () => {
			this.props.onDataLoaded(defaultValue)
		});
	}

	/**
	 * Change date
	 * @param {Object} date New date object
	 */
	handleDateChange = (date) => {
		this.setState({ value: date }, () => {
			this.props.onDateFieldChanged(date);
		});
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { value } = this.state;
		let { classes, title } = this.props;

		return <div className={classes.formControl}>
			<Typography 
				gutterBottom
				align="center"
				variant="headline"
				className={classes.label}>
					{title}
			</Typography>

			<DateTimePicker
				value={value}
				ampm={false}
				className={classes.dateInput +' date-picker__container'}
				onChange={this.handleDateChange}
				timeIcon={<AccessTime />}
				dateRangeIcon={<DateRange />}
				leftArrowIcon={<KeyboardArrowLeft />}
				rightArrowIcon={<KeyboardArrowRight />} />
		</div>
	}
}

export default withStyles(styles)(InputDatePicker);