/**
 * Menu aside block
 * @module Menu
 * @author Ihor Bielchenko
 * @requires react
 * @requires react#Component
 * @requires redux#bindActionCreators
 * @requires react-redux#connect
 */

import React, { Component } from 'react';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import { Link } from 'react-router-dom';

import Manager from '../../Manager.js';
import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';
import Drawer from 'material-ui/Drawer';
import List, { ListItem, ListItemIcon, ListItemText } from 'material-ui/List';
import * as StateElementAction from '../../actions/StateElementAction.js';
import * as MaterialIcons from 'material-ui-icons';

/**
 * Menu aside block
 * @extends Component
 */
class Menu extends Component {

	/**
	 * State object of component
	 * @type {Object} 
	 * @inner
	 * @property {Array} components Array of app components
	 */
	state = {
		components: []
	}

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		classes: PropTypes.object.isRequired,
	}

	/**
	 * Close aside menu container
	 * @fires click
	 */
	asideMenuClose = () => {
		this.props.StateElementAction.show(this.props.elements, 'aside_menu');
	}

	/**
	 * Invoked just before mounting occurs
	 * @fires componentWillMount
	 */
	componentWillMount() {
		this.getComponentsData();
	}

	/**
	 * Query for getting components date
	 */
	getComponentsData() {
		let xhr = Manager.xhr();

		xhr.open('GET', Manager.url +'/api/components/', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xhr.setRequestHeader('X-CSRF-Token', Manager.csrf);
		xhr.send();

		xhr.onreadystatechange = () => {
			if((xhr.status === 200 || xhr.status === 201) && xhr.readyState === 4) {
				var r = JSON.parse(xhr.response);
				if(r) {
					this.setState({ components: r });
				}
			}
		}
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { elements, classes } = this.props;
		let { components } = this.state;

		if(!components.length) {
			return <div></div>
		}

		var Icon;
		return <Drawer anchor="left" 
					open={elements.aside_menu} 
					onBackdropClick={this.asideMenuClose}>
						<div tabIndex={0} role="button" onClick={this.asideMenuClose}>
							<List className={classes.list}>
							{components.map((item, i) => {
								Icon = MaterialIcons[item.icon];
								return <Link to={Manager.url + item.link}>
									<ListItem button>
										<ListItemIcon>
											{Icon ? <Icon /> : ''}
										</ListItemIcon>
										<ListItemText primary={item.name} />
									</ListItem>
								</Link>
							})}
							</List>
						</div>
				</Drawer>
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

export default connect(mapStateToProps, mapDispatchToProps)(withStyles(styles)(Menu));