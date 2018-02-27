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
import TextField from 'material-ui/TextField';
import Slide from 'material-ui/transitions/Slide';
import Delete from 'material-ui-icons/Delete';

/**
 * Header block
 * @extends Component
 */
class Users extends Component {

	transition(props) {
		return <Slide direction="up" {...props} />
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
	 * Show remove user dialog
	 * @fires click
	 * @param {Object} e
	 */
	handleClickOpenRemoveDialog(e) {
		this.setState({remove: true});
	}

	/**
	 * Hide remove user dialog
	 * @fires click
	 * @param {Object} e
	 */
	handleCloseRemoveDialog = (e) => {
		this.setState({remove: false});
	}

	/**
	 * State object of component
	 * @type {Object} 
	 * @inner
	 * @property {Array} data Table pages data 
	 */
	state = {
		data: [{
			id: 1,
			name: 'admin',
			email: 'ihor.bielchenko@ohmycode.studio',
			created_at: '2018-02-23 14:23:34',
			control: this.getButtonControl(),
		}],
		remove: false
	}

	/**
	 * Build control buttons
	 * @param {Number} id Current page identificator
	 * @param {Number} childs Amount children pages
	 * @return {Object} JSX object
	 */
	getButtonControl() {
		let { classes } = this.props;

		return <div style={{width: '172px'}}>
					<Button className={classes.control}
						title={'Редактировать'}>
							<Edit />
					</Button>
					<Button className={classes.control}
						onClick={this.handleClickOpenRemoveDialog.bind(this)}
						title={'Удалить'}>
							<Delete />
					</Button>
				</div>
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { classes } = this.props;
		let { data, remove } = this.state;

		return <div>
				<Grid container spacing={24}>
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
						<Button variant="raised" color="secondary" className={classes.button}>
							Удалить отмеченные
						</Button>
					</Grid>
				</Grid>

				<Paper className={classes.root} zdepth={1}>
					<ManagerTable 
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
							id: 'Control',
							numeric: false,
							disablePadding: true,
							label: 'Управление'
						}]}
						data={data} />
				</Paper>
				<Dialog
					open={remove}
					transition={this.transition}
					keepMounted
					onClose={this.handleCloseRemoveDialog}
					aria-labelledby="alert-dialog-slide-title"
					aria-describedby="alert-dialog-slide-description">

						<DialogTitle id="alert-dialog-slide-title">
							Удаление
						</DialogTitle>

						<DialogContent>
							<DialogContentText id="alert-dialog-slide-description">
								Вы уверены что хотите удалить эту страницу?
							</DialogContentText>
						</DialogContent>

						<DialogActions>
							<Button onClick={this.handleCloseRemoveDialog} color="primary">
							Отмена
						</Button>

						<Button onClick={this.handleCloseRemoveDialog} color="primary">
							Подтвердить
						</Button>
					</DialogActions>
				</Dialog>
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