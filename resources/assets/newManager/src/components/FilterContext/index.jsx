/**
 * FilterContext module
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

import { allContexts } from 'server/Contexts.js';

import styles from './styles.js';
import { withStyles } from '@material-ui/core/styles';

/**
 * FilterContext block
 * @extends PureComponent
 */
class FilterContext extends PureComponent {
	constructor(props) {
		super(props);

		this.fetchContexts = allContexts()
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
		none: true,
		name: 'context_id',
		defaultValue: 0,
		onFilterSelected: (e, value) => {}
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
			{ defaultValue, name, none, langs } = this.props;

		return <SelectDefault
			none={none}
			name={name}
			title={langs['filterSelectContext']}
			helperText={langs['helperSelectContext']}
			data={data}
			defaultValue={defaultValue}
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

export default connect(mapStateToProps)(withStyles(styles)(FilterContext));