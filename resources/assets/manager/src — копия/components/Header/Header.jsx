/**
 * Header block module
 * @module Header
 * @author Ihor Bielchenko
 * @requires react
 * @requires react#Component
 * @requires redux#bindActionCreators
 * @requires react-redux#connect
 */

import React, { Component } from 'react';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';

import Manager from '../../Manager.js';
import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';
import AppBar from 'material-ui/AppBar';
import Toolbar from 'material-ui/Toolbar';
import Typography from 'material-ui/Typography';
import IconButton from 'material-ui/IconButton';
import MenuIcon from 'material-ui-icons/Menu';
import MoreVertIcon from 'material-ui-icons/MoreVert';
import Menu, { MenuItem } from 'material-ui/Menu';
import Divider from 'material-ui/Divider';
import * as StateElementAction from '../../actions/StateElementAction.js';

/**
 * Header block
 * @extends Component
 */
class Header extends Component {

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
	 * State object of component
	 * @type {Object} 
	 * @inner
	 * @property {Object} anchorEl The DOM element used to set the position of the menu.
	 */
	state = {
		anchorEl: null
	}

	/**
	 * Open aux header menu
	 * @fires click
	 */
	handleClick = event => {
		this.setState({anchorEl: event.currentTarget});
	}

	/**
	 * Close aux header menu
	 * @fires click
	 */
	handleClose = () => {
		this.setState({ anchorEl: null });
	}

	/**
	 * Show aside menu container
	 * @fires click
	 */
	asideMenuOpen = () => {
		this.props.StateElementAction.show(this.props.elements, 'aside_menu');
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { anchorEl } = this.state;
		let { title, classes } = this.props;

		return <div className={classes.root}>
					<AppBar position="static">
						<Toolbar>
							<IconButton className={classes.menuButton} 
								color="inherit" 
								aria-label="Menu"
								onClick={this.asideMenuOpen}>
									<MenuIcon />
							</IconButton>

							<Typography type="title" 
								color="inherit" 
								className={classes.flex}>
									{title}
							</Typography>

							<IconButton
								color="inherit"
								onClick={this.handleClick}>
									<MoreVertIcon />
							</IconButton>

							<Menu
								id="simple-menu"
								anchorEl={anchorEl}
								open={Boolean(anchorEl)}
								onClose={this.handleClose}>
									<MenuItem onClick={this.handleClose}>Словарь</MenuItem>
									<MenuItem onClick={this.handleClose}>Очистить кэш</MenuItem>
									<Divider />
									<MenuItem onClick={() => {
										var form = document.getElementById('logour-form');
										if (form) {
											form.submit();
										}
									}}>Выход</MenuItem>
							</Menu>

						</Toolbar>
					</AppBar>
					<form action={Manager.url +'/logout'} method="POST" style={{display: 'none'}} id="logour-form">
						<input type="hiddent" name="_token" value={Manager.csrf()} />
					</form>
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

export default connect(mapStateToProps, mapDispatchToProps)(withStyles(styles)(Header));