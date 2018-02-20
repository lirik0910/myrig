/**
 * Create table pattern module
 * @module ManagerTable
 * @author Ihor Bielchenko
 * @requires react
 * @requires react#Component
 * @requires prop-types
 * @requires material-ui/styles#withStyles
 * @requires material-ui/Table
 * @requires material-ui/Table#TableBody
 * @requires material-ui/Table#TableCell
 * @requires material-ui/Table#TableFooter
 * @requires material-ui/Table#TablePagination
 * @requires material-ui/Table#TableRow
 * @requires material-ui/Paper
 * @requires material-ui/Menu
 * @requires material-ui/Form#FormControl
 * @requires material-ui/Form#FormHelperText
 * @requires material-ui/Select
 * @requires material-ui/Button
 * @requires material-ui/Input
 * @requires components/Common/ManagerTable/EnhancedTableToolbar/EnhancedTableToolbar.jsx
 * @requires components/Common/ManagerTable/EnhancedTableHead/EnhancedTableHead.jsx
 * @requires components/Common/ManagerTable/styles.js
 */

import React, { Component } from 'react';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';

import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';
import Table, {
	TableBody,
	TableCell,
	TableFooter,
	TablePagination,
	TableRow,
} from 'material-ui/Table';
import Paper from 'material-ui/Paper';
import Checkbox from 'material-ui/Checkbox';
import { MenuItem } from 'material-ui/Menu';
import { FormControl, FormHelperText } from 'material-ui/Form';
import Select from 'material-ui/Select';
import Button from 'material-ui/Button';
import Input, { InputLabel } from 'material-ui/Input';
import EnhancedTableToolbar from './EnhancedTableToolbar/EnhancedTableToolbar.jsx';
import EnhancedTableHead from './EnhancedTableHead/EnhancedTableHead.jsx';
import styles from './styles.js';

/**
 * Table pattern
 * @extends Component
 */
class ManagerTable extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 * @property {Boolean} selecting Use checkbox for selecting
	 * @property {Boolean} footer Show footer
	 * @property {String} order Order type of table rows
	 * @property {Number} page Start page numbaer
	 * @property {Number} rowsPerPage Rows limit on once page
	 * @property {Function} select Function runs when some rows was selected
	 */
	static defaultProps = {
		classes: PropTypes.object.isRequired,
		selecting: true,
		footer: true,
		order: 'asc',
		page: 0,
		rowsPerPage: 20,
		orderBy: 'id',
		select: () => {}
	}

	/**
	 * Invoked immediately before mounting occurs
	 * @fires componentWillMount
	 */
	componentWillMount() {
		this.setState({
			data: this.props.data.sort((a, b) => (a.calories < b.calories ? -1 : 1)),
			order: this.props.order,
			page: this.props.page,
			rowsPerPage: this.props.rowsPerPage,
			orderBy: this.props.orderBy
		})
	}

	/**
	 * State object of component
	 * @type {Object} 
	 * @inner
	 * @property {String} order Table order type
	 * @property {String} orderBy Value by order table
	 * @property {Array} selected Selected rows
	 * @property {Array} data Table content
	 * @property {Number} page Current page
	 * @property {Number} rowsPerPage Limit of rows
	 */
	state = {
		order: 'asc',
		orderBy: 'id',
		selected: [],
		data: [],
		page: 0,
		rowsPerPage: 10,
	}

	/**
	 * Check if row in table is selected
	 * @param {Number} id
	 * @return {Number}
	 */
	isSelected = id => this.state.selected.indexOf(id) !== -1

	/**
	 * Change rows limit
	 * @param {Object} event
	 */
	handleChangeRowsPerPage = event => {
		this.setState({rowsPerPage: event.target.value});
	}

	/**
	 * Change current page value
	 * @param {Object} event
	 */
	handleChangePage = (event, page) => {
		this.setState({page});
	}

	/**
	 * Click on row and select it
	 * @param {Object} event
	 * @param {Number} id
	 */
	handleClick = (event, id) => {
		const { selected } = this.state;
		const selectedIndex = selected.indexOf(id);
		let newSelected = [];

		if (selectedIndex === -1) {
			newSelected = newSelected.concat(selected, id);
		} else if (selectedIndex === 0) {
			newSelected = newSelected.concat(selected.slice(1));
		} else if (selectedIndex === selected.length - 1) {
			newSelected = newSelected.concat(selected.slice(0, -1));
		} else if (selectedIndex > 0) {
			newSelected = newSelected.concat(
				selected.slice(0, selectedIndex),
				selected.slice(selectedIndex + 1),
			);
		}

		this.setState({selected: newSelected}, () => {
			this.props.select(newSelected);
		});
	}

	/**
	 * Select all rows
	 * @param {Object} event
	 * @param {Array} checked
	 */
	handleSelectAllClick = (event, checked) => {
		if (checked) {
			this.setState({selected: this.state.data.map(n => n.id)}, () => {
				this.props.select(this.state.selected);
			});
			return;
		}
		this.setState({selected: []}, () => this.props.select([]));
	}

	/**
	 * Sort table by value
	 * @param {Object} event
	 * @param {String} property
	 */
	handleRequestSort = (event, property) => {
		const orderBy = property;
		let order = 'desc';

		if (this.state.orderBy === property && this.state.order === 'desc') {
			order = 'asc';
		}

		const data =
			order === 'desc'
				? this.state.data.sort((a, b) => (b[orderBy] < a[orderBy] ? -1 : 1))
				: this.state.data.sort((a, b) => (a[orderBy] < b[orderBy] ? -1 : 1));

		this.setState({data, order, orderBy});
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		const { classes, columns, selecting, footer } = this.props;
		const { data, order, orderBy, selected, rowsPerPage, page, } = this.state;
		const emptyRows = rowsPerPage - Math.min(rowsPerPage, data.length - page * rowsPerPage);

		let pagePaginStart = page * rowsPerPage;
		let pagePaginFinish = page * rowsPerPage + rowsPerPage;

		var row = [],
			i,
			k;

		return <Paper className={classes.root}>
				<div className={classes.tableWrapper}>
					<Table className={classes.table}>
						<EnhancedTableHead
							columns={columns}
							numSelected={selected.length}
							order={order}
							orderBy={orderBy}
							onSelectAllClick={this.handleSelectAllClick}
							onRequestSort={this.handleRequestSort}
							rowCount={data.length}
							selecting={selecting} />
						<TableBody>
							{data.slice(pagePaginStart, pagePaginFinish).map(n => {
								const isSelected = this.isSelected(n.id);

								k = 0;
								row = [];
								for(i in n) {
									row.push(<TableCell key={k}>{n[i]}</TableCell>);
									k++;
								}

								return <TableRow
										hover
										onClick={event => this.handleClick(event, n.id)}
										role="checkbox"
										aria-checked={isSelected}
										tabIndex={-1}
										key={n.id}
										selected={isSelected}>
											{selecting === true ? 
												<TableCell padding="checkbox" className={classes.checkbox}>
													<Checkbox checked={isSelected} />
												</TableCell> : ''}
														
											{row}
								</TableRow>
							})}
						</TableBody>
				
						{footer === true ?
							<TableFooter>
								<TableRow>
									<TablePagination
										colSpan={6}
										count={data.length}
										rowsPerPage={rowsPerPage}
										page={page}
										backIconButtonProps={{
											'aria-label': 'Previous Page',
										}}
										nextIconButtonProps={{
											'aria-label': 'Next Page',
										}}
										onChangePage={this.handleChangePage}
										onChangeRowsPerPage={this.handleChangeRowsPerPage}/>
								</TableRow>
							</TableFooter> : ''}
					</Table>
				</div>
			</Paper>
	}
}

export default withStyles(styles)(ManagerTable);