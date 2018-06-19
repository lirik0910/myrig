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

import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';

import Grid from 'material-ui/Grid';
import { Link } from 'react-router-dom';
import Menu from '../components/Menu/Menu.jsx';
import Header from '../components/Header/Header.jsx';
import { LinearProgress } from 'material-ui/Progress';
import TopTitle from '../components/TopTitle/TopTitle.jsx';
import PaperPages from '../components/PaperPages/PaperPages.jsx';
import DialogDelete from '../components/DialogDelete/DialogDelete.jsx';

import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

import * as StateLexiconAction from 'actions/StateLexiconAction.js';

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
		click: false,
		trash: false,
		completed: 100,
		langLoaded: false
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

	emptyTrashRequest() {
		if (this.state.completed === 100) {
			this.setState({ completed: 0 }, () => {
				App.api({
					name: 'trash',
					model: 'page',
					type: 'DELETE',
					success: (r) => {
						r = JSON.parse(r.response);
						if (r) {
							this.setState({ 
								trash: false,
								completed: 100,
							});
						}
					},
					error: (r) => {
						r = JSON.parse(r.response);
						if (r.message) {
							this.setState({ 
								trash: false,
								completed: 100,
							});
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
		let { classes } = this.props;
		let { a, completed, langLoaded } = this.state;

		if (langLoaded === false) {
			return <div className="pages-list__container">
				<LinearProgress color="secondary" variant="determinate" value={0} />
			</div>
		}

		return <div className="pages-list__container">
				{completed === 0 && 
					<LinearProgress color="secondary" variant="determinate" value={completed} />}

				<Header
					title={this.props.lexicon.pages_list_title} />
				<Menu />

				<TopTitle

					title={''}
					addButtonTitle={this.props.lexicon.new_page}
					saveButtonTitle={this.props.lexicon.save_label}
					trashButtonTitle={this.props.lexicon.empty_trash_label}
					duplicateButtonTitle={this.props.lexicon.duplicate_label}
					deleteButtonTitle={this.props.lexicon.delete_button}
					recoveryButtonTitle={this.props.lexicon.recovery_button}

					addButtonDisplay={true}
					saveButtonDisplay={false}
					onAddButtonClicked={() => {
						this.setState({
							a: App.name() +'/pages/create'
						}, () => {
							var el = document.getElementById('create-page');
							if (el) {
								el.click();
							}
						});
					}}
					trashButtonDisplay={true}
					onTrashButtonClicked={() => this.setState({ trash: true })} />

				<Grid container spacing={24} className={classes.root}>
					<Grid item xs={12}>
						{this.state.completed === 100 && <PaperPages />}
					</Grid>
				</Grid>

				<Link to={a}
					id="create-page"
					style={{display: 'none'}}></Link>

				{this.state.trash === true && <DialogDelete

					title={this.props.lexicon.delete_button}
					content={this.props.lexicon.delete_confirm}

					defaultValue={this.state.trash}
					onDialogClosed={() => this.setState({
						trash: false,
					})}
					content={this.props.lexicon.empty_trash}
					onDialogConfirmed={() => this.emptyTrashRequest()} />}
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

export default connect(mapStateToProps, mapDispatchToProps)(withStyles(styles)(ListPagesContainer));