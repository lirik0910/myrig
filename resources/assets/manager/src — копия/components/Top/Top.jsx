/**
 * Header block module
 * @module Users
 * @author Ihor Bielchenko
 * @requires react
 * @requires react#Component
 * @requires redux#bindActionCreators
 * @requires react-redux#connect
 */

import React, { Component } from 'react';

import Manager from '../../Manager.js';
import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';
import Save from 'material-ui-icons/Save';
import Grid from 'material-ui/Grid';
import Button from 'material-ui/Button';
import Typography from 'material-ui/Typography';

/**
 * Header block
 * @extends Component
 */
class Top extends Component {

	/**
	 * State object of component
	 * @type {Object} 
	 * @inner
	 * @property {Array} contexts
	 * @property {String} currentID 
	 */
	state = {
	}

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		classes: PropTypes.object.isRequired,
		title: 'Title'
	}

	/**
	 * Render 
	 */
	render() {
		let { classes, title } = this.props;

		return <Grid container spacing={24} className={classes.root}>
					<Grid item xs={11}>
						<Typography className={classes.title}>
							{title}
						</Typography>
					</Grid>
					
					<Grid item xs={1}>
						<Button className={classes.button} 
							variant="raised" 
							size="small">
								<Save className={classes.leftIcon} />Save
						</Button>
					</Grid>
				</Grid>
	}
}

export default withStyles(styles)(Top);