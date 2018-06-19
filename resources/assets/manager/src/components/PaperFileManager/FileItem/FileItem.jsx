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
import Dialog, {
	DialogActions,
	DialogContent,
	DialogContentText,
	DialogTitle,
} from 'material-ui/Dialog';
import DialogError from '../../DialogError/DialogError.jsx';

import Create from 'material-ui-icons/Create';
import Delete from 'material-ui-icons/Delete';
import InsertDriveFile from 'material-ui-icons/InsertDriveFile';

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
class FileItem extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material default classes collection
	 */
	static defaultProps = {
		data: {},
		path: '/',
		onFileDeleted: () => {},
		onFileSelected: () => {},
		onFileNameChanged: () => {},
		onEditDialogClosed: () => {},
		onEditDialogOpened: () => {},
		onDeleteDialogOpened: () => {},
		onDeleteDialogClosed: () => {},
		classes: PropTypes.object.isRequired,
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
		value: this.props.data.name,
	}

	/**
	 * Request for rename file
	 * @param {String} name
	 */
	editFileNameRequest = name => {
		let { path, data } = this.props;


		App.api({
			type: 'PUT',
			name: 'path',
			model: 'file',
			data: {
				name: path + name,
				path: path + data.name
			},
			success: (r) => {
				r = JSON.parse(r.response);
				if (r) {
					this.setState({
						click: false, 
						error: false,
						editDailogOpen: false,
						errorDialogMessage: ''
					}, () => this.props.onFileNameChanged(name));
				}
			},
			error: (r) => {
				r = JSON.parse(r.response);
				if (r.message) {
					this.setState({ editDailogOpen: false }, () => {
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

	/**
	 * Delete file request
	 * @param {Object} e
	 */
	deleteFileRequest = e => {
		let { click } = this.state;
		let { path, data } = this.props;

		if (click === false) {
			this.setState({ click: true });

			App.api({
				type: 'DELETE',
				name: 'path',
				model: 'file',
				data: {
					path: path + data.name
				},
				success: (r) => {
					r = JSON.parse(r.response);
					if (r) {
						this.setState({ 
							click: false,
							error: false,
							deleteDailogOpen: false,
							errorDialogMessage: ''
						}, () => this.props.onFileDeleted(path + data.name));
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
		let { classes, data } = this.props;
		let { 
			click, 
			value, 
			error, 
			errorDialogMessage, 
			editDailogOpen, 
			deleteDailogOpen 
		} = this.state;

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
								if (click === false) {
									this.setState({ click: true }, () => {
										this.props.onFileSelected(data);
										this.setState({ click: false });
									});
								}
							}}>

						{data.type === 'jpg' || 
							data.type === 'png' || 
							data.type === 'jpeg' ? 
							<div classes={classes.file}>
								<img src={data.url} 
									alt={data.name}
									className={classes.img} />
									
								<span className={classes.fileName}>
									{data.name}
								</span>
							</div> : 
							<div classes={classes.file}>
								<span className={classes.fileName}>
									<div style={{fontSize: '26px'}}>
										<InsertDriveFile />
									</div>
									{data.name}
								</span>
							</div>}
						</Button>
					</Grid>
					
					<Grid item xs={2}>
						<Button
							variant="raised" 
							size="small"
							className={classes.button}
							onClick={e => {
								if (click === false) {
									this.setState({
										click: true,
										editDailogOpen: true,
										value: data.name,
									}, () => {
										this.props.onEditDialogOpened(data);
										this.setState({ click: false });
									});
								}
							}}>
							
							<Create />
						</Button>

						<Button
							variant="raised" 
							size="small"
							className={classes.button}
							onClick={e => {
								if (click === false) {
									this.setState({ 
										click: true,
										deleteDailogOpen: true
									}, () => {
										this.props.onDeleteDialogOpened(data.name);
										this.setState({ click: false });
									});
								}
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
							{this.props.lexicon.delete_file}
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
							onClick={this.deleteFileRequest}>
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
							label="Rename current file"
							type="text"
							id="name"
							defaultValue={value}
							onChange={e => {
								this.setState({ value: e.target.value });
							}}
							style={{minWidth: '342px'}} />
					</DialogContent>

					<DialogActions>
						<Button onClick={e => {
							if (click === false) {
								this.setState({
									click: true,
									editDailogOpen: false
								}, () => {
									this.props.onEditDialogClosed(data);
									this.setState({ click: false });
								});
							}
						}} color="primary">
							{this.props.lexicon.cancel_label}
						</Button>

						<Button color="primary"
							onClick={e => {
								if (click === false) {
									this.setState({ click: true }, () => {
										this.editFileNameRequest(value);
										this.setState({ click: false });
									});
								}
							}}>
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

export default connect(mapStateToProps)(withStyles(styles)(FileItem));