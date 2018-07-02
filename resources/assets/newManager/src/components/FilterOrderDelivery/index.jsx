/**
 * FilterOrderDelivery module
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

import { allDeliveries } from 'server/Deliveries.js';

import styles from './styles.js';
import { withStyles } from '@material-ui/core/styles';

/**
 * FilterOrderDelivery block
 * @extends PureComponent
 */
class FilterOrderDelivery extends PureComponent {
	constructor(props) {
		super(props);

		this.fetchDeliveries = allDeliveries()
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
		name: 'delivery_id',
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
			{ defaultValue, name, langs } = this.props;

		return <SelectDefault
			none
			name={name}
			title={langs['filterSelectOrderDelivery']}
			helperText={langs['helperSelectOrderDelivery']}
			data={data}
			defaultValue={defaultValue}
			onItemChanged={this.props.onFilterSelected} />
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

export default connect(mapStateToProps)(withStyles(styles)(FilterOrderDelivery));