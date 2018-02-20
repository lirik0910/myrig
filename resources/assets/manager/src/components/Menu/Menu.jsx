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

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';
import Drawer from 'material-ui/Drawer';
import Button from 'material-ui/Button';
import Divider from 'material-ui/Divider';
import List, { ListItem, ListItemIcon, ListItemText } from 'material-ui/List';
import Home from 'material-ui-icons/Home';
import Store from 'material-ui-icons/Store';
import People from 'material-ui-icons/People';
import Settings from 'material-ui-icons/Settings';
import ContentCopy from 'material-ui-icons/ContentCopy';
import Assignment from 'material-ui-icons/Assignment';
import Chat from 'material-ui-icons/Chat';
import * as StateElementAction from '../../actions/StateElementAction.js';

/**
 * Menu aside block
 * @extends Component
 */
class Menu extends Component {

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
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let elements = this.props.elements;
		return <Drawer anchor="left" 
					open={elements.aside_menu} 
					onBackdropClick={this.asideMenuClose}>
						<div tabIndex={0} role="button" onClick={this.asideMenuClose}>
							<List className={this.props.classes.list}>
								<Link to="/">
									<ListItem button>
										<ListItemIcon>
											<Home />
										</ListItemIcon>
										<ListItemText primary="Статистика" />
									</ListItem>
								</Link>

								<Link to="/pages">
									<ListItem button>
										<ListItemIcon>
											<ContentCopy />
										</ListItemIcon>
										<ListItemText primary="Страницы" />
									</ListItem>
								</Link>

								<Link to="/users">
									<ListItem button>
										<ListItemIcon>
											<People />
										</ListItemIcon>
										<ListItemText primary="Пользователи" />
									</ListItem>
								</Link>

								<Link to="/settings">
									<ListItem button>
										<ListItemIcon>
											<Settings />
										</ListItemIcon>
										<ListItemText primary="Настройки" />
									</ListItem>
								</Link>

								<Divider />

								<Link to="/orders">
									<ListItem button>
										<ListItemIcon>
											<Assignment />
										</ListItemIcon>
										<ListItemText primary="Заказы" />
									</ListItem>
								</Link>

								<Link to="/orders">
									<ListItem button>
										<ListItemIcon>
											<Store />
										</ListItemIcon>
										<ListItemText primary="Продукты" />
									</ListItem>
								</Link>

								<Link to="/orders">
									<ListItem button>
										<ListItemIcon>
											<Chat />
										</ListItemIcon>
										<ListItemText primary="Тикеты" />
									</ListItem>
								</Link>
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