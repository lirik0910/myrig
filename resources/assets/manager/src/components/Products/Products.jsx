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
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';

import Manager from '../../Manager.js';
import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';
import Slide from 'material-ui/transitions/Slide';
import { LinearProgress } from 'material-ui/Progress';
import * as StateElementAction from '../../actions/StateElementAction.js';

/**
 * Animate opening dialog
 * @param {Object} props
 * @return {Object} JSX object
 */
function Transition(props) {
	return <Slide direction="up" {...props} />;
}

/**
 * Header block
 * @extends Component
 */
class Products extends Component {

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
	 * @property {Array} data Table pages data 
	 */
	state = {
		data: [],
		total: 0,
		start: 0,
		limit: 10,
		search: '',
		completed: 0,
		forRemove: [],
		dialog: {
			title: '',
			content: '',
			actions: '',
			open: false,
		}
	}

	/**
	 * Invoked just before mounting occurs
	 * @fires componentWillMount
	 */
	componentWillMount() {
		this.setState({ completed: 0 }, () => {
			this.setState({ completed: 100 });
		});
	}

	/**
	 * Render 
	 */
	render() {
		let { classes } = this.props;
		let { 
			data, 
			start, 
			limit, 
			total,
			search,
			dialog, 
			forRemove, 
			completed
		} = this.state;

		if(completed === 0) {
			return <div>
				<LinearProgress color="secondary" variant="determinate" value={completed} />
			</div>
		}

		return <div>
			
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

export default connect(mapStateToProps, mapDispatchToProps)(withStyles(styles)(Products));