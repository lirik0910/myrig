/**
 * Select page module
 * @module PriceField
 * @author Ihor Bielchenko
 * @requires react
 */

import React, { Component } from 'react';

import Button from 'material-ui/Button';

import draftToHtml from 'draftjs-to-html';
import { Editor } from 'react-draft-wysiwyg';
import { EditorState, convertToRaw, ContentState, convertFromHTML } from 'draft-js';

import Delete from 'material-ui-icons/Delete';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';
import 'react-draft-wysiwyg/dist/react-draft-wysiwyg.css';

/**
 * Component for selecting page
 * @extends Component
 */
class EditorFieldItem extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		data: {},
		onImageSet: () => {},
		onDeletedField: () => {},
		onFieldInputed: () => {},
		classes: PropTypes.object.isRequired,
	}

	state = {
		editorState: EditorState.createEmpty(),
	}

	/**
	 * Invoked just before mounting occurs
	 * @fires componentWillMount
	 */
	componentWillMount() {
		this.editorSetDefaultValue();
	}

	/**
	 * Set default text to editor area
	 */
	editorSetDefaultValue() {
		let { data } = this.props;

		if (data.content) {
			let blocksFromHTML = convertFromHTML(data.content);
			let state = ContentState.createFromBlockArray(
				blocksFromHTML.contentBlocks,
				blocksFromHTML.entityMap
			);

			this.setState({ 
				editorState: EditorState.createWithContent(state) 
			});
		}
	}

	/**
	 * Edit content textarea
	 * @param {Object} editorState
	 */
	onEditorStateChange = editorState => {
		this.setState({ editorState }, () => {
			var content = draftToHtml(convertToRaw(editorState.getCurrentContent()));
			this.props.onFieldInputed(content, this.props.data);
		});
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { editorState } = this.state;
		let { classes, data } = this.props;

		return <div>
				<Editor 
					editorState={editorState}
					editorClassName={classes.contentEditor}
					toolbarClassName={classes.toolbarEditor}
					onEditorStateChange={this.onEditorStateChange} />
			
				<Button 
					className={classes.button} 
					variant="raised" 
					color="secondary"
					onClick={e => this.props.onDeletedField(data)}>
						<Delete />{'Remove field'}
				</Button>
			</div>
	}
}

export default withStyles(styles)(EditorFieldItem);