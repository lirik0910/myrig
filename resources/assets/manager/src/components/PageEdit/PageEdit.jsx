/**
 * Module for create or update page
 * @module PageEdit
 * @author Ihor Bielchenko
 */

import React, { Component } from 'react';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import { Link } from 'react-router-dom';
import Manager from '../../Manager.js';
import Files from '../Files/Files.jsx';

import styles from './styles.js';
import PropTypes from 'prop-types';
import Paper from 'material-ui/Paper';
import AppBar from 'material-ui/AppBar';
import Toolbar from 'material-ui/Toolbar';
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
import IconButton from 'material-ui/IconButton';
import Save from 'material-ui-icons/Save';
import Delete from 'material-ui-icons/Delete';
import AddIcon from 'material-ui-icons/Add';
import CloseIcon from 'material-ui-icons/Close';
import { Editor } from 'react-draft-wysiwyg';
import { EditorState, convertToRaw, ContentState, convertFromHTML } from 'draft-js';
import draftToHtml from 'draftjs-to-html';
import htmlToDraft from 'html-to-draftjs';
import 'react-draft-wysiwyg/dist/react-draft-wysiwyg.css';
import Slide from 'material-ui/transitions/Slide';
import * as StateElementAction from '../../actions/StateElementAction.js';

/**
 * Animate opening dialog
 * @param {Object} props
 * @return {Object} JSX object
 */
function Transition(props) {
	return <Slide direction="up" {...props} />;
}

/**
 * Add or edit page
 * @extends Component
 */
class PageEdit extends Component {

	/**
	 * State object of component
	 * @type {Object} 
	 * @inner
	 * @property {Number} value Current tab
	 */
	state = {
		click: false,
		files: false,
		value: 0,
		page: '',
		input: {
			input: '',
			variable: '',
			field: ''
		},
		view: [],
		parent: [],
		context: [],
		variables: [],
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
		this.setState({ completed: 0 }, () => {
			this.getContextData(() => 
				this.getViewData(() => 
					this.getPageData(() => 
						this.getVariablesData(() => {
							this.getAdditionalFieldsData(() => 
								this.getParentData(() => this.setState({ completed: 100 }))
							)
						})
					)
				)
			)
		});
	}

	/**
	 * Get additional field
	 * @param {Function} callback
	 */
	getVariablesData(callback = () => {}) {
		let xhr = Manager.xhr();
		let { page } = this.state;

		xhr.open('GET', Manager.url +'/api/variable/'+ page.view_id, true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xhr.setRequestHeader('X-CSRF-Token', Manager.csrf());
		xhr.send();

		var r,
			i,
			data = [];
		xhr.onreadystatechange = () => {
			if(xhr.readyState === 4) {
				if(xhr.status === 200 || xhr.status === 201) {
					r = JSON.parse(xhr.response);
					if (r) {
						for (i = 0; i < r.length; i++) {
							r[i]['data'] = [];
						}
						data = r;
					}
					this.setState({ variables: data }, () => callback());
				}
			}
		}
	}

	/**
	 * Get data of additional field
	 * @param {Function} callback
	 */
	getAdditionalFieldsData(callback = () => {}) {
		let xhr = Manager.xhr();
		let { page, variables } = this.state;

		xhr.open('GET', Manager.url +'/api/page/variable/'+ page.id, true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xhr.setRequestHeader('X-CSRF-Token', Manager.csrf());
		xhr.send();

		var r,
			i,
			a,
			state,
			blocksFromHTML;
		xhr.onreadystatechange = () => {
			if(xhr.readyState === 4) {
				if(xhr.status === 200 || xhr.status === 201) {
					r = JSON.parse(xhr.response);
					if (r) {
						for (i = 0; i < r.length; i++) {
							for (a = 0; a < variables.length; a++) {
								if(r[i].variable_id === variables[a].id) {
									if (variables[a].type === 'richtext') {
										blocksFromHTML = convertFromHTML(r[i].content);
										state = ContentState.createFromBlockArray(
											blocksFromHTML.contentBlocks,
											blocksFromHTML.entityMap
										);
										r[i]['editorState'] = EditorState.createWithContent(state);
									}
									
									variables[a].data.push(r[i]);
								}
							}
						}
					}
					this.setState({ variables }, () => callback());
				}
			}
		}
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

		var r;
		xhr.onreadystatechange = () => {
			if((xhr.status === 200 || xhr.status === 201) && xhr.readyState === 4) {
				r = JSON.parse(xhr.response);
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

		var r;
		xhr.onreadystatechange = () => {
			if((xhr.status === 200 || xhr.status === 201) && xhr.readyState === 4) {
				r = JSON.parse(xhr.response);
				if(r) {
					this.setState({ view: r }, () => callback());
				}
			}
		}
	}

	/**
	 * Get current page data
	 */
	getPageData(callback = () => {}) {
		let { page, editorState } = this.state;

		let query = Manager.defineResourceProps();
		let id = query[query.length - 1];
		let xhr = Manager.xhr();

		xhr.open('GET', Manager.url +'/api/page/'+ id, true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xhr.setRequestHeader('X-CSRF-Token', Manager.csrf());
		xhr.send();

		var r;
		xhr.onreadystatechange = () => {
			if((xhr.status === 200 || xhr.status === 201) && xhr.readyState === 4) {
				r = JSON.parse(xhr.response);
				if(r) {
					if (r.content) {
						let blocksFromHTML = convertFromHTML(r.content);
						let state = ContentState.createFromBlockArray(
							blocksFromHTML.contentBlocks,
							blocksFromHTML.entityMap
						);

						this.setState({ 
							page: r,
							editorState: EditorState.createWithContent(state),
						}, () => callback());
					}

					else this.setState({ page: r }, () => callback());
				}
			}
		}
	}

	/**
	 * Get parent pages
	 */
	getParentData(callback = () => {}) {
		let xhr = Manager.xhr();
		let { page } = this.state;

		xhr.open('GET', Manager.url +'/api/page/except/'+ page.id, true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xhr.setRequestHeader('X-CSRF-Token', Manager.csrf());
		xhr.send();

		var r,
			data = [];
		xhr.onreadystatechange = () => {
			if((xhr.status === 200 || xhr.status === 201) && xhr.readyState === 4) {
				r = JSON.parse(xhr.response);
				if(r) {
					data = r;
				}
				this.setState({ parent: data }, () => callback());
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
		if (form) {
			let xhr = Manager.xhr();
			let { page, click, variables } = this.state;

			if(click === false) {
				this.setState({
					click: true,
					completed: 0
				});

				var i,
					r,
					a,
					body = '',
					fieldsData,
					fields = [];

				for (i = 0; i < variables.length; i++) {
					fieldsData = [];
					for (a = 0; a < variables[i].data.length; a++) {
						fieldsData.push({
							page_id: variables[i].data[a].page_id,
							variable_id: variables[i].data[a].variable_id,
							content: variables[i].type === 'richtext' ? draftToHtml(convertToRaw(variables[i].data[a].editorState.getCurrentContent())) : variables[i].data[a].content,
						});
					}
					fields.push(fieldsData);
				}

				body += 'fields='+ encodeURIComponent(JSON.stringify(fields)) +'&';
				for(i = 0; i < form.elements.length; i++) {
					body += form.elements[i].name +'='+ encodeURIComponent(form.elements[i].value) +'&';
				}
				body = body.substring(0, body.length - 1);

				xhr.open('PUT', Manager.url +'/api/page/'+ page.id, true);
				xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
				xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
				xhr.setRequestHeader('X-CSRF-Token', Manager.csrf());
				xhr.send(body);

				xhr.onreadystatechange = () => {
					if(xhr.readyState === 4) {
						if(xhr.status === 200 || xhr.status === 201) {
							this.openDialog('Ответ', 'Страница успешно сохранена',
								<DialogActions>
									<Button onClick={this.closeDialog.bind(this)} color="primary">
										OK
									</Button>
								</DialogActions>, () => {
									this.setState({ completed: 0 }, () => {
										this.getContextData(() => 
											this.getViewData(() => 
												this.getPageData(() => 
													this.getVariablesData(() => {
														this.getAdditionalFieldsData(() => 
															this.getParentData(() => this.setState({ completed: 100 }))
														)
													})
												)
											)
										)
									});
								});
						}

						if(xhr.status === 422 || xhr.status === 500 || xhr.status === 419) {
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
	 * Open dialog for removing current page
	 * @param {Object} e
	 */
	handleDeletePage(e) {
		this.openDialog('Удаление', 'Вы уверены что хотите удалить страницу?',
			<DialogActions>
				<Button onClick={this.closeDialog.bind(this)} color="primary">
					Cancel
				</Button>

				<Button onClick={this.deletePageQuery.bind(this)} color="primary">
					OK
				</Button>
			</DialogActions>);
	}

	/**
	 * Query for remove page
	 * @param {Object} e
	 */
	deletePageQuery(e) {
		let xhr = Manager.xhr();
		let { page, click } = this.state;
		let a = document.getElementById('pages-link');

		if (a) {
			if(click === false) {
				this.setState({
					click: true,
					completed: 0
				});

				xhr.open('DELETE', Manager.url +'/api/page/'+ page.id, true);
				xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
				xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
				xhr.setRequestHeader('X-CSRF-Token', Manager.csrf());
				xhr.send();

				var r;
				xhr.onreadystatechange = () => {
					if(xhr.readyState === 4) {
						if(xhr.status === 200 || xhr.status === 201) {
							r = JSON.parse(xhr.response);
							if(r) {
								this.openDialog('Ответ', 'Страница успешно удалена', 
									<DialogActions>
										<Button onClick={this.closeDialog.bind(this)} color="primary">
											OK
										</Button>
									</DialogActions>, 
									() => {
									setTimeout(() => {
										a.click();
									}, 500);
								});
							}
						}

						if(xhr.status === 422 || xhr.status === 500 || xhr.status === 419) {
							r = JSON.parse(xhr.response);
							if(r.errors) {
								this.openDialog('Ошибка во время удаления страницы', r.message, 
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
	 * Open or close file manager component
	 */
	filesDialog(open = false, callback = () => {}) {
		this.setState({ files: open }, () => callback());
	}

	/**
	 * 
	 */
	buildAdditionalFields() {
		let { variables } = this.state;
		let { classes } = this.props;
		var i,
			f,
			a,
			o = [];

		for (i = 0; i < variables.length; i++) {
			
			f = [];
			for (a = 0; a < variables[i].data.length; a++) {
				if (variables[i].type === 'input') {
					f.push(<div key={a}>
						<TextField
							type="text"
							defaultValue={variables[i].data[a].content}
							InputLabelProps={{
								shrink: true
							}}
							style={{
								width: '100%'
							}}
							onInput={this.onInputAdditionalField.bind(this, variables[i], variables[i].data[a])} />
						<Button className={classes.button} 
							variant="raised" 
							color="secondary"
							onClick={this.removeField.bind(this, variables[i], variables[i].data[a])}>
								<Delete />
								{'Удалить поле'}
						</Button>
					</div>);
				}

				else if (variables[i].type === 'richtext') {
					f.push(<div key={a}>
						<Editor 
							onEditorStateChange={this.onEditorFieldsChange.bind(this, variables[i], variables[i].data[a])}
							editorState={variables[i].data[a]['editorState']}
							editorClassName={classes.contentEditor}
							toolbarClassName={classes.toolbarEditor} />
						<Button className={classes.button} 
							variant="raised" 
							color="secondary"
							onClick={this.removeField.bind(this, variables[i], variables[i].data[a])}>
								<Delete />
								{'Удалить поле'}
						</Button>
					</div>);
				}

				else if (variables[i].type === 'image') {
					f.push(<div key={a}>
						<TextField
							type="text"
							defaultValue={variables[i].data[a].content}
							placeholder={'URL картинки'}
							onClick={this.handleSelectImage.bind(this, variables[i], variables[i].data[a])}
							InputLabelProps={{
								shrink: true
							}}
							style={{
								width: '100%'
							}} />
						<Button className={classes.button} 
							variant="raised" 
							color="secondary"
							onClick={this.removeField.bind(this, variables[i], variables[i].data[a])}>
								<Delete />
								{'Удалить поле'}
						</Button>
					</div>);
				}
			}

			o.push(<Grid item xs={12} key={i}>
				<Paper className={classes.paper}>
						<Typography className={classes.title}>
							{variables[i].description}
						</Typography>

						<FormControl className={classes.formControl} aria-describedby="name-helper-text">
							{f}

							<FormHelperText id="name-helper-text">
								<Button variant="fab" 
									color="primary" 
									aria-label="add" 
									onClick={this.addAdditionalField.bind(this, variables[i])}
									className={classes.button}>
										<AddIcon />
										{'Добавить поле'}
								</Button>
							</FormHelperText>
						</FormControl>
					</Paper>
				</Grid>);
		}
		return o;
	}

	/**
	 * Select image
	 * @fires click
	 * @param {Object} e
	 */
	handleSelectImage(variable, field, e) {
		var target = e.target;
		this.setState({
			input: {
				target: target,
				variable: variable,
				field: field
			}
		}, () => {
			this.filesDialog(true);
		});
	}

	/**
	 * Add field value to variables state content
	 * @fires input
	 * @param {Object} variable Current variable
	 * @param {Object} field Current field
	 * @param {Object} e
	 */
	onInputAdditionalField(variable, field, e) {
		let { variables } = this.state;
		var i,
			a;

		for (i = 0; i < variables.length; i++) {
			if (variable.id === variables[i].id) {
				for (a = 0; a < variables[i].data.length; a++) {
					if (variables[i].data[a].id === field.id) {
						variables[i].data[a].content = e.target.value;
						break;
					}
				}
				break;
			}
		}
		this.setState({ variables });
	}

	/**
	 * Remove additional field
	 * @fires click
	 * @param {Object} variable Current variable
	 * @param {Object} field Current field
	 * @param {Object} e
	 */
	removeField(variable, field, e) {
		let { variables } = this.state;
		var i,
			a,
			index;

		this.setState({ value: -1}, () => {
			for (i = 0; i < variables.length; i++) {
				if (variable.id === variables[i].id) {
					for (a = 0; a < variables[i].data.length; a++) {
						if (variables[i].data[a].id === field.id) {
							index = a;
							break;
						}
					}
					variables[i].data.splice(index, 1);
					break;
				}
			}
			this.setState({ variables }, () => this.setState({ value: 1}));
		});
	}

	/**
	 * Add new field
	 * @fires click
	 * @param {Object} variable
	 * @param {Object} e
	 */
	addAdditionalField(variable, e) {
		let { variables, page } = this.state;
		var i;

		for (i = 0; i < variables.length; i++) {
			if (variable.id === variables[i].id) {
				variables[i].data.push({
					id: Date.now() + i,
					content: '',
					page_id: page.id,
					variable_id: variables[i].id
				});
				break;
			}
		}

		this.setState({ variables });
	}

	/**
	 * Edit additional fields textarea
	 * @param {Object} variable Current variable
	 * @param {Object} field Current field
	 * @param {Object} editorState
	 */
	onEditorFieldsChange(variable, field, editorState) {
		let { variables, page } = this.state;
		var i,
			a;

		for (i = 0; i < variables.length; i++) {
			if (variable.id === variables[i].id) {
				for (a = 0; a < variables[i].data.length; a++) {
					if (variables[i].data[a].id === field.id) {
						variables[i].data[a]['editorState'] = editorState;
						//variables[i].data[a].content = 
					}
				}
				break;
			}
		}

		this.setState({ variables });
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { classes } = this.props;
		let {  
			page,
			value, 
			view, 
			files,
			parent,
			context,
			dialog,
			completed,
			variables,
			editorState
		} = this.state;

		if(page === '') {
			return <div>
				<LinearProgress color="secondary" variant="determinate" value={completed} />
			</div>
		}

		return <div className={classes.root}>
				{completed === 0 && 
					<LinearProgress color="secondary" variant="determinate" value={completed} />}

				<Grid container spacing={24} className={classes.root}>
					<Grid item xs={10}>
						<Typography className={classes.title}>
							Главная страница
						</Typography>
					</Grid>

					<Grid item xs={2}>
						<Button className={classes.button} 
							variant="raised" 
							size="small"
							onClick={this.handleSavePage.bind(this)}>
								<Save className={classes.leftIcon} />Save
						</Button>

						<Button 
							className={classes.button} 
							variant="raised"
							color="secondary"
							onClick={this.handleDeletePage.bind(this)}>
								<Delete className={classes.rightIcon} />Delete
						</Button>
					</Grid>
				</Grid>

				<Tabs value={value} onChange={this.handleChangeTab}>
					<Tab label={'Страница'} />
					<Tab label={'Дополнительные поля'} />
				</Tabs>

				<form id="edit-page-form" style={{display: value === 0 ? 'block' : 'none'}}>
				<Grid container spacing={24} className={classes.root}>
					<Grid item xs={9}>
						<Paper className={classes.paper}>
							<TextField
								id="title"
								label="Название"
								type="text"
								name="title"
								defaultValue={page.title}
								className={classes.textField}
								InputLabelProps={{
									shrink: true
								}} />

							<TextField
								id="description"
								label="Описание"
								type="text"
								name="description"
								defaultValue={page.description}
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
								defaultValue={page.introtext}
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
											<em>{'None'}</em>
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
								defaultValue={page.link}
								className={classes.textField}
								InputLabelProps={{
									shrink: true
								}} />

							<TextField
								id="created_at"
								label="Дата создания"
								type="date"
								name="created_at"
								defaultValue={page.created_at}
								className={classes.textField}
								InputLabelProps={{
									shrink: true,
								}} />

							<TextField
								id="updated_at"
								label="Дата обновления"
								type="date"
								name="updated_at"
								defaultValue={page.updated_at}
								className={classes.textField}
								InputLabelProps={{
									shrink: true,
								}} />
						</Paper>
					</Grid>
				</Grid></form>

				{value !== -1 && <Grid container spacing={24} 
					className={classes.root} 
					style={{display: value === 1 ? 'block' : 'none'}}>
						{this.buildAdditionalFields()}	
				</Grid>}

				<Dialog
					open={dialog.open}
					transition={Transition}
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

				<Dialog
					fullScreen
					open={files}
					transition={Transition}>
						<Grid container spacing={24} className={classes.root}>
							<Grid item xs={11}>
								<Typography className={classes.title}>
									Выбор картинки
								</Typography>
							</Grid>

							<Grid item xs={1}>
								<IconButton color="inherit" 
									className={classes.button} 
									color="secondary"
									onClick={this.filesDialog.bind(this, false, () => {
										this.setState({ input: '' })
									})} 
									aria-label="Close">
										<CloseIcon />
								</IconButton>
							</Grid>
						</Grid>

						<Files 
							selectFile={(item, path) => {
								var el = this.state.input,
									i,
									a;
								if (el) {

									el.target.value = path + item.name;
									this.setState({ input: {
										target: '',
										variable: '',
										field: ''
									}, value: -1}, () => {
										for (i = 0; i < variables.length; i++) {
											if (el.variable.id === variables[i].id) {
												for (a = 0; a < variables[i].data.length; a++) {
													if (variables[i].data[a].id === el.field.id) {
														variables[i].data[a].content = el.target.value;
														break;
													}
												}
												break;
											}
										}

										this.setState({ variables, value: 1 }, () => {
											this.filesDialog(false);
										});
									});
								}
							}} />
				</Dialog>

				<Link to={Manager.url +'/pages'} id="pages-link" style={{display: 'none'}}></Link>
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

export default connect(mapStateToProps, mapDispatchToProps)(withStyles(styles)(PageEdit));