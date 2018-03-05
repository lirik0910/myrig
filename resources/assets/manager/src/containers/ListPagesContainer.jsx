/**
 * Base module of manager users container
 * @module ProductContainers
 * @author Ihor Bielchenko
 * @requires react
 * @requires react#Component
 * @requires redux#bindActionCreators
 * @requires react-redux#connect
 */

import App from '../App.js';
import React, { Component } from 'react';

import Grid from 'material-ui/Grid';
import { Link } from 'react-router-dom';
import Menu from '../components/Menu/Menu.jsx';
import Header from '../components/Header/Header.jsx';
import { LinearProgress } from 'material-ui/Progress';
import TopTitle from '../components/TopTitle/TopTitle.jsx';
import PaperPages from '../components/PaperPages/PaperPages.jsx';

import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Users base container
 * @extends Component
 */
class ListPagesContainer extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		classes: PropTypes.object.isRequired,
	}

	state = {
		a: '',
		completed: 100
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { classes } = this.props;
		let { a, completed } = this.state;

		return <div className="pages-list__container">
				{completed === 0 && 
					<LinearProgress color="secondary" variant="determinate" value={completed} />}
					
				<Header
					title={'Pages list'} />
				<Menu />

				<TopTitle
					title={''}
					addButtonDisplay={true}
					saveButtonDisplay={false}
					addButtonTitle={'Create new page'}
					onAddButtonClicked={() => {
						this.setState({
							a: App.name() +'/pages/create'
						}, () => {
							var el = document.getElementById('create-page');
							if (el) {
								el.click();
							}
						});
					}} />

				<Grid container spacing={24} className={classes.root}>
					<Grid item xs={12}>
						<PaperPages />
					</Grid>
				</Grid>

				<Link to={a}
					id="create-page"
					style={{display: 'none'}}></Link>
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

export default withStyles(styles)(ListPagesContainer);