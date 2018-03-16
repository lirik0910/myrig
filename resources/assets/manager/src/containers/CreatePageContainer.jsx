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
import TabOptions from '../components/TabOptions/TabOptions.jsx';
import DialogError from '../components/DialogError/DialogError.jsx';
import PaperPageForm from '../components/PaperPageForm/PaperPageForm.jsx';
import PaperContentForm from '../components/PaperContentForm/PaperContentForm.jsx';

import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Users base container
 * @extends Component
 */
class CreatePageContainer extends Component {

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
		tab: 0,
		data: {},
		completed: 100,
		resultDialog: false,
		resultDialogTitle: '',
		resultDialogMessage: ''
	}

	/**
	 * Invoked just before mounting occurs
	 * @fires componentWillMount
	 */
	componentWillMount() {
		this.getUrlProps();
	}

	/**
	 * Get props from url
	 * @param {Function} callback
	 */
	getUrlProps(callback = () => {}) {
		let { data } = this.state;
		let url = App.getLocationProps();

		if (typeof url.context_id !== 'undefined') {
			data['context_id'] = Number(url.context_id);
		}

		if (typeof url.parent_id !== 'undefined') {
			data['parent_id'] = Number(url.parent_id);
		}

		if (typeof url.link !== 'undefined') {
			data['link'] = url.link;
		}

		if (typeof url.view_id !== 'undefined') {
			data['view_id'] = url.view_id;
		}

		this.setState({ data }, () => callback());
	}

	/**
	 * Request for adding new page
	 * @param {Object} e
	 */
	pagePostRequest = e => {
		let { data } = this.state;

		this.setState({ 
			completed: 0 
		});

		App.api({
			type: 'POST',
			model: 'page',
			name: 'create',
			data,
			success: (r) => {
				r = JSON.parse(r.response);
				if (r) {
					this.setState({ 
						completed: 100,
						resultDialog: true,
						resultDialogTitle: 'Success',
						resultDialogMessage: 'The request was successful',
						a: App.name() + '/pages/'+ r.id
					}, () => {
						setTimeout(() => {
							var a = document.getElementById('page-edit');
							if (a) {
								a.click();
							}
						}, 824);
					});
				}
			},
			error: (r) => {
				r = JSON.parse(r.response);
				if (r.message) {
					this.setState({ 
						completed: 100,
						resultDialog: true,
						resultDialogTitle: 'Error',
						resultDialogMessage: r.message
					});
				}
			}
		});
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { classes } = this.props;
		let { 
			a, 
			tab, 
			data, 
			completed,
			resultDialog,
			resultDialogTitle,
			resultDialogMessage
		} = this.state;

		return <div className="create-page__container">
				{completed === 0 && 
					<LinearProgress color="secondary" variant="determinate" value={completed} />}
					
				<Header
					title={'Pages list'} />
				<Menu />

				<TopTitle
					title={'New page'}
					saveButtonDisplay={true}
					onSaveButtonClicked={() => this.pagePostRequest()} />

				<TabOptions
					defaultValue={tab}
					onTabButtonClicked={tab => this.setState({ tab })}
					data={[
						'Page',
						//'Additional fields',
					]} />

				<Grid container 
					spacing={24} 
					className={classes.root}
					style={{display: tab === 0 ? 
						'flex' : 
						'none'}}>
				
					<Grid item xs={9}>
						<PaperContentForm
							descrShow
							introShow
							onEditorAreaInputed={value => {
								data['content'] = value;
								this.setState({ data });
							}}
							onTitleFieldInputed={value => {
								data['title'] = value;
								this.setState({ data });
							}}
							onDescrFieldInputed={value => {
								data['description'] = value;
								this.setState({ data });
							}}
							onIntroFieldInputed={value => {
								data['introtext'] = value;
								this.setState({ data });
							}} />
					</Grid>

					<Grid item xs={3}>
						<PaperPageForm
							linkDefaultValue={data.link}
							viewDefaultValue={data.view_id}
							contextDefaultValue={data.context_id}
							parentDefaultValue={data.parent_id}
							onParentSelected={value => {
								data['parent_id'] = value;
								this.setState({ data });
							}}
							onContextSelected={value => {
								data['context_id'] = value;
								this.setState({ data });
							}}
							onViewSelected={value => {
								data['view_id'] = value;
								this.setState({ data });
							}}
							onDateSelected={value => {
								var date = value._d.toISOString().split('T')[0],
									time = value._d.toLocaleTimeString();
				
								data['created_at'] = date +' '+ time;
								this.setState({ data });
							}}
							onLinkInputed={value => {
								data['link'] = value;
								this.setState({ data });
							}} />
					</Grid>
				</Grid>

				{resultDialog === true && <DialogError 
					title={resultDialogTitle}
					defaultValue={resultDialog}
					message={resultDialogMessage}
					onDialogClosed={() => this.setState({
						resultDialog: false
					})} />}

				<Link to={a}
					id="page-edit"
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

export default withStyles(styles)(CreatePageContainer);