/**
 * Base module of manager users container
 * @module OrderContainers
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
import { LinearProgress } from 'material-ui/Progress';
import TopTitle from '../components/TopTitle/TopTitle.jsx';
import PaperTable from '../components/PaperTable/PaperTable.jsx';
import DialogOrder from '../components/DialogOrder/DialogOrder.jsx';
import DialogNote from '../components/DialogNote/DialogNote.jsx';
import DialogError from '../components/DialogError/DialogError.jsx';
import DialogDelete from '../components/DialogDelete/DialogDelete.jsx';
import PaperToolBar from '../components/PaperToolBar/PaperToolBar.jsx';
import ControlOptions from '../components/ControlOptions/ControlOptions.jsx';

import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Users base container
 * @extends Component
 */
class ListOrdersContainer extends Component {

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
		start: 0, 
		limit: 10, 
		save: false,
		total: 0,
		flag: true,
		dateTo: '',
		dateFrom: '',
		statusID: 0,
		paymentID: 0,
		contextID: 0,
		deliveryID: 0,
		searchText: '',
		completed: 100,
		deleteOrderId: 0,
		editOrder: {},
		noteOrder: {},
		noteData: {},
		dat: {},
		trash: false,
		deleteID: null,
		editDialog: false,
		noteDialog: false,
		deleteDialog: false,
		resultDialog: false,
		resultDialogTitle: '',
		resultDialogMessage: ''
	}

	/**
	 * Invoked just before mounting occurs
	 * @fires componentWillMount
	 */
	componentWillMount() {
		this.ordersGetDataRequest();
	}

	/**
	 * Get orders from server
	 * @param {Function} callback
	 */
	ordersGetDataRequest(callback = () => {}) {
		let { 
			start, 
			limit, 
			dateTo,
			dateFrom,
			contextID, 
			searchText, 
			statusID, 
			deleteID,
			paymentID,
			deliveryID } = this.state;

		this.setState({ completed: 0 }, () => {
			var data = {
				limit,
				start: start + 1,
			};

			/** Set string query
			 */
			if (searchText && searchText.length > 0) {
				data['search'] = searchText;
			}

			/** Set filter by context
			 */
			if (contextID && contextID > 0) {
				data['context_id'] = contextID;
			}

			/** Set filter by status
			 */
			if (statusID && statusID > 0) {
				data['status_id'] = statusID;
			}

			/** Set filter by payment
			 */
			if (paymentID && paymentID > 0) {
				data['payment_type_id'] = paymentID;
			}

			/** Set filter by delivery
			 */
			if (deliveryID && deliveryID > 0) {
				data['delivery_id'] = deliveryID;
			}

			/** Set filter by created date
			 */
			if (dateFrom) {
				data['created_at_from'] = dateFrom;
			}

			/** Set filter by created date
			 */
			if (dateTo) {
				data['created_at_to'] = dateTo;
			}

			if (deleteID !== null) {
				data['delete_type'] = String(deleteID);
			}

			App.api({
				type: 'GET',
				name: 'all',
				model: 'order',
				data: data,
				success: (r) => {
					r = JSON.parse(r.response);
					if (r) {
						this.setState({ 
							data: r.data,
							total: r.total,
							completed: 100,
							deleteOrderId: 0
						}, () => callback(r));
					}
				}
			});
		});
	}

	/**
	 * Get orders from server
	 * @param {Function} callback
	 */
	orderPutDataRequest(data, callback = () => {}) {
		this.setState({
			completed: 0
		}, () => {
			let { editOrder } = this.state;

			App.api({
				type: 'PUT',
				name: 'one',
				model: 'order',
				data,
				resource: editOrder.id,
				success: (r) => {
					r = JSON.parse(r.response);
					if (r) {
						this.setState({ 
							completed: 100,
							resultDialog: true,
							resultDialogTitle: 'Success',
							resultDialogMessage: 'The request was successful',
						}, () => callback());
					}
				},
				error: (r) => {
					r = JSON.parse(r.response);
					if (r.message) {
						this.setState({ 
							completed: 100,
							resultDialog: true,
							resultDialogTitle: 'Error',
							resultDialogMessage: r.message,
						}, () => callback());
					}
				}
			});
		});
	}

    /**
     * Get orders from server
     * @param {Function} callback
     */
    noteCreateRequest(data, callback = () => {}) {
        this.setState({
            completed: 0
        }, () => {
            let { noteOrder, noteData, dat } = this.state;

            dat.orderId = noteOrder.id;
            dat.text = noteData.text;
            App.api({
                type: 'POST',
                name: 'createNote',
                model: 'note',
                data: dat,
                success: (r) => {
                    r = JSON.parse(r.response);
                    if (r) {
                        this.setState({
                            completed: 100,
                            resultDialog: true,
                            resultDialogTitle: 'Success',
                            resultDialogMessage: 'The request was successful',
                            noteDialog: false
                        }, () => callback());
                        this.ordersGetDataRequest();
                    }
                },
                error: (r) => {
                    r = JSON.parse(r.response);
                    if (r.message) {
                        this.setState({
                            completed: 100,
                            resultDialog: true,
                            resultDialogTitle: 'Error',
                            resultDialogMessage: r.message,
                        }, () => callback());
                    }
                }
            });
        });
    }

	/**
	 * Delete order
	 * @param {Function} callback
	 */
	ordersDelteRequest(callback = () => {}) {
		let { deleteOrderId } = this.state;

		this.setState({ completed: 0 }, () => {
			App.api({
				name: 'trash',
				type: 'PUT',
				model: 'order',
				resource: deleteOrderId,
				success: (r) => {
					r = JSON.parse(r.response);
					if (r) {
						this.setState({ 
							completed: 100,
							deleteOrderId: 0,
							deleteDialog: false,
						}, () => callback(r));
					}
				},
				error: (r) => {
					r = JSON.parse(r.response);
					if (r.message) {
						this.setState({ 
							completed: 100,
							deleteOrderId: 0,
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

	emptyTrashRequest() {
		if (this.state.completed === 100) {
			this.setState({ completed: 0 }, () => {
				App.api({
					name: 'trash',
					model: 'order',
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
							}, () => this.ordersGetDataRequest());
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
	 * Stylize table data
	 */
	stylizeRows(data = []) {
		let { classes, editButtonValue } = this.props

		return data.map((item, i) => {
			if (this.state.save === true && this.state.editOrder.id === item.id) {
				this.setState({
					editOrder: item,
				})
			}

			return {
				id: item.id,
				numberRow: <div className={classes.numberCell}>
						<span className={classes.numberItem}
							style={{
								fontSize: '29px',
								color: item.delete === 1 ?
									'red' :
									'#000000',
								textDecoration: item.delete === 1 ?
									'line-through' :
									'none'
							}}># {item.number}</span>
						<span className={classes.statusItem}
							style={{color: item.status.color}}>{item.status.title}</span>

						<div className={classes.fieldItem}>
							context {item.context.title}
						</div>
					</div>,

				deliveryRow: <div className={classes.deliveryCell}>
						{ item.order_deliveries ? <div>
							{item.order_deliveries.first_name && item.order_deliveries.last_name ?
                                <div className={classes.fieldItem}>
                                    {item.order_deliveries.first_name} {item.order_deliveries.last_name}
                                </div>
							: null}

							{item.order_deliveries.email ? <div className={classes.fieldItem}>
								{item.order_deliveries.email}
							</div> : null}

						{item.order_deliveries.phone ? <div className={classes.fieldItem}>
							{item.order_deliveries.phone}
							</div> : null}

						{item.order_deliveries.city || item.order_deliveries.address ?
							<div className={classes.fieldItem}>
							{item.order_deliveries.city} {item.order_deliveries.address}
							</div> : null}

						{item.order_deliveries.delivery ?
							<div className={classes.fieldItem} style={{
							marginTop: '8px',
							paddingTop: '8px',
							borderTop: '1px solid #d6d6d6',
							color: item.order_deliveries.delivery.color
						}}>
                        <b>{item.order_deliveries.delivery.title}</b>
							</div> : null}
						</div>
						: null }
						</div>,
				costRow: <div className={classes.costCell}>
						<div>
							<span className={classes.fieldItem}>Order cost:</span>
							<span className={classes.costItem}>{item.cost.toFixed(2)} $</span>
						</div>

						<div>
							<span className={classes.fieldItem}>Prepayment cost:</span>
							<span className={classes.costItem}>{item.prepayment.toFixed(2)} $</span>
						</div>

					    {item.btc_price ?
                            <div>
                                <span className={classes.fieldItem}>BTC cost:</span>
                                <span className={classes.costItem}>{item.btc_price.toFixed(5)}</span>
                            </div>
					    : null}

						{item.payment_type ? 
							<div className={classes.fieldItem} style={{
								marginTop: '8px',
								paddingTop: '8px',
								borderTop: '1px solid #d6d6d6',
							}}>
								<b>{item.payment_type.title}</b>
							</div> : null}
					</div>,
				dateRow: <div className={classes.dateCell}>
						<span className={classes.dateItem}>{item.created_at}</span>
					</div>,
				control: <ControlOptions
							item={item}
							editButton={item.order_deliveries ? true : false}
							noteButton={true}
							onNoteButtonClicked={item => {
								this.setState({
									noteOrder: item,
									noteDialog: true
								})
							}}
							onEditButtonClicked={item => {
								this.setState({
									editOrder: item,
									editDialog: true
								})
							}}
							onDeleteButtonClicked={item => {
								this.setState({
									deleteDialog: true,
									deleteOrderId: item.id,
								});
							}} />
			};
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
			flag,
			start, 
			limit, 
			total, 
			dateTo,
			dateFrom,
			statusID,
			editOrder,
			paymentID,
			contextID, 
			deliveryID,
			searchText, 
			editDialog,
			noteDialog,
			deleteDialog,
			resultDialog,
			resultDialogTitle,
			resultDialogMessage,
			users,
			completed } = this.state;

		return <div className="pages-list__container">
				{completed === 0 && 
					<LinearProgress color="secondary" variant="determinate" value={completed} />}
					
				<Header
					title={'Orders list'} />
				<Menu />

				<Grid container spacing={24} className={classes.root}>
					<Grid item xs={12}>
						<TopTitle
							title={''}
							addButtonDisplay={true}
							saveButtonDisplay={false}
							deleteButtonDisplay={false}
							addButtonTitle={'Add new order'}
							onAddButtonClicked={() => {
								this.setState({
									a: App.name() +'/orders/create'
								}, () => {
									var el = document.getElementById('change-page');
									if (el) {
										el.click();
									}
								});
							}}
							deleteButtonTitle={'Delete selected'}
							trashButtonDisplay={true}
							onTrashButtonClicked={() => this.setState({ trash: true })} />

						<PaperToolBar
							statusShow
							paymentShow
							deliveryShow
							orderActionShow
							dateCreatedShow
							deleteFilterShow
							statusTitle={'Filter by status'}
							contextTitle={'Filter by context'}
							paymentTitle={'Filter by payment type'}
							deliveryTitle={'Filter by delivery type'}
							dateFromTitle={'Filter by order create date from'}
							dateToTitle={'to date'}
							contextDefaultValue={contextID}
							onDeleteSelected={deleteID => {
								this.setState({ deleteID }, () => {
									this.ordersGetDataRequest();
								});
							}}
							onContextSelected={contextID => {
								this.setState({ contextID }, () => {
									this.ordersGetDataRequest();
								});
							}}
							searchDefaultValue={searchText}
							onSearchFieldSubmited={searchText => {
								this.setState({ searchText }, () => {
									this.ordersGetDataRequest();
								});
							}}
							statusDefaultValue={statusID}
							onStatusSelected={statusID => {
								this.setState({ statusID }, () => {
									this.ordersGetDataRequest();
								});
							}}
							paymentDefaultValue={paymentID}
							onPaymentSelected={paymentID => {
								this.setState({ paymentID }, () => {
									this.ordersGetDataRequest();
								});
							}}
							deliveryDefaultValue={deliveryID}
							onDeliverySelected={deliveryID => {
								this.setState({ deliveryID }, () => {
									this.ordersGetDataRequest();
								});
							}}
							dateFromDefaultValue={dateFrom}
							onDateFromSelected={dateFrom => {
								dateFrom = dateFrom._d.toString();
								this.setState({ dateFrom }, () => {
									this.ordersGetDataRequest();
								});
							}}
							dateToDefaultValue={dateTo}
							onDateToSelected={dateTo => {
								dateTo = dateTo._d.toString();
								this.setState({ dateTo }, () => {
									this.ordersGetDataRequest();
								});
							}} />
					</Grid>
				</Grid>

				<Grid container spacing={24} className={classes.root}>
					<Grid item xs={12}>
						{completed === 100 ? <PaperTable
							data={this.stylizeRows(data)}
							except={['id']}
							page={start}
							limit={limit}
							total={total}
							columns={[{
								id: 'number', 
								numeric: false, 
								disablePadding: true, 
								label: 'Number'
							}, {
								id: 'delivery', 
								numeric: false, 
								disablePadding: true, 
								label: 'Delivery data'
							}, {
								id: 'cost', 
								numeric: false, 
								disablePadding: true, 
								label: 'Payment'
							}, {
								id: 'created_at', 
								numeric: false, 
								disablePadding: true, 
								label: 'Date'
							}, {
								id: 'control', 
								numeric: false, 
								disablePadding: true, 
								label: 'Control'
							}]}
							onRowsSelected={selected => this.setState({ selected })}
							onStartValueChanged={start => {
								this.setState({ 
									start,
								}, () => this.ordersGetDataRequest());
							}}
							onLimitValueChanged={limit => this.setState({ limit })} /> : null}
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
						deleteDialog: false
					})}
					onDialogConfirmed={() => this.ordersDelteRequest(() => {
						this.ordersGetDataRequest();
					})} />}

				{noteDialog === true && <DialogNote
					defaultValue={noteDialog}
					onNoteFieldInputed={value => {
						data['text'] = value;
						this.setState({
							noteData: data
						})
					}}
					onDialogClosed={() => this.setState({
						noteDialog: false
					})}
					onDialogConfirmed={() =>

						this.noteCreateRequest(() => {
						//this.ordersGetDataRequest();
					})} />}

				{this.state.trash === true && <DialogDelete
					defaultValue={this.state.trash}
					onDialogClosed={() => this.setState({
						trash: false,
					})}
					content="Are you sure to empty trash?"
					onDialogConfirmed={() => this.emptyTrashRequest()} />}

				{(editDialog === true && flag === true) && <DialogOrder
					order={editOrder}
					defaultValue={editDialog}
					onDialogClosed={() => {
						this.setState({ editDialog: false })
					}}
					onDialogSaved={form => {
						var i,
							data = {};

						this.setState({ flag: false, save: true }, () => {
							for (i = 0; i < form.length; i++) {
								if (form[i].name) {
									data[form[i].name] = form[i].value;
								}
							}

							this.orderPutDataRequest(data, () => this.ordersGetDataRequest(() => this.setState({ 
								save: false,
								flag: true,
								resultDialog: false
							})));
						});
					}} />}

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
	numberCell: {
		margin: '12px 0',
	},
	numberItem: {
		fontSize: 32,
		display: 'block'
	},
	statusItem: {
		fontSize: 15,
		display: 'block' 
	},
	costItem: {
		fontSize: 18,
		marginLeft: 4
	},
	fieldItem: {
		fontSize: 13,
		margin: '6px 0'
	},
});

export default withStyles(styles)(ListOrdersContainer);