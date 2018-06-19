/**
 * Base module of manager users container
 * @module ProductContainers
 * @author Ihor Bielchenko
 * @requires react
 * @requires react#Component
 * @requires redux#bindActionCreators
 * @requires react-redux#connect
 */

import App from 'App.js';
import React, { Component } from 'react';

import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';

import Grid from 'material-ui/Grid';
import Menu from '../components/Menu/Menu.jsx';
import Header from '../components/Header/Header.jsx';
import PaperFileManager from '../components/PaperFileManager/PaperFileManager.jsx';
import PaperFolderManager from '../components/PaperFolderManager/PaperFolderManager.jsx';
import { LinearProgress } from 'material-ui/Progress';

import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

import * as StateLexiconAction from 'actions/StateLexiconAction.js';

/**
 * Users base container
 * @extends Component
 */
class FileManagerContainer extends Component {

	state = {
		path: '/',
		ready: true,
		completed: 100,
		langLoaded: false
	}

/*	onLoaded(value){
		this.setState({completed: value});
	}*/

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		classes: PropTypes.object.isRequired,
	}

	componentWillMount() {
		App.defineCurrentLang((r) => {
			if (App.isEmpty(r) === false) {
				this.props.StateLexiconAction.get(r, () => {
					this.setState({
						langLoaded: true
					});
				});
			}
		});
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { classes } = this.props;
		let { path, ready, completed } = this.state;

		if (this.state.langLoaded === false) 
			return <div className="create-page__container">
				<LinearProgress color="secondary" variant="determinate" value={0} />
			</div>

		return <div className="file-manager__container">
            		{completed === 0 &&
						<LinearProgress color="secondary" variant="determinate" value={completed} />}

					<Header
						title={this.props.lexicon.file_manager} />
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
								completed={completed}
								defaultPath={path}
								onLoaded={value => {
									this.setState({
										completed: value
									})
								}}
							/>}
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

/**
 * Init redux states
 * @param {Object} state
 * @return {Object}
 */
function mapStateToProps(state) {
	return {
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
		StateLexiconAction: bindActionCreators(StateLexiconAction, dispatch)
	}
}

export default connect(mapStateToProps, mapDispatchToProps)(withStyles(styles)(FileManagerContainer));