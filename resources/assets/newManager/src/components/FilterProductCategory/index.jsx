/**
 * FilterProductCategory module
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

import { allCategories } from 'server/Products.js';

import styles from './styles.js';
import { withStyles } from '@material-ui/core/styles';

/**
 * FilterProductCategory block
 * @extends PureComponent
 */
class FilterProductCategory extends PureComponent {
	constructor(props) {
		super(props);

		this.fetchCategories = allCategories()
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
		defaultValue: 0,
		onCategoryChanged: (e, value) => {}
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
			{ defaultValue, langs } = this.props;

		return <SelectDefault
			title={langs['filterSelectProductCategory']}
			helperText={langs['helperSelectProductCategory']}
			data={data}
			defaultValue={defaultValue}
			onItemChanged={this.props.onCategoryChanged} />
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

export default connect(mapStateToProps)(withStyles(styles)(FilterProductCategory));