/**
 * Select page module
 * @module PriceField
 * @author Ihor Bielchenko
 * @requires react
 */

import React, { Component } from 'react';

import Button from 'material-ui/Button';
import Slide from 'material-ui/transitions/Slide';
import Dialog, {
	DialogActions,
	DialogContent,
	DialogContentText,
	DialogTitle,
} from 'material-ui/Dialog';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Animate opening dialog
 * @param {Object} props
 * @return {Object} JSX object
 */
function Transition(props) {
	return <Slide direction="up" {...props} />;
}

/**
 * Component for selecting page
 * @extends Component
 */
class DialogError extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		title: 'Edit',
		message: '',
		defaultValue: false,
		classes: PropTypes.object.isRequired,
		onDialogClosed: () => {},
	}

	/**
	 * State object of component
	 * @type {Object} 
	 * @inner
	 */
	state = {
		open: this.props.defaultValue,
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { open } = this.state;
		let { title, message, classes, defaultValue } = this.props;

		return <Dialog
				open={open}
				transition={Transition}
				keepMounted
				aria-labelledby="dialog-error-slide-title"
				aria-describedby="dialog-error-slide-text">

				<DialogTitle id="dialog-error-slide-title">
					{title}
				</DialogTitle>

				<DialogContent>
					<DialogContentText id="dialog-error-slide-text">
						{message}
					</DialogContentText>
				</DialogContent>

				<DialogActions>
					<Button color="primary"
						onClick={e => this.props.onDialogClosed()}>
						OK
					</Button>
				</DialogActions>
			</Dialog>
	}
}

export default withStyles(styles)(DialogError);