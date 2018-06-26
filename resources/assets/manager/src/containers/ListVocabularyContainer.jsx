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

import Grid from 'material-ui/Grid';
import Paper from 'material-ui/Paper';
import Menu from '../components/Menu/Menu.jsx';
import Header from '../components/Header/Header.jsx';
import { LinearProgress } from 'material-ui/Progress';
import DialogUser from '../components/DialogUser/DialogUser.jsx';
import PaperTable from '../components/PaperTable/PaperTable.jsx';
import DialogError from '../components/DialogError/DialogError.jsx';
import DialogDelete from '../components/DialogDelete/DialogDelete.jsx';
import ControlOptions from '../components/ControlOptions/ControlOptions.jsx';
import SelectLang from '../components/FormControl/SelectLang/SelectLang.jsx';
import InputSearch from '../components/FormControl/InputSearch/InputSearch.jsx';

import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Users base container
 * @extends Component
 */
class ListVocabularyContainer extends Component {

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
	}

	/**
	 * Invoked just before mounting occurs
	 * @fires componentWillMount
	 */
	componentWillMount() {
		this.usersDataGetRequest();
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
							resultDialogTitle: 'Success',
							resultDialogMessage: 'The request was successful'
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
							resultDialogTitle: 'Error',
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
							resultDialogTitle: 'Success',
							resultDialogMessage: 'The request was successful'
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
							resultDialogTitle: 'Error',
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

		return <div className="uesrs-list__container">
				{completed === 0 && 
					<LinearProgress color="secondary" variant="determinate" value={completed} />}
					
				<Header
					title={'Vocabulary list'} />
				<Menu />

				<Grid container spacing={24} className={classes.root}>
					<Grid item xs={12}>
						<Paper className={classes.paper}>
							<Grid container spacing={24} className={classes.root}>
								<Grid item xs={12} sm={2}>
									<InputSearch
										defaultValue={'test'} />
								</Grid>

								<Grid item xs={12} sm={2}>
									<SelectLang />
								</Grid>
							</Grid>
						</Paper>
					</Grid>
				</Grid>

				<Grid container spacing={24} className={classes.root}>
					<Grid item xs={12}>
						{completed === 100 && <PaperTable
							data={[{
								name: 'test',
								value: 'hello'
							}]}
							page={start}
							limit={limit}
							total={total}
							columns={[{
								id: 'name', 
								numeric: false, 
								disablePadding: true, 
								label: 'Name'
							}, {
								id: 'value', 
								numeric: false, 
								disablePadding: true, 
								label: 'Value'
							}]}
							onRowsSelected={selected => this.setState({ selected })}
							onStartValueChanged={start => {
								this.setState({ 
									start,
								}, () => this.usersDataGetRequest());
							}}
							onLimitValueChanged={limit => this.setState({ limit }, () => this.usersDataGetRequest())} />}
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

export default withStyles(styles)(ListVocabularyContainer);