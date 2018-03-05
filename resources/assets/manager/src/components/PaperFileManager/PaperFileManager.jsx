/**
 * Select page module
 * @module PriceField
 * @author Ihor Bielchenko
 * @requires react
 */

import App from '../../App.js';
import React, { Component } from 'react';

import Paper from 'material-ui/Paper';
import Dropzone from 'react-dropzone';
import Button from 'material-ui/Button';
import FileItem from './FileItem/FileItem.jsx';
import DialogError from '../DialogError/DialogError.jsx';

import Add from 'material-ui-icons/Add';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Component for selecting page
 * @extends Component
 */
class PaperFileManager extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		defaultPath: '/',
		onFileSelected: () => {},
		onFilesDataLoaded: () => {},
		classes: PropTypes.object.isRequired,
	}

	/**
	 * State object of component
	 * @type {Object} 
	 * @inner
	 */
	state = {
		data: [],
		path: '/',
		error: false,
		click: false,
		errorDialogMessage: '',
	}

	/**
	 * Invoked just before mounting occurs
	 * @fires componentWillMount
	 */
	componentWillMount() {
		let { defaultPath } = this.props;

		this.setState({ path: defaultPath }, () => {
			this.filesDataGetRequest(data => this.props.onFilesDataLoaded(data));
		});
	}

	/**
	 * Get files from server
	 * @param {Function} callback
	 */
	filesDataGetRequest(callback = () => {}) {
		let { path } = this.state;

		App.api({
			type: 'GET',
			name: 'path',
			model: 'file',
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
	 * Request for upload new files on server
	 * @fires click
	 */
	filesPostRequest = files => {
		let { path, click } = this.state;

		if (click === false) {
			this.setState({ click: true });

			var i,
				formData = new FormData();
			formData.append('path', path);

			formData.append('path', path);
			for (i = 0; i < files.length; i++) {
				formData.append('file[]', files[i]);
			}

			App.api({
				type: 'POST',
				name: 'path',
				model: 'file',
				formData: formData,
				headers: {
					'X-Requested-With': 'XMLHttpRequest',
					'X-CSRF-Token': App.csrf()
				},
				success: (r) => {
					r = JSON.parse(r.response);
					if (r) {
						this.setState({
							click: false,
							error: false,
							errorDialogMessage: ''
						}, () => {
							this.filesDataGetRequest(data => this.props.onFilesDataLoaded(data));
						});
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
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { classes} = this.props;
		let { data, path, error, errorDialogMessage } = this.state;

		return <Paper className={classes.paper}>
				<Dropzone onDrop={(files) => this.filesPostRequest(files)}
					style={{border: 'none'}}>
					
					<Button 
						variant="raised" 
						size="small"
						className={classes.add}>
					
						<Add />{'New file'}
					</Button>
				</Dropzone>

				<div className={classes.overflow}>
					{data.map((item, i) => {
						return <FileItem 
							key={i}
							data={item}
							path={path}
							onFileDeleted={path => {
								this.filesDataGetRequest(path => {
									this.props.onFilesDataLoaded(path);
								});
							}}
							onFileSelected={data => {
								this.props.onFileSelected(data);
							}}
							onFileNameChanged={name => {
								this.filesDataGetRequest(data => {
									this.props.onFilesDataLoaded(data);
								});
							}} />
					})}
				</div>

				{error === true && <DialogError 
					defaultValue={error}
					message={errorDialogMessage}
					onDialogClosed={() => this.setState({
						error: false
					})} />}
			</Paper>
	}
}

export default withStyles(styles)(PaperFileManager);