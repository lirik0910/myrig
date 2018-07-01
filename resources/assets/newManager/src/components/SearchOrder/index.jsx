/**
 * SearchOrder module
 * @requires react
 * @requires react#PureComponent
 * @requires prop-types
 * @requires components/InputMultiSelectDefault
 * @requires @material-ui/core/styles#withStyles
 */

import React, { PureComponent } from 'react';
import PropTypes from 'prop-types';
import InputMultiSelectDefault from 'components/InputMultiSelectDefault'

import styles from './styles.js';
import { withStyles } from '@material-ui/core/styles';

/**
 * SearchOrder block
 * @extends PureComponent
 */
class SearchOrder extends PureComponent {
	
	/**
	 * Props validators
	 * @type {object}
	 * @property {function} classes
	 */
	static propTypes = {
		classes: PropTypes.object.isRequired
	}

	static defaultProps = {
		onStartFind: () => {}
	}

	/**
	 * Render component
	 * @return {object} jsx object
	 */
	render() {
		return <InputMultiSelectDefault
			placeholder="placeholderOrdersMultiSelect"
			onInputChanged={this.props.onStartFind} />
	}
}

export default withStyles(styles)(SearchOrder);