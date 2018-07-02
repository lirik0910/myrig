/**
 * FilterProduct module
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

import { findProduct } from 'server/Products.js';

import styles from './styles.js';
import { withStyles } from '@material-ui/core/styles';

/**
 * FilterProduct block
 * @extends PureComponent
 */
class FilterProduct extends PureComponent {
	constructor(props) {
		super(props);

		this.fetchProduct = findProduct()
			.then((products) => this.setState({ data: products.data }));
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
		defaultValue: 0,
		category: null
	}

	state = {
		data: []
	}

	componentWillReceiveProps(willProps) {
		if (willProps.category !== null) {
			this.fetchProduct = findProduct('?category_id='+ willProps.category)
				.then((products) => this.setState({ data: products.data }));
		}
	}

	onProductSelected = (e, value) => {
		let i = 0,
			{ data } = this.state;
		
		while (i < data.length) {
			if (data[i].id === value) {
				this.props.onProductSelected(data[i]);
				break;
			}
			i++;
		}
	}

	/**
	 * Render component
	 * @return {object} jsx object
	 */
	render() {
		let { data } = this.state,
			{ defaultValue, langs } = this.props;

		return <SelectDefault
			title={langs['filterSelectProduct']}
			helperText={langs['helperSelectProduct']}
			data={data}
			defaultValue={defaultValue}
			onItemChanged={this.onProductSelected} />
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

export default connect(mapStateToProps)(withStyles(styles)(FilterProduct));