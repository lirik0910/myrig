/**
 * MenuDefault module
 * @requires react
 * @requires react#PureComponent
 * @requires prop-types
 * @requires @material-ui/core/Menu
 * @requires @material-ui/core/MenuItem
 * @requires @material-ui/core/styles#withStyles
 */

import React, { PureComponent, Fragment } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';

import Menu from '@material-ui/core/Menu';
import MenuItem from '@material-ui/core/MenuItem';

import styles from './styles.js';
import { withStyles } from '@material-ui/core/styles';

/**
 * MenuDefault block
 * @extends PureComponent
 */
class MenuDefault extends PureComponent {

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
	 * @property {function} switchEl
	 * @property {function} onMenuItemClicked Callback function if the menu item was clicked
	 */
	static defaultProps = {
		switchEl: (obj) => {},
		onMenuItemClicked: (e, item) => {}
	}

	/**
	 * Current component state object
	 * @type {object}
	 * @property {object} anchorEl Current menu button DOM element
	 */
	state = {
		anchorEl: null
	}

	/**
	 * Close menu list
	 * @fires onClose
	 * @param {object} e
	 */
	handleMenuClose = (e) => {
		this.setState({ anchorEl: null });
	}

	/**
	 * If the menu item was clicked
	 * @fires onClick
	 * @param {object} e
	 * @param {string} item
	 */
	onMenuItemClicked = (e, item) => {
		this.props.onMenuItemClicked(e, item);
		this.handleMenuClose(e);
	}

	/**
	 * Render component
	 * @return {object} jsx object
	 */
	render() {
		let { menu, switchEl, langs } = this.props;

		return <Fragment>
			{switchEl(this)}
			
			<Menu
				anchorEl={this.state.anchorEl}
				open={Boolean(this.state.anchorEl)}
				onClose={this.handleMenuClose}>
				
				{menu && menu.map((item, i) => {
					return <MenuItem 
						key={i}
						onClick={(e) => this.onMenuItemClicked(e, item)}>

						{langs[item]}
					</MenuItem>
				})}
			</Menu>
		</Fragment>
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

export default connect(mapStateToProps)(withStyles(styles)(MenuDefault));