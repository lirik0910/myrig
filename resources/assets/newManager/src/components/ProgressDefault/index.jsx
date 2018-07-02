/**
 * ProgressDefault module
 * @requires react
 * @requires react#PureComponent
 * @requires prop-types
 * @requires @material-ui/core/LinearProgress
 * @requires @material-ui/core/styles#withStyles
 */

import React, { PureComponent, Fragment } from 'react';
import PropTypes from 'prop-types';

import LinearProgress from '@material-ui/core/LinearProgress';

import styles from './styles.js';
import { withStyles } from '@material-ui/core/styles';

/**
 * ProgressDefault block
 * @extends PureComponent
 */
class ProgressDefault extends PureComponent {

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
	 * @property {boolean} completed
	 */
	static defaultProps = {
		completed: false
	}

	/**
	 * Render component
	 * @return {object} jsx object
	 */
	render() {
		let { classes, completed } = this.props;

		return completed === false ? 
			<LinearProgress 
				color="secondary"
				className={classes.progress} /> :
			<Fragment />
	}
}

export default withStyles(styles)(ProgressDefault);