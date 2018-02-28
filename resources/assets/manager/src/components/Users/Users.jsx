/**
 * Header block module
 * @module Users
 * @author Ihor Bielchenko
 * @requires react
 * @requires react#Component
 * @requires redux#bindActionCreators
 * @requires react-redux#connect
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
import ExpansionPanel, {
	ExpansionPanelSummary,
	ExpansionPanelDetails,
} from 'material-ui/ExpansionPanel';
import Grid from 'material-ui/Grid';
import Typography from 'material-ui/Typography';
import Button from 'material-ui/Button';
import Input, { InputLabel } from 'material-ui/Input';
import Select from 'material-ui/Select';
import { FormControl, FormHelperText } from 'material-ui/Form';
import ExpandMoreIcon from 'material-ui-icons/ExpandMore';
import * as StateElementAction from '../../actions/StateElementAction.js';
import ManagerTable from '../Common/ManagerTable/ManagerTable.jsx';
import Edit from 'material-ui-icons/Edit';
import Search from 'material-ui-icons/Search';
import ArrowDropDown from 'material-ui-icons/ArrowDropDown';
import Dialog, {
	DialogActions,
	DialogContent,
	DialogContentText,
	DialogTitle,
} from 'material-ui/Dialog';
import { MenuItem } from 'material-ui/Menu';
import TextField from 'material-ui/TextField';
import Slide from 'material-ui/transitions/Slide';
import Delete from 'material-ui-icons/Delete';
import { LinearProgress } from 'material-ui/Progress';

/**
 * Animate opening dialog
 * @param {Object} props
 * @return {Object} JSX object
 */
function Transition(props) {
	return <Slide direction="up" {...props} />;
}

/**
 * Header block
 * @extends Component
 */
class Users extends Component {

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
	 * State object of component
	 * @type {Object} 
	 * @inner
	 * @property {Array} data Table pages data 
	 */
	state = {
		data: [],
		policies: [],
		dialog: {
			title: '',
			content: '',
			actions: '',
			open: false,
		},
		start: 0,
		limit: 5,
		total: 0,
		forRemove: [],
		completed: 0
	}

	/**
	 * Invoked just before mounting occurs
	 * @fires componentWillMount
	 */
	componentWillMount() {
		this.setState({ completed: 0 }, () => {
			this.loadPolicies(() => {
				this.loadUsersData(() => this.setState({ completed: 100 }))
			});
		});
	}

	/**
	 * Get policy list from server
	 * @param {Function} callback
	 */
	loadPolicies(callback = () => {}) {
		let xhr = Manager.xhr();

		xhr.open('GET', Manager.url +'/api/policy', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xhr.setRequestHeader('X-CSRF-Token', Manager.csrf());
		xhr.send();

		var r;
		xhr.onreadystatechange = () => {
			if (xhr.readyState === 4) {
				if(xhr.status === 200 || xhr.status === 201) {
					r = JSON.parse(xhr.response);
					if(r) {
						this.setState({ policies: r }, () => callback());
					}
				}

				if(xhr.status === 422 || xhr.status === 500 || xhr.status === 419) {
					r = JSON.parse(xhr.response);
					if(r.message) {
						this.openDialog('Ошибка во время получения пользоваетелей', 
							<DialogContentText id="alert-dialog-slide-description">
								{r.message}
							</DialogContentText>,
							<DialogActions>
								<Button onClick={this.closeDialog.bind(this)} color="primary">
									OK
								</Button>
							</DialogActions>);
					}
				}
			}
		}
	}

	/**
	 * Load users from server
	 * @param {Function} callback
	 */
	loadUsersData(callback = () => {}) {
		let { start, limit } = this.state;
		let xhr = Manager.xhr();

		xhr.open('GET', Manager.url +'/api/user/?start='+ (start + 1) +'&limit='+ limit, true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xhr.setRequestHeader('X-CSRF-Token', Manager.csrf());
		xhr.send();

		var r,
			i,
			data = [];
		xhr.onreadystatechange = () => {
			if (xhr.readyState === 4) {
				if(xhr.status === 200 || xhr.status === 201) {
					r = JSON.parse(xhr.response);
					if(r) {
						for (i in r.data) {
							r.data[i]['control'] = this.getButtonControl(r.data[i]);
							data.push(r.data[i]);
						}

						this.setState({ 
							data, 
							total: r.total
						}, () => callback());
					}
				}

				if(xhr.status === 422 || xhr.status === 500 || xhr.status === 419) {
					r = JSON.parse(xhr.response);
					if(r.message) {
						this.openDialog('Ошибка во время получения пользоваетелей', 
							<DialogContentText id="alert-dialog-slide-description">
								{r.message}
							</DialogContentText>,
							<DialogActions>
								<Button onClick={this.closeDialog.bind(this)} color="primary">
									OK
								</Button>
							</DialogActions>);
					}
				}
			}
		}
	}

	/**
	 * Build control buttons
	 * @param {Number} id Current page identificator
	 * @param {Number} childs Amount children pages
	 * @return {Object} JSX object
	 */
	getButtonControl(item) {
		let { classes } = this.props;

		return <div style={{width: '172px'}}>
					<Button className={classes.control}
						title={'Редактировать'}
						onClick={this.handleClickOpenEditDialog.bind(this, item)}>
							<Edit />
					</Button>
					<Button className={classes.control}
						onClick={this.handleClickOpenRemoveDialog.bind(this, item.id)}
						title={'Удалить'}>
							<Delete />
					</Button>
				</div>
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
	 * Show remove user dialog
	 * @fires click
	 * @param {Object} e
	 */
	handleClickOpenRemoveDialog(id, e) {
		this.openDialog('Удаление', 
			<DialogContentText id="alert-dialog-slide-description">
				Подтвердите удаление пользователя
			</DialogContentText>,
			<DialogActions>
				<Button onClick={this.closeDialog.bind(this)} color="primary">
					Cancel
				</Button>

				<Button onClick={this.deleteUserRequest.bind(this, id)} color="primary">
					OK
				</Button>
			</DialogActions>);
	}

	/**
	 * Change select fields
	 * @fires click
	 * @param {Object} e
	 */
	handleChangeSelect(e) {
		let { data } = this.state;

		/*page[type] = e.target.value;
		this.setState({ page });*/
	};

	/**
	 * Show edit dialog
	 * @fires click
	 * @param {Object} item
	 * @param {Object} e
	 */
	handleClickOpenEditDialog(item, e) {
		let { classes } = this.props;
		let { policies } = this.state;

		this.openDialog('Edit', <div>
			<FormControl className={classes.formControl}>
				<TextField
					id="name"
					label="Имя"
					type="text"
					name="name"
					defaultValue={item.name}
					className={classes.textField}
					InputLabelProps={{
						shrink: true
					}} />
			</FormControl>

			<FormControl className={classes.formControl}>
				<TextField
					id="email"
					label="Email"
					type="email"
					name="email"
					defaultValue={item.email}
					className={classes.textField}
					InputLabelProps={{
						shrink: true
					}} />
			</FormControl>

			<FormControl className={classes.formControl}>
				<TextField
					id="password"
					label="New password"
					type="password"
					name="new_password"
					defaultValue=""
					className={classes.textField}
					InputLabelProps={{
						shrink: true
					}} />
			</FormControl>

			<FormControl className={classes.formControl}>
				<TextField
					id="confirm-password"
					label="Confirm password"
					type="password"
					name="confirm_password"
					defaultValue=""
					className={classes.textField}
					InputLabelProps={{
						shrink: true
					}} />
			</FormControl>

			<FormControl className={classes.formControl}>
				<InputLabel htmlFor="policy">Access policy</InputLabel>
				<Select
					value={1}
					onChange={this.handleChangeSelect.bind(this)}
					input={<Input name="policy" id="policy" />}>
						{policies.map((item, i) => {
							return <MenuItem
									key={i} 
									value={item.id}>
										{item.name}
								</MenuItem>
						})}
				</Select>
			</FormControl>
			</div>,
			<DialogActions>
				<Button onClick={this.closeDialog.bind(this)} color="primary">
					Cancel
				</Button>

				<Button onClick={this.updateUserRequest.bind(this)} color="primary">
					OK
				</Button>
			</DialogActions>);
	}

	/**
	 * Update user window
	 * @fires click
	 * @param {Object} e
	 */
	updateUserRequest(e) {

	}

	/**
	 * Request to server for delete user
	 * @fires click
	 * @param {Object} e
	 */
	deleteUserRequest(id = 0, e) {
		let { forRemove } = this.state;
		let xhr = Manager.xhr();

		if (id !== 0) {
			forRemove.push(id);
		}

		xhr.open('DELETE', Manager.url +'/api/user/', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xhr.setRequestHeader('X-CSRF-Token', Manager.csrf());
		xhr.send('users='+ encodeURIComponent(JSON.stringify(forRemove)));

		this.setState({ forRemove: [] });

		var r;
		xhr.onreadystatechange = () => {
			if(xhr.readyState === 4) {
				if(xhr.status === 200 || xhr.status === 201) {
					this.openDialog('Ответ', 
						<DialogContentText id="alert-dialog-slide-description">
							Запрос выполнен успешно
						</DialogContentText>,
						<DialogActions>
							<Button onClick={this.closeDialog.bind(this)} color="primary">
								OK
							</Button>
						</DialogActions>, () => this.setState({ completed: 0 }, () => {
							this.loadUsersData(() => this.setState({ completed: 100 }))
						}));
				}

				if(xhr.status === 422 || xhr.status === 500 || xhr.status === 419) {
					r = JSON.parse(xhr.response);
					if(r.message) {
						this.openDialog('Ошибка во время удаления', 
							<DialogContentText id="alert-dialog-slide-description">
								r.message
							</DialogContentText>,
							<DialogActions>
								<Button onClick={this.closeDialog.bind(this)} color="primary">
									OK
								</Button>
							</DialogActions>);
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
		let { classes } = this.props;
		let { 
			data, 
			dialog, 
			forRemove, 
			completed, 
			start, 
			limit, 
			total 
		} = this.state;

		if(completed === 0) {
			return <div>
				<LinearProgress color="secondary" variant="determinate" value={completed} />
			</div>
		}

		return <div>
			<Grid container spacing={24} className={classes.root}>
				<Grid item xs={10}>
					<TextField
						placeholder="Search field"
						InputProps={{
							disableUnderline: true,
							classes: {
								root: classes.textFieldRoot,
								input: classes.textFieldInput,
							},
						}}
						InputLabelProps={{
							shrink: true,
							className: classes.textFieldFormLabel,
						}} />
			
					<Button className={classes.search}>
						<Search />
					</Button>
				</Grid>
			
				<Grid item xs={2}>
					{forRemove.length > 0 &&
						<Button variant="raised" color="secondary" className={classes.button}
							onClick={this.handleClickOpenRemoveDialog.bind(this, 0)}>
								Удалить отмеченные
						</Button>}
				</Grid>
			</Grid>

			<Paper className={classes.root} zdepth={1}>
				<ManagerTable 
					page={start}
					rowsPerPage={limit}
					total={total}
					columns={[{
						id: 'id', 
						numeric: false, 
						disablePadding: true, 
						label: 'ID'
					}, {
						id: 'name', 
						numeric: false, 
						disablePadding: true, 
						label: 'Имя пользователя'
					}, {
						id: 'email', 
						numeric: false, 
						disablePadding: true, 
						label: 'Почта'
					}, {
						id: 'created_at', 
						numeric: false, 
						disablePadding: true, 
						label: 'Дата регистрации'
					}, {
						id: 'updated_at', 
						numeric: false, 
						disablePadding: true, 
						label: 'Обновлен'
					}, {
						id: 'Control',
						numeric: false,
						disablePadding: true,
						label: 'Управление'
					}]}
					data={data}
					select={forRemove => this.setState({ forRemove })}
					getStart={start => {
						this.setState({ 
							start,
							completed: 0,
						}, () => this.loadUsersData(() => {
							this.setState({ completed: 100 });
						}));
					}}
					getLimit={limit => this.setState({ limit })} />
			</Paper>
				
			{dialog.open === true && <Dialog
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

export default connect(mapStateToProps, mapDispatchToProps)(withStyles(styles)(Users));