/**
 * CellPaymentOrdersTable module
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

import React, { PureComponent, Fragment } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';

import Typography from '@material-ui/core/Typography';
import List from '@material-ui/core/List';
import ListItem from '@material-ui/core/ListItem';

import styles from './styles.js';
import { withStyles } from '@material-ui/core/styles';

/**
 * CellPaymentOrdersTable block
 * @extends PureComponent
 */
class CellPaymentOrdersTable extends PureComponent {
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
	 * @property {array} head
	 * @property {array} rows
	 */
	static defaultProps = {
		cost: 0,
		btcCost: 0,
		cart: [],
		payment: {}
	}

	/**
	 * Render component
	 * @return {object} jsx object
	 */
	render() {
		let { classes, cost, btcCost, cart, payment, langs } = this.props;

		return <Fragment>
			<Typography variant="subheading">
				{langs['txtOrderTotalSum']}: <b>{cost.toFixed(2)}</b>
			</Typography>

			<Typography variant="subheading">
				{langs['txtOrderTotalBtcSum']}: <b>{btcCost.toFixed(2)}</b>
			</Typography>

			<List>
			{cart.map((item, i) => {
				if (item.product === null) {
					return null;
				}
				
				return <ListItem 
					key={i}
					className={classes.productItem}>

					<b>{ item.product.title } ({ item.count })</b>
					<div>{langs['txtOrderTotalSum']}: { item.cost }</div>
					<div>{langs['txtOrderTotalBtcSum']}: { item.btcCost }</div>
				</ListItem>
			})}
			</List>

			<Typography variant="subheading">
				{ langs['payment_'+ payment.title] }
			</Typography>
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

export default connect(mapStateToProps)(withStyles(styles)(CellPaymentOrdersTable));