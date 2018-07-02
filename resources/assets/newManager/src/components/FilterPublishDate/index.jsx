/**
 * FilterPublishDate module
 * @requires react
 * @requires react#PureComponent
 * @requires prop-types
 * @requires material-ui-pickers#DateTimePicker
 * @requires @material-ui/icons/KeyboardArrowLeft
 * @requires @material-ui/icons/KeyboardArrowRight
 * @requires @material-ui/icons/AccessTime
 * @requires @material-ui/icons/DateRange
 * @requires @material-ui/core/styles#withStyles
 */

import React, { PureComponent } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { DateTimePicker } from 'material-ui-pickers';

import KeyboardArrowLeft from '@material-ui/icons/KeyboardArrowLeft';
import KeyboardArrowRight from '@material-ui/icons/KeyboardArrowRight';
import AccessTime from '@material-ui/icons/AccessTime';
import DateRange from '@material-ui/icons/DateRange';
import Button from '@material-ui/core/Button';

import styles from './styles.js';
import { withStyles } from '@material-ui/core/styles';

/**
 * FilterPublishDate block
 * @extends PureComponent
 */
class FilterPublishDate extends PureComponent {
	
	/**
	 * Props validators
	 * @type {object}
	 * @property {function} classes
	 */
	static propTypes = {
		classes: PropTypes.object.isRequired
	}

	static defaultProps = {
		onFilterChanged: (date, el) => {}
	}

	/**
	 * Current component state object
	 * @type {object}
	 * @property {object} dateFrom
	 * @property {object} dateTo
	 */
	state = {
		dateFrom: new Date(),
		dateTo: new Date(),
	}

	/**
	 * Change date from
	 * @fires onChange
	 * @param {data} object
	 * @param {string} el
	 */
	handleDateChange = (date, el) => {
		this.setState({ [el]: date }, () => 
			this.props.onFilterChanged(date, el));
	}

	/**
	 * Render component
	 * @return {object} jsx object
	 */
	render() {
		const { dateFrom, dateTo } = this.state;
		const { classes, langs } = this.props;

		return <div className={classes.root +' date-picker__container'}>
			<div style={{ margin: '12px 0' }}>
				<DateTimePicker
					value={dateFrom}
					name="dateFrom"
					invalidLabel=""
					onChange={(date) => this.handleDateChange(date, 'dateFrom')}
					label={langs['filterPublishDateFrom']}
					timeIcon={<AccessTime />}
					dateRangeIcon={<DateRange />}
					leftArrowIcon={<KeyboardArrowLeft />}
					rightArrowIcon={<KeyboardArrowRight />}
					className={classes.picker} />
			</div>

			<div style={{ margin: '12px 0' }}>
				<DateTimePicker
					value={dateTo}
					name="dateTo"
					invalidLabel=""
					onChange={(date) => this.handleDateChange(date, 'dateTo')}
					label={langs['filterPublishDateTo']}
					timeIcon={<AccessTime />}
					dateRangeIcon={<DateRange />}
					leftArrowIcon={<KeyboardArrowLeft />}
					rightArrowIcon={<KeyboardArrowRight />}
					className={classes.picker} />
			</div>

			{langs['filterPaublishDateClear'] && <Button 
				className={classes.clearBtn} 
				color="secondary"
				onClick={(e) => {
					this.setState({ 
						dateTo: null,
						dateFrom: null
					}, () => {
						this.handleDateChange(null);
					});
				}}>
				
				{langs['filterPaublishDateClear']}
			</Button>}
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

export default connect(mapStateToProps)(withStyles(styles)(FilterPublishDate));