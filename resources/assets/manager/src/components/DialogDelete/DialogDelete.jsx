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
class DialogDelete extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		title: 'Delete',
		defaultValue: false,
		content: 'Are you sure to delete current model?',
		classes: PropTypes.object.isRequired,
		onDialogClosed: () => {},
		onDialogConfirmed: () => {}
	}

	/**
	 * State object of component
	 * @type {Object} 
	 * @inner
	 */
	state = {
		deleteDailogOpen: this.props.defaultValue,
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { title, content } = this.props;
		let { deleteDailogOpen } = this.state;

		return <Dialog
				open={deleteDailogOpen}
				transition={Transition}
				keepMounted
				aria-labelledby="dialog-delete-slide-title"
				aria-describedby="dialog-delere-slide-content">

				<DialogTitle id="dialog-delete-slide-title">
					{title}
				</DialogTitle>

				<DialogContent>
					<DialogContentText id="dialog-delete-slide-text">
						{content}
					</DialogContentText>
				</DialogContent>

				<DialogActions>
					<Button 
						color="primary"
						onClick={e => this.setState({
							deleteDailogOpen: false
						}, () => this.props.onDialogClosed())}>
						Cancel
					</Button>

					<Button color="primary"
						onClick={e => this.props.onDialogConfirmed()}>
						OK
					</Button>
				</DialogActions>
			</Dialog>
	}
}

export default withStyles(styles)(DialogDelete);