/**
 * Base module of manager users container
 * @module ProductContainers
 * @author Ihor Bielchenko
 * @requires react
 * @requires react#Component
 * @requires redux#bindActionCreators
 * @requires react-redux#connect
 */

import React, { Component } from 'react';

import Grid from 'material-ui/Grid';
import Menu from '../components/Menu/Menu.jsx';
import Header from '../components/Header/Header.jsx';
import PaperFileManager from '../components/PaperFileManager/PaperFileManager.jsx';
import PaperFolderManager from '../components/PaperFolderManager/PaperFolderManager.jsx';

import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Users base container
 * @extends Component
 */
class FileManagerContainer extends Component {

	state = {
		path: '/',
		ready: true,
		completed: 0
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
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { classes } = this.props;
		let { path, ready } = this.state;

		return <div className="file-manager__container">
					<Header
						title={'Create new product'} />
					<Menu />

					<Grid container spacing={24} className={classes.root}>
						<Grid item xs={6}>
							<PaperFolderManager
								defaultPath={path}
								onFolderChanged={path => this.setState({ ready: false }, () => {
									this.setState({
										path,
										ready: true
									});
								})} />
						</Grid>

						<Grid item xs={6}>
							{ready === true && <PaperFileManager
								defaultPath={path} />}
						</Grid>
					</Grid>
				</div>
	}
}

let styles = theme => ({
	root: {
		width: '100%',
		margin: 0,
		padding: 0,
	},
});

export default withStyles(styles)(FileManagerContainer);