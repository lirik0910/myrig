/**
 * FilterCountry module
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

import styles from './styles.js';
import { withStyles } from '@material-ui/core/styles';

/**
 * FilterCountry block
 * @extends PureComponent
 */
class FilterCountry extends PureComponent {
	/**
	 * Props validators
	 * @type {object}
	 * @property {function} classes
	 */
	static propTypes = {
		classes: PropTypes.object.isRequired
	}

	static defaultValue = {
		name: 'country',
		defaultValue: 0,
		data: []
	}

	/**
	 * Render component
	 * @return {object} jsx object
	 */
	render() {
		let { defaultValue, data, langs, ...other } = this.props;

		return <SelectDefault
			title={langs['filterSelectCountry']}
			helperText={langs['helperSelectCountry']}
			data={data}
			defaultValue={defaultValue}
			{...other} />
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

export default connect(mapStateToProps)(withStyles(styles)(FilterCountry));