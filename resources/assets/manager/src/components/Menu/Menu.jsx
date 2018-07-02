/**
 * Menu aside block
 * @module Menu
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

import { Link } from 'react-router-dom';
import Drawer from 'material-ui/Drawer';
import List, { 
	ListItem, 
	ListItemIcon, 
	ListItemText 
} from 'material-ui/List';
import * as MaterialIcons from 'material-ui-icons';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Menu aside block
 * @extends Component
 */
class Menu extends Component {

	/**
	 * State object of component
	 * @type {Object} 
	 * @inner
	 * @property {Array} data Array of app components
	 */
	state = {
		data: []
	}

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		onMenuClosed: () => {},
		onDataLoaded: () => {},
		onItemClicked: () => {},
		classes: PropTypes.object.isRequired,
	}

	/**
	 * Invoked just before mounting occurs
	 * @fires componentWillMount
	 */
	componentWillMount() {
		this.componentsDataGetRequest(data => this.props.onDataLoaded(data));
	}

	/**
	 * Query for getting components date
	 * @param {Function} callback
	 */
	componentsDataGetRequest(callback = () => {}) {
		App.api({
			type: 'GET',
			name: 'all',
			model: 'component',
			success: (r) => {
				r = JSON.parse(r.response);
				if (r) {
					this.setState({ data: r }, () => callback(r));
				}
			}
		});
	}

	/**
	 * Close aside menu container
	 * @fires click
	 * @param {Obkect} e
	 */
	asideMenuClose = e => {
		this.props.StateElementAction.show(this.props.elements, 'aside_menu', () => {
			this.props.onMenuClosed();
		});
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { data } = this.state;
		let { elements, classes } = this.props;

		if(!data.length) {
			return <div></div>
		}

		var Icon;
		return <Drawer anchor="left" 
					open={elements.aside_menu} 
					onBackdropClick={this.asideMenuClose}>
					
				<div tabIndex={0} role="button" onClick={this.asideMenuClose}>
					<List className={classes.list}>
						{data.map((item, i) => {
							Icon = MaterialIcons[item.icon];
							return <a key={i}
										href={App.name() + item.link}
										onClick={this.props.onItemClicked(item.link)}>
								<ListItem button>
									<ListItemIcon>
										{Icon ? <Icon /> : ''}
									</ListItemIcon>
									<ListItemText primary={this.props.lexicon['menu_'+ item.name]} />
								</ListItem>
							</a>
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
	}
}

export default connect(mapStateToProps, mapDispatchToProps)(withStyles(styles)(Menu));