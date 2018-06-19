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

import { connect } from 'react-redux';

import Dialog, {
	DialogActions,
	DialogContent,
	DialogTitle,
} from 'material-ui/Dialog';
import Button from 'material-ui/Button';
import TextField from 'material-ui/TextField';
import { FormControl } from 'material-ui/Form';
import Slide from 'material-ui/transitions/Slide';
import SelectPolicy from '../FormControl/SelectPolicy/SelectPolicy.jsx';

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
 * Header block
 * @extends Component
 */
class DialogUser extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		data: {},
		defaultValue: false,
		onDialogClosed: () => {},
		onDialogConfirmed: () => {},
		classes: PropTypes.object.isRequired,
	}

	state = {
		editDailogOpen: this.props.defaultValue,
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { classes, data } = this.props;
		let { editDailogOpen } = this.state;

		return <Dialog
				open={editDailogOpen}
				transition={Transition}
				keepMounted
				aria-labelledby="edit-dialog-slide-title"
				aria-describedby="edit-dialog-slide-content">
				
				<DialogTitle id="edit-dialog-slide-title">
					{this.props.lexicon.edit_label}
				</DialogTitle>

				<form id="edit-user-form" onSubmit={e => {
					e.preventDefault();
					var data = {};
					for (var i = 0; i < e.target.elements.length; i++) {
						if (e.target.elements[i].name) {
							data[e.target.elements[i].name] = e.target.elements[i].value;
						}
					}

					this.props.onDialogConfirmed(data);
				}}>	
					<DialogContent>
						<FormControl className={classes.formControl}>
							<TextField
								id="name"
								label={this.props.lexicon.table_name}
								type="text"
								name="name"
								defaultValue={data.name}
								className={classes.textField}
								InputLabelProps={{
									shrink: true
								}} />
						</FormControl>

						<FormControl className={classes.formControl}>
							<TextField
								id="email"
								label={this.props.lexicon.table_email}
								type="email"
								name="email"
								defaultValue={data.email}
								className={classes.textField}
								InputLabelProps={{
									shrink: true
								}} />
						</FormControl>

						<FormControl className={classes.formControl}>
							<TextField
								id="password"
								label={this.props.lexicon.new_password}
								type="password"
								name="new_password"
								defaultValue=""
								className={classes.textField}
								InputLabelProps={{
									shrink: true
								}} />
						</FormControl>

						<FormControl className={classes.formControl}>
							<TextField
								id="confirm-password"
								label={this.props.lexicon.register_confirm}
								type="password"
								name="confirm_password"
								defaultValue=""
								className={classes.textField}
								InputLabelProps={{
									shrink: true
								}} />
						</FormControl>

						<SelectPolicy
							title={this.props.lexicon.select_policy}
							defaultValue={data.policy_id} />
					</DialogContent>

					<DialogActions>
						<Button color="primary"
							onClick={e => this.props.onDialogClosed()}>
							{this.props.lexicon.cancel_label}
						</Button>

						<Button color="primary"
							type="submit">
							{this.props.lexicon.ok_label}
						</Button>
					</DialogActions>
				</form>
			</Dialog>
	}
}

/**
 * Init redux states
 * @param {Object} state
 * @return {Object}
 */
function mapStateToProps(state) {
	return {
		lexicon: state.lexicon
	}
}

export default connect(mapStateToProps)(withStyles(styles)(DialogUser));