/**
 * File manager module
 * @module Files
 * @author Ihor Bielchenko
 * @requires react
 * @requires react#Component
 * @requires redux#bindActionCreators
 * @requires react-redux#connect
 */

import React, { Component } from 'react';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import Dropzone from 'react-dropzone';

import Manager from '../../Manager.js';
import styles from './styles.js';
import { withStyles } from 'material-ui/styles';
import * as StateElementAction from '../../actions/StateElementAction.js';
import Paper from 'material-ui/Paper';
import Grid from 'material-ui/Grid';
import Button from 'material-ui/Button';
import TextField from 'material-ui/TextField';
import Add from 'material-ui-icons/Add';
import Reply from 'material-ui-icons/Reply';
import Create from 'material-ui-icons/Create';
import Delete from 'material-ui-icons/Delete';
import InsertDriveFile from 'material-ui-icons/InsertDriveFile';
import CreateNewFolder from 'material-ui-icons/CreateNewFolder';
import List, { ListItem, ListItemIcon } from 'material-ui/List';
import Dialog, {
	DialogActions,
	DialogContent,
	DialogContentText,
	DialogTitle,
} from 'material-ui/Dialog';
import { LinearProgress } from 'material-ui/Progress';
import Slide from 'material-ui/transitions/Slide';

/**
 * File manager component
 * @extends Component
 */
class Files extends Component {

	/**
	 * Animate opening dialog
	 * @param {Object} props
	 * @return {Object} JSX element
	 */
	transition(props) {
		return <Slide direction="up" {...props} />
	}

	/**
	 * Component default props
	 */
	static defaultProps = {
		selectFile: () => {}
	}

	/**
	 * State object of component
	 * @type {Object} 
	 * @inner
	 * @property {String} click Flag of ckick
	 * @property {String} path Curret file path
	 * @property {Array} folders Folders array of current path
	 * @property {Array} files Files array of current path
	 * @property {Object} dialog Settings of dialog window
	 * @property {Number} completed Loading indicator of progress bar (0 - 100)
	 */
	state = {
		click: false,
		path: '/',
		folders: [],
		files: [],
		dialog: {
			title: '',
			content: '',
			actions: '',
			open: false,
		},
		completed: 0
	}

	/**
	 * Invoked just before mounting occurs
	 * @fires componentWillMount
	 */
	componentWillMount() {
		this.setState({ completed: 0 }, () => {
			this.loadFolders(() => 
				this.loadFiles(() => this.setState({ completed: 100 }))
			)
		});
	}

	/**
	 * Request for loading folders
	 * @param {Function} callback
	 */
	loadFolders(callback = () => {}) {
		let xhr = Manager.xhr();
		let { path } = this.state;

		xhr.open('GET', Manager.url +'/api/folder?path='+ path, true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xhr.setRequestHeader('X-CSRF-Token', Manager.csrf());
		xhr.send();

		var r;
		xhr.onreadystatechange = () => {
			if (xhr.readyState === 4) {

				/** If success response
				 */
				if (xhr.status === 200 || xhr.status === 201) {
					r = JSON.parse(xhr.response);
					if(r) {
						this.setState({ folders: r }, () => callback());
					}
				}

				/** If error response.
				 * Show dialog window with error message
				 */
				if(xhr.status === 422 || xhr.status === 500 || xhr.status === 419) {
					r = JSON.parse(xhr.response);
					if(r.message) {
						this.openDialog('Ошибка во время получения каталогов', 
							<DialogContentText id="alert-dialog-slide-description">
								{r.message}
							</DialogContentText>,
							<DialogActions>
								<Button onClick={this.closeDialog.bind(this)} color="primary">
									OK
								</Button>
							</DialogActions>, () => this.setState({ completed: 100 }));
					}
				}
			}
		}
	}

	/**
	 *
	 */
	loadFiles(callback = () => {}) {
		let xhr = Manager.xhr();
		let { path } = this.state;

		xhr.open('GET', Manager.url +'/api/file?path='+ path, true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xhr.setRequestHeader('X-CSRF-Token', Manager.csrf());
		xhr.send();

		var r;
		xhr.onreadystatechange = () => {
			if (xhr.readyState === 4) {
				if (xhr.status === 200 || xhr.status === 201) {
					r = JSON.parse(xhr.response);
					if(r) {
						this.setState({ files: r }, () => callback());
					}
				}

				if(xhr.status === 422 || xhr.status === 500 || xhr.status === 419) {
					r = JSON.parse(xhr.response);
					if(r.message) {
						this.openDialog('Ошибка во время получения файлов', 
							<DialogContentText id="alert-dialog-slide-description">
								{r.message}
							</DialogContentText>,
							<DialogActions>
								<Button onClick={this.closeDialog.bind(this)} color="primary">
									OK
								</Button>
							</DialogActions>, () => this.setState({ completed: 100 }));
					}
				}
			}
		}
	}

	/**
	 * Show dialog window
	 * @param {String} title Hrader of window
	 * @param {String} content Window text content
	 * @param {Function} callback
	 */
	openDialog(title = '', content = '', actions = '', callback = () => {}) {
		let { dialog } = this.state;

		dialog.title = title;
		dialog.content = content;
		dialog.actions = actions;
		dialog.open = true;

		this.setState({ dialog }, () => callback());
	}

	/**
	 * Hide dialog window
	 * @fires click
	 * @param {Object} e
	 */
	closeDialog(e) {
		let { dialog } = this.state;
		dialog.open = false;

		this.setState({ dialog });
	}

	/**
	 * Open new folder
	 * @fores click
	 * @param {String} folder
	 * @param {Object} e
	 */
	openFolder(folder = '/', e) {
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
				this.setState({ completed: 0 }, () => {
					this.loadFolders(() => 
						this.loadFiles(() => this.setState({ completed: 100 }))
					)
				});
			});
		}
	}

	/**
	 * Open dialog for rename file
	 * @fires click
	 * @param {String} currentName
	 * @param {Object} e
	 */
	editFileDialog(currentName, e) {
		this.openDialog('Edit', <div>
			<TextField
				autoFocus
				margin="dense"
				label="Rename current file"
				type="text"
				id="name"
				defaultValue={currentName}
				style={{minWidth: '342px'}}
				fullWidth />
			</div>, 
			<DialogActions>
				<Button onClick={this.closeDialog.bind(this)} color="primary">
					Cancel
				</Button>

				<Button onClick={this.editFileRequest.bind(this, currentName)} color="primary">
					OK
				</Button>
			</DialogActions>);
	}

	/**
	 * Open dialog for remove folder
	 * @fires click
	 * @param {Object} e
	 */
	deleteFolderDialog(currentName, e) {
		this.openDialog('Delete', 
			<DialogContentText id="alert-dialog-slide-description">
				Вы действительно хотите удалить данный каталог
			</DialogContentText>, 
			<DialogActions>
				<Button onClick={this.closeDialog.bind(this)} color="primary">
					Cancel
				</Button>

				<Button onClick={this.deleteFolderRequest.bind(this, currentName)} color="primary">
					OK
				</Button>
			</DialogActions>);
	}

	/**
	 * Open dialog for remove folder
	 * @fires click
	 * @param {Object} e
	 */
	deleteFileDialog(currentName, e) {
		this.openDialog('Delete', 
			<DialogContentText id="alert-dialog-slide-description">
				Вы действительно хотите удалить данный файл
			</DialogContentText>, 
			<DialogActions>
				<Button onClick={this.closeDialog.bind(this)} color="primary">
					Cancel
				</Button>

				<Button onClick={this.deleteFileRequest.bind(this, currentName)} color="primary">
					OK
				</Button>
			</DialogActions>);
	}

	/**
	 * Open dialog for create new folder
	 * @fires click
	 * @param {Object} e
	 */
	createNewFolderDialog(e) {
		this.openDialog('Create', <div>
			<TextField
				autoFocus
				margin="dense"
				label="Create new folder"
				type="text"
				id="name"
				style={{minWidth: '342px'}}
				fullWidth />
			</div>, 
			<DialogActions>
				<Button onClick={this.closeDialog.bind(this)} color="primary">
					Cancel
				</Button>

				<Button onClick={this.createNewFolderRequest.bind(this)} color="primary">
					OK
				</Button>
			</DialogActions>);
	}

	/**
	 * Request for rename folder
	 */
	editFileRequest(currentName) {
		let name = document.getElementById('name');

		if (name && name.value) {
			let xhr = Manager.xhr();
			let { path, click } = this.state;

			if(click === false) {
				var body = '',
					r;

				this.setState({ 
					completed: 0, 
					click: true 
				});

				body += 'name='+ encodeURIComponent(path + name.value);
				body += '&path='+ encodeURIComponent(path + currentName);

				xhr.open('PUT', Manager.url +'/api/folder', true);
				xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
				xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
				xhr.setRequestHeader('X-CSRF-Token', Manager.csrf());
				xhr.send(body);

				xhr.onreadystatechange = () => {
					if (xhr.readyState === 4) {
						if (xhr.status === 200 || xhr.status === 201) {
							this.loadFolders(() => 
								this.loadFiles(() => this.setState({ 
									completed: 100, 
									click: false
								}, () => {
									this.closeDialog()
								}))
							)
						}

						if(xhr.status === 422 || xhr.status === 500 || xhr.status === 419) {
							r = JSON.parse(xhr.response);
							if(r.message) {
								this.openDialog('Ошибка во время изменения каталога', 
									<DialogContentText id="alert-dialog-slide-description">
										{r.message}
									</DialogContentText>,
									<DialogActions>
										<Button onClick={this.closeDialog.bind(this)} color="primary">
											OK
										</Button>
									</DialogActions>, () => this.setState({ 
										completed: 100,
										click: false
									}));
							}
						}
					}
				}
			}
		}
	}

	deleteFileRequest(currentName) {
		let xhr = Manager.xhr();
		let { path, click } = this.state;

		if(click === false) {
			this.setState({ 
				completed: 0, 
				click: true 
			});

			xhr.open('DELETE', Manager.url +'/api/file', true);
			xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
			xhr.setRequestHeader('X-CSRF-Token', Manager.csrf());
			xhr.send('path='+ encodeURIComponent(path + currentName));

			var r;
			xhr.onreadystatechange = () => {
				if (xhr.readyState === 4) {
					if (xhr.status === 200 || xhr.status === 201) {
						this.loadFolders(() => 
							this.loadFiles(() => this.setState({ 
								completed: 100, 
								click: false
							}, () => {
								this.closeDialog()
							}))
						)
					}

					else {
						r = JSON.parse(xhr.response);
						if(r.message) {
							this.openDialog('Ошибка во время удаления файла', 
								<DialogContentText id="alert-dialog-slide-description">
									{r.message}
								</DialogContentText>,
								<DialogActions>
									<Button onClick={this.closeDialog.bind(this)} color="primary">
										OK
									</Button>
								</DialogActions>, () => this.setState({ 
									completed: 100,
									click: false
								}));
						}
					}
				}
			}
		}
	}

	/**
	 * Request for remove folder
	 * @param {String} currentName
	 */
	deleteFolderRequest(currentName) {
		let xhr = Manager.xhr();
		let { path, click } = this.state;

		if(click === false) {
			this.setState({ 
				completed: 0, 
				click: true 
			});

			xhr.open('DELETE', Manager.url +'/api/folder', true);
			xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
			xhr.setRequestHeader('X-CSRF-Token', Manager.csrf());
			xhr.send('path='+ encodeURIComponent(path + currentName));

			var r;
			xhr.onreadystatechange = () => {
				if (xhr.readyState === 4) {
					if (xhr.status === 200 || xhr.status === 201) {
						this.loadFolders(() => 
							this.loadFiles(() => this.setState({ 
								completed: 100, 
								click: false
							}, () => {
								this.closeDialog()
							}))
						)
					}

					else {
						r = JSON.parse(xhr.response);
						if(r.message) {
							this.openDialog('Ошибка во время удаления каталога', 
								<DialogContentText id="alert-dialog-slide-description">
									{r.message}
								</DialogContentText>,
								<DialogActions>
									<Button onClick={this.closeDialog.bind(this)} color="primary">
										OK
									</Button>
								</DialogActions>, () => this.setState({ 
									completed: 100,
									click: true
								}));
						}
					}
				}
			}
		}
	}

	/**
	 * Request for create new folder
	 * @fires click
	 * @param {Object} e
	 */
	createNewFolderRequest(e) {
		let name = document.getElementById('name');

		if (name && name.value) {
			let xhr = Manager.xhr();
			let { path, click } = this.state;

			if(click === false) {
				var r;

				this.setState({ 
					completed: 0, 
					click: true 
				});

				xhr.open('POST', Manager.url +'/api/folder', true);
				xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
				xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
				xhr.setRequestHeader('X-CSRF-Token', Manager.csrf());
				xhr.send('path='+ encodeURIComponent(path + name.value));

				xhr.onreadystatechange = () => {
					if (xhr.readyState === 4) {
						if (xhr.status === 200 || xhr.status === 201) {
							this.loadFolders(() => 
								this.loadFiles(() => this.setState({ 
									completed: 100, 
									click: false
								}, () => {
									this.closeDialog()
								}))
							)
						}

						if(xhr.status === 422 || xhr.status === 500 || xhr.status === 419) {
							r = JSON.parse(xhr.response);
							if(r.message) {
								this.openDialog('Ошибка во время добавления каталога', 
									<DialogContentText id="alert-dialog-slide-description">
										{r.message}
									</DialogContentText>,
									<DialogActions>
										<Button onClick={this.closeDialog.bind(this)} color="primary">
											OK
										</Button>
									</DialogActions>, () => this.setState({ 
										completed: 100,
										click: false
									}));
							}
						}
					}
				}
			}
		}
	}

	/**
	 * Request for upload new files on server
	 * @fires click
	 */
	uploadFilesRequest(files) {
		let { path, click } = this.state;

		if(click === false) {
			let xhr = Manager.xhr();
			var r,
				i,
				formData = new FormData();

			this.setState({ 
				completed: 0, 
				click: true 
			});

			formData.append('path', path);
			for (i = 0; i < files.length; i++) {
				formData.append('file[]', files[i]);
			}

			xhr.open('POST', Manager.url +'/api/file', true);
			xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
			xhr.setRequestHeader('X-CSRF-Token', Manager.csrf());
			xhr.send(formData);

			xhr.onreadystatechange = () => {
				if (xhr.readyState === 4) {
					if (xhr.status === 200 || xhr.status === 201) {
						this.loadFolders(() => 
							this.loadFiles(() => this.setState({ 
								completed: 100, 
								click: false
							}, () => {
								this.closeDialog()
							}))
						)
					}

					if(xhr.status === 422 || xhr.status === 500 || xhr.status === 419) {
						r = JSON.parse(xhr.response);
						if(r.message) {
							this.openDialog('Ошибка во время добавления каталога', 
								<DialogContentText id="alert-dialog-slide-description">
									{r.message}
								</DialogContentText>,
								<DialogActions>
									<Button onClick={this.closeDialog.bind(this)} color="primary">
										OK
									</Button>
								</DialogActions>, () => this.setState({ 
									completed: 100,
									click: false
								}));
						}
					}
				}
			}
		}
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { path, dialog, completed, folders, files } = this.state;
		let { classes } = this.props;

		return <div style={{height: '100%'}}>
				{completed === 0 && 
					<LinearProgress color="secondary" variant="determinate" value={completed} />}
				<Grid container spacing={24} className={classes.root}>
					<Grid item xs={6}>
						<Paper className={classes.paper}>
							<Grid container spacing={24} className={classes.inner}>
								<Grid item xs={11}>
									<TextField
										disabled
										id="path"
										type="text"
										name="title"
										value={path}
										defaultValue={path}
										className={classes.pathField}
										InputLabelProps={{
											shrink: true
										}} />
								</Grid>

								<Grid item xs={1}>
									<Button
										variant="raised" 
										size="small"
										className={classes.button}
										onClick={this.createNewFolderDialog.bind(this)}>
											<CreateNewFolder />
									</Button>
								</Grid>
							</Grid>

							<List component="nav">
								<ListItem button
									onClick={this.openFolder.bind(this, -1)}>
										<ListItemIcon>
											<Reply />
										</ListItemIcon>
								</ListItem>
							</List>

							<div className={classes.overflow}>
								{folders.map((item, index) => {
									return <Paper className={classes.folder}>
										<Grid key={index} 
											container 
											spacing={24} 
											className={classes.inner}>
										<Grid item xs={10}>
											<Button
												variant="raised" 
												size="small"
												className={classes.folderName}
												onClick={this.openFolder.bind(this, item)}>
													{item}
											</Button>
										</Grid>
										<Grid item xs={2}>
											<Button
												variant="raised" 
												size="small"
												className={classes.button}
												onClick={this.editFileDialog.bind(this, item)}>
													<Create />
											</Button>

											<Button
												variant="raised" 
												size="small"
												className={classes.button}
												onClick={this.deleteFolderDialog.bind(this, item)}>
													<Delete />
											</Button>
										</Grid>
									</Grid>
								</Paper>
								})}
							</div>
						</Paper>
					</Grid>

					<Grid item xs={6}>
						<Paper className={classes.paper}>
							<Dropzone onDrop={(files) => this.uploadFilesRequest(files)}
									style={{border: 'none'}}>
								<Button 
									variant="raised" 
									size="small"
									className={classes.add}>
										<Add />{'New file'}
								</Button>
							</Dropzone>

							<div className={classes.overflow}>
							{files.map((item, index) => {
								return <Paper className={classes.folder}>
									<Grid key={index} 
										container 
										spacing={24} 
										className={classes.inner}>
		
										<Grid item xs={10}>
											<Button
												variant="raised" 
												size="small"
												className={classes.folderName}
												onClick={this.props.selectFile.bind(this, item, path)}>

												{item.type === 'jpg' || 
													item.type === 'png' || 
													item.type === 'jpeg' ? 
												<div classes={classes.file}>
													<img src={item.url} 
														alt={item.name}
														className={classes.img} />
													<span className={classes.fileName}>
														{item.name}
													</span>
												</div> : 
												<div classes={classes.file}>
													<span className={classes.fileName}>
														<div style={{fontSize: '26px'}}>
															<InsertDriveFile />
														</div>
														{item.name}
													</span>
												</div>}
											</Button>
										</Grid>
										<Grid item xs={2}>
											<Button
												variant="raised" 
												size="small"
												className={classes.button}
												onClick={this.editFileDialog.bind(this, item.name)}>
													<Create />
											</Button>

											<Button
												variant="raised" 
												size="small"
												className={classes.button}
												onClick={this.deleteFileDialog.bind(this, item.name)}>
													<Delete />
											</Button>
										</Grid>
									</Grid>
								</Paper>
							})}
							</div>
						</Paper>
					</Grid>
				</Grid>

				{dialog.open === true && <Dialog
					open={dialog.open}
					transition={this.transition}
					keepMounted
					onClose={this.openDialog}
					aria-labelledby="alert-dialog-slide-title"
					aria-describedby="alert-dialog-slide-description">

						<DialogTitle id="alert-dialog-slide-title">
							{dialog.title}
						</DialogTitle>

						<DialogContent>
							{dialog.content}
						</DialogContent>

						{dialog.actions}
				</Dialog>}
			</div>
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
		StateElementAction: bindActionCreators(StateElementAction, dispatch),
	}
}

export default connect(mapStateToProps, mapDispatchToProps)(withStyles(styles)(Files));