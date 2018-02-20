/**
 * Header block module
 * @module EnhancedTableHead
 * @author Ihor Bielchenko
 * @requires react
 * @requires react#Component
 * @requires redux#bindActionCreators
 * @requires react-redux#connect
 */

import React, { Component } from 'react';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';
import Checkbox from 'material-ui/Checkbox';
import Tooltip from 'material-ui/Tooltip';
import {
	TableCell,
	TableHead,
	TableRow,
	TableSortLabel,
} from 'material-ui/Table';

const columnData = [
	{ id: 'name', numeric: false, disablePadding: true, label: 'Название страницы' },
	{ id: 'calories', numeric: true, disablePadding: false, label: 'Calories' },
	{ id: 'fat', numeric: true, disablePadding: false, label: 'Fat (g)' },
	{ id: 'carbs', numeric: true, disablePadding: false, label: 'Carbs (g)' },
	{ id: 'protein', numeric: true, disablePadding: false, label: 'Protein (g)' },
];

/**
 * Header block
 * @extends Component
 */
class EnhancedTableHead extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		classes: PropTypes.object.isRequired,
		numSelected: PropTypes.number.isRequired,
		onRequestSort: PropTypes.func.isRequired,
		onSelectAllClick: PropTypes.func.isRequired,
		order: PropTypes.string.isRequired,
		orderBy: PropTypes.string.isRequired,
		rowCount: PropTypes.number.isRequired,
	}

	createSortHandler = property => event => {
		this.props.onRequestSort(event, property);
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		const { onSelectAllClick, order, orderBy, numSelected, rowCount, columns, selecting } = this.props;

		return <TableHead>
				<TableRow>
					{selecting === true ? 
						<TableCell padding="checkbox">
							<Checkbox
								indeterminate={numSelected > 0 && numSelected < rowCount}
								checked={numSelected === rowCount}
								onChange={onSelectAllClick} />
						</TableCell> : ''}
	
					{columns.map(column => {
						return <TableCell
									key={column.id}
									numeric={column.numeric}
									sortDirection={orderBy === column.id ? 
										order : 
										false}>

									<Tooltip
										title="Sort"
										placement={column.numeric ? 
											'bottom-end' : 
											'bottom-start'}
										enterDelay={300}>
											<TableSortLabel
												active={orderBy === column.id}
												direction={order}
												onClick={this.createSortHandler(column.id)}>
													{column.label}
											</TableSortLabel>
									</Tooltip>
								</TableCell>
						}, this)}
				</TableRow>
			</TableHead>
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
		//StateElementAction: bindActionCreators(StateElementAction, dispatch),
	}
}

export default connect(mapStateToProps, mapDispatchToProps)(withStyles(styles)(EnhancedTableHead));