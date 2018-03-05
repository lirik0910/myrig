/**
 * Base module of manager users container
 * @module ProductContainers
 * @author Ihor Bielchenko
 * @requires react
 * @requires react#Component
 * @requires redux#bindActionCreators
 * @requires react-redux#connect
 */

import React, { Component } from 'react';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';
import * as StateElementAction from '../actions/StateElementAction.js';
import Header from '../components/Header/Header.jsx';
import Menu from '../components/Menu/Menu.jsx';
import Top from '../components/Top/Top.jsx';
import Tabs, { Tab } from 'material-ui/Tabs';
import Paper from 'material-ui/Paper';
import Input, { InputLabel } from 'material-ui/Input';
import TextField from 'material-ui/TextField';
import Grid from 'material-ui/Grid';
import Delete from 'material-ui-icons/Delete';
import Button from 'material-ui/Button';
import AddIcon from 'material-ui-icons/Add';
import Typography from 'material-ui/Typography';
import { MenuItem } from 'material-ui/Menu';
import Select from 'material-ui/Select';
import { FormControl, FormHelperText, FormControlLabel  } from 'material-ui/Form';
import { Editor } from 'react-draft-wysiwyg';
import { EditorState, convertToRaw } from 'draft-js';
import draftToHtml from 'draftjs-to-html';
import 'react-draft-wysiwyg/dist/react-draft-wysiwyg.css';
import { LinearProgress } from 'material-ui/Progress';

import ImageVariable from '../components/ImageVariable/ImageVariable.jsx';
import BaseFormEditor from '../components/BaseFormEditor/BaseFormEditor.jsx';
import ProductFormPaper from '../components/ProductFormPaper/ProductFormPaper.jsx';

const styles = theme => ({
	root: {
		width: '100%',
		margin: 0,
		padding: 0,
	},
	paper: {
		marginTop: '12px',
		marginBottom: '12px',
		padding: theme.spacing.unit * 2,
		textAlign: 'center',
		color: theme.palette.text.secondary,
	},
	textField: {
		margin: '8px 8px 14px 8px',
		width: '100%',
	},
	formControl: {
		margin: theme.spacing.unit,
		minWidth: '100%',
	},
	toolbarEditor: {
		fontFamily: 'arial'
	},
	contentEditor: {
		fontFamily: 'arial',
		color: '#000',
		height: '226px'
	},
	title: {
		fontSize: '20px',
		textAlign: 'left'
	},
});

/**
 * Users base container
 * @extends Component
 */
class CreateProductContainers extends Component {

	state = {
		tab: 0,
		data: {},
		images: [],
		completed: 100,
		activeChecked: true,
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
	 * Change tab
	 * @fires click
	 * @param {Object} event
	 */
	handleChangeTab = (event, tab) => {
		this.setState({ tab });
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { classes } = this.props;
		let { completed, tab, editorState, activeChecked } = this.state;

		return <div className={classes.root +' users__container'}>
				<Header title="Add product" />
				<Menu />

				{completed === 0 && 
					<LinearProgress color="secondary" variant="determinate" value={completed} />}

				<Top title={'Create new product'} />

				<Tabs value={tab} onChange={this.handleChangeTab}>
					<Tab label={'Product'} />
				</Tabs>

				<Grid container spacing={24} className={classes.root}>
					<Grid item xs={9}>
						<BaseFormEditor />
						<ImageVariable />
					</Grid>

					<Grid item xs={3}>
						<ProductFormPaper />
					</Grid>
				</Grid>
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

export default connect(mapStateToProps, mapDispatchToProps)(withStyles(styles)(CreateProductContainers));