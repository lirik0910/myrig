/**
 * FilterPages module
 * @requires react
 * @requires react#PureComponent
 * @requires react#Fragment
 * @requires prop-types
 * @requires components/SearchPage
 * @requires components/FilterPageView
 * @requires components/FilterPageTrash
 * @requires components/FilterPublishDate
 * @requires @material-ui/core/styles#withStyles
 */

import React, { PureComponent, Fragment } from 'react';
import PropTypes from 'prop-types';

import SearchPage from 'components/SearchPage';
import FilterPageView from 'components/FilterPageView';
import FilterPageTrash from 'components/FilterPageTrash';
import FilterPublishDate from 'components/FilterPublishDate';

import styles from './styles.js';
import { withStyles } from '@material-ui/core/styles';

/**
 * FilterPages block
 * @extends PureComponent
 */
class FilterPages extends PureComponent {
	
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

	/**
	 * Render component
	 * @return {object} jsx object
	 */
	render() {
		return <Fragment>
			<SearchPage />

			<FilterPageView />

			<FilterPageTrash />

			<FilterPublishDate />
		</Fragment>
	}
}

export default withStyles(styles)(FilterPages);