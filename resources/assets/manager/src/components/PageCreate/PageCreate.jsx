/**
 * Module for create new page
 * @module PageCreate
 * @author Ihor Bielchenko
 */

import React, { Component } from 'react';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import { Link } from 'react-router-dom';
import Manager from '../../Manager.js';

import styles from './styles.js';
import PropTypes from 'prop-types';
import Paper from 'material-ui/Paper';
import { withStyles } from 'material-ui/styles';
import Grid from 'material-ui/Grid';
import TextField from 'material-ui/TextField';
import Select from 'material-ui/Select';
import { MenuItem } from 'material-ui/Menu';
import Tabs, { Tab } from 'material-ui/Tabs';
import Input, { InputLabel } from 'material-ui/Input';
import { FormControl, FormHelperText } from 'material-ui/Form';
import Button from 'material-ui/Button';
import Typography from 'material-ui/Typography';
import Dialog, {
	DialogActions,
	DialogContent,
	DialogContentText,
	DialogTitle,
} from 'material-ui/Dialog';
import { LinearProgress } from 'material-ui/Progress';
import Save from 'material-ui-icons/Save';
import Delete from 'material-ui-icons/Delete';
import AddIcon from 'material-ui-icons/Add';
import { Editor } from 'react-draft-wysiwyg';
import { EditorState, convertToRaw, ContentState } from 'draft-js';
import draftToHtml from 'draftjs-to-html';
import htmlToDraft from 'html-to-draftjs';
import 'react-draft-wysiwyg/dist/react-draft-wysiwyg.css';
import Slide from 'material-ui/transitions/Slide';
import * as StateElementAction from '../../actions/StateElementAction.js';

/**
 * Add new page
 * @extends Component
 */
class PageCreate extends Component {

	/**
	 * Animate opening dialog
	 * @param {Object} props
	 */
	transition(props) {
		return <Slide direction="up" {...props} />
	}

	/**
	 * State object of component
	 * @type {Object} 
	 * @inner
	 * @property {Number} value Current tab
	 */
	state = {
		id: 0,
		value: 0,
		view: [],
		parent: [],
		context: [],
		page: {
			context_id: 0,
			parent_id: 0,
			view_id: 0
		},
		click: false,
		completed: 100,
		editorState: EditorState.createEmpty(),
		dialog: {
			title: '',
			content: '',
			actions: '',
			open: false,
		}
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
	 * Invoked just before mounting occurs
	 * @fires componentWillMount
	 */
	componentWillMount() {
		this.getUrlProps(() => {
			this.getContextData(() => {
				this.getViewData(() => this.getParentData())
			});
		});
	}

	/**
	 * Get props from url
	 * @param {Function} callback
	 */
	getUrlProps(callback = () => {}) {
		let { page } = this.state;
		let url = Manager.getLocationProps();

		if (typeof url.context_id !== 'undefined') {
			page.context_id = Number(url.context_id);
		}

		if (typeof url.parent_id !== 'undefined') {
			page.parent_id = Number(url.parent_id);
		}

		this.setState({ page }, () => callback());
	}

	/**
	 * Get data about contexts
	 */
	getContextData(callback = () => {}) {
		let xhr = Manager.xhr();

		xhr.open('GET', Manager.url +'/api/context/', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xhr.setRequestHeader('X-CSRF-Token', Manager.csrf());
		xhr.send();

		xhr.onreadystatechange = () => {
			if((xhr.status === 200 || xhr.status === 201) && xhr.readyState === 4) {
				var r = JSON.parse(xhr.response);
				if(r) {
					this.setState({ context: r }, () => callback());
				}
			}
		}
	}

	/**
	 * Get data about views
	 */
	getViewData(callback = () => {}) {
		let xhr = Manager.xhr();

		xhr.open('GET', Manager.url +'/api/view/', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xhr.setRequestHeader('X-CSRF-Token', Manager.csrf());
		xhr.send();

		xhr.onreadystatechange = () => {
			if((xhr.status === 200 || xhr.status === 201) && xhr.readyState === 4) {
				var r = JSON.parse(xhr.response);
				if(r) {
					this.setState({ view: r }, () => callback());
				}
			}
		}
	}

	/**
	 * Get parent pages
	 */
	getParentData(callback = () => {}) {
		let xhr = Manager.xhr();

		xhr.open('GET', Manager.url +'/api/page', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xhr.setRequestHeader('X-CSRF-Token', Manager.csrf());
		xhr.send();

		xhr.onreadystatechange = () => {
			if((xhr.status === 200 || xhr.status === 201) && xhr.readyState === 4) {
				var r = JSON.parse(xhr.response);
				if(r) {
					this.setState({ parent: r }, () => callback());
				}
			}
		}
	}

	/**
	 * Change select fields
	 * @fires click
	 * @param {String} type Select type
	 * @param {Object} e
	 */
	handleChangeSelect(type, e) {
		let { page } = this.state;

		page[type] = e.target.value;
		this.setState({ page });
	};

	/**
	 * Change tab
	 * @fires click
	 * @param {Object} event
	 */
	handleChangeTab = (event, value) => {
		this.setState({ value });
	}

	/**
	 * Edit content textarea
	 * @param {Object} editorState
	 */
	onEditorStateChange = editorState => {
		this.setState({ editorState });
	}

	/**
	 * Save page
	 * @fires click
	 * @param {Object} e
	 */
	handleSavePage(e) {
		let form = document.getElementById('edit-page-form');
		let a = document.getElementById('pages-link');

		if (form && a) {
			let xhr = Manager.xhr();
			let { click } = this.state;

			if(click === false) {
				this.setState({
					click: true,
					completed: 0
				});

				var i,
					r,
					body = '';

				for(i = 0; i < form.elements.length; i++) {
					body += form.elements[i].name +'='+ encodeURIComponent(form.elements[i].value) +'&';
				}
				body = body.substring(0, body.length - 1);

				xhr.open('POST', Manager.url +'/api/page', true);
				xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
				xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
				xhr.setRequestHeader('X-CSRF-Token', Manager.csrf());
				xhr.send(body);

				xhr.onreadystatechange = () => {
					if(xhr.readyState === 4) {
						if(xhr.status === 200 || xhr.status === 201) {
							r = JSON.parse(xhr.response);
							if(r) {
								this.openDialog('Ответ', 'Страница успешно сохранена',
									<DialogActions>
										<Button onClick={this.closeDialog.bind(this)} color="primary">
											OK
										</Button>
									</DialogActions>, 
								() => {
									this.setState({
										id: r.id
									}, () => {
										setTimeout(() => {
											a.click();
										}, 500);
									});
								});
							}
						}

						if(xhr.status === 422 || xhr.status === 419 || xhr.status === 500) {
							r = JSON.parse(xhr.response);

							if(r.message) {
								this.openDialog('Ошибка во время сохранения страницы', r.message,
									<DialogActions>
										<Button onClick={this.closeDialog.bind(this)} color="primary">
											OK
										</Button>
									</DialogActions>);
							}
						}

						this.setState({
							click: false,
							completed: 100
						});
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
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { classes } = this.props;
		let { 
			id,
			value, 
			page, 
			editorState, 
			view, 
			parent,
			context,
			dialog,
			completed
		} = this.state;

		return <div className={classes.root}>
				{completed === 0 && 
					<LinearProgress color="secondary" variant="determinate" value={completed} />}
				<Grid container spacing={24} className={classes.root}>
					<Grid item xs={11}>
						<Typography className={classes.title}>
							Главная страница
						</Typography>
					</Grid>
					<Grid item xs={1}>
						<Button className={classes.button} 
							variant="raised" 
							size="small"
							onClick={this.handleSavePage.bind(this)}>
								<Save className={classes.leftIcon} />Save
						</Button>
					</Grid>
				</Grid>

				<Tabs value={value} onChange={this.handleChangeTab}>
					<Tab label={'Страница'} />
				</Tabs>

				{value === 0 && <form id="edit-page-form">
					<Grid container spacing={24} className={classes.root}>
						<Grid item xs={9}>
							<Paper className={classes.paper}>
								<TextField
									id="title"
									label="Название"
									type="text"
									name="title"
									defaultValue=""
									className={classes.textField}
									InputLabelProps={{
										shrink: true
									}} />

								<TextField
									id="description"
									label="Описание"
									type="text"
									name="description"
									defaultValue=""
									className={classes.textField}
									InputLabelProps={{
										shrink: true
									}} />

								<TextField
									id="introtext"
									name="introtext"
									label="Аннотация"
									multiline={true}
									rows={4}
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
										name="content"
										style={{display: 'none'}}
										value={draftToHtml(convertToRaw(editorState.getCurrentContent()))} />
								</div>
							</Paper>
						</Grid>

						<Grid item xs={3}>
							<Paper className={classes.paper}>
								<FormControl className={classes.formControl}>
									<InputLabel htmlFor="context-select">Контекст страницы</InputLabel>
									<Select
										value={page.context_id}
										onChange={this.handleChangeSelect.bind(this, 'context_id')}
										input={<Input name="context_id" id="context-select" />}>

											<MenuItem value="0">
												<em>None</em>
											</MenuItem>

											{context.map((item, index) => {
												return <MenuItem 
														value={item.id} 
														key={index}>
															{item.title}
														</MenuItem>
											})}
									</Select>
								</FormControl>

								<FormControl className={classes.formControl}>
									<InputLabel htmlFor="parent-select">Родительская страница</InputLabel>
									<Select
										value={page.parent_id}
										onChange={this.handleChangeSelect.bind(this, 'parent_id')}
										input={<Input name="parent_id" id="parent-select" />}>
											
											<MenuItem value="0">
												<em>None</em>
											</MenuItem>

											{parent.map((item, index) => {
												return <MenuItem 
														value={item.id} 
														key={index}>
															{item.link}
														</MenuItem>
											})}
									</Select>
								</FormControl>

								<FormControl className={classes.formControl}>
									<InputLabel htmlFor="view-select">Шаблон</InputLabel>
									<Select
										name="view_id"
										value={page.view_id}
										onChange={this.handleChangeSelect.bind(this, 'view_id')}
										input={<Input name="view" id="view-select" />}>
											
											<MenuItem value="0">
												<em>None</em>
											</MenuItem>

											{view.map((item, index) => {
												return <MenuItem 
														value={item.id} 
														key={index}>
															{item.title}
														</MenuItem>
											})}
									</Select>
								</FormControl>

								<TextField
									id="link"
									name="link"
									label="Адрес"
									type="text"
									defaultValue=""
									className={classes.textField}
									InputLabelProps={{
										shrink: true
									}} />
							</Paper>
						</Grid>
					</Grid>
				</form>}

				<Dialog
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
							<DialogContentText id="alert-dialog-slide-description">
								{dialog.content}
							</DialogContentText>
						</DialogContent>

						{dialog.actions}
				</Dialog>
				<Link to={Manager.url +'/pages/'+ id} id="pages-link" style={{display: 'none'}}></Link>
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

export default connect(mapStateToProps, mapDispatchToProps)(withStyles(styles)(PageCreate));