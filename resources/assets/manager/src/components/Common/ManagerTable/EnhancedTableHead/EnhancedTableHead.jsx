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
import * as StateElementAction from '../../../../actions/StateElementAction.js';
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
		let { onSelectAllClick, order, orderBy, numSelected, rowCount, columns, selecting, defaultSort } = this.props;

		return <TableHead>
				<TableRow>
					{selecting === true ? 
						<TableCell padding="checkbox">
							<Checkbox
								indeterminate={numSelected > 0 && numSelected < rowCount}
								checked={numSelected === rowCount}
								onChange={onSelectAllClick} />
						</TableCell> : null}
	
					{columns.map(column => {
						return <TableCell
									key={column.id}
									numeric={column.numeric}
									sortDirection={orderBy === column.id ? 
										order : 
										false}>

									{defaultSort === true ?
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
										</Tooltip> : 
										column.label}
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
		StateElementAction: bindActionCreators(StateElementAction, dispatch),
	}
}

export default connect(mapStateToProps, mapDispatchToProps)(withStyles(styles)(EnhancedTableHead));