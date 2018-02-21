/**
 * Header block module
 * @module Header
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

import Manager from '../Manager.js';
import styles from './styles.js';
import PropTypes from 'prop-types';
import Paper from 'material-ui/Paper';
import { withStyles } from 'material-ui/styles';
import ExpansionPanel, {
	ExpansionPanelSummary,
	ExpansionPanelDetails,
} from 'material-ui/ExpansionPanel';
import Typography from 'material-ui/Typography';
import Button from 'material-ui/Button';
import Grid from 'material-ui/Grid';
import { FormControl, FormHelperText } from 'material-ui/Form';
import ExpandMoreIcon from 'material-ui-icons/ExpandMore';
import * as StateElementAction from '../../actions/StateElementAction.js';
import ManagerTable from '../Common/ManagerTable/ManagerTable.jsx';

/**
 * Header block
 * @extends Component
 */
class Pages extends Component {

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
	 * @property {Number} edit ID of single selected row
	 * @property {Array} remove Values that need's remove
	 */
	state = {
		edit: 0,
		remove: []
	}

	/**
	 * Show or hide option buttons
	 * @param {Array} IDs of current selected rows
	 * @param {Object} e
	 */
	showOptions(rows, e) {
		if(rows.length === 1) {
			this.setState({
				edit: rows[0],
				remove: rows
			});		
		}

		else {
			this.setState({
				edit: 0,
				remove: rows
			});
		}
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { classes } = this.props;
		let { edit, remove } = this.state;

		console.log(Manager.getLocationProps())

		return <Paper className={classes.root} zdepth={1}>
					<ExpansionPanel className={classes.expansion}>
						<ExpansionPanelSummary className={classes.summary} expandIcon={<ExpandMoreIcon />}>
							<Typography className={classes.heading}>Контекст: Украина</Typography>
						</ExpansionPanelSummary>

						<ExpansionPanelDetails className={classes.details}>
							<div className={classes.options}>
								<Grid container spacing={24}>
									<Grid item xs={12} sm={6} className={classes.breadcrumbs}>
										<ul className="breadcrumbs__container">
											<li><Link to="#">Add</Link></li>
											<li><Link to="#">Add</Link></li>
										</ul>
									</Grid>

									<Grid item xs={12} sm={6}>
										<Button className={classes.button}>
											Добавить страницу
										</Button>

										{edit !== 0 ?
											<Button className={classes.button}>
												Редактировать
											</Button> : ''}

										{remove.length > 0 ?
											<Button color="secondary" className={classes.button}>
												Удалить отмеченные
											</Button> : ''}
									</Grid>
								</Grid>
							</div>

							<ManagerTable columns={[{
								id: 'id', 
								numeric: false, 
								disablePadding: true, 
								label: 'ID'
							}, {
								id: 'link', 
								numeric: false, 
								disablePadding: true, 
								label: 'Адрес'
							}, {
								id: 'title', 
								numeric: false, 
								disablePadding: true, 
								label: 'Название'
							}, {
								id: 'description', 
								numeric: false, 
								disablePadding: true, 
								label: 'Описание'
							}]}
							data={[{
								id: 1,
								link: <Link to="?c=/">/</Link>,
								title: 'Главная',
								description: 'Главная страница сайта',
							}, {
								id: 2,
								link: <Link to="?c=/contacts/">/contacts</Link>,
								title: 'Lorem ipsum dolor sit amet',
								description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
							}]}
							select={(rows) => this.showOptions(rows)} />
						</ExpansionPanelDetails>
					</ExpansionPanel>
				</Paper>
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

export default connect(mapStateToProps, mapDispatchToProps)(withStyles(styles)(Pages));