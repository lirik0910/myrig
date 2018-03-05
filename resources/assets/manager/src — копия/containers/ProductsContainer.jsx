/**
 * Base module of manager users container
 * @module ProductContainers
 * @author Ihor Bielchenko
 * @requires react
 * @requires react#Component
 * @requires redux#bindActionCreators
 * @requires react-redux#connect
 */

import React, { Component } from 'react';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import * as StateElementAction from '../actions/StateElementAction.js';
import Header from '../components/Header/Header.jsx';
import Menu from '../components/Menu/Menu.jsx';
import Products from '../components/Products/Products.jsx';

/**
 * Users base container
 * @extends Component
 */
class ProductContainers extends Component {

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		return <div className="users__container">
					<Header title="Products" />
					<Menu />
					<Products />
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

export default connect(mapStateToProps, mapDispatchToProps)(ProductContainers);