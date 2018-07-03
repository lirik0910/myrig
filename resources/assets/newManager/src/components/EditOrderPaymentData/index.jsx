/**
 * EditOrderPaymentData module
 * @requires react
 * @requires react#PureComponent
 */

import React, { PureComponent } from 'react';
import { connect } from 'react-redux';

import Paper from '@material-ui/core/Paper';
import Typography from '@material-ui/core/Typography';
import TextField from '@material-ui/core/TextField';
import FilterCountry from 'components/FilterCountry';

/**
 * EditOrderPaymentData block
 * @extends PureComponent
 */
class EditOrderPaymentData extends PureComponent {

	/**
	 * Default properties
	 * @type {object}
	 */
	static defaultProps = {
		order: {},
		countries: [],
		handleFieldChanged: (e) => {}
	}

	state = {
		...(() => {
			let i, o = {},
				{ order } = this.props;

			for (i in order.order_payments) {
				o['p_'+ i] = order.order_payments[i] === null ?
					'' :
					order.order_payments[i];
			}
			return o;
		})()
	}

	componentWillReceiveProps(willProps) {
		let { order_payments } = this.props.order;

		if (order_payments !== null) {
			if (order_payments.id === 0 && willProps.order.order_payments.id > 0) {

				let i,
					o = {};

				for (i in willProps.order.order_payments) {
					o['p_'+ i] = willProps.order.order_payments[i] === null ?
						order_payments[i] :
						willProps.order.order_payments[i];
				}
				this.setState({ ...o });
			}
		}
	}

	_handleChange = (e) => {
		this.setState({ [e.target.name]: e.target.value }, () => 
			this.props.handleFieldChanged(e));
	}

	/**
	 * Render component
	 * @return {object} jsx object
	 */
	render() {
		let { order, countries, langs } = this.props;

		return <Paper style={{ marginBottom: 24 }}>
			<Typography variant="title">
				{langs['orderTablePaymentTitle']}
			</Typography>

			<Typography style={{ padding: 12 }}>
				{langs['txtOrderTotalSum']}: <b>{order.cost}</b>
			</Typography>

			<Typography style={{ padding: 12 }}>
				{langs['txtOrderTotalBtcSum']}: <b>{order.btc_price}</b>
			</Typography>

			<TextField
				name="p_first_name"
				value={this.state.p_first_name}
				label={langs['labelFieldUserFirstName']}
				onChange={this._handleChange}
				style={{
					width: 'calc(100% - 24px)',
					margin: 12
				}} />

			<TextField
				name="p_last_name"
				value={this.state.p_last_name}
				label={langs['labelFieldUserLastName']}
				onChange={this._handleChange}
				style={{
					width: 'calc(100% - 24px)',
					margin: 12
				}} />

			{order.order_payments === null || order.order_payments.country === null ? <FilterCountry
				name="p_country"
				data={countries}
				value="title" /> :
			<FilterCountry
				name="p_country"
				data={countries}
				value="title"
				defaultValue={order.order_payments.country} />}

			<TextField
				name="p_city"
				value={this.state.p_city}
				label={langs['labelFieldUserCity']}
				onChange={this._handleChange}
				style={{
					width: 'calc(100% - 24px)',
					margin: 12
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

export default connect(mapStateToProps)(EditOrderPaymentData);