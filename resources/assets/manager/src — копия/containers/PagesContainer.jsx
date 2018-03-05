/**
 * Base module of site pages list
 * @module PagesContainer
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
import Pages from '../components/Pages/Pages.jsx';
import * as StateElementAction from '../actions/StateElementAction.js';

/**
 * Base container of site pages list
 * @extends Component
 */
class PagesContainer extends Component {

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		return <div className="pages__container">
					<Header title="Pages" />
					<Menu />
					<Pages />
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

export default connect(mapStateToProps, mapDispatchToProps)(PagesContainer);