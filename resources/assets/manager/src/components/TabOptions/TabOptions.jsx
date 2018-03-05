/**
 * Header block module
 * @module Users
 * @author Ihor Bielchenko
 * @requires react
 * @requires react#Component
 * @requires redux#bindActionCreators
 * @requires react-redux#connect
 */

//import App from '../../App.js';
import React, { Component } from 'react';

import Tabs, { Tab } from 'material-ui/Tabs';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Header block
 * @extends Component
 */
class TabOptions extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {String} title Title text 
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		data: [],
		defaultValue: 0,
		classes: PropTypes.object.isRequired,
		onTabButtonClicked: () => {},
	}

	/**
	 * State object of component
	 * @type {Object} 
	 * @inner
	 * @property {Number} value Current tab
	 */
	state = {
		value: this.props.defaultValue
	}

	/**
	 * Change tab
	 * @fires click
	 * @param {Object} event
	 */
	handleChangeTab = (event, value) => {
		this.setState({ value });
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { value } = this.state;
		let { data } = this.props;

		return <Tabs value={value} onChange={this.handleChangeTab}>
				{data.map((item, i) => {
					return <Tab key={i}
						label={item}
						onClick={e => this.props.onTabButtonClicked(i)} />
				})}
			</Tabs>
	}
}

export default withStyles(styles)(TabOptions);