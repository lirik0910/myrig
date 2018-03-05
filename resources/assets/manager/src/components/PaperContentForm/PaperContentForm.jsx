/**
 * Select page module
 * @module PriceField
 * @author Ihor Bielchenko
 * @requires react
 */

import React, { Component } from 'react';

import Paper from 'material-ui/Paper';
import draftToHtml from 'draftjs-to-html';
import { Editor } from 'react-draft-wysiwyg';
import TextField from 'material-ui/TextField';
import { 
	EditorState, 
	convertToRaw, 
	ContentState, 
	convertFromHTML 
} from 'draft-js';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';
import 'react-draft-wysiwyg/dist/react-draft-wysiwyg.css';

/**
 * Component for selecting page
 * @extends Component
 */
class PaperContentForm extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		inputID: 'title',
		descrID: 'descr',
		introID: 'intro',
		inputName: 'title',
		descrName: 'description',
		introName: 'introtext',
		inputTitle: 'Title',
		introTitle: 'Introtext',
		descrTitle: 'Description',
		inputDefaultValue: '',
		descrDefaultValue: '',
		introDefaultValue: '',
		editorDefaultValue: '',
		inputShow: true,
		descrShow: false,
		introShow: false,
		editorShow: true,
		classes: PropTypes.object.isRequired,
		onTitleFieldInputed: () => {},
		onDescrFieldInputed: () => {},
		onIntroFieldInputed: () => {},
		onEditorAreaInputed: () => {}
	}

	/**
	 * State object of component
	 * @type {Object} 
	 * @inner
	 */
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
		let { editorDefaultValue } = this.props;

		if (editorDefaultValue) {
			let blocksFromHTML = convertFromHTML(editorDefaultValue);
			let state = ContentState.createFromBlockArray(
				blocksFromHTML.contentBlocks,
				blocksFromHTML.entityMap
			);

			this.setState({ 
				editorState: EditorState.createWithContent(state) 
			});
		}
	}

	handleInputField = e => {
		var target = e.target;
		this.setState({ inputDefaultValue: target.value }, () => {
			this.props.onTitleFieldInputed(target.value);
		});
	}

	/**
	 * Edit content textarea
	 * @param {Object} editorState
	 */
	onEditorStateChange = editorState => {
		this.setState({ editorState }, () => {
			var content = draftToHtml(convertToRaw(editorState.getCurrentContent()));
			this.props.onEditorAreaInputed(content);
		});
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { editorState } = this.state;
		let { 
			classes, 
			inputID,
			descrID,
			introID,
			inputShow,
			descrShow,
			introShow,
			editorShow,
			inputName,
			descrName,
			introName,
			descrTitle,
			introTitle,
			inputTitle,
			descrDefaultValue,
			introDefaultValue,
			inputDefaultValue,
		} = this.props;

		return <Paper className={classes.paper}>
			{inputShow && <TextField
				id={inputID}
				label={inputTitle}
				type="text"
				name={inputName}
				onChange={this.handleInputField}
				defaultValue={inputDefaultValue}
				className={classes.textField}
				InputLabelProps={{
					shrink: true
				}} />}

			{descrShow && <TextField
				id={descrID}
				label={descrTitle}
				type="text"
				name={descrName}
				onChange={e => {
					var target = e.target;
					this.setState({ descrDefaultValue: target.value }, () => {
						this.props.onDescrFieldInputed(target.value);
					});
				}}
				defaultValue={descrDefaultValue}
				className={classes.textField}
				InputLabelProps={{
					shrink: true
			}} />}

			{introShow && <TextField
				id={introID}
				name={introName}
				label={introTitle}
				multiline={true}
				rows={4}
				defaultValue={introDefaultValue}
				className={classes.textField}
				onChange={e => {
					var target = e.target;
					this.setState({ introDefaultValue: target.value }, () => {
						this.props.onIntroFieldInputed(target.value);
					});
				}}
				InputLabelProps={{
					shrink: true
				}} />}

			{editorShow && <div>
				<Editor 
					editorState={editorState}
					editorClassName={classes.contentEditor}
					toolbarClassName={classes.toolbarEditor}
					onEditorStateChange={this.onEditorStateChange} />
			</div>}
		</Paper>
	}
}

export default withStyles(styles)(PaperContentForm);