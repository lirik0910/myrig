/**
 * FilterPageTrash module
 * @requires react
 * @requires react#PureComponent
 * @requires prop-types
 * @requires components/SelectDefault
 * @requires @material-ui/core/styles#withStyles
 */

import React, { PureComponent } from 'react';
import PropTypes from 'prop-types';

import SelectDefault from 'components/SelectDefault';

import styles from './styles.js';
import { withStyles } from '@material-ui/core/styles';

/**
 * FilterPageTrash block
 * @extends PureComponent
 */
class FilterPageTrash extends PureComponent {
	
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
		return <SelectDefault
			title="filterSelectPageView"
			helperText="helperSelectPageView"
			data={[{
				id: 1,
				title: 'Test'
			}, {
				id: 2,
				title: 'Test2'
			}]} />
	}
}

export default withStyles(styles)(FilterPageTrash);