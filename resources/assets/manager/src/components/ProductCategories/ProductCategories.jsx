/**
 * Header block module
 * @module Users
 * @author Ihor Bielchenko
 * @requires react
 * @requires react#Component
 * @requires redux#bindActionCreators
 * @requires react-redux#connect
 */

import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';
import ListSubheader from 'material-ui/List/ListSubheader';
import List, { ListItem, ListItemIcon, ListItemText } from 'material-ui/List';
import Collapse from 'material-ui/transitions/Collapse';
import Folder from 'material-ui-icons/Folder';
import ExpandLess from 'material-ui-icons/ExpandLess';
import ExpandMore from 'material-ui-icons/ExpandMore';
import styles from './styles.js';

/**
 * Header block
 * @extends Component
 */
class ProductCategories extends Component {

	/**
	 * State object of component
	 * @type {Object} 
	 * @inner
	 * @property {Array} contexts
	 * @property {String} currentID 
	 */
	state = {
		open: true
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
	 * Get query for search users
	 * @fires input
	 * @param {Object} e
	 */
	handleClick = () => {
		this.setState({ open: !this.state.open });
	}

	/**
	 * Render 
	 */
	render() {
		let { classes } = this.props;

		return <List
				component="nav"
				subheader={<ListSubheader component="div">Product Categories</ListSubheader>}>
					<ListItem button>
						<ListItemIcon>
							<Folder />
						</ListItemIcon>
						<ListItemText inset primary="Sent mail" />
					</ListItem>
					
					<ListItem button>
						<ListItemIcon>
							<Folder />
						</ListItemIcon>
						<ListItemText inset primary="Drafts" />
					</ListItem>
					
					<ListItem button onClick={this.handleClick}>
						<ListItemIcon>
							<Folder />
						</ListItemIcon>
						<ListItemText inset primary="Inbox" />
						{this.state.open ? <ExpandLess /> : <ExpandMore />}
					</ListItem>
					
					<Collapse in={this.state.open} timeout="auto" unmountOnExit>
						<List component="div" disablePadding>
							<ListItem button className={classes.nested}>
								<ListItemIcon>
									<Folder />
								</ListItemIcon>
								<ListItemText inset primary="Starred" />
								{this.state.open ? <ExpandLess /> : <ExpandMore />}
							</ListItem>

							<Collapse in={this.state.open} timeout="auto" unmountOnExit>
								<List component="div" disablePadding>
									<ListItem button className={classes.nested2}>
										<ListItemIcon>
											<Folder />
										</ListItemIcon>
										<ListItemText inset primary="Starred" />
										{this.state.open ? <ExpandLess /> : <ExpandMore />}
									</ListItem>

									<ListItem button className={classes.nested}>
										<ListItemIcon>
											<Folder />
										</ListItemIcon>
										<ListItemText inset primary="Starred" />
									</ListItem>
								</List>
							</Collapse>

							<ListItem button className={classes.nested}>
								<ListItemIcon>
									<Folder />
								</ListItemIcon>
								<ListItemText inset primary="Starred" />
							</ListItem>
						</List>
					</Collapse>
				</List>
	}
}

export default withStyles(styles)(ProductCategories);