/**
 * EditOrderCommonData module
 * @requires react
 * @requires react#PureComponent
 */

import React, { PureComponent } from 'react';
import { connect } from 'react-redux';

import Paper from '@material-ui/core/Paper';
import Typography from '@material-ui/core/Typography';
import Checkbox from '@material-ui/core/Checkbox';
import FormControlLabel from '@material-ui/core/FormControlLabel';
import FieldPublichDate from 'components/FieldPublichDate';
import SearchUser from 'components/SearchUser';
import FilterContext from 'components/FilterContext';
import FilterOrderStatus from 'components/FilterOrderStatus';
import FilterOrderPayment from 'components/FilterOrderPayment';

/**
 * EditOrderCommonData block
 * @extends PureComponent
 */
class EditOrderCommonData extends PureComponent {

	/**
	 * Default properties
	 * @type {object}
	 */
	static defaultProps = {
		order: {},
		onUserSelected: (value, item) => {},
		onOrdersLoaded: (flag) => {}
	}

	/**
	 * Render component
	 * @return {object} jsx object
	 */
	render() {
		let { order, langs } = this.props;

		return <Paper style={{ marginBottom: 24 }}>
			<Typography variant="title">
				{langs['orderEditCommonTitle']}
			</Typography>

			{order.user_id > 0 ? <SearchUser
				formId="el_user_id"
				defaultUser={order.user}
				onUserSelected={this.props.onUserSelected}
				onDataLoaded={this.props.onOrdersLoaded} /> :
			<SearchUser
				formId="el_user_id"
				onUserSelected={this.props.onUserSelected}
				onDataLoaded={this.props.onOrdersLoaded} />}

			<FilterContext
				formId="el_context_id"
				defaultValue={order.context_id} />

			<FilterOrderStatus
				formId="el_status_id"
				defaultValue={order.status_id} />

			<FilterOrderPayment
				formId="el_payment_type_id"
				defaultValue={order.payment_type_id} />

			<FieldPublichDate
				name="created_at"
				defaultValue={new Date(order.created_at)} />

			<FormControlLabel
				style={{ padding: 12 }}
				control={
					<Checkbox name="send" color="primary" />
				}
				label={langs['orderSendToGoogle']} />
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

export default connect(mapStateToProps)(EditOrderCommonData);