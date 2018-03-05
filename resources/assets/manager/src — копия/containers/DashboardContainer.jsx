/**
 * Base module of manager dashboard container
 * @module DashboardContainer
 * @author Ihor Bielchenko
 * @requires react
 * @requires react#Component
 * @requires redux#bindActionCreators
 * @requires react-redux#connect
 */

import React, { Component } from 'react';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';

import Header from '../components/Header/Header.jsx';
import Menu from '../components/Menu/Menu.jsx';
import * as StateElementAction from '../actions/StateElementAction.js';

/**
 * DashboardContainer base container
 * @extends Component
 */
class DashboardContainer extends Component {

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		return <div className="dashboard__container">
					<Header title="Statistic" />
					<Menu />
				</div>
	}
}

/**
 * Init redux states
 * @param {Object} state
 * @return {Object}
 */
function mapStateToProps(state) {
	return {
		elements: state.elements
	}
}

/**
 * Init redux actions
 * @param {Function} dispatch
 * @return {Object}
 */
function mapDispatchToProps(dispatch) {
	return {
		StateElementAction: bindActionCreators(StateElementAction, dispatch),
	}
}

export default connect(mapStateToProps, mapDispatchToProps)(DashboardContainer);