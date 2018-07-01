/**
 * OrderHistory module
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
import { connect } from 'react-redux';

import Typography from '@material-ui/core/Typography';
import Paper from '@material-ui/core/Paper';
import TableDefault from 'components/TableDefault';

import styles from './styles.js';
import { withStyles } from '@material-ui/core/styles';

/**
 * OrderHistory block
 * @extends PureComponent
 */
class OrderHistory extends PureComponent {
	static defaultProps = {
		total: 0,
		data: [],
		head: [
			'orderHistoryValue',
			'orderHistoryUser',
			'orderHistoryDate'
		],
		rows: {
			orderHistoryValue: (item) => {
				return <Typography>
					{ item.value }
				</Typography>
			},
			orderHistoryUser: (item) => {
				return <Typography>
					{item.user.name}
				</Typography>
			},
			orderHistoryDate: (item) => {
				return <Typography>
					{item.created_at}
				</Typography>
			}
		}
	}

	state = {
		limit: 100
	}

	/**
	 * Build table rows
	 * @param {array} data
	 */
	buildDataRows(data = []) {
		let i = 0,
			o = [],
			a, row;

		while (i < data.length) {
			row = {};
			a = 0;

			while (a < this.props.head.length) {
				row[this.props.head[a]] = this.props.rows[this.props.head[a]] ? 
					this.props.rows[this.props.head[a]](data[i]) : 
					'';
				a++;
			}

			o.push(row);
			i++;
		}
		return o;
	}

	render() {
		let { limit } = this.state,
			{ data, total, langs } = this.props;

		return <Paper style={{ marginBottom: 24, overflow: 'hidden' }}>
			<Typography variant="title">
				{langs['orderEditHistoryTitle']}
			</Typography>

			<TableDefault
				limit={limit}
				total={total}
				data={this.buildDataRows(data)}
				TableRowProps={{
					style: {
						verticalAlign: 'initial'
					}
				}} />
		</Paper>
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

export default connect(mapStateToProps)(withStyles(styles)(OrderHistory));