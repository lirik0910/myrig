/**
 * SelectActions module
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
 * SelectActions block
 * @extends PureComponent
 */
class SelectActions extends PureComponent {
	
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
		data: [
			'selectActionChangeStatus',
			'selectActionChangePayment',
			'selectActionChangeDelivery',
			'selectActionChangeManagerComment',
			'selectActionSendInTrash'
		]
	}

	state = {
		items: this.props.data.map((item, i) => {
			return {
				id: i,
				title: item
			}
		})
	}

	/**
	 * Render component
	 * @return {object} jsx object
	 */
	render() {
		let { items } = this.state;

		return <SelectDefault
			title="selectActionsTitle"
			helperText="helperSelectActionsText"
			data={items} />
	}
}

export default withStyles(styles)(SelectActions);