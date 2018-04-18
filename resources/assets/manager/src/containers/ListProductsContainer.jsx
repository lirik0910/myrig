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
import { Link } from 'react-router-dom';
import Menu from '../components/Menu/Menu.jsx';
import Header from '../components/Header/Header.jsx';
import PaperTable from 'components/Paper/PaperTable';
import { LinearProgress } from 'material-ui/Progress';
import TopTitle from '../components/TopTitle/TopTitle.jsx';
import DialogError from '../components/DialogError/DialogError.jsx';
import PaperToolBar from '../components/PaperToolBar/PaperToolBar.jsx';
import DialogDelete from '../components/DialogDelete/DialogDelete.jsx';
import ControlOptions from '../components/ControlOptions/ControlOptions.jsx';

import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Users base container
 * @extends Component
 */
class ListProductsContainer extends Component {

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
		a: '',
		data: [],
		limit: 10,
		start: 0,
		total: 0,
		selected: [],
		deleteID: null,
		completed: 100,
		contextID: 0,
		searchText: '',
		deleteProductId: 0,
		trash: false,
		resultDialog: false,
		deleteDialog: false,
		resultDialogTitle: '',
		resultDialogMessage: ''
	}

	/**
	 * Invoked just before mounting occurs
	 * @fires componentWillMount
	 */
	componentWillMount() {
		this.productsGetDataRequest();
	}

	emptyTrashRequest() {
		if (this.state.completed === 100) {
			this.setState({ completed: 0 }, () => {
				App.api({
					name: 'trash',
					model: 'product',
					type: 'DELETE',
					success: (r) => {
						r = JSON.parse(r.response);
						if (r) {
							this.setState({ 
								trash: false,
								completed: 100,
								resultDialog: true,
								deleteDialog: false,
								resultDialogTitle: 'Success',
								resultDialogMessage: 'The request was successful'
							}, () => this.productsGetDataRequest());
						}
					},
					error: (r) => {
						r = JSON.parse(r.response);
						if (r.message) {
							this.setState({ 
								trash: false,
								completed: 100,
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
	}

	/**
	 * Request for getting products array
	 * @param {Function} callback
	 */
	productsGetDataRequest(callback = () => {}) {
		let { 
			start, 
			limit, 
			deleteID,
			contextID,
			searchText, 
		} = this.state;

		this.setState({ completed: 0 }, () => {
			var data = {
				limit,
				start: start + 1,
			};

			if (searchText && searchText.length > 0) {
				data['search'] = searchText;
			}

			if (contextID && contextID > 0) {
				data['context_id'] = contextID;
			}

			if (deleteID !== null) {
				data['delete_type'] = String(deleteID);
			}

			App.api({
				type: 'GET',
				name: 'all',
				model: 'product',
				data: data,
				success: (r) => {
					r = JSON.parse(r.response);
					if (r) {
						for (var i in r.data) {
							r.data[i]['title'] = <span 
								style={{ 
									color: r.data[i].delete === 1 ?
										'red' :
										'#000000',
									textDecoration: r.data[i].delete === 1 ?
										'line-through' :
										'none'
								}}>{r.data[i]['title']}</span>;
							r.data[i]['img'] = typeof r.data[i].images[0] === 'undefined' ?
								'' :
								<img src={App.uploads() + r.data[i].images[0].name}
									style={{maxHeight: '96px'}}
									alt={'icon'} />
							r.data[i]['control'] = <ControlOptions
								item={r.data[i]}
								editButton={true}
								onEditButtonClicked={item => {
									this.setState({
										a: App.name() +'/products/'+ item.id
									}, () => {
										var el = document.getElementById('change-page');
										if (el) {
											el.click();
										}
									});
								}}
								onDeleteButtonClicked={item => {
									this.setState({
										deleteDialog: true,
										deleteProductId: item.id,
									});
								}} />
						}

						this.setState({ 
							data: r.data,
							total: r.total,
							completed: 100
						}, () => callback(r));
					}
				}
			});
		});
	}

	/**
	 * Request for delete product
	 * @param {Object} e
	 */
	productDeleteRequest = e => {
		let { deleteProductId, selected } = this.state;

		this.setState({ 
			completed: 0 
		}, () => {
			App.api({
				name: selected.length > 0 ? 
					'trashMany' : 
					'trash',
				type: 'PUT',
				model: 'product',
				resource: deleteProductId > 0 && deleteProductId,
				data: selected.length > 0 && selected,
				success: (r) => {
					r = JSON.parse(r.response);
					if (r) {
						this.setState({ 
							trash: false,
							selected: [],
							completed: 100,
							deleteProductId: 0,
							deleteDialog: false,
						}, () => this.productsGetDataRequest());
					}
				},
				error: (r) => {
					r = JSON.parse(r.response);
					if (r.message) {
						this.setState({ 
							trash: false,
							selected: [],
							completed: 100,
							deleteProductId: 0,
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
			a,
			data, 
			limit,
			start,
			total,
			selected, 
			completed,
			contextID,
			searchText,
			resultDialog,
			deleteDialog,
			resultDialogTitle,
			resultDialogMessage
		} = this.state;

		return <div className="products-list__container">
				{completed === 0 && 
					<LinearProgress color="secondary" variant="determinate" value={completed} />}
					
				<Header
					title={'Products list'} />
				<Menu />

				<TopTitle
					title={''}
					addButtonDisplay={true}
					saveButtonDisplay={false}
					deleteButtonDisplay={selected.length > 0 ? 
						true : 
						false}
					addButtonTitle={'Add new product'}
					deleteButtonTitle={'Delete selected'}
					onAddButtonClicked={() => {
						this.setState({
							a: App.name() +'/products/create'
						}, () => {
							var el = document.getElementById('change-page');
							if (el) {
								el.click();
							}
						});
					}}
					onDeleteButtonClicked={() => {
						this.setState({
							deleteDialog: true
						});
					}}
					trashButtonDisplay={true}
					onTrashButtonClicked={() => this.setState({ trash: true })} />

				<Grid container spacing={24} className={classes.root}>
					<Grid item xs={12}>
						<PaperToolBar
							deleteFilterShow
							onDeleteSelected={deleteID => {
								this.setState({ deleteID }, () => {
									this.productsGetDataRequest();
								});
							}}
							contextDefaultValue={contextID}
							onContextSelected={contextID => {
								this.setState({ contextID }, () => {
									this.productsGetDataRequest();
								});
							}}
							searchDefaultValue={searchText}
							onSearchFieldSubmited={searchText => {
								this.setState({ searchText }, () => {
									this.productsGetDataRequest();
								});
							}} />
					</Grid>
				</Grid>

				<Grid container spacing={24} className={classes.root}>
					<Grid item xs={12}>
						{console.log(total)}
						{completed === 100 && <PaperTable
							page={start}
							limit={limit}
							total={total}
							headerItems={[{
								name: 'id', 
								title: 'ID'
							}, {
								name: 'title', 
								title: 'Name'
							}, {
								name: 'articul', 
								title: 'Articul'
							}, {
								name: 'price', 
								title: 'Price'
							}, {
								name: 'img',  
								title: 'Icon'
							}, {
								name: 'control', 
								title: 'Manage'
							}]}
							dataItems={data}
							onPrevPageClicked={e => this.setState({
								start: this.state.start - 1
							}, () => {
								this.productsGetDataRequest()
							})}
							onNextPageClicked={e => this.setState({
								start: this.state.start + 1
							}, () => {
								this.productsGetDataRequest()
							})} />}
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
						deleteProductId: 0
					})}
					onDialogConfirmed={() => this.productDeleteRequest()} />}

				{this.state.trash === true && <DialogDelete
					defaultValue={this.state.trash}
					onDialogClosed={() => this.setState({
						trash: false,
					})}
					content="Are you sure to empty trash?"
					onDialogConfirmed={() => this.emptyTrashRequest()} />}

				<Link to={a}
					id="change-page"
					style={{display: 'none'}}></Link>
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

export default withStyles(styles)(ListProductsContainer);