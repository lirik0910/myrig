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

import Manager from '../Manager.js';
import Header from '../components/Header/Header.jsx';
import Menu from '../components/Menu/Menu.jsx';
import PageEdit from '../components/PageEdit/PageEdit.jsx';
import PageCreate from '../components/PageCreate/PageCreate.jsx';
import * as StateElementAction from '../actions/StateElementAction.js';

/**
 * Base container of site pages list
 * @extends Component
 */
class PageEditContainer extends Component {

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let query = Manager.defineResourceProps();
		/** If property 'create' is absent it's update and 
		 * get current page data
		 */
		if(query.indexOf('create') === -1) {
			return <div className="pages__container">
						<Header title="Редактировать" />
						<Menu />
						<PageEdit />
					</div>
		}

		else return <div className="pages__container">
					<Header title="Новая страница" />
					<Menu />
					<PageCreate />
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

export default connect(mapStateToProps, mapDispatchToProps)(PageEditContainer);