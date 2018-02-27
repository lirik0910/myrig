/**
 * Base module of manager users container
 * @module FilesContainer
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
import Files from '../components/Files/Files.jsx';

/**
 * Users base container
 * @extends Component
 */
class FilesContainer extends Component {

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		return <div className="files__container">
					<Header title="Файлы" />
					<Menu />
					<Files />
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

export default connect(mapStateToProps, mapDispatchToProps)(FilesContainer);