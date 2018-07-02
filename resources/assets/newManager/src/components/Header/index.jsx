/**
 * Header module
 * @requires react
 * @requires react#PureComponent
 * @requires prop-types
 * @requires @material-ui/core#AppBar
 * @requires @material-ui/core#Toolbar
 * @requires @material-ui/core#Typography
 * @requires @material-ui/core#Button
 * @requires @material-ui/core#IconButton
 * @requires @material-ui/core#Menu
 * @requires @material-ui/core#MenuItem
 * @requires components/MenuDefault
 * @requires @material-ui/icons#Menu
 * @requires @material-ui/icons#MoreVert
 * @requires @material-ui/core/styles#withStyles
 */

import React, { PureComponent } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';

import Cookies from 'js-cookie';
import { langsOrders } from 'server/Langs.js';

import AppBar from '@material-ui/core/AppBar';
import Toolbar from '@material-ui/core/Toolbar';
import Typography from '@material-ui/core/Typography';
import IconButton from '@material-ui/core/IconButton';
import MenuDefault from 'components/MenuDefault';
import FilterContext from 'components/FilterContext';

import MenuIcon from '@material-ui/icons/Menu';
import MoreVert from '@material-ui/icons/MoreVert';

import styles from './styles.js';
import { withStyles } from '@material-ui/core/styles';

import * as StateLangsAction from 'actions/StateLangsAction.js';

/**
 * Header block
 * @extends PureComponent
 */
class Header extends PureComponent {

	/**
	 * Props validators
	 * @type {object}
	 * @property {function} classes
	 */
	static propTypes = {
		classes: PropTypes.object.isRequired
	}

	/**
	 * Default properties
	 * @type {object}
	 * @property {string} title AppBar title
	 * @property {array} menu Menu items list
	 * @property {function} onMenuItemClicked Callback function if the menu item was clicked
	 * @property {function} onAsideNavButtonClicked Open aside bar block
	 */
	static defaultProps = {
		title: 'appBarTitle',
		menu: [
			//'menuProfile',
			//'menuOptions',
			//'menuVocabulary',
			'menuClearCache',
			'menuExit'
		],
		onMenuItemClicked: (e, item) => {},
		onAsideNavButtonClicked: (e) => {}
	}

	/**
	 * Render component
	 * @return {object} jsx object
	 */
	render() {
		let { classes, title, menu, langs } = this.props;

		return <AppBar className={classes.root}>
			<Toolbar>
				<IconButton 
					className={classes.iconButton}
					onClick={(e) => this.props.onAsideNavButtonClicked(e)}>
						
					<MenuIcon />
				</IconButton>

				<Typography 
					variant="headline"
					className={classes.flex}>
						
					{langs[title]}
				</Typography>

				<div className="header-lang__container">
					<FilterContext
						none={false}
						onFilterSelected={(e, value, data) => {
							let i = 0,
								lang;

							while (i < data.length) {
								if (data[i].id === value) {
									lang = data[i].title.toLowerCase();

									Cookies.set('lang', lang);
									langsOrders(lang, 'orders')
										.then(this.props.StateLangsAction.get);
									break;
								}
								i++;
							}
						}} />
				</div>

				{menu.length > 0 && <MenuDefault
					menu={menu}
					switchEl={(obj) => {
						return <IconButton 
							className={classes.iconButton}
							onClick={(e) => obj.setState({
								anchorEl: e.currentTarget
							})}>
									
							<MoreVert />
						</IconButton>
					}} />}
			</Toolbar>
		</AppBar>
	}
}

/**
 * Init redux states
 * @param {Object} state
 * @return {Object}
 */
function mapStateToProps(state) {
	return {
		langs: state.langs
	}
}

/**
 * Init redux actions
 * @param {Function} dispatch
 * @return {Object}
 */
function mapDispatchToProps(dispatch) {
	return {
		StateLangsAction: bindActionCreators(StateLangsAction, dispatch)
	}
}

export default connect(mapStateToProps, mapDispatchToProps)(withStyles(styles)(Header));