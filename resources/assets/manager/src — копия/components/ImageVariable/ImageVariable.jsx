/**
 * Select page module
 * @module PriceField
 * @author Ihor Bielchenko
 * @requires react
 */

import Manager from '../../Manager.js';
import React, { Component } from 'react';

import Paper from 'material-ui/Paper';
import Button from 'material-ui/Button';
import Typography from 'material-ui/Typography';
import FieldItem from './FieldItem/FieldItem.jsx';
import { FormControl, FormHelperText  } from 'material-ui/Form';

import AddIcon from 'material-ui-icons/Add';
import Delete from 'material-ui-icons/Delete';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Component for selecting page
 * @extends Component
 */
class ImageVariable extends Component {

	/**
	 * State object of component
	 * @type {Object} 
	 * @inner
	 * @property {Object} data Component data
	 * @property {Number} defaultValue Component data
	 */
	state = {
		data: [],
	}

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		title: 'Images',
		classes: PropTypes.object.isRequired,
		onSetImage: () => {},
		onAddedField: () => {},
		onDeletedField: () => {},
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { classes, title } = this.props;

		return <Paper className={classes.paper}>
				<Typography className={classes.title}>
					{title}
				</Typography>

				<FormControl className={classes.formControl} aria-describedby="name-helper-text">
					<FieldItem />

					<FormHelperText id="name-helper-text">
						<Button 
							variant="fab" 
							color="primary" 
							aria-label="add" 
							className={classes.button}>
								<AddIcon />{'Add field'}
						</Button>
					</FormHelperText>
				</FormControl>
			</Paper>
	}
}

export default withStyles(styles)(ImageVariable);