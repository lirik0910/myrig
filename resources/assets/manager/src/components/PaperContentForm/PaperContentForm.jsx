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
import htmlToDraft from 'html-to-draftjs';
import Image from './Image.jsx';
import ColorPic from './ColorPic.jsx';

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

		articulID: 'articul',
		articulShow: false,
		articulName: 'articul',
		articulTitle: 'Articul',
		articulDefaultValue: '',

		classes: PropTypes.object.isRequired,
		onTitleFieldInputed: () => {},
		onDescrFieldInputed: () => {},
		onIntroFieldInputed: () => {},
		onEditorAreaInputed: () => {},
		onArticulFieldInputed: () => {}
	}

	/**
	 * State object of component
	 * @type {Object} 
	 * @inner
	 */
	state = {
		open: false,
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

		if (editorDefaultValue !== '' && editorDefaultValue !== null) {
			let blocksFromHTML = htmlToDraft(editorDefaultValue);

			if (blocksFromHTML.contentBlocks !== '' && blocksFromHTML.contentBlocks !== null) {
				let content = ContentState.createFromBlockArray(blocksFromHTML.contentBlocks);
				let editorState = EditorState.createWithContent(content);
				
				this.setState({ editorState });
			}
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
	onEditorStateChange: Function = (editorState) => {
		this.setState({
			editorState
		}, () => {
			var content = draftToHtml(convertToRaw(editorState.getCurrentContent()));
			this.props.onEditorAreaInputed(content);
		});
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { open } = this.state;
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

			articulID,
			articulShow,
			articulName,
			articulTitle,
			articulDefaultValue
		} = this.props;

		return <Paper className={classes.paper}>
			{inputShow && <TextField
				required
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

			{articulShow && <TextField
				required
				id={articulID}
				label={articulTitle}
				type="text"
				name={articulName}
				defaultValue={articulDefaultValue}
				onChange={e => {
					var target = e.target;
					this.setState({ articulDefaultValue: target.value }, () => {
						this.props.onArticulFieldInputed(target.value);
					});
				}}
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
					editorState={this.state.editorState}
					editorClassName={classes.contentEditor}
					toolbarClassName={classes.toolbarEditor}
					onEditorStateChange={this.onEditorStateChange}
					toolbar={{
						image: {
							component: Image,
						},
						colorPicker: {
							component: ColorPic
						},
					}} />
			</div>}
		</Paper>
	}
}

export default withStyles(styles)(PaperContentForm);