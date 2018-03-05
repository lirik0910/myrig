/**
 * Select page module
 * @module PriceField
 * @author Ihor Bielchenko
 * @requires react
 */

import Manager from '../../Manager.js';
import React, { Component } from 'react';

import Paper from 'material-ui/Paper';
import draftToHtml from 'draftjs-to-html';
import { Editor } from 'react-draft-wysiwyg';
import TextField from 'material-ui/TextField';
import { EditorState, convertToRaw } from 'draft-js';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';
import 'react-draft-wysiwyg/dist/react-draft-wysiwyg.css';

/**
 * Component for selecting page
 * @extends Component
 */
class BaseFormEditor extends Component {

	/**
	 * State object of component
	 * @type {Object} 
	 * @inner
	 * @property {Object} data Component data
	 * @property {Number} defaultValue Component data
	 */
	state = {
		editorState: EditorState.createEmpty(),
	}

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		classes: PropTypes.object.isRequired,
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { classes } = this.props;
		let { editorState } = this.state;

		return <Paper className={classes.paper}>
			<TextField
				id="title"
				label={'Title'}
				type="text"
				name="title"
				defaultValue=""
				className={classes.textField}
				InputLabelProps={{
					shrink: true
				}} />

			<div>
				<Editor 
					editorState={editorState}
					onEditorStateChange={this.onEditorStateChange}
					editorClassName={classes.contentEditor +' content-editor'}
					toolbarClassName={classes.toolbarEditor} />
					
				<textarea
					name="description"
					style={{display: 'none'}}
					value={draftToHtml(convertToRaw(editorState.getCurrentContent()))} />
			</div>
		</Paper>
	}
}

export default withStyles(styles)(BaseFormEditor);