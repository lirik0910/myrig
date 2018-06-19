/**
 * Select page module
 * @module PriceField
 * @author Ihor Bielchenko
 * @requires react
 */

import App from '../../../App.js';
import React, { Component } from 'react';

import { connect } from 'react-redux';

import Grid from 'material-ui/Grid';
import Paper from 'material-ui/Paper';
import Button from 'material-ui/Button';
import TextField from 'material-ui/TextField';
import Slide from 'material-ui/transitions/Slide';
import DialogError from '../../DialogError/DialogError.jsx';
import Dialog, {
	DialogActions,
	DialogContent,
	DialogContentText,
	DialogTitle,
} from 'material-ui/Dialog';

import Create from 'material-ui-icons/Create';
import Delete from 'material-ui-icons/Delete';

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
class FolderItem extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		data: '',
		path: '/',
		classes: PropTypes.object.isRequired,
		onFolderChanged: () => {},
		onFolderDeleted: () => {},
		onEditDialogOpened: () => {},
		onEditDialogClosed: () => {},
		onFolderNameChanged: () => {},
		onDeleteDialogOpened: () => {},
		onDeleteDialogClosed: () => {}
	}

	/**
	 * State object of component
	 * @type {Object} 
	 * @inner
	 */
	state = {
		click: false,
		error: false,
		errorDialogMessage: '',
		editDailogOpen: false,
		deleteDailogOpen: false,
		value: this.props.data,
	}

	/**
	 * Request for edit folder
	 * @param {String} name
	 */
	editFolderNameRequest = name => {
		let { click } = this.state;
		let { path, data } = this.props;

		if (click === false) {
			this.setState({ click: true });

			App.api({
				type: 'PUT',
				name: 'path',
				model: 'folder',
				data: {
					name: path + name,
					path: path + data
				},
				success: (r) => {
					r = JSON.parse(r.response);
					if (r) {
						this.setState({ 
							click: false,
							error: false,
							editDailogOpen: false,
							errorDialogMessage: ''
						}, () => this.props.onFolderNameChanged(name));
					}
				},
				error: (r) => {
					r = JSON.parse(r.response);
					if (r.message) {
						this.setState({ editDailogOpen: false }, () => {
							this.setState({ 
								error: true,
								value: data,
								click: false,
								errorDialogMessage: r.message
							});
						});
					}
				}
			});
		}
	}

	/**
	 * Request for removing folder
	 * @param {Object} e
	 */
	deleteFolderRequest = e => {
		let { click } = this.state;
		let { path, data } = this.props;

		if (click === false) {
			this.setState({ click: true });

			App.api({
				type: 'DELETE',
				name: 'path',
				model: 'folder',
				data: {
					path: path + data
				},
				success: (r) => {
					r = JSON.parse(r.response);
					if (r) {
						this.setState({ 
							error: false,
							click: false,
							deleteDailogOpen: false,
							errorDialogMessage: ''
						}, () => this.props.onFolderDeleted(path + data));
					}
				},
				error: (r) => {
					r = JSON.parse(r.response);
					if (r.message) {
						this.setState({ deleteDailogOpen: false }, () => {
							this.setState({ 
								error: true,
								click: false,
								errorDialogMessage: r.message
							});
						});
					}
				}
			});
		}
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { data, classes } = this.props;
		let { value, editDailogOpen, deleteDailogOpen, error, errorDialogMessage } = this.state;

		return <Paper className={classes.folder}>
				<Grid 
					container 
					spacing={24} 
					className={classes.inner}>
					
					<Grid item xs={10}>
						<Button
							variant="raised" 
							size="small"
							className={classes.folderName}
							onClick={e => {
								this.props.onFolderChanged(data)
							}}>
								{data}
						</Button>
					</Grid>
					
					<Grid item xs={2}>
						<Button
							variant="raised" 
							size="small"
							className={classes.button}
							onClick={e => {
								this.setState({ editDailogOpen: true }, () => {
									this.props.onEditDialogOpened(data);
								});
							}}>
								<Create />
						</Button>

						<Button
							variant="raised" 
							size="small"
							className={classes.button}
							onClick={e => {
								this.setState({ deleteDailogOpen: true }, () => {
									this.props.onDeleteDialogOpened(data);
								});
							}}>
								<Delete />
						</Button>
					</Grid>
				</Grid>

				<Dialog
					open={deleteDailogOpen}
					transition={Transition}
					keepMounted
					aria-labelledby="dialog-delete-slide-title"
					aria-describedby="dialog-delere-slide-content">

					<DialogTitle id="dialog-delete-slide-title">
						{this.props.lexicon.delete_button}
					</DialogTitle>

					<DialogContent>
						<DialogContentText id="dialog-delete-slide-text">
							{this.props.lexicon.folder_delete}
						</DialogContentText>
					</DialogContent>

					<DialogActions>
						<Button 
							color="primary"
							onClick={e => this.setState({
								deleteDailogOpen: false
							})}>
							{this.props.lexicon.cancel_label}
						</Button>

						<Button color="primary"
							onClick={this.deleteFolderRequest}>
							{this.props.lexicon.ok_label}
						</Button>
					</DialogActions>
				</Dialog>

				{editDailogOpen === true && <Dialog
					open={editDailogOpen}
					transition={Transition}
					keepMounted
					aria-labelledby="dialog-edit-slide-title"
					aria-describedby="dialog-edit-slide-description">

					<DialogTitle id="dialog-edit-slide-title">
						{this.props.lexicon.edit_label}
					</DialogTitle>

					<DialogContent>
						<TextField
							autoFocus
							fullWidth
							margin="dense"
							label={this.props.lexicon.rename_folder}
							type="text"
							id="name"
							defaultValue={data}
							onChange={e => {
								this.setState({ value: e.target.value });
							}}
							style={{minWidth: '342px'}} />
					</DialogContent>

					<DialogActions>
						<Button onClick={e => {
							this.setState({
								value: data,
								editDailogOpen: false,
							}, () => this.props.onEditDialogClosed(data));
						}} color="primary">
							{this.props.lexicon.cancel_label}
						</Button>

						<Button color="primary"
							onClick={e => this.editFolderNameRequest(value)}>
							{this.props.lexicon.ok_label}
						</Button>
					</DialogActions>
				</Dialog>}

				{error === true && <DialogError 
					defaultValue={error}
					message={errorDialogMessage}
					onDialogClosed={() => this.setState({
						error: false
					})} />}
			</Paper>
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

export default connect(mapStateToProps)(withStyles(styles)(FolderItem));