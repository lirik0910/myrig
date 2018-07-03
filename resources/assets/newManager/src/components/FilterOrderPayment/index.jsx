/**
 * FilterOrderPayment module
 * @requires react
 * @requires react#PureComponent
 * @requires prop-types
 * @requires components/SelectDefault
 * @requires @material-ui/core/styles#withStyles
 */

import React, { PureComponent } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';

import SelectDefault from 'components/SelectDefault';

import { allPaymentTypes } from 'server/PaymentTypes';

import styles from './styles.js';
import { withStyles } from '@material-ui/core/styles';

/**
 * FilterOrderPayment block
 * @extends PureComponent
 */
class FilterOrderPayment extends PureComponent {
	constructor(props) {
		super(props);

		this.fetchPayments = allPaymentTypes()
			.then((data) => this.setState({ data }));
	}
	
	/**
	 * Props validators
	 * @type {object}
	 * @property {function} classes
	 */
	static propTypes = {
		classes: PropTypes.object.isRequired
	}

	static defaultProps = {
		name: 'payment_type_id',
		defaultValue: 0,
		onFilterSelected: (e, value) => {}
	}

	state = {
		data: []
	}

	/**
	 * Render component
	 * @return {object} jsx object
	 */
	render() {
		let { data } = this.state,
			{ defaultValue, name, langs, ...others } = this.props;

		return <SelectDefault
			none
			name={name}
			title={langs['filterSelectOrderPayment']}
			helperText={langs['helperSelectOrderPayment']}
			data={data}
			defaultValue={defaultValue}
			onItemChanged={this.props.onFilterSelected}
			{...others} />
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

export default connect(mapStateToProps)(withStyles(styles)(FilterOrderPayment));