/**
 * Base module of manager users container
 * @module ProductContainers
 * @author Ihor Bielchenko
 * @requires react
 * @requires react#Component
 * @requires redux#bindActionCreators
 * @requires react-redux#connect
 */

import App from '../App.js';
import React, { Component } from 'react';

import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';

import Grid from 'material-ui/Grid';
import Menu from '../components/Menu/Menu.jsx';
import Header from '../components/Header/Header.jsx';
import { LinearProgress } from 'material-ui/Progress';
import TopTitle from '../components/TopTitle/TopTitle.jsx';
import DialogUser from '../components/DialogUser/DialogUser.jsx';
import PaperTable from '../components/PaperTable/PaperTable.jsx';
import DialogError from '../components/DialogError/DialogError.jsx';
import PaperToolBar from '../components/PaperToolBar/PaperToolBar.jsx';
import DialogDelete from '../components/DialogDelete/DialogDelete.jsx';
import ControlOptions from '../components/ControlOptions/ControlOptions.jsx';

import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

import * as StateLexiconAction from 'actions/StateLexiconAction.js';

/**
 * Users base container
 * @extends Component
 */
class ListUsersContainer extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		classes: PropTypes.object.isRequired,
	}

	state = {
		data: [],
		start: 0,
		limit: 10,
		total: 0,
		selected: [],
		searchText: '',
		completed: 100,
		editUserId: 0,
		editUserItem: {},
		editUserDialog: false,
		deleteUserId: 0,
		resultDialog: false,
		resultDialogTitle: '',
		resultDialogMessage: '',
		deleteDialog: false,
		langLoaded: false
	}

	/**
	 * Invoked just before mounting occurs
	 * @fires componentWillMount
	 */
	componentWillMount() {
		this.usersDataGetRequest();

		App.defineCurrentLang((r) => {
			if (App.isEmpty(r) === false) {
				this.props.StateLexiconAction.get(r, () => {
					this.setState({
						langLoaded: true
					});
				});
			}
		});
	}

	/**
	 * Request for getting products array
	 * @param {Function} callback
	 */
	usersDataGetRequest(callback = () => {}) {
		let { 
			start, 
			limit, 
			searchText, 
		} = this.state;

		this.setState({
			completed: 0
		}, () => {
			var data = {
				limit,
				start: start + 1,
			};

			if (searchText && searchText.length > 0) {
				data['search'] = searchText;
			}

			App.api({
				type: 'GET',
				name: 'all',
				model: 'user',
				data: data,
				success: (r) => {
					r = JSON.parse(r.response);
					if (r) {
						for (var i in r.data) {
							r.data[i]['profile'] = <div>
								{r.data[i].attributes !== null && 
									r.data[i].attributes.fname +' '+ r.data[i].attributes.lname}
							</div>
							r.data[i]['control'] = <ControlOptions
								item={r.data[i]}
								editButton={true}
								onEditButtonClicked={item => {
									this.setState({
										editUserDialog: true,
										editUserItem: item,
										editUserId: item.id
									})
								}}
								onDeleteButtonClicked={item => {
									this.setState({
										deleteDialog: true,
										deleteUserId: item.id,
									});
								}} />
						}

						this.setState({
							data: r.data,
							total: r.total,
							completed: 100
						}, () => callback());
					}
				}
			});
		});
	}

	/**
	 * Request for update user
	 * @param {Object} data
	 */
	userPutRequest = data => {
		let { editUserItem } = this.state;

		this.setState({ 
			completed: 0 
		}, () => {
			App.api({
				name: 'one',
				type: 'PUT',
				model: 'user',
				resource: editUserItem.id,
				data: data,
				success: (r) => {
					r = JSON.parse(r.response);
					if (r) {
						this.setState({ 
							selected: [],
							completed: 100,
							deleteUserId: 0,
							editUserItem: {},
							resultDialog: true,
							deleteDialog: false,
							editUserDialog: false,
							resultDialogTitle: this.props.lexicon.success_title,
							resultDialogMessage: this.props.lexicon.request_successful
						}, () => this.usersDataGetRequest());
					}
				},
				error: (r) => {
					r = JSON.parse(r.response);
					if (r.message) {
						this.setState({ 
							selected: [],
							completed: 100,
							deleteUserId: 0,
							editUserItem: {},
							resultDialog: true,
							deleteDialog: false,
							editUserDialog: false,
							resultDialogTitle: this.props.lexicon.error_title,
							resultDialogMessage: r.message
						});
					}
				}
			});
		});
	}

	/**
	 * Request for delete user
	 * @param {Object} e
	 */
	userDeleteRequest = e => {
		let { deleteUserId, selected } = this.state;

		this.setState({ 
			completed: 0 
		}, () => {
			App.api({
				name: selected.length > 0 ? 
					'many' : 
					'one',
				model: 'user',
				type: 'DELETE',
				resource: selected.length === 0 && deleteUserId,
				data: selected.length > 0 && selected,
				success: (r) => {
					r = JSON.parse(r.response);
					if (r) {
						this.setState({ 
							selected: [],
							completed: 100,
							deleteUserId: 0,
							editUserItem: {},
							resultDialog: true,
							deleteDialog: false,
							resultDialogTitle: this.props.lexicon.success_title,
							resultDialogMessage: this.props.lexicon.request_successful
						}, () => this.usersDataGetRequest());
					}
				},
				error: (r) => {
					r = JSON.parse(r.response);
					if (r.message) {
						this.setState({ 
							selected: [],
							completed: 100,
							deleteUserId: 0,
							editUserItem: {},
							resultDialog: true,
							deleteDialog: false,
							resultDialogTitle: this.props.lexicon.error_title,
							resultDialogMessage: r.message
						});
					}
				}
			});
		});
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { classes } = this.props;
		let { 
			data,
			start,
			limit,
			total,
			selected,
			completed,
			searchText,
			editUserItem,
			deleteDialog,
			resultDialog,
			editUserDialog,
			resultDialogTitle,
			resultDialogMessage,
		} = this.state;

		if (this.state.langLoaded === false) 
			return <div className="create-page__container">
				<LinearProgress color="secondary" variant="determinate" value={0} />
			</div>

		return <div className="uesrs-list__container">
				{completed === 0 && 
					<LinearProgress color="secondary" variant="determinate" value={completed} />}
					
				<Header
					title={this.props.lexicon.users_list_title} />
				<Menu />

				<TopTitle
					title={''}
					addButtonDisplay={false}
					saveButtonDisplay={false}
					deleteButtonDisplay={selected.length > 0 ? 
						true : 
						false}

					saveButtonTitle={this.props.lexicon.save_label}
					trashButtonTitle={this.props.lexicon.empty_trash_label}
					duplicateButtonTitle={this.props.lexicon.duplicate_label}
					recoveryButtonTitle={this.props.lexicon.recovery_button}
					addButtonTitle={this.props.lexicon.new_product_button}
					deleteButtonTitle={this.props.lexicon.delete_selected_button}

					onDeleteButtonClicked={() => {
						this.setState({
							deleteDialog: true
						});
					}} />

				<Grid container spacing={24} className={classes.root}>
					<Grid item xs={12}>
						<PaperToolBar
							contextShow={false}
							searchDefaultValue={searchText}
							onSearchFieldSubmited={searchText => {
								this.setState({ searchText }, () => {
									this.usersDataGetRequest();
								});
							}} />
					</Grid>
				</Grid>

				<Grid container spacing={24} className={classes.root}>
					<Grid item xs={12}>
						{completed === 100 && <PaperTable
							data={data}
							page={start}
							limit={limit}
							total={total}
							except={[
								'id',
								'icon',
								'active', 
								'page_id',
								'policy_id',
								'vendor_id',
								'context_id',
								'attributes',
/*								'created_at',
								'updated_at', */
								'category_id', 
								'description',
								'compare_price',
								'images',
								'options',
								'category',
							]}
							columns={[{
								id: 'name', 
								numeric: false, 
								disablePadding: true, 
								label: this.props.lexicon.table_name
							}, {
								id: 'email', 
								numeric: false, 
								disablePadding: true, 
								label: this.props.lexicon.table_email
							}, {
								id: 'created_at', 
								numeric: false, 
								disablePadding: true, 
								label: this.props.lexicon.table_created_date
							}, {
								id: 'updated_at', 
								numeric: false, 
								disablePadding: true, 
								label: this.props.lexicon.table_updated_date
							}, {
								id: 'profile', 
								numeric: false, 
								disablePadding: true, 
								label: this.props.lexicon.table_profile
							}, {
								id: 'control', 
								numeric: false, 
								disablePadding: true, 
								label: this.props.lexicon.table_manage
							}]}
							onRowsSelected={selected => this.setState({ selected })}
							onStartValueChanged={start => {
								this.setState({ 
									start,
								}, () => this.usersDataGetRequest());
							}}
							onLimitValueChanged={limit => this.setState({ limit }, () => { 
								this.usersDataGetRequest() })} />}
					</Grid>
				</Grid>

				{resultDialog === true && <DialogError 
					title={resultDialogTitle}
					defaultValue={resultDialog}
					message={resultDialogMessage}
					onDialogClosed={() => this.setState({
						resultDialog: false
					})} />}

				{deleteDialog === true && <DialogDelete

					title={this.props.lexicon.delete_button}
					content={this.props.lexicon.delete_confirm}
					
					defaultValue={deleteDialog}
					onDialogClosed={() => this.setState({
						deleteDialog: false,
					})}
					onDialogConfirmed={() => this.userDeleteRequest()} />}

				{editUserDialog && <DialogUser
					data={editUserItem}
					defaultValue={editUserDialog}
					onDialogClosed={() => this.setState({
						editUserDialog: false,
						editUserItem: {},
						editUserId: 0
					})}
					onDialogConfirmed={data => this.userPutRequest(data)} />}
			</div>
	}
}

let styles = theme => ({
	root: {
		width: '100%',
		margin: 0,
		padding: 0,
	},
});

/**
 * Init redux states
 * @param {Object} state
 * @return {Object}
 */
function mapStateToProps(state) {
	return {
		lexicon: state.lexicon
	}
}

/**
 * Init redux actions
 * @param {Function} dispatch
 * @return {Object}
 */
function mapDispatchToProps(dispatch) {
	return {
		StateLexiconAction: bindActionCreators(StateLexiconAction, dispatch)
	}
}

export default connect(mapStateToProps, mapDispatchToProps)(withStyles(styles)(ListUsersContainer));