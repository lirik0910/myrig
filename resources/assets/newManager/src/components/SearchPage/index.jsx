/**
 * SearchPage module
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
 * SearchPage block
 * @extends PureComponent
 */
class SearchPage extends PureComponent {
	
	/**
	 * Props validators
	 * @type {object}
	 * @property {function} classes
	 */
	static propTypes = {
		classes: PropTypes.object.isRequired
	}

	/**
	 * Render component
	 * @return {object} jsx object
	 */
	render() {
		return <InputMultiSelectDefault />
	}
}

export default withStyles(styles)(SearchPage);

