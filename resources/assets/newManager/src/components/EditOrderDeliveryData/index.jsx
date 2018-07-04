/**
 * EditOrderDeliveryData module
 * @requires react
 * @requires react#PureComponent
 */

import React, { PureComponent } from 'react';
import { connect } from 'react-redux';

import Paper from '@material-ui/core/Paper';
import Typography from '@material-ui/core/Typography';
import TextField from '@material-ui/core/TextField';
import FilterOrderDelivery from 'components/FilterOrderDelivery';
import FilterCountry from 'components/FilterCountry';

/**
 * EditOrderDeliveryData block
 * @extends PureComponent
 */
class EditOrderDeliveryData extends PureComponent {

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

			for (i in order.order_deliveries) {
				o['d_'+ i] = order.order_deliveries[i] === null ?
					'' :
					order.order_deliveries[i];
			}
			return o;
		})()
	}

	componentWillReceiveProps(willProps) {
		let { order_deliveries } = this.props.order;

		if ((typeof order_deliveries.id === 'undefined' || order_deliveries.id === 0) && 
			willProps.order.order_deliveries.id > 0) {

			let i,
				o = {};

			for (i in willProps.order.order_deliveries) {
				o['d_'+ i] = willProps.order.order_deliveries[i] === null ?
					order_deliveries[i] :
					willProps.order.order_deliveries[i];
			}
			this.setState({ ...o });
		}

		/*else if (willProps.order.order_deliveries.id > 0) {
			let i,
				o = {};

			for (i in willProps.order.order_deliveries) {
				o['d_'+ i] = willProps.order.order_deliveries[i] === null ?
					order_deliveries[i] :
					willProps.order.order_deliveries[i];
			}
			this.setState({ ...o });
		}*/
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
				{langs['orderTableAboutTitle']}
			</Typography>

			<FilterOrderDelivery
				formId="el_delivery_id"
				defaultValue={order.order_deliveries.delivery_id} />

			<TextField
				required
				id="el_d_first_name"
				name="d_first_name"
				value={this.state.d_first_name}
				label={langs['labelFieldUserFirstName']}
				onChange={this._handleChange}
				style={{
					width: 'calc(100% - 24px)',
					margin: 12
				}} />

			<TextField
				required
				id="el_d_last_name"
				name="d_last_name"
				value={this.state.d_last_name}
				label={langs['labelFieldUserLastName']}
				onChange={this._handleChange}
				style={{
					width: 'calc(100% - 24px)',
					margin: 12
				}} />

			<TextField
				required
				name="d_email"
				id="el_d_email"
				value={this.state.d_email}
				label={langs['labelFieldUserEmail']}
				onChange={this._handleChange}
				style={{
					width: 'calc(100% - 24px)',
					margin: 12
				}} />

			<TextField
				required
				id="el_d_phone"
				name="d_phone"
				value={this.state.d_phone}
				label={langs['labelFieldUserPhone']}
				onChange={this._handleChange}
				style={{
					width: 'calc(100% - 24px)',
					margin: 12
				}} />

			<FilterCountry
				name="d_country"
				data={countries}
				defaultValue={order.order_deliveries.country} />

			<TextField
				name="d_city"
				value={this.state.d_city}
				label={langs['labelFieldUserCity']}
				onChange={this._handleChange}
				style={{
					width: 'calc(100% - 24px)',
					margin: 12
				}} />

			<TextField
				name="d_state"
				value={this.state.d_state}
				label={langs['labelFieldUserState']}
				onChange={this._handleChange}
				style={{
					width: 'calc(100% - 24px)',
					margin: 12
				}} />

			<TextField
				name="d_address"
				value={this.state.d_address}
				label={langs['labelFieldUserAddress']}
				onChange={this._handleChange}
				style={{
					width: 'calc(100% - 24px)',
					margin: 12
				}} />

			<TextField
				name="d_office"
				value={this.state.d_office}
				label={langs['labelFieldUserOffice']}
				onChange={this._handleChange}
				style={{
					width: 'calc(100% - 24px)',
					margin: 12
				}} />

			<TextField
				name="d_passport"
				value={this.state.d_passport}
				label={langs['labelFieldUserPassport']}
				onChange={this._handleChange}
				style={{
					width: 'calc(100% - 24px)',
					margin: 12
				}} />

			<TextField
				name="d_zendesk"
				value={this.state.d_zendesk}
				label={langs['labelFieldUserZendesk']}
				onChange={this._handleChange}
				style={{
					width: 'calc(100% - 24px)',
					margin: 12
				}} />

			<TextField
				name="d_warranty"
				value={this.state.d_warranty}
				label={langs['labelFieldUserWarranty']}
				onChange={this._handleChange}
				style={{
					width: 'calc(100% - 24px)',
					margin: 12
				}} />

			<TextField
				name="d_waybill"
				value={this.state.d_waybill}
				label={langs['labelFieldUserWaybill']}
				onChange={this._handleChange}
				style={{
					width: 'calc(100% - 24px)',
					margin: 12
				}} />

			<TextField
				multiline
				rows="4"
				name="d_comment"
				value={this.state.d_comment}
				label={langs['labelFieldUserComment']}
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

export default connect(mapStateToProps)(EditOrderDeliveryData);