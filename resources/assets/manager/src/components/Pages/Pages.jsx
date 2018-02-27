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
import Manager from '../../Manager.js';

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
import ExpandMoreIcon from 'material-ui-icons/ExpandMore';
import * as StateElementAction from '../../actions/StateElementAction.js';
import ManagerTable from '../Common/ManagerTable/ManagerTable.jsx';
import Edit from 'material-ui-icons/Edit';
import Add from 'material-ui-icons/Add';
import ArrowDropDown from 'material-ui-icons/ArrowDropDown';
import Dialog, {
	DialogActions,
	DialogContent,
	DialogContentText,
	DialogTitle,
} from 'material-ui/Dialog';
import { LinearProgress } from 'material-ui/Progress';
import Slide from 'material-ui/transitions/Slide';
import Delete from 'material-ui-icons/Delete';

/**
 * Header block
 * @extends Component
 */
class Pages extends Component {

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
	 * State object of component
	 * @type {Object} 
	 * @inner
	 * @property {Array} data Table pages data 
	 */
	state = {
		data: [],
		context: [],
		click: false,
		completed: 0,
		dialog: {
			title: '',
			content: '',
			actions: '',
			open: false,
		}
	}

	/**
	 * Invoked just before mounting occurs
	 * @fires componentWillMount
	 */
	componentWillMount() {
		this.setState({ completed: 0 }, () => {
			this.getContextData(() => {
				this.getPagesList(0, () => this.setState({ completed: 100 }));
			});
		});
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
	 * Query for getting pages data
	 * @param {Function} callback
	 */
	getPagesList(id, callback = () => {}) {
		let xhr = Manager.xhr();
		let { data } = this.state;

		/** Query only if current chlds is empty
		 */
		if (this.isEmptyChilds(id, data) === true) {
			xhr.open('GET', Manager.url +'/api/page/childs/'+ id, true);
			xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
			xhr.setRequestHeader('X-CSRF-Token', Manager.csrf());
			xhr.send();

			var r;
			xhr.onreadystatechange = () => {
				if (xhr.readyState === 4) {
					if (xhr.status === 200 || xhr.status === 201) {
						r = JSON.parse(xhr.response);
						r = this.forEachPagesData(r);

						this.setState({ data: this.findParentPage(id, r, data) }, () => callback());
					}
				}
			}
		}

		else callback();
	}

	/**
	 * Check if childs of current pages are emoty
	 * @param {Number} id
	 * @param {Array} data
	 * @return {Boolean}
	 */
	isEmptyChilds(id, data) {
		var i,
			check;

		if (data.length === 0 || id === 0) {
			return true;
		}
		
		for (i in data) {
			if (data[i].id === id) {
				if (data[i].childs.length === 0) {
					return true;
				}

				else return false;
			}

			else if (data[i].childs.length > 0) {
				check = this.isEmptyChilds(id, data[i].childs);
			}
		}

		return check;
	}

	/**
	 * Set childs for current parent page
	 * @param {Number} id
	 * @param {Array} childs
	 * @param {Array} data
	 * @return {Array}
	 */
	findParentPage(id, childs, data) {
		var i;

		if (data.length === 0 || id === 0) {
			return childs;
		}
		
		for (i in data) {
			if (data[i].id === id) {
				data[i].childs = childs;
				break;
			}

			else if (data[i].childs.length > 0) {
				data[i].childs = this.findParentPage(id, childs, data[i].childs);
			}
		}

		return data;
	}

	/**
	 * Build correct data for component
	 * @param {Array} data
	 * @return {Array}
	 */
	forEachPagesData(data = []) {
		var i,
			o = [];
		
		for(i in data) {
			o.push({
				id: data[i].id,
				link: data[i].link,
				title: data[i].title,
				description: data[i].description,
				props: {
					parent_id: data[i].parent_id,
					context_id: data[i].context_id,
					showChilds: false
				},
				childs: [],
				control: this.getButtonControl(
					data[i].id, 
					data[i].childs === true ? 1 : 0, 
					data[i].parent_id, 
					data[i].context_id),
			});
		}

		return o;
	}

	/**
	 * Open remove dialog
	 * @fires click
	 * @param {Number} id
	 * @param {Object} e
	 */
	handleClickOpenRemoveDialog(id, e) {
		this.openDialog('Удаление', 'Вы цверены что хотите удалить текущую чтраницу?', 
			<DialogActions>
				<Button onClick={this.closeDialog.bind(this)} color="primary">
					Cancel
				</Button>

				<Button onClick={this.deletePageQuery.bind(this, id)} color="primary">
					OK
				</Button>
			</DialogActions>);
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
	 * Build control buttons
	 * @param {Number} id Current page identificator
	 * @param {Number} childs Amount children pages
	 * @return {Object} JSX object
	 */
	getButtonControl(id = 0, childs = 0, parent = 0, context_id = 1) {
		let { classes } = this.props;

		return <div style={{width: '172px'}}>
					<Link to={Manager.url +'/pages/create?parent_id='+ id +'&context_id='+ context_id}>
						<Button className={classes.control}
							title={'Добавить дочернюю страницу'}>
								<Add />
						</Button>
					</Link>
					<Link to={Manager.url +'/pages/'+ id}>
						<Button className={classes.control}
							title={'Редактировать'}>
								<Edit />
						</Button>
					</Link>
					<Button className={classes.control}
						onClick={this.handleClickOpenRemoveDialog.bind(this, id)}
						title={'Удалить'}>
							<Delete />
					</Button>
					{childs > 0 ?
						<span>
							<span style={{margin: '0 4px'}}>|</span>
							<Button className={classes.control} 
								title={'Посмотреть дочерние страницы'}
								onClick={this.showChilds.bind(this, id)}>
									<ArrowDropDown />
							</Button>
						</span> : null}
				</div>
	}

	/**
	 * Show childs rows
	 * @param {Number} id ID of curent page
	 * @param {Object} e
	 */
	showChilds(id, e) {
		let { data, click } = this.state;
		let target = e.target;

		if(click === false) {
			this.setState({ click: true });

			this.getPagesList(id, () => {
				var i;
				for(i = 0; i < data.length; i++) {
					if(data[i].id === id && data[i].props.showChilds === true && data[i].childs.length > 0) {
						data[i].childs = this.toggleChildrenRows(data[i].childs);
						break;
					}
				}

				this.setState({
					data: this.forEachChilds(data, id)
				}, () => {
					if(target.style['transform'] === 'rotate(180deg)') {
						target.style['transform'] = 'rotate(0deg)';
					}
					else target.style['transform'] = 'rotate(180deg)';

					this.setState({ click: false });
				});
			});
		}
	}

	/**
	 * Collapse all childrean rows
	 * @props {Array} data
	 * @return {Array}
	 */
	toggleChildrenRows(data) {
		var i;
		for(i = 0; i < data.length; i++) {
			if(data[i].props.showChilds === true && data[i].childs.length > 0) {
				data[i].props.showChilds = false;
				data[i].childs = this.toggleChildrenRows(data[i].childs);
			}
		}

		return data;
	}

	/**
	 * Pass on array with inner arrays for define current page childs
	 * @props {Array} data Pages array
	 * @parops {Number} id Current page id
	 * @return {Array}
	 */
	forEachChilds(data, id) {
		var i;

		for(i = 0; i < data.length; i++) {
			if(data[i].id === id) {
				data[i].props.showChilds = !data[i].props.showChilds;
				break;
			}

			else if(data[i].childs.length > 0) {
				this.forEachChilds(data[i].childs, id);
			}
		}

		return data;
	}

	/**
	 * Query for remove page
	 * @param {Object} e
	 */
	deletePageQuery(id, e) {
		let xhr = Manager.xhr();
		let { click } = this.state;
		
		if(click === false) {
			this.setState({
				click: true,
				completed: 0
			});			

			var r;
			xhr.open('DELETE', Manager.url +'/api/page/'+ id, true);
			xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
			xhr.setRequestHeader('X-CSRF-Token', Manager.csrf());
			xhr.send();

			xhr.onreadystatechange = () => {
				if(xhr.readyState === 4) {
					if(xhr.status === 200 || xhr.status === 201) {
						this.openDialog('Ответ', 'Страница успешно удалена', 
							<DialogActions>
								<Button onClick={this.closeDialog.bind(this)} color="primary">
									OK
								</Button>
							</DialogActions>, () => {
								this.getPagesList(0, () => this.setState({
										click: false,
										completed: 100
									})
								)}
							);
					}

					if(xhr.status === 422 || xhr.status === 419 || xhr.status === 500) {
						r = JSON.parse(xhr.response);
						if(r.message) {
							this.openDialog('Ошибка во время удаления страницы', r.message, 
								<DialogActions>
									<Button onClick={this.closeDialog.bind(this)} color="primary">
										OK
									</Button>
								</DialogActions>);
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
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { classes } = this.props;
		let { data, completed, dialog, context } = this.state;

		if(completed === 0) {
			return <div>
				<LinearProgress color="secondary" variant="determinate" value={completed} />
			</div>
		}

		var pages,
			a;
		return <div>
				{completed === 1 &&
					<LinearProgress color="secondary" variant="determinate" value={completed} />}
				<Paper className={classes.root} zdepth={1}>
					{context.map((item, i) => {
						
						pages = [];
						for (a = 0; a < data.length; a++) {
							if (data[a].props.context_id === item.id) {
								pages.push(data[a]);
							}
						}

						return <ExpansionPanel key={i} 
								className={classes.expansion} 
								defaultExpanded={i === 0 ? true : false}>
							<ExpansionPanelSummary 
								className={classes.summary} 
								expandIcon={<ExpandMoreIcon />}>
									<Typography className={classes.heading}>
										Контекст: {item.title}
									</Typography>
							</ExpansionPanelSummary>

							<ExpansionPanelDetails className={classes.details}>
								<div className={classes.options}>
									<Link to={Manager.url +'/pages/create?context_id='+ item.id}>
										<Button className={classes.button}>
											Добавить страницу
										</Button>
									</Link>
								</div>

								<ManagerTable 
									footer={false}
									selecting={false}
									columns={[{
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
									}, {
										id: 'Control',
										numeric: false,
										disablePadding: true,
										label: 'Управление'
									}]}
									data={pages} />
							</ExpansionPanelDetails>
						</ExpansionPanel>
					})}
				</Paper>

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

export default connect(mapStateToProps, mapDispatchToProps)(withStyles(styles)(Pages));