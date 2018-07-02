/**
 * AsideNav module
 * @requires react
 * @requires react#PureComponent
 * @requires prop-types
 * @requires @material-ui/core/Drawer
 * @requires @material-ui/core/List
 * @requires @material-ui/core/ListItem
 * @requires @material-ui/core/ListItemIcon
 * @requires @material-ui/core/ListItemText
 * @requires @material-ui/icons/PlayArrow
 * @requires @material-ui/core/styles#withStyles
 */

import React, { PureComponent } from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';

//import { Link } from 'react-router-dom';
import Drawer from '@material-ui/core/Drawer';
import List from '@material-ui/core/List';
import ListItem from '@material-ui/core/ListItem';
import ListItemIcon from '@material-ui/core/ListItemIcon';
import ListItemText from '@material-ui/core/ListItemText';

import PlayArrow from '@material-ui/icons/PlayArrow';

import styles from './styles.js';
import { withStyles } from '@material-ui/core/styles';

/**
 * AsideNav block
 * @extends PureComponent
 */
class AsideNav extends PureComponent {

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
	 * @property {array} list
	 * @property {function} getInstanceLink Return current component object
	 */
	static defaultProps = {
		list: [
			//'asideBarDashboard',
			{ 'asideBarPages': 'pages' },
			{ 'asideBarProducts': 'products' },
			{ 'asideBarOrders': 'orders' },
			//'asideBarVars',
			{ 'asideBarUsers': 'users' },
			{ 'asideBarFiles': 'files' },
			{ 'asideBTCRates': 'rates' },
			{ 'asideCreateNews': 'pages/create?parent_id=16&context_id=1&link=news&view_id=10' },
			{ 'asideCreateArticles': 'pages/create?parent_id=17&context_id=1&link=info&view_id=10' },
			{ 'asideNotifications': 'notifications'}
			//'asideBarSettings'
		],
		getInstanceLink: (obj) => {}
	}

	/**
	 * Current component state object
	 * @type {object}
	 * @property {boolean} drawer Visible drawer block state
	 */
	state = {
		drawer: false
	}

	/**
	 * @method componentDidMount
	 */
	componentDidMount() {
		this.props.getInstanceLink(this);
	}

	/**
	 * Chane state of drawer visible
	 * @param {object} e
	 * @param {boolean} open
	 */
	toggleDrawer = (e, open) => {
		this.setState({
			drawer: open
		});
	}

	/**
	 * Render component
	 * @return {object} jsx object
	 */
	render() {
		let { classes, list, langs } = this.props;

		return <Drawer 
			open={this.state.drawer} 
			onClose={(e) => this.toggleDrawer(e, false)}>

			<List 
				component="nav">
				
				{list.map((item, i) => {
					return <a 
						key={i} 
						href={item[Object.keys(item)[0]]}
						className={classes.linkItem}>
						
						<ListItem button>
							<ListItemIcon>
								<PlayArrow />
							</ListItemIcon>

							<ListItemText 
								primary={langs[Object.keys(item)[0]]} />
						</ListItem>
					</a>
				})}
			</List>
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
		langs: state.langs
	}
}

export default connect(mapStateToProps)(withStyles(styles)(AsideNav));