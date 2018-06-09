/**
 * Header block module
 * @module Header
 * @author Ihor Bielchenko
 * @requires react
 * @requires react#Component
 * @requires redux#bindActionCreators
 * @requires react-redux#connect
 */

import React, { Component } from 'react';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';

import styles from './styles.js';
import PropTypes from 'prop-types';
import classNames from 'classnames';
import Toolbar from 'material-ui/Toolbar';
import Typography from 'material-ui/Typography';
import IconButton from 'material-ui/IconButton';
import Tooltip from 'material-ui/Tooltip';
import DeleteIcon from 'material-ui-icons/Delete';
import FilterListIcon from 'material-ui-icons/FilterList';
import { withStyles } from 'material-ui/styles';

/**
 * Header block
 * @extends Component
 */
class EnhancedTableToolbar extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		classes: PropTypes.object.isRequired,
		numSelected: PropTypes.number.isRequired,
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		const { numSelected, classes } = this.props;
		return <Toolbar
			className={classNames(classes.root, {
				[classes.highlight]: numSelected > 0,
			})}>
				<div className={classes.title}>
					{numSelected > 0 ? (
						<Typography type="subheading">{numSelected} selected</Typography>
					) : (
						<Typography type="title">Nutrition</Typography>)}
				</div>

				<div className={classes.spacer} />
	
				<div className={classes.actions}>
					{numSelected > 0 ? (
						<Tooltip title="Delete">
							<IconButton aria-label="Delete">
								<DeleteIcon />
							</IconButton>
						</Tooltip>
					) : (
						<Tooltip title="Filter list">
							<IconButton aria-label="Filter list">
								<FilterListIcon />
							</IconButton>
						</Tooltip>
					)}
				</div>
			</Toolbar>
	}
}

/**
 * Init redux states
 * @param {Object} state
 * @return {Object}
 */
function mapStateToProps(state) {
	return {
		elements: state.elements
	}
}

/**
 * Init redux actions
 * @param {Function} dispatch
 * @return {Object}
 */
function mapDispatchToProps(dispatch) {
	return {
		//StateElementAction: bindActionCreators(StateElementAction, dispatch),
	}
}

export default connect(mapStateToProps, mapDispatchToProps)(withStyles(styles)(EnhancedTableToolbar));