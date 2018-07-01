/**
 * FilterOrders module
 * @requires react
 * @requires react#PureComponent
 * @requires react#Fragment
 * @requires prop-types
 * @requires components/SearchOrder
 * @requires components/FilterContext
 * @requires components/FilterOrderTrash
 * @requires components/FilterOrderStatus
 * @requires components/FilterPublishDate
 * @requires @material-ui/core/styles#withStyles
 */

import React, { PureComponent, Fragment } from 'react';
import PropTypes from 'prop-types';

import SearchOrder from 'components/SearchOrder';
import FilterContext from 'components/FilterContext';
import FilterOrderTrash from 'components/FilterOrderTrash';
import FilterOrderStatus from 'components/FilterOrderStatus';
import FilterOrderPayment from 'components/FilterOrderPayment';
import FilterOrderDelivery from 'components/FilterOrderDelivery';
import FilterPublishDate from 'components/FilterPublishDate';

import styles from './styles.js';
import { withStyles } from '@material-ui/core/styles';

/**
 * FilterOrders block
 * @extends PureComponent
 */
class FilterOrders extends PureComponent {
	
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
	 * @property {array} data
	 */
	static defaultProps = {
		data: []
	}

	state = {
		query: {}
	}

	/**
	 * Render component
	 * @return {object} jsx object
	 */
	render() {
		return <Fragment>
			<SearchOrder
				onStartFind={(e) => {
					let { query } = this.state;
					query['search'] = e.target.value;

					this.setState({ query }, () => 
						this.props.onFilterChanged(query));
				}} />

			<FilterContext
				onFilterSelected={(e, value) => {
					let { query } = this.state;
					query['context_id'] = value;

					this.setState({ query }, () => 
						this.props.onFilterChanged(query));
				}} />

			<FilterOrderStatus
				onFilterSelected={(e, value) => {
					let { query } = this.state;
					query['status_id'] = value;

					this.setState({ query }, () => 
						this.props.onFilterChanged(query));
				}} />

			<FilterOrderPayment
				onFilterSelected={(e, value) => {
					let { query } = this.state;
					query['payment_type_id'] = value;

					this.setState({ query }, () => 
						this.props.onFilterChanged(query));
				}} />

			<FilterOrderDelivery
				onFilterSelected={(e, value) => {
					let { query } = this.state;
					query['delivery_id'] = value;

					this.setState({ query }, () => 
						this.props.onFilterChanged(query));
				}} />

			<FilterOrderTrash
				onFilterSelected={(e, value) => {
					let { query } = this.state;
					query['delete_type'] = value;

					this.setState({ query }, () => 
						this.props.onFilterChanged(query));
				}} />

			<FilterPublishDate
				onFilterChanged={(date, item) => {
					let { query } = this.state;

					if (date === null) {
						query['created_at_from'] = '';
						query['created_at_to'] = '';
					}

					else {
						if (item === 'dateFrom') {
							query['created_at_from'] = date.toLocaleDateString() +' '+ date.toLocaleTimeString();
						}

						else {
							query['created_at_to'] = date.toLocaleDateString() +' '+ date.toLocaleTimeString();
						}
					}

					this.setState({ query }, () => 
						this.props.onFilterChanged(query));
				}} />
		</Fragment>
	}
}

export default withStyles(styles)(FilterOrders);