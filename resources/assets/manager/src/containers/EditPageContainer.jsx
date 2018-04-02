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
import DialogDelete from '../components/DialogDelete/DialogDelete.jsx';
import PaperPageForm from '../components/PaperPageForm/PaperPageForm.jsx';
import PaperContentForm from '../components/PaperContentForm/PaperContentForm.jsx';
import PaperMultiVariable from '../components/PaperMultiVariable/PaperMultiVariable.jsx';
import PaperInputVariable from '../components/PaperInputVariable/PaperInputVariable.jsx';
import PaperImageVariable from '../components/PaperImageVariable/PaperImageVariable.jsx';
import PaperRichtextVariable from '../components/PaperRichtextVariable/PaperRichtextVariable.jsx';

import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Users base container
 * @extends Component
 */
class EditPageContainer extends Component {

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
		trash: false,
		completed: 100,
		deleteDialog: false,
		resultDialog: false,
		resultDialogTitle: '',
		resultDialogMessage: ''
	}

	/**
	 * Invoked just before mounting occurs
	 * @fires componentWillMount
	 */
	componentWillMount() {
		this.pageDataGetRequest();
	}

	pageDeleteRequest = e => {
		let { data } = this.state;

		App.api({
			name: 'trash',
			model: 'page',
			type: 'PUT',
			resource: data.id,
			success: (r) => {
				r = JSON.parse(r.response);
				if (r) {
					this.setState({ 
						ready: false,
						deleteDialog: false,
					}, () => this.pageDataGetRequest(() => {
						this.setState({ ready: true })
					}));
				}
			},
			error: (r) => {
				r = JSON.parse(r.response);
				if (r.message) {
					this.setState({ 
						deleteDialog: false,
						resultDialog: true,
						resultDialogTitle: 'Error',
						resultDialogMessage: r.message
					});
				}
			}
		});
	}

	/**
	 * Get page data from server
	 * @param {Function} callback
	 */
	pageDataGetRequest() {
		this.setState({ 
			completed: 0 
		});

		let resource = App.defineResourceProps();

		App.api({
			type: 'GET',
			name: 'one',
			model: 'page',
			resource: resource[resource.length - 1],
			success: (r) => {
				r = JSON.parse(r.response);
				if (r) {
					this.setState({ 
						data: r,
						completed: 100,
					});
				}
			}
		})
	}

	/**
	 * Request for adding new page
	 * @param {Object} e
	 */
	pagePutRequest = e => {
		let { data } = this.state;

		this.setState({ 
			completed: 0 
		});
		data['fields'] = JSON.stringify(data.view.variables);

		App.api({
			type: 'PUT',
			model: 'page',
			name: 'update',
			data,
			resource: data.id,
			success: (r) => {
				r = JSON.parse(r.response);
				if (r) {
					this.setState({ 
						completed: 100,
						resultDialog: true,
						resultDialogTitle: 'Success',
						resultDialogMessage: 'The request was successful',
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
	 * Request for delete page
	 * @param {Object} e
	 */
	// pageDeleteRequest = e => {
	// 	let { data } = this.state;

	// 	this.setState({ 
	// 		completed: 0 
	// 	});

	// 	App.api({
	// 		name: 'one',
	// 		model: 'page',
	// 		type: 'DELETE',
	// 		resource: data.id,
	// 		success: (r) => {
	// 			r = JSON.parse(r.response);
	// 			if (r) {
	// 				this.setState({ 
	// 					completed: 100,
	// 					resultDialog: true,
	// 					deleteDialog: false,
	// 					a: App.name() +'/pages',
	// 					resultDialogTitle: 'Success',
	// 					resultDialogMessage: 'The request was successful'
	// 				}, () => {
	// 					setTimeout(() => {
	// 						var a = document.getElementById('page-edit');
	// 						if (a) {
	// 							a.click();
	// 						}
	// 					}, 824);
	// 				});
	// 			}
	// 		},
	// 		error: (r) => {
	// 			r = JSON.parse(r.response);
	// 			if (r.message) {
	// 				this.setState({ 
	// 					completed: 100,
	// 					resultDialog: true,
	// 					deleteDialog: false,
	// 					resultDialogTitle: 'Error',
	// 					resultDialogMessage: r.message
	// 				});
	// 			}
	// 		}
	// 	});
	// }

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
			deleteDialog,
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

				{completed === 100 && <TopTitle
					title={<span style={{
						color: data.delete === 1 ?
							'red' :
							'#000000',
						textDecoration: data.delete === 1 ?
							'line-through' :
							'none'
					}}>{data.title}</span>}
					saveButtonDisplay={true}
					deleteButtonDisplay={true}
					onSaveButtonClicked={() => this.pagePutRequest()}
					onDeleteButtonClicked={() => this.setState({
						deleteDialog: true
					})} />}

				<TabOptions
					defaultValue={tab}
					onTabButtonClicked={tab => this.setState({ tab })}
					data={[
						'Page',
						'Additional fields',
					]} />

				<Grid container 
					spacing={24} 
					className={classes.root}
					style={{display: tab === 0 ? 
						'flex' : 
						'none'}}>
				
					<Grid item xs={9}>
						{completed === 100 && <PaperContentForm
							descrShow
							introShow
							inputDefaultValue={data.title}
							descrDefaultValue={data.description}
							introDefaultValue={data.introtext}
							editorDefaultValue={data.content}
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
							}} />}
					</Grid>

					<Grid item xs={3}>
						{completed === 100 && <PaperPageForm
							linkDefaultValue={data.link}
							contextDefaultValue={data.context_id}
							parentDefaultValue={data.parent_id}
							createDefaultValue={new Date(data.created_at)}
							viewDefaultValue={data.view_id}
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
							}} />}
					</Grid>
				</Grid>

				<Grid container 
					spacing={24} 
					className={classes.root}
					style={{display: tab === 1 ? 
						'flex' : 
						'none'}}>
					{completed === 100 && data.view.variables.map((item, i) => {
						return <Grid item xs={12} key={i}>
							{item.type === 'input' &&
								<PaperInputVariable
									key={i}
									title={item.description}
									data={item.variable_content}
									onAddedField={fields => {
										this.setState({ data });
									}} />}

							{item.type === 'multi' && 
								<PaperMultiVariable
									key={i}
									pageId={data.id}
									variableId={item.id}
									title={item.description}
									data={item.multi_variable_lines}
									columns={item.columns} />}

							{item.type === 'image' &&
								<PaperImageVariable
									key={i}
									title={item.description}
									data={item.variable_content.map((field, a) => {
										return {...field, name: field.content}
									})}
									onImageSet={fields => {
										for (var a in fields) {
											fields[a].content = fields[a].name;
										}
										data.view.variables[i].variable_content = fields;

										this.setState({ data });
									}}
									onDeletedField={fields => {
										for (var a in fields) {
											fields[a].content = fields[a].name;
										}
										data.view.variables[i].variable_content = fields;

										this.setState({ data });
									}}
									onAddedField={fields => {
										for (var a in fields) {
											fields[a].content = fields[a].name;
										}
										data.view.variables[i].variable_content = fields;

										this.setState({ data });
									}} />}

							{item.type === 'richtext' &&
								<PaperRichtextVariable
									key={i}
									title={item.description}
									onAddedField={fields => {
										this.setState({ data });
									}}
									data={item.variable_content} />}
						</Grid>
					})}
				</Grid>

				{resultDialog === true && <DialogError 
					title={resultDialogTitle}
					defaultValue={resultDialog}
					message={resultDialogMessage}
					onDialogClosed={() => this.setState({
						resultDialog: false
					})} />}

				{deleteDialog === true && <DialogDelete
					defaultValue={deleteDialog}
					onDialogClosed={() => this.setState({
						deleteDialog: false
					})}
					onDialogConfirmed={() => this.pageDeleteRequest()} />}

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

export default withStyles(styles)(EditPageContainer);