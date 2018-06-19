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
import TabOptions from '../components/TabOptions/TabOptions.jsx';
import DialogError from '../components/DialogError/DialogError.jsx';
import DialogDelete from '../components/DialogDelete/DialogDelete.jsx';
import PaperPageForm from '../components/PaperPageForm/PaperPageForm.jsx';
import PaperContentForm from '../components/PaperContentForm/PaperContentForm.jsx';
import PaperProductForm from '../components/PaperProductForm/PaperProductForm.jsx';
import PaperImageVariable from '../components/PaperImageVariable/PaperImageVariable.jsx';
import PaperInputVariable from '../components/PaperInputVariable/PaperInputVariable.jsx';
import PaperMultiVariable from '../components/PaperMultiVariable/PaperMultiVariable.jsx';
import PaperOptionVariable from '../components/PaperOptionVariable/PaperOptionVariable.jsx';
import PaperAutoProductForm from '../components/PaperAutoProductForm/PaperAutoProductForm.jsx';
import PaperRichtextVariable from '../components/PaperRichtextVariable/PaperRichtextVariable.jsx';

import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

import * as StateLexiconAction from 'actions/StateLexiconAction.js';

/**
 * Users base container
 * @extends Component
 */
class EditProductContainer extends Component {

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
		tab: 0,
		data: {},
		page: {},
		images: [],
		options: [],
		currencies: [],
		completed: 100,
		btc: 0,
		deleteDialog: false,
		resultDialog: false,
		resultDialogTitle: '',
		resultDialogMessage: '',
		langLoaded: false
	}

	/**
	 * Invoked just before mounting occurs
	 * @fires componentWillMount
	 */
	componentWillMount() {
		this.currenciesDataGetRequest(() => {
			this.productDataGetRequest();
			//this.btcDataGetRequest();
			//console.log(this.state.btc);
		});

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
	 * Get page data from server
	 * @param {Function} callback
	 */
	pageDataGetRequest(pageID) {
		this.setState({ 
			completed: 0 
		});

		let resource = App.defineResourceProps();

		App.api({
			type: 'GET',
			name: 'one',
			model: 'page',
			resource: pageID,
			success: (r) => {
				r = JSON.parse(r.response);
				if (r) {
					this.setState({ 
						page: r,
						completed: 100,
					});
				}
			}
		})
	}

	/**
	 * Get product data from server
	 * @param {Function} callback
	 */
	productDataGetRequest() {
		this.setState({ 
			completed: 0 
		});

		let resource = App.defineResourceProps();

		App.api({
			type: 'GET',
			name: 'one',
			model: 'product',
			resource: resource[resource.length - 1],
			success: (r) => {
				r = JSON.parse(r.response);
				if (r) {
					this.setState({ 
						data: r.product,
						images: r.product.images,
						options: r.product.options,
						categories_line: '0',
                        btc: r.btc.value
					}, () => {
						if (r.product.page_id > 0 && r.product.page_id !== '') {
							this.pageDataGetRequest(r.product.page_id)
						}

						else this.setState({ completed: 100 });
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
		let { page } = this.state;

		this.setState({ 
			completed: 0 
		});
		page['fields'] = JSON.stringify(page.view.variables);

		App.api({
			type: 'PUT',
			model: 'page',
			name: 'update',
			data: page,
			resource: page.id,
			error: (r) => {
				r = JSON.parse(r.response);
				if (r.message) {
					this.setState({ 
						completed: 100,
						resultDialog: true,
						resultDialogTitle: this.props.lexicon.error_title,
						resultDialogMessage: r.message
					});
				}
			}
		});
	}

	/**
	 * Get currencies data from server
	 * @param {Function} callback
	 */
	currenciesDataGetRequest(callback = () => {}) {
		this.setState({ 
			completed: 0 
		});

		App.api({
			type: 'GET',
			name: 'all',
			model: 'currency',
			success: (r) => {
				r = JSON.parse(r.response);
				if (r) {
					this.setState({ 
						currencies: r,
					}, () => callback());
				}
			}
		})
	}

	/**
	 * Request for update product
	 * @param {Object} e
	 */
	productPutRequest = e => {
		let { data } = this.state;

		this.setState({ 
			completed: 0 
		});

		if (typeof data['product_auto_prices'] !== 'undefined' && data['product_auto_prices']) {
			data['product_auto_prices'] = JSON.stringify(data['product_auto_prices']);
		}

		App.api({
			type: 'PUT',
			name: 'update',
			model: 'product',
			resource: data.id,
			data,
			success: (r) => {
				r = JSON.parse(r.response);
				if (r) {
					this.setState({ 
						resultDialog: true,
						resultDialogTitle: this.props.lexicon.success_title,
						resultDialogMessage: this.props.lexicon.request_successful
					}, () => this.productDataGetRequest());
				}
			},
			error: (r) => {
				r = JSON.parse(r.response);
				if (r.message) {
					if (r.message === 'The given data was invalid.') {
						var l = [],
							n,
							k;
						
						k = 0;
						for (n in r.errors) {
							l.push(<p key={k}>{r.errors[n][0]}</p>);
							k++;
						}
					}

					this.setState({ 
						completed: 100,
						resultDialog: true,
						resultDialogTitle: this.props.lexicon.error_title,
						resultDialogMessage: <div><b>{r.message}</b> {l}</div>
					});
				}
			}
		});
	}

	/**
	 * Request for delete product
	 * @param {Object} e
	 */
	/*productDeleteRequest = e => {
		let { data } = this.state;

		this.setState({ 
			completed: 0 
		});

		App.api({
			name: 'one',
			type: 'DELETE',
			model: 'product',
			resource: data.id,
			success: (r) => {
				r = JSON.parse(r.response);
				if (r) {
					this.setState({ 
						completed: 100,
						resultDialog: true,
						deleteDialog: false,
						resultDialogTitle: 'Success',
						resultDialogMessage: 'The request was successful'
					}, () => {
						setTimeout(() => {
							var a = document.getElementById('product-list');
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
						deleteDialog: false,
						resultDialogTitle: 'Error',
						resultDialogMessage: r.message
					});
				}
			}
		});
	}*/

	/**
	 * Request for delete product
	 * @param {Object} e
	 */
	productDeleteRequest = e => {
		let { data } = this.state;

		this.setState({ 
			completed: 0 
		}, () => {
			App.api({
				name: 'trash',
				type: 'PUT',
				model: 'product',
				resource: data.id,
				success: (r) => {
					r = JSON.parse(r.response);
					if (r) {
						this.setState({ 
							completed: 100,
							deleteDialog: false,
							resultDialogTitle: this.props.lexicon.success_title,
							resultDialogMessage: this.props.lexicon.request_successful,
						}, () => this.productDataGetRequest());
					}
				},
				error: (r) => {
					r = JSON.parse(r.response);
					if (r.message) {
						this.setState({ 
							completed: 100,
							resultDialog: true,
							deleteDialog: false,
							resultDialogTitle: this.props.lexicon.error_title,
							resultDialogMessage: r.message
						});
					}
				}
			});
		});
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { classes } = this.props;
		let { 
			tab, 
			data, 
			page,
			images,
			options,
			completed,
			btc,
			currencies,
			deleteDialog,
			resultDialog, 
			resultDialogTitle, 
			resultDialogMessage
		} = this.state;

		var tabs = [this.props.lexicon.product_label, this.props.lexicon.options_label];

		if (data.page_id > 0 && data.page_id !== '' && App.isEmpty(page) === false) {
			tabs.push(this.props.lexicon.page_title);
			tabs.push(this.props.lexicon.additional_fields_tab);
		}

		if (this.state.langLoaded === false) 
			return <div className="create-page__container">
				<LinearProgress color="secondary" variant="determinate" value={0} />
			</div>

		return <div className="products__container">
				{completed === 0 && 
					<LinearProgress color="secondary" variant="determinate" value={completed} />}
				
				<Header
					title={this.props.lexicon.edit_product} />
				<Menu />
					
				{completed === 100 && <TopTitle
					item={data}
					title={<span style={{
						color: data.delete === 1 ?
							'red' :
							'#000000',
						textDecoration: data.delete === 1 ?
							'line-through' :
							'none'
					}}>{data.title}</span>}

					addButtonTitle={this.props.lexicon.add_label}
					saveButtonTitle={this.props.lexicon.save_label}
					trashButtonTitle={this.props.lexicon.empty_trash_label}
					duplicateButtonTitle={this.props.lexicon.duplicate_label}
					deleteButtonTitle={this.props.lexicon.delete_selected_button}
					recoveryButtonTitle={this.props.lexicon.recovery_button}

					deleteButtonDisplay={true}
					onSaveButtonClicked={() => {
						this.productPutRequest();

						if (App.isEmpty(page) === false) {
							this.pagePutRequest();
						}
					}}
					onDeleteButtonClicked={() => this.setState({
						deleteDialog: true
					})} />}
					
				<TabOptions
					defaultValue={tab}
					onTabButtonClicked={tab => this.setState({ tab })}
					data={tabs} />

				<Grid container 
					spacing={24} 
					className={classes.root}
					style={{display: tab === 0 ? 
						'flex' : 
						'none'}}>
				
					<Grid item xs={9}>
						{completed === 100 && <PaperContentForm
							inputTitle={this.props.lexicon.title_label}
							introTitle={this.props.lexicon.introtext_label}
							descrTitle={this.props.lexicon.description_label}
							articulTitle={this.props.lexicon.articul_label}

							articulShow
							articulDefaultValue={data.articul}
							inputDefaultValue={data.title}
							editorDefaultValue={data.description}
							onEditorAreaInputed={value => {
								data['description'] = value;
								this.setState({ data });
							}}
							onTitleFieldInputed={value => {
								data['title'] = value;
								this.setState({ data });
							}}
							onArticulFieldInputed={value => {
								data['articul'] = value;
								this.setState({ data });
							}} />}

						<PaperImageVariable
							data={images}
							onImageSet={images => {
								data['images'] = JSON.stringify(images);
								this.setState({ images });
							}}
							onAddedField={images => {
								data['images'] = JSON.stringify(images);
								this.setState({ images });
							}}
							onDeletedField={images => {
								data['images'] = JSON.stringify(images);
								this.setState({ images });
							}} />
					</Grid>

					<Grid item xs={3}>
						{completed === 100 && <PaperProductForm
							priceDefaultValue={data.price}
							pageDefaultValue={data.page_id}
							statusDefaultValue={data.product_status_id}
							contextDefaultValue={data.context_id}
							warrantyDefaultValue={data.warranty}
							activePriceField={Boolean(data.auto_price)}
							activeDefaultValue={Boolean(data.active)}
							createDefaultValue={new Date(data.created_at)}
							categoriesDefaultValue={data.categories}
							onPageSelected={value => {
								data['page_id'] = value;
								this.setState({ data });
							}}
							onContextSelected={value => {
								data['context_id'] = value;
								this.setState({ data });
							}}
							onStatusSelected={value => {
								data['product_status_id'] = value;
								this.setState({ data });
							}}
							onWarrantyInputed={value => {
								data['warranty'] = value;
								this.setState({ data });
							}}
							onCategoryInputed={value => {
								if (value) {
									data['categories_line'] = value;
								}
								else data['categories_line'] = '0';

								this.setState({ data });
							}}
							onPriceInputed={value => {
								data['price'] = value;
								this.setState({ data });
							}}
							onDateSelected={value => {
								var date = value._d.toISOString().split('T')[0],
									time = value._d.toLocaleTimeString();
				
								data['created_at'] = date +' '+ time;
								this.setState({ data });
							}}
							onActiveChanged={value => {
								data['active'] = Number(value);
								this.setState({ data });
							}} />}

						{completed === 100 && <PaperAutoProductForm
							currencies={currencies}
							data={data.product_auto_prices}
							btc={btc}
							activeDefaultValue={Boolean(data.auto_price)}
							onActiveChanged={value => {
								data['auto_price'] = Number(value);
								this.setState({ data });
							}}
							onDataUpdated={value => {
								data.product_auto_prices = value;
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
						
					<Grid item xs={12}>
						<PaperOptionVariable
							data={options}
							onVariableUpdated={options => {
								data['options'] = JSON.stringify(options);
								this.setState({ options });
							}} />
					</Grid>
				</Grid>

				{App.isEmpty(page) === false && <Grid container 
					spacing={24} 
					className={classes.root}
					style={{display: tab === 2 ? 
						'flex' : 
						'none'}}>
				
					<Grid item xs={9}>
						{completed === 100 && <PaperContentForm
							descrShow
							introShow

							inputTitle={this.props.lexicon.title_label}
							introTitle={this.props.lexicon.introtext_label}
							descrTitle={this.props.lexicon.description_label}
							articulTitle={this.props.lexicon.articul_label}

							inputDefaultValue={page.title}
							descrDefaultValue={page.description}
							introDefaultValue={page.introtext}
							editorDefaultValue={page.content}
							onEditorAreaInputed={value => {
								page['content'] = value;
								this.setState({ page });
							}}
							onTitleFieldInputed={value => {
								page['title'] = value;
								this.setState({ page });
							}}
							onDescrFieldInputed={value => {
								page['description'] = value;
								this.setState({ page });
							}}
							onIntroFieldInputed={value => {
								page['introtext'] = value;
								this.setState({ page });
							}} />}
					</Grid>

					<Grid item xs={3}>
						{completed === 100 && <PaperPageForm
							linkDefaultValue={page.link}
							contextDefaultValue={page.context_id}
							parentDefaultValue={page.parent_id}
							createDefaultValue={new Date(page.created_at)}
							viewDefaultValue={page.view_id}
							onParentSelected={value => {
								page['parent_id'] = value;
								this.setState({ page });
							}}
							onContextSelected={value => {
								page['context_id'] = value;
								this.setState({ page });
							}}
							onViewSelected={value => {
								page['view_id'] = value;
								this.setState({ page });
							}}
							onDateSelected={value => {
								var date = value._d.toISOString().split('T')[0],
									time = value._d.toLocaleTimeString();
				
								page['created_at'] = date +' '+ time;
								this.setState({ page });
							}}
							onLinkInputed={value => {
								page['link'] = value;
								this.setState({ page });
							}} />}
					</Grid>
				</Grid>}

				{App.isEmpty(page) === false && <Grid container 
					spacing={24} 
					className={classes.root}
					style={{display: tab === 3 ? 
						'flex' : 
						'none'}}>
					{completed === 100 && page.view.variables.map((item, i) => {
						return <Grid item xs={12} key={i}>
							{item.type === 'input' &&
								<PaperInputVariable
									key={i}
									title={this.props.lexicon['var_'+ item.title]}
									data={item.variable_content}
									onAddedField={fields => {
										this.setState({ page });
									}} />}

							{item.type === 'multi' && 
								<PaperMultiVariable
									key={i}
									pageId={page.id}
									variableId={item.id}
									title={this.props.lexicon['var_'+ item.title]}
									data={item.multi_variable_lines}
									columns={item.columns} />}

							{item.type === 'image' &&
								<PaperImageVariable
									key={i}
									title={this.props.lexicon['var_'+ item.title]}
									data={item.variable_content.map((field, a) => {
										return {...field, name: field.content}
									})}
									onImageSet={fields => {
										for (var a in fields) {
											fields[a].content = fields[a].name;
										}
										page.view.variables[i].variable_content = fields;

										this.setState({ page });
									}}
									onDeletedField={fields => {
										for (var a in fields) {
											fields[a].content = fields[a].name;
										}
										page.view.variables[i].variable_content = fields;

										this.setState({ page });
									}}
									onAddedField={fields => {
										for (var a in fields) {
											fields[a].content = fields[a].name;
										}
										page.view.variables[i].variable_content = fields;

										this.setState({ page });
									}} />}

							{item.type === 'richtext' &&
								<PaperRichtextVariable
									key={i}
									title={this.props.lexicon['var_'+ item.title]}
									onAddedField={fields => {
										this.setState({ page });
									}}
									data={item.variable_content} />}
						</Grid>
					})}
				</Grid>}

				{resultDialog === true && <DialogError 
					title={resultDialogTitle}
					defaultValue={resultDialog}
					message={resultDialogMessage}
					onDialogClosed={() => this.setState({
						resultDialog: false
					})} />}

				{deleteDialog === true && <DialogDelete

					title={this.props.lexicon.delete_button}
					content={this.props.lexicon.delete_confirm}
					
					defaultValue={deleteDialog}
					onDialogClosed={() => this.setState({
						deleteDialog: false
					})}
					onDialogConfirmed={() => this.productDeleteRequest()} />}

				<Link 
					id="product-list" 
					to={App.name() + '/products/'} 
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

export default connect(mapStateToProps, mapDispatchToProps)(withStyles(styles)(EditProductContainer));