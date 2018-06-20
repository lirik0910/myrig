/**
 * Select page module
 * @module PriceField
 * @author Ihor Bielchenko
 * @requires react
 */

import App from '../../App.js';
import React, { Component } from 'react';

import { connect } from 'react-redux';

import Grid from 'material-ui/Grid';
import Paper from 'material-ui/Paper';
import Button from 'material-ui/Button';
import TextField from 'material-ui/TextField';
import Slide from 'material-ui/transitions/Slide';
import FolderItem from './FolderItem/FolderItem.jsx';
import DialogError from '../DialogError/DialogError.jsx';
import Dialog, {
	DialogActions,
	DialogContent,
	DialogTitle,
} from 'material-ui/Dialog';
import List, { ListItem, ListItemIcon } from 'material-ui/List';

import Reply from 'material-ui-icons/Reply';
import CreateNewFolder from 'material-ui-icons/CreateNewFolder';

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
class PaperFolderManager extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		defaultPath: '/',
		classes: PropTypes.object.isRequired,
		onFolderDataLoaded: () => {},
		onFolderChanged: () => {},
		onFolderCreateNameSet: () => {}
	}

	/**
	 * State object of component
	 * @type {Object} 
	 * @inner
	 */
	state = {
		data: [],
		path: '/',
		ready: true,
		error: false,
		click: false,
		newFolder: '',
		errorDialogMessage: '',
		createDailogOpen: false
	}

	/**
	 * Invoked just before mounting occurs
	 * @fires componentWillMount
	 */
	componentWillMount() {
		let { defaultPath } = this.props;

		this.setState({ path: defaultPath }, () => {
			this.folderDataGetRequest(data => this.props.onFolderDataLoaded(data));
		});
	}

	/**
	 * Get folders list from server
	 * @param {Function} callback
	 */
	folderDataGetRequest(callback = () => {}) {
		let { path } = this.state;

		App.api({
			type: 'GET',
			name: 'path',
			model: 'folder',
			data: {
				path
			},
			success: (r) => {
				r = JSON.parse(r.response);
				if (r) {
					this.setState({ data: r }, () => callback(r));
				}
			}
		});
	}

	/**
	 * Open new folder
	 * @fores click
	 * @param {String} folder
	 * @param {Object} e
	 */
	openFolder = (folder = '/', callback = () => {}) => {
		let { path } = this.state;

		var string = path + folder +'/';
		if (folder === -1) {
			var split = path.split('/'),
				i;

			string = '/';
			for (i = 1; i < split.length - 2; i++) {
				string += split[i] +'/';
			}
		}

		if (folder !== '/') {
			this.setState({ path: string }, () => {
				this.folderDataGetRequest(data => {
					this.props.onFolderChanged(string);
					callback();
				});
			});
		}
	}

	/**
	 * Request for creating new folder
	 * @param {String} name
	 */
	createFolderRequest = name => {
		let { path } = this.state;
		App.api({
			type: 'POST',
			name: 'path',
			model: 'folder',
			data: {
				path: path + name
			},
			success: (r) => {
				r = JSON.parse(r.response);
				if (r) {
					this.setState({
						error: false,
						errorDialogMessage: '',
						createDailogOpen: false
					}, () => {
						this.folderDataGetRequest(data => this.props.onFolderChanged(path + name));
					});
				}
			},
			error: (r) => {
				r = JSON.parse(r.response);
				if (r.message) {
					this.setState({ editDailogOpen: false }, () => {
						this.setState({ 
							error: true,
							errorDialogMessage: r.message
						});
					});
				}
			}
		});
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { classes} = this.props;
		let { 
			path, 
			data, 
			click, 
			ready,
			error,
			newFolder, 
			createDailogOpen, 
			errorDialogMessage 
		} = this.state;

		return <Paper className={classes.paper}>
				<Grid container spacing={24} className={classes.inner}>
					<Grid item xs={11}>
						{ready === true && <TextField
							disabled
							id="path"
							type="text"
							name="title"
							defaultValue={path}
							className={classes.pathField}
							InputLabelProps={{
								shrink: true
							}} />}
					</Grid>

					<Grid item xs={1}>
						<Button
							variant="raised" 
							size="small"
							className={classes.button}
							onClick={e => this.setState({
								createDailogOpen: true
							})}>
								<CreateNewFolder />
						</Button>
					</Grid>
				</Grid>

				<List component="nav">
					<ListItem button
						onClick={e => {
							if (click === false) {
								this.setState({ 
									click: true,
									ready: false
								}, () => {
									this.openFolder(-1, () => {
										this.setState({ 
											ready: true,
											click: false
										});
									});
								});
							}
						}}>

						<ListItemIcon>
							<Reply />
						</ListItemIcon>
					</ListItem>
				</List>

				<div className={classes.overflow}>
					{data.map((item, i) => {
						return <FolderItem
							key={i}
							data={item}
							path={path}
							onFolderDeleted={path => {
								this.folderDataGetRequest(path => {
									this.props.onFolderDataLoaded(path);
								});
							}}
							onFolderNameChanged={name => {
								this.folderDataGetRequest(data => {
									this.props.onFolderDataLoaded(data);
								});
							}}
							onDeleteDialogClosed={() => {
								this.folderDataGetRequest(data => {
									this.props.onFolderDataLoaded(data);
								});
							}}
							onFolderChanged={data => {
								this.setState({ ready: false }, () => {
									this.openFolder(data, () => {
										this.setState({ ready: true });
									});
								});
							}} />
					})}
				</div>

				{createDailogOpen === true && <Dialog
					open={createDailogOpen}
					transition={Transition}
					keepMounted
					aria-labelledby="dialog-create-slide-title"
					aria-describedby="dialog-create-slide-description">

					<DialogTitle id="dialog-create-slide-title">
						{this.props.lexicon.create}
					</DialogTitle>

					<DialogContent>
						<TextField
							autoFocus
							fullWidth
							margin="dense"
							label={this.props.lexicon.create_new_folder}
							type="text"
							id="name"
							onChange={e => {
								var target = e.target;
								this.setState({ newFolder: target.value }, () => {
									this.props.onFolderCreateNameSet(target.value);
								});
							}}
							style={{minWidth: '342px'}} />
					</DialogContent>

					<DialogActions>
						<Button 
							color="primary"
							onClick={e => this.setState({ 
								newFolder: '',
								createDailogOpen: false
							})}>
							{this.props.lexicon.cancel_label}
						</Button>

						<Button color="primary"
							onClick={e => this.createFolderRequest(newFolder)}>
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

export default connect(mapStateToProps)(withStyles(styles)(PaperFolderManager));