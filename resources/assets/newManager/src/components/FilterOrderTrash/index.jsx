/**
 * FilterOrderTrash module
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
 * FilterOrderTrash block
 * @extends PureComponent
 */
class FilterOrderTrash extends PureComponent {
	
	/**
	 * Props validators
	 * @type {object}
	 * @property {function} classes
	 */
	static propTypes = {
		classes: PropTypes.object.isRequired
	}

	static defaultProps = {
		onFilterSelected: (e, value) => {}
	}

	/**
	 * Render component
	 * @return {object} jsx object
	 */
	render() {
		let { langs } = this.props;

		return <SelectDefault
			none
			title={langs['filterSelectOrderTrash']}
			helperText={langs['helperSelectOrderTrash']}
			data={[{
				id: 1,
				title: langs['labelInTrashFilter']
			}, {
				id: 0,
				title: langs['labelNotInTrashFilter']
			}]}
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

export default connect(mapStateToProps)(withStyles(styles)(FilterOrderTrash));