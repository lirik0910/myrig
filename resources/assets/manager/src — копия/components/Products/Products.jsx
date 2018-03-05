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

import Manager from '../../Manager.js';
import ManagerTable from '../Common/ManagerTable/ManagerTable.jsx';
import ContextSelect from '../Common/ContextSelect/ContextSelect.jsx';
import SearchField from '../Common/SearchField/SearchField.jsx';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';
import Slide from 'material-ui/transitions/Slide';
import Grid from 'material-ui/Grid';
import Paper from 'material-ui/Paper';
import Button from 'material-ui/Button';
import Tabs, { Tab } from 'material-ui/Tabs';
import { LinearProgress } from 'material-ui/Progress';
import Add from 'material-ui-icons/Add';
import Edit from 'material-ui-icons/Edit';
import Delete from 'material-ui-icons/Delete';
import Dialog, {
	DialogActions,
	DialogContent,
	DialogContentText,
	DialogTitle,
} from 'material-ui/Dialog';

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
class Products extends Component {

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
		tab: 0,
		data: [],
		total: 0,
		start: 0,
		limit: 5,
		contextID: 0,
		categoryID: 0,
		searchText: '',
		completed: 0,
		forRemove: [],
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
		this.loadProductsData();
	}

	loadProductsData(callback = () => {}) {
		this.setState({ completed: 0 }, () => {
			this.productsGetRequest(() => {
				this.setState({ completed: 100 }, () => callback());
			});
		});
	}

	/**
	 * Get product list from server
	 * @param {Function} callback
	 */
	productsGetRequest(callback = () => {}) {
		let { classes } = this.props;
		let { start, limit, searchText, contextID, categoryID } = this.state;
		let xhr = Manager.xhr();

		/** Build base request string
		 */
		var query = Manager.url +'/api/product?';
			query += 'start='+ (start + 1);
			query += '&limit='+ limit;

		/** Add search text filter to query
		 */
		if (searchText !== '' && searchText.length > 0) {
			query += '&search='+ searchText;
		}

		/** Add context filter to query
		 */
		if (contextID !== 0) {
			query += '&context_id='+ contextID;
		}

		if (categoryID !== 0) {
			query += '&category_id='+ categoryID;
		}

		xhr.open('GET', query, true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xhr.setRequestHeader('X-CSRF-Token', Manager.csrf());
		xhr.send();

		var r,
			i,
			data = [];
		xhr.onreadystatechange = () => {
			if (xhr.readyState === 4) {
				if (xhr.status === 200 || xhr.status === 201) {
					r = JSON.parse(xhr.response);
					if(r) {
						for (i in r.data) {
							r.data[i]['control'] = this.getButtonControl(r.data[i]);
							data.push(r.data[i]);
						}

						for (i in data) {
							data[i]['control'] = this.getButtonControl(data[i]);
							data[i].description = data[i].description.substr(0, 51) + '...';
							data[i].icon = <img src={window.site.uploads_url +'/'+ data[i].icon} 
								alt={data[i].title}
								className={classes.icon} />
						}

						this.setState({ 
							data: data, 
							total: r.total 
						}, () => callback());
					}
				}
			}
		}
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
	 * Build control buttons
	 * @param {Number} id Current page identificator
	 * @param {Number} childs Amount children pages
	 * @return {Object} JSX object
	 */
	getButtonControl(item) {
		let { classes } = this.props;

		return <div style={{width: '80px'}}>
				<Button className={classes.control}
					title={'Edit'}>
						<Edit />
				</Button>
				
				<Button className={classes.control}
					title={'Delete'}>
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
	 * Render 
	 */
	render() {
		let { classes } = this.props;
		let { 
			tab,
			data, 
			start, 
			limit, 
			total,
			dialog, 
			forRemove, 
			completed,
			contextID,
			searchText,
			categoryID,
		} = this.state;

		if(completed === 0) {
			return <div>
				<LinearProgress color="secondary" variant="determinate" value={completed} />
			</div>
		}

		return <div>
			<Grid container spacing={24} className={classes.root}>
				<Grid item xs={12}>
					<Paper className={classes.paper}>
						<Grid container spacing={24} className={classes.root}>
							<Grid item xs={12} sm={2}>
								<SearchField 
									defaultText={searchText}
									onSubmited={searchText => {
										this.setState({ searchText }, () => {
											this.loadProductsData();
										});
									}} />
							</Grid>

							<Grid item xs={12} sm={2}>
								<ContextSelect 
									currentID={contextID}
									onSelected={contextID => {
										this.setState({ contextID }, () => {
											this.loadProductsData();
										});
								}} />
							</Grid>

							<Grid item xs={12} sm={8} style={{textAlign: 'right'}}>
								<Button className={classes.button}
									title={'Add product'}>
										<Add />Add product
								</Button>

								{forRemove.length > 0 && <Button className={classes.button}
									color="secondary"
									title={'Delete selected'}>
										<Delete />Delete selected
								</Button>}
							</Grid>
						</Grid>
					</Paper>
				</Grid>
			</Grid>

			<Grid container spacing={24} className={classes.root}>
				<Grid item xs={12}>
					<Paper className={classes.paper}>
						<ManagerTable 
							page={start}
							rowsPerPage={limit}
							total={total}
							except={[
								'created_at', 
								'updated_at', 
								'active', 
								'category_id', 
								'context_id',
								'vendor_id',
								'compare_price',
								'description'
							]}
							columns={[{
								id: 'id', 
								numeric: false, 
								disablePadding: true, 
								label: 'ID'
							}, {
								id: 'title', 
								numeric: false, 
								disablePadding: true, 
								label: 'Name'
							}, {
								id: 'icon', 
								numeric: false, 
								disablePadding: true, 
								label: 'Image'
							}, {
								id: 'price', 
								numeric: false, 
								disablePadding: true, 
								label: 'Price'
							}, {
								id: 'control',
								numeric: false,
								disablePadding: true,
								label: 'Control'
							}]}
							data={data}
							select={forRemove => this.setState({ forRemove })}
							getStart={start => {
								this.setState({ 
									start,
									completed: 0,
								}, () => this.productsGetRequest(() => {
									this.setState({ completed: 100 });
								}));
							}}
							getLimit={limit => this.setState({ limit })} />
					</Paper>
				</Grid>
			</Grid>

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

export default withStyles(styles)(Products);