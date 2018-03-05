/**
 * Header block module
 * @module Header
 * @author Ihor Bielchenko
 * @requires react
 * @requires react#Component
 * @requires redux#bindActionCreators
 * @requires react-redux#connect
 */

import App from '../../App.js';
import React, { Component } from 'react';

import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import * as StateElementAction from '../../actions/StateElementAction.js';

import AppBar from 'material-ui/AppBar';
import Toolbar from 'material-ui/Toolbar';
import Divider from 'material-ui/Divider';
import MenuIcon from 'material-ui-icons/Menu';
import Typography from 'material-ui/Typography';
import IconButton from 'material-ui/IconButton';
import Menu, { MenuItem } from 'material-ui/Menu';
import MoreVertIcon from 'material-ui-icons/MoreVert';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

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
		title: 'Manager',
		classes: PropTypes.object.isRequired,
		onMenuOpened: () => {},
		onMenuClosed: () => {}
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
	 * @param {Object} event
	 */
	handleClick = event => {
		this.setState({anchorEl: event.currentTarget});
	}

	/**
	 * Close aux header menu
	 * @fires click
	 * @param {Object} event
	 */
	handleClose = event => {
		this.setState({ anchorEl: null }, () => this.props.onMenuClosed());
	}

	/**
	 * Show aside menu container
	 * @fires click
	 * @param {Object} event
	 */
	asideMenuOpen = event => {
		this.props.StateElementAction.show(this.props.elements, 'aside_menu', (flag) => {
			this.props.onMenuOpened();
		});
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
								<MenuItem onClick={this.handleClose}>Vocabulary</MenuItem>
					
								<MenuItem onClick={this.handleClose}>Clear cache</MenuItem>
								<Divider />
					
								<MenuItem onClick={() => {
									var form = document.getElementById('logour-form');
										if (form) {
											form.submit();
										}
								}}>Exit</MenuItem>
						</Menu>
					</Toolbar>
				</AppBar>
				
				<form action={App.url +'/logout'} 
					method="POST" 
					id="logour-form"
					style={{display: 'none'}}>

					<input type="hiddent" name="_token" defaultValue={App.csrf()} />
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