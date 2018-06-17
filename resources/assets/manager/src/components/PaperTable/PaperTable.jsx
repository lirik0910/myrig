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
import EnhancedTableHead from './EnhancedTableHead/EnhancedTableHead.jsx';
import styles from './styles.js';

/**
 * Table pattern
 * @extends Component
 */
class PaperTable extends Component {

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
		data: [],
		columns: [],
		page: 0,
		total: 0,
		limit: 20,
		except: [],
		order: 'asc',
		footer: true,
		orderBy: 'id',
		buildByData: false,
		selecting: true,
		defaultSort: true,
		tableStyle: {},
		onRowsSelected: () => {},
		onStartValueChanged: () => {},
		onLimitValueChanged: () => {},
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
		selected: [],
		page: this.props.page,
		data: this.props.data,
		order: this.props.order,
		orderBy: this.props.orderBy,
		rowsPerPage: this.props.limit,
		total: this.props.total === 0 ? 
			this.props.data.length : 
			this.props.total
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
	handleChangeRowsPerPage(event) {
		this.setState({rowsPerPage: event.target.value}, () => {
			this.props.onLimitValueChanged(event.target.value);
		});
	}

	/**
	 * Change current page value
	 * @param {Object} event
	 */
	handleChangePage(event, page) {
		if (event !== null) {
			this.setState({ page }, () => {
				this.props.onStartValueChanged(page);
			});
		}
	}

	/**
	 * Click on row and select it
	 * @param {Object} event
	 * @param {Number} id
	 */
	handleClick = (event, id) => {
		const { selected, page, pagePaginStart } = this.state;
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

		this.setState({ selected: newSelected }, () => {
			this.props.onRowsSelected(newSelected, page, pagePaginStart);
		});
	}

	/**
	 * Select all rows
	 * @param {Object} event
	 * @param {Array} checked
	 */
	handleSelectAllClick = (event, checked) => {
		if (checked) {
			if (this.state.selected.length === this.state.data.length) {
				this.setState({selected: []}, () => this.props.onRowsSelected([]));
				return;
			}
			
			this.setState({selected: this.state.data.map(n => n.id)}, () => {
				this.props.onRowsSelected(this.state.selected);
			});
			return;
		}
		this.setState({selected: []}, () => this.props.onRowsSelected([]));
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
	 * Build table rows
	 * @return Array
	 */
	createRows(data, pagePaginStart, pagePaginFinish, k = 0) {
		const { classes, selecting, except, columns } = this.props;

		var i,
			a,
			cells;

		return data.map(n => {
			const isSelected = this.isSelected(n.id);

			cells = [];
			for(i in n) {
				if(except.indexOf(i) === -1) {
					cells.push(<TableCell key={k}
						style={{
							padding: 0
						}}>{n[i]}</TableCell>);
					k++;
				}
			}

			return <TableRow
					hover
					onClick={event => this.handleClick(event, n.id)}
					role="checkbox"
					aria-checked={isSelected}
					tabIndex={-1}
					key={n.id}
					selected={isSelected}>
					
					{selecting === true ? <TableCell 
						padding="checkbox" 
						className={classes.checkbox}
						style={{
							padding: 0
						}}>
						<Checkbox checked={isSelected} />
					</TableCell> : null}
											
					{cells}
				</TableRow>
		});
	}

	buildColumns(columns, data) {
		var cols,
			i,
			n,
			k,
			a;

		cols = [];
		for (k = 0; k < data.length; k++) {
			for(i in data[k]) {
				for (a = 0; a < columns.length; a++) {
					if (columns[a].name === i) {
						cols.push(columns[a]);
						break;
					}
				}
			}
			break;
		}

		return cols;
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		const { classes, columns, selecting, footer, defaultSort, buildByData, tableStyle } = this.props;
		const { 
			data, 
			order, 
			orderBy, 
			selected, 
			rowsPerPage, 
			page,
			total
		} = this.state;

		let pagePaginStart = page * rowsPerPage;
		let pagePaginFinish = page * rowsPerPage + rowsPerPage;

		return <Paper className={classes.paper}>
				<div className={classes.tableWrapper}>
					<Table className={classes.table} style={tableStyle}>
						<EnhancedTableHead
							columns={buildByData === true ? 
								this.buildColumns(columns, data) :
								columns}
							numSelected={selected.length}
							order={order}
							orderBy={orderBy}
							defaultSort={defaultSort}
							onSelectAllClick={this.handleSelectAllClick}
							onRequestSort={this.handleRequestSort}
							rowCount={total}
							selecting={selecting} />
						
						<TableBody>
							{this.createRows(data, pagePaginStart, pagePaginFinish)}
						</TableBody>
				
						{footer === true ? <TableFooter>
							<TableRow>
								<TablePagination
									colSpan={6}
									count={total}
									rowsPerPage={rowsPerPage}
									page={page}
									backIconButtonProps={{
										'aria-label': 'Previous Page',
									}}
									nextIconButtonProps={{
										'aria-label': 'Next Page',
									}}
									onChangePage={this.handleChangePage.bind(this)}
									onChangeRowsPerPage={this.handleChangeRowsPerPage.bind(this)} />
							</TableRow>
						</TableFooter> : null}
					</Table>
				</div>
			</Paper>
	}
}

export default withStyles(styles)(PaperTable);