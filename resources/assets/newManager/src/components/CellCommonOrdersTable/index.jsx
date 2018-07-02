/**
 * CellCommonOrdersTable module
 * @requires react
 * @requires react#PureComponent
 * @requires prop-types
 * @requires @material-ui/core/Grid
 * @requires @material-ui/core/Button
 * @requires @material-ui/core/IconButton
 * @requires @material-ui/core/Paper
 * @requires components/TableDefault
 * @requires components/BreadCrumbs
 * @requires components/MenuDefault
 * @requires components/FilterPages
 * @requires @material-ui/icons/Add
 * @requires @material-ui/icons/Delete
 * @requires @material-ui/icons/Create
 * @requires @material-ui/icons/ContentCopy
 * @requires @material-ui/core/styles#withStyles
 */

import React, { PureComponent, Fragment } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';

import Typography from '@material-ui/core/Typography';

import styles from './styles.js';
import { withStyles } from '@material-ui/core/styles';

/**
 * CellCommonOrdersTable block
 * @extends PureComponent
 */
class CellCommonOrdersTable extends PureComponent {
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
	 * @property {array} head
	 * @property {array} rows
	 */
	static defaultProps = {
		delete: false,
		number: '',
		status: '',
		color: '#000',
		context: '',
		date: ''
	}

	/**
	 * Render component
	 * @return {object} jsx object
	 */
	render() {
		let { classes, number, status, color, context, date, langs } = this.props;

		return <Fragment>
			<Typography 
				variant="display1">
				{this.props['delete'] === true ? 
					<span 
						style={{ 
							color: 'red', 
							textDecoration: 'line-through' 
						}}>
						# {number}
					</span> : 
					<span># {number}</span>}
			</Typography>

			<div 
				className={classes.status}
				style={{ color }}>
				
				<span className={'mark '+ status.replace(/\s/g, '').toLowerCase()}>
					{ langs['status_'+ status] }
				</span>
			</div>

			<div 
				className={classes.vertical}>
				
				{langs['tableContextTitle']}: {context}
			</div>

			<div
				className={classes.vertical +' '+ classes.weight}>
				{date}
			</div>
		</Fragment>
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

export default connect(mapStateToProps)(withStyles(styles)(CellCommonOrdersTable));