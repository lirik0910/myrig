/**
 * MenuDefault module
 * @requires react
 * @requires react#PureComponent
 * @requires react#Fragment
 * @requires prop-types
 * @requires @material-ui/core/Table
 * @requires @material-ui/core/TableBody
 * @requires @material-ui/core/TableCell
 * @requires @material-ui/core/TableHead
 * @requires @material-ui/core/TableRow
 * @requires @material-ui/core/TablePagination
 * @requires @material-ui/core/Checkbox
 * @requires @material-ui/core/styles#withStyles
 */

import React, { PureComponent, Fragment } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';

import Table from '@material-ui/core/Table';
import TableBody from '@material-ui/core/TableBody';
import TableCell from '@material-ui/core/TableCell';
import TableHead from '@material-ui/core/TableHead';
import TableRow from '@material-ui/core/TableRow';
import TablePagination from '@material-ui/core/TablePagination';
import Checkbox from '@material-ui/core/Checkbox';

import styles from './styles.js';
import { withStyles } from '@material-ui/core/styles';

/**
 * TableDefault block
 * @extends PureComponent
 */
class TableDefault extends PureComponent {

	/**
	 * Props validators
	 * @type {object}
	 * @property {function} classes
	 */
	static propTypes = {
		classes: PropTypes.object.isRequired
	}

	/**
	 * Default properties
	 * @type {object}
	 * @property {boolean} headVisible
	 * @property {array} data
	 * @property {boolean} paggination
	 * @property {boolean} checkbox
	 * @property {number} limit
	 * @property {number} startPage
	 * @property {number} total
	 * @property {function} onPageChanged
	 * @property {function} onLimitChanged
	 * @property {function} onRowSelected
	 * @property {function} onAllSelected
	 * @property {string} labelRowsPerPage
	 */
	static defaultProps = {
		headVisible: true,
		data: [],
		paggination: false,
		checkbox: false,
		limit: 10,
		startPage: 0,
		total: 10,
		rowsLimits: [5, 10, 25, 50],
		TableRowProps: {},
		onPageChanged: (e, page) => {},
		onLimitChanged: (e) => {},
		onAllSelected: (rows, e) => {},
		onRowSelected: (rows, i) => {},
		labelRowsPerPage: 'labelTableDefaultRowsPerPage'
	}

	/**
	 * Current component state object
	 * @type {object}
	 * @property {array} head Column titles list
	 * @property {number} page Current page
	 * @property {number} total Amount pages
	 * @property {array} selected
	 */
	state = {
		head: this.props.data[0] ? 
			Object.keys(this.props.data[0]) : [],
		page: this.props.startPage,
		selected: []
	}

	/** 
	 * Invoked just before mounting occurs 
	 * @fires componentWillMount
	 */
	componentWillMount() {
		this.setCheckboxesState();
	}

	/**
	 * Create table lines array for checkboxes state
	 */
	setCheckboxesState() {
		let { data } = this.props;

		let i = 0,
			selected = [];
		while (i < data.length) {
			selected.push(false);
			i++;
		}
		this.setState({ selected });
	}

	/**
	 * Select all rows
	 * @fires onChange
	 * param {object} e
	 */
	handleAllSelected = (e) => {
		let i = 0,
			a = [];

		while (i < this.state.selected.length) {
			a.push(e.target.checked);
			i++;
		}
		this.setState({ selected: a }, () => {
			this.props.onAllSelected(a, e);
		});
	}

	/**
	 * Select row
	 * @fires onChange
	 * @param {object} e
	 * @param {number} i
	 */
	handleSelectRow(e, i) {
		let a = [],
			c = 0;
		
		while (c < this.state.selected.length) {
			a.push(i === c ?
				!this.state.selected[i] :
				this.state.selected[c]);
			c++;
		}

		this.setState({ selected: a }, () => {
			this.props.onRowSelected(a, i);
		});
	}

	/**
	 * Render component
	 * @return {object} jsx object
	 */
	render() {
		let { classes, headVisible, data, paggination, limit, TableRowProps, checkbox, langs } = this.props,
			c = 0;

		return <Fragment>
			<Table className={classes.table}>
				{headVisible && this.state.head.length > 0 && <TableHead>
					<TableRow>
					{this.state.head.map((item, i) => {
						return checkbox === true && i === 0 ? 
							<TableCell key={i} padding="checkbox">
								<Checkbox
									onChange={this.handleAllSelected} />
							</TableCell> :
							<TableCell key={i}>
								{langs[item]}
							</TableCell>
					})}
					</TableRow>
				</TableHead>}

				{data.length > 0 && <TableBody>
					{data.map((row, i) => {
						return <TableRow key={i} {...TableRowProps}>
							{Object.keys(row).map((cell, n) => {
								return checkbox === true && n === 0 ?
									<TableCell 
										key={c++}
										scope="row"
										component="th"
										padding="checkbox">
											<Checkbox
												value={cell}
												checked={this.state.selected[i]}
												onChange={(e) => this.handleSelectRow(e, i)} />
									</TableCell> :
									<TableCell 
										key={c++}
										scope="row"
										component="th">
											{row[cell]}
									</TableCell>
							})}
						</TableRow>
					})}
				</TableBody>}
			</Table>

			{paggination && <TablePagination
				component="div"
				count={this.props.total}
				rowsPerPage={limit}
				page={this.state.page}
				onChangePage={(e, page) => {
					this.setState({ page }, () => {
						this.props.onPageChanged(e, page);
					});
				}}
				onChangeRowsPerPage={(e) => {
					this.setState({ rowsPerPage: e.target.value }, () => {
						this.props.onLimitChanged(e, this.state.page);
					});
				}}
				rowsPerPageOptions={this.props.rowsLimits} />}
		</Fragment>
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

export default connect(mapStateToProps)(withStyles(styles)(TableDefault));