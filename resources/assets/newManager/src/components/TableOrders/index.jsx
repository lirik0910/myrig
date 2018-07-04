/**
 * TableOrders module
 * @requires react
 * @requires react#PureComponent
 * @requires prop-types
 * @requires @material-ui/core/Grid
 * @requires @material-ui/core/Button
 * @requires @material-ui/core/IconButton
 * @requires @material-ui/core/Paper
 * @requires components/TableDefault
 * @requires components/BreadCrumbs
 * @requires components/MenuDefault
 * @requires components/FilterPages
 * @requires @material-ui/icons/Add
 * @requires @material-ui/icons/Delete
 * @requires @material-ui/icons/Create
 * @requires @material-ui/icons/ContentCopy
 * @requires @material-ui/core/styles#withStyles
 */

import React, { PureComponent } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';

import Grid from '@material-ui/core/Grid';
import Button from '@material-ui/core/Button';
import IconButton from '@material-ui/core/IconButton';
import Paper from '@material-ui/core/Paper';
import Dialog from '@material-ui/core/Dialog';
import DialogTitle from '@material-ui/core/DialogTitle';
import DialogContent from '@material-ui/core/DialogContent';
import DialogContentText from '@material-ui/core/DialogContentText';
import DialogActions from '@material-ui/core/DialogActions';
import TextField from '@material-ui/core/TextField';
import TableDefault from 'components/TableDefault';
import MenuDefault from 'components/MenuDefault';
import FilterOrders from 'components/FilterOrders';
import SelectDefault from 'components/SelectDefault';
import CellCommonOrdersTable from 'components/CellCommonOrdersTable';
import CellAboutOrdersTable from 'components/CellAboutOrdersTable';
import CellPaymentOrdersTable from 'components/CellPaymentOrdersTable';

import Add from '@material-ui/icons/Add';
import Delete from '@material-ui/icons/Delete';
import Create from '@material-ui/icons/Create';
// import ContentCopy from '@material-ui/icons/ContentCopy';

import { allOrders, trashOrder, postComment } from 'server/Orders.js';

import styles from './styles.js';
import { withStyles } from '@material-ui/core/styles';

/**
 * TableOrders block
 * @extends PureComponent
 */
class TableOrders extends PureComponent {
	constructor(props) {
		super(props);

		/** Get orders from server
		 */
		this.fetchOrders = allOrders(this.state.limit, 1)
			.then(this.buildDataRows.bind(this));

		document.addEventListener('allUserOrdersAction', (e) => this.handleFilterData({
			user_id: e.detail.user_id
		}));
		document.addEventListener('optionOrderDeleteAction', this.deleteOneOrder);
		document.addEventListener('optionOrderRecoveryAction', (e) => {
			this.setState({ selectedRows: [e.detail] }, () => 
				this.handleOrderTrash(e));
		});
		document.addEventListener('optionAddCommentAction', (e) => this.setState({ 
			managerComment: true,
			commentOrderId: e.detail.id,
			alertTitle: 'dialogTitleOrderComment'
		}));
	}
	
	/**
	 * Props validators
	 * @type {object}
	 * @property {function} classes
	 */
	static propTypes = {
		classes: PropTypes.object.isRequired
	}

	/**
	 * Page manage list
	 * @type {array}
	 */
	static itemOptions = [
		//'optionOrderView',
		'optionOrderEdit',
		'optionAddComment',
		//'optionOrderBlankEdit',
		//'optionOrderCopy',
		'optionOrderDelete',
		'optionOrderRecovery'
	]

	/**
	 * Default properties
	 * @type {object}
	 * @property {array} head
	 * @property {array} rows
	 */
	static defaultProps = {
		completed: false,
		orderUpdated: null,
		head: [
			'orderTableIdTitle',
			'orderTableCommonTitle',
			'orderTableAboutTitle',
			'orderTablePaymentTitle',
			'orderTableManageTitle'
		],
		rows: {
			orderTableCommonTitle: (item) => {
				let { number, created_at, status, context } = item;

				return <CellCommonOrdersTable
					delete={Boolean(item['delete'])}
					number={number}
					status={status.title}
					color={status.color}
					context={context.title}
					date={created_at} />
			},
			orderTableAboutTitle: (item) => {
				if (item.order_deliveries === null) {
					return null;
				}

				let { first_name, last_name, phone, email, address, city, delivery } = item.order_deliveries;
				
				return <CellAboutOrdersTable
					phone={phone}
					email={email}
					name={first_name +' '+ last_name}
					address={city +', '+ address}
					delivery={delivery}
					handleAllUserOrders={(e) => {
						let action = new CustomEvent('allUserOrdersAction', { detail: item });
						document.dispatchEvent(action);
					}} />
			},
			orderTablePaymentTitle: (item) => {
				let { cost, btc_price, carts, payment_type } = item;

				return <CellPaymentOrdersTable
					cost={cost}
					btcCost={btc_price}
					cart={carts}
					payment={payment_type} />
			},
			orderTableManageTitle: (item) => {
				return <MenuDefault
					menu={TableOrders.itemOptions.filter((opt) => {
						if (opt === 'optionOrderDelete' && item['delete'] === 1) {
							return false;
						}

						else if (opt === 'optionOrderRecovery' && item['delete'] === 0) {
							return false;
						}
						return true;
					})}
					switchEl={(obj) => {
						return <IconButton 
							color="primary"
							onClick={(e) => obj.setState({
								anchorEl: e.currentTarget
							})}>

							<Create />
						</IconButton>
					}}
					onMenuItemClicked={(e, name) => {
						let action = new CustomEvent(name +'Action', { detail: item });
						document.dispatchEvent(action);
					}} />
			}
		},
		onOrdersLoaded: (flag) => {},
		onRowUpdated: () => {},
		handleOrderCreate: () => {}
	}

	/**
	 * Current component state object
	 * @type {object}
	 * @property {boolean} selected
	 */
	state = {
		alert: false,
		selected: false,
		data: [],
		limit: 10,
		total: 0,
		page: 1,
		query: '',
		managerComment: false,
		fetchData: [],
		selectedRows: [],
		alertTitle: '',
		alertText: '',
		commentOrderId: 0,
		alertOkButton: () => {}
	}

	componentWillReceiveProps(willProps) {
		let { orderUpdated } = willProps;

		if (orderUpdated !== null) {
			let { fetchData } = this.state,
				i = 0;

			while (i < fetchData.data.length) {
				if (fetchData.data[i].id === orderUpdated.id) {
					fetchData.data[i] = orderUpdated;
					break;
				}
				i++;
			}
			this.props.onRowUpdated();
			this.buildDataRows(fetchData);
		}
	}

	/**
	 * Build table rows
	 * @param {object} list
	 */
	buildDataRows(list = { data: [] }) {
		this.setState({ 
			fetchData: list 
		}, () => {
			this.props.onOrdersLoaded(false);
			let i = 0,
				o = [],
				a, row;

			while (i < list.data.length) {
				row = {};
				a = 0;

				while (a < this.props.head.length) {
					row[this.props.head[a]] = this.props.rows[this.props.head[a]] ? 
						this.props.rows[this.props.head[a]](list.data[i]) : 
						'';
					a++;
				}

				o.push(row);
				i++;
			}

			this.setState({ 
				data: o,
				total: list.total
			}, () => this.props.onOrdersLoaded(true));
		});
	}

	/**
	 * Change current page and send new request on server
	 * @param {object} e
	 * @param {object} i
	 */
	handleChangePage = (e, newPage) => {
		let page = newPage + 1;

		this.props.onOrdersLoaded(false);
		this.setState({ page }, () => {
			this.fetchOrders = allOrders(this.state.limit, page, this.state.query)
				.then(this.buildDataRows.bind(this))
				.then(() => this.props.onOrdersLoaded(true));
		});
	}

	/**
	 * Change limit value
	 * @param {object} e
	 * @param {number} page
	 */
	handleChangeLimit = (e, page) => {
		let target = e.target;

		this.setState({ limit: target.value }, () => {
			this.fetchOrders = allOrders(target.value, page, this.state.query)
				.then(this.buildDataRows.bind(this));
		});
	}

	/**
	 * Clicked on copy orders button
	 * @fires onClick
	 * @param {object} e
	 */
	/*handleOrderCopy = (e) => {

	}*/

	/**
	 * Delete orders from trash
	 * @fires onClick
	 * @param {object} e
	 */
	handleOrderTrash = (e) => {
		let { selectedRows, page, limit, total } = this.state,
			i = 0, orders = [];

		while (i < selectedRows.length) {
			orders.push(selectedRows[i].id);
			i++;
		}
		this.fetchTrash = trashOrder('ids='+ JSON.stringify(orders))
			.then((r) => {
				if (r.message === true) {
					this.setState({ 
						total: 0
					}, () => {
						this.fetchOrders = allOrders(limit, page, this.state.query)
							.then(this.buildDataRows.bind(this))
							.then(() => {
								this.setState({ 
									total,
									alert: false
								});
							});
					});
				}
			});
	}

	deleteOneOrder = (e) => {
		this.setState({ 
			selectedRows: [e.detail], 
			alert: true,
			alertTitle: 'dialogTitleSendOrderToTrash',
			alertText: 'dialogTextSendOrderToTrash',
			alertOkButton: (e) => this.handleOrderTrash(e)
		});
	}

	/**
	 * Define that any row is selected
	 * @param {array} rows
	 */
	handleRowSelected = (rows) => {
		let i = 0,
			flag = false,
			selectedRows = [],
			{ fetchData } = this.state;

		while (i < rows.length) {
			if (rows[i] === true) {
				selectedRows.push(fetchData.data[i]);
				flag = true;
			}
			i++;
		}
		this.setState({ selected: flag, selectedRows });
	}

	/**
	 * Filter data
	 * @param {object} query
	 */
	handleFilterData = (query) => {
		if (this.props.completed === true) {
			let string = '',
				i;

			for (i in query) {
				string += '&'+ i +'='+ query[i];
			}

			this.setState({
				query: string
			});

			/** Get orders from server
			 */
			this.fetchOrders = allOrders(this.state.limit, 1, string)
				.then(this.buildDataRows.bind(this));
		}
	}

	sendComment = (e) => {
		e.preventDefault();

		this.props.onOrdersLoaded(false);
		e.target.elements;

		let i = 0,
			query = '';
		while (i < e.target.elements.length) {
			if (e.target.elements[i].name) {
				query += e.target.elements[i].name +'='+ e.target.elements[i].value +'&';
			}
			i++;
		}
		query = query.substring(0, query.length - 1);

		postComment(query)
			.then((data) => {
				this.setState({ managerComment: false }, () => 
					this.props.onOrdersLoaded(true));
			});
	}

	/**
	 * Render component
	 * @return {object} jsx object
	 */
	render() {
		let { classes, langs } = this.props;
		let { data, total, limit, alert, alertTitle, alertText, alertOkButton, managerComment } = this.state;

		return <div 
			className={classes.root}>
			
			<Grid container spacing={24} style={{ margin: 0 }}>
				<Grid item xs={12} sm={12} className={classes.toolBar}>
					<Button 
						onClick={this.props.toolbareOrdersCreate}>
						
						<Add />
						{langs['toolbareOrderCreate']}
					</Button>

					{/*<Button 
						disabled={!this.state.selected}
						onClick={this.handleOrderCopy}>
						
						<ContentCopy />
						{langs['toolbareOrderCopy']}
					</Button>*/}

					<Button 
						disabled={!this.state.selected}
						color="secondary"
						onClick={(e) => this.setState({ 
							alert: true,
							alertTitle: 'dialogTitleSendOrderToTrash',
							alertText: 'dialogTextSendOrderToTrash',
							alertOkButton: (e) => this.handleOrderTrash(e) 
						})}>
						
						<Delete />
						{langs['toolbareOrderTrash']}
					</Button>
				</Grid>
			</Grid>

			<Grid container spacing={24} style={{ margin: 0, width: '100%' }}>
				<Grid item xs={12} sm={9}>
					<Paper>
						{total > 0 ? <TableDefault
							key={1}
							limit={limit}
							total={total}
							data={data}
							paggination
							checkbox
							onRowSelected={this.handleRowSelected}
							onAllSelected={this.handleRowSelected}
							onPageChanged={this.handleChangePage}
							onLimitChanged={this.handleChangeLimit}
							TableRowProps={{
								style: {
									verticalAlign: 'initial'
								}
							}} /> : 
						<TableDefault
							key={2}
							limit={limit}
							total={total}
							data={[]}
							paggination
							TableRowProps={{
								style: {
									verticalAlign: 'initial'
								}
							}} />}
					</Paper>
				</Grid>

				<Grid item xs={12} sm={3}>
					<Paper>
						<FilterOrders
							onFilterChanged={this.handleFilterData} />
					</Paper>
				</Grid>
			</Grid>

			{managerComment === true && <Dialog 
				open={managerComment}
				onClose={(e) => this.setState({ 
					managerComment: false 
				})}
				PaperProps={{
					style: {
						width: 600
					}
				}}>

				<DialogTitle>
					{langs[alertTitle]}
				</DialogTitle>

				<form onSubmit={this.sendComment} method="post" action={window.server +'/note'}>
					<input type="hidden" name="orderId" value={this.state.commentOrderId} />

					<DialogContent>
						<SelectDefault
							name="type"
							title={langs['filterSelectCommentType']}
							helperText={langs['filterSelectHelperCommentType']}
							data={[{
								id: 'note',
								title: langs['labelSelectNote']
							}, {
								id: 'message',
								title: langs['labelSelectMessage']
							}]}
							onItemChanged={(e) => {}} />

						<TextField
							multiline
							rows="6"
							name="text"
							label={langs['labelFieldManagerComment']}
							style={{
								width: 'calc(100% - 24px)',
								margin: 12
							}} />
					</DialogContent>

					<DialogActions>
						<Button 
							color="secondary"
							onClick={(e) => this.setState({ 
								managerComment: false 
							})}>
							{langs['labelCancelButton']}
						</Button>

						<Button type="submit">
							{langs['labelOkButton']}
						</Button>
					</DialogActions>
				</form>
			</Dialog>}

			{alert === true && <Dialog 
				open={alert}
				onClose={(e) => this.setState({ 
					alert: false 
				})}>
				
				<DialogTitle>
					{langs[alertTitle]}
				</DialogTitle>
				
				<DialogContent>
					<DialogContentText>
						{langs[alertText]}
					</DialogContentText>
				</DialogContent>

				<DialogActions>
					<Button 
						color="secondary"
						onClick={(e) => this.setState({ 
							alert: false 
						})}>
						{langs['labelCancelButton']}
					</Button>

					<Button onClick={alertOkButton}>
						{langs['labelOkButton']}
					</Button>
				</DialogActions>
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
		langs: state.langs
	}
}

export default connect(mapStateToProps)(withStyles(styles)(TableOrders));