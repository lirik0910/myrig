/**
 * CellAboutOrdersTable module
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

import styles from './styles.js';
import { withStyles } from '@material-ui/core/styles';

/**
 * CellAboutOrdersTable block
 * @extends PureComponent
 */
class CellAboutOrdersTable extends PureComponent {
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
		email: '',
		name: '',
		phone: '',
		address: '',
		delivery: {},
		handleAllUserOrders: (e) => {}
	}

	/**
	 * Render component
	 * @return {object} jsx object
	 */
	render() {
		let { classes, email, name, phone, address, delivery, langs } = this.props;

		return <Fragment>			
			<Typography variant="subheading">
				<b>{ name }</b>
				<span
					className={classes.allOrders}
					onClick={this.props.handleAllUserOrders}>
					
					{langs['txtAllOrders']}
				</span>
			</Typography>

			<Typography variant="subheading">{ email }</Typography>
			<Typography variant="subheading">{ phone }</Typography>
			<Typography variant="subheading">{ address }</Typography>
			<Typography variant="subheading">
				<span style={{ color: delivery.color }}>{ langs['delivery_'+ delivery.title] }</span>
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

export default connect(mapStateToProps)(withStyles(styles)(CellAboutOrdersTable));