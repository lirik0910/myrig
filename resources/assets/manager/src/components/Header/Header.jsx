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
import Cookies from 'js-cookie';

import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import * as StateElementAction from '../../actions/StateElementAction.js';

//import { Link } from 'react-router-dom';

import AppBar from 'material-ui/AppBar';
import Toolbar from 'material-ui/Toolbar';
import Divider from 'material-ui/Divider';
import MenuIcon from 'material-ui-icons/Menu';
import Typography from 'material-ui/Typography';
import IconButton from 'material-ui/IconButton';
import Menu, { MenuItem } from 'material-ui/Menu';
import MoreVertIcon from 'material-ui-icons/MoreVert';
import { LinearProgress } from 'material-ui/Progress';
import DialogError from '../DialogError/DialogError.jsx';
import SelectLang from '../FormControl/SelectLang/SelectLang.jsx';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

import * as StateLexiconAction from 'actions/StateLexiconAction.js';

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
		anchorEl: null,
		completed: 100,
		resultDialog: '', 
		resultDialogTitle: '', 
		resultDialogMessage: ''
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
	 * Request for delete product
	 * @param {Object} e
	 */
	cacheClearRequest(callback = () => {}) {
		if (this.state.completed === 100) {
			this.setState({ 
				completed: 0 
			}, () => {
				App.api({
					name: 'clear',
					type: 'DELETE',
					model: 'cache',
					success: (r) => {
						r = JSON.parse(r.response);
						if (r) {
							this.setState({ 
								completed: 100,
								resultDialog: true,
								resultDialogTitle: this.props.lexicon.success_title,
								resultDialogMessage: this.props.lexicon.request_successful
							}, () => callback());
						}
					},
					error: (r) => {
						r = JSON.parse(r.response);
						if (r.message) {
							this.setState({ 
								completed: 100,
								resultDialog: true,
								resultDialogTitle: this.props.lexicon.error_title,
								resultDialogMessage: r.message
							}, () => callback());
						}
					}
				});
			});
		}
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { anchorEl, completed, resultDialog, resultDialogTitle, resultDialogMessage } = this.state;
		let { title, classes } = this.props;

		return <div className={classes.root}>
			{completed === 0 && 
				<LinearProgress color="secondary" variant="determinate" value={completed} />}
			
			<AppBar position="static" style={{ backgroundColor: '#60A645' }}>
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

					<div 
						style={{ width: 124 }}>
						<SelectLang
							defaultValueContent={Cookies.get('lang')}
							title={this.props.lexicon.select_lang_title}
							titleStyle={{ color: '#FFF' }}
							selectStyle={{ color: '#FFF' }}
							selectClassName="select-header-lang__container"
							onItemSelected={(e, a) => {
								Cookies.set('lang', a[e]);
								App.getCurrentLangResource(a[e], (r) => {
									this.props.StateLexiconAction.get(r);
								});
							}} />
					</div>

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
							{/*<Link to="vocabulary">
								<MenuItem>Vocabulary</MenuItem>
							</Link>*/}
				
							<MenuItem onClick={e => this.cacheClearRequest(() => {
								this.handleClose
							})}>
								{this.props.lexicon.clear_cache}
							</MenuItem>
							<Divider />
				
							<MenuItem onClick={() => {
								var form = document.getElementById('logour-form');
									if (form) {
										form.submit();
									}
							}}>{this.props.lexicon.exit_label}</MenuItem>
					</Menu>
				</Toolbar>
			</AppBar>
				
			<form action={App.name() +'/logout'} 
				method="POST" 
				id="logour-form"
				style={{display: 'none'}}>

				<input type="hiddent" name="_token" defaultValue={App.csrf()} />
			</form>

			{resultDialog === true && <DialogError 
				title={resultDialogTitle}
				defaultValue={resultDialog}
				message={resultDialogMessage}
				onDialogClosed={() => this.setState({
					resultDialog: false
				})} />}
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
		elements: state.elements,
		lexicon: state.lexicon
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
		StateLexiconAction: bindActionCreators(StateLexiconAction, dispatch)
	}
}

export default connect(mapStateToProps, mapDispatchToProps)(withStyles(styles)(Header));