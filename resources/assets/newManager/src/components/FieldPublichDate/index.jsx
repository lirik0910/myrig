/**
 * FieldPublichDate module
 * @requires react
 * @requires react#PureComponent
 */

import React, { PureComponent } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';

import { DateTimePicker } from 'material-ui-pickers';
import KeyboardArrowLeft from '@material-ui/icons/KeyboardArrowLeft';
import KeyboardArrowRight from '@material-ui/icons/KeyboardArrowRight';
import AccessTime from '@material-ui/icons/AccessTime';
import DateRange from '@material-ui/icons/DateRange';

import styles from './styles.js';
import { withStyles } from '@material-ui/core/styles';

/**
 * FieldPublichDate block
 * @extends PureComponent
 */
class FieldPublichDate extends PureComponent {

	/**
	 * Props validators
	 * @type {object}
	 * @property {function} classes
	 */
	static propTypes = {
		classes: PropTypes.object.isRequired
	}

	/**
	 * Default properties
	 * @type {object}
	 */
	static defaultProps = {
		format: 'YYYY-MM-DD hh:mm:ss',
		name: 'fieldOrderDate',
		handleDateChange: (e) => {},
		defaultValue: new Date()
	}

	state = {
		date: this.props.defaultValue
	}

	/**
	 * Render component
	 * @return {object} jsx object
	 */
	render() {
		let { classes, name, format, langs } = this.props,
			{ date } = this.state;

		return <div className={classes.root}>
			<DateTimePicker
				format={format}
				value={date}
				ampm={false}
				name={name}
				label={langs['labelFieldOrderDate']}
				onChange={(date) => {
					this.setState({ date }, () => {
						this.props.handleDateChange(date);
					});
				}}
				timeIcon={<AccessTime />}
				dateRangeIcon={<DateRange />}
				leftArrowIcon={<KeyboardArrowLeft />}
				rightArrowIcon={<KeyboardArrowRight />}
				className={classes.picker} />
			</div>
	}
}

/**
 * Init redux states
 * @param {Object} state
 * @return {Object}
 */
function mapStateToProps(state) {
	return {
		langs: state.langs
	}
}

export default connect(mapStateToProps)(withStyles(styles)(FieldPublichDate));