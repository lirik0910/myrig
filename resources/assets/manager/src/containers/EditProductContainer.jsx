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
import PaperContentForm from '../components/PaperContentForm/PaperContentForm.jsx';
import PaperProductForm from '../components/PaperProductForm/PaperProductForm.jsx';
import PaperImageVariable from '../components/PaperImageVariable/PaperImageVariable.jsx';
import PaperOptionVariable from '../components/PaperOptionVariable/PaperOptionVariable.jsx';
import PaperAutoProductForm from '../components/PaperAutoProductForm/PaperAutoProductForm.jsx';

import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

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
		images: [],
		options: [],
		currencies: [],
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
		this.currenciesDataGetRequest(() => {
			this.productDataGetRequest();
		});
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
						data: r,
						completed: 100,
						images: r.images,
						options: r.options,
						categories_line: '0'
					});
				}
			}
		})
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
						resultDialogTitle: 'Success',
						resultDialogMessage: 'The request was successful'
					}, () => this.productDataGetRequest());
				}
			},
			error: (r) => {
				r = JSON.parse(r.response);
				if (r.message) {
					this.setState({ 
						resultDialog: true,
						resultDialogTitle: 'Error',
						resultDialogMessage: r.message
					});
				}
			}
		});
	}

	/**
	 * Request for delete product
	 * @param {Object} e
	 */
	productDeleteRequest = e => {
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
			images,
			options,
			completed,
			currencies,
			deleteDialog,
			resultDialog, 
			resultDialogTitle, 
			resultDialogMessage
		} = this.state;

		return <div className="products__container">
				{completed === 0 && 
					<LinearProgress color="secondary" variant="determinate" value={completed} />}
				
				<Header
					title={'Create new product'} />
				<Menu />
					
				{completed === 100 && <TopTitle
					title={data.title}
					deleteButtonDisplay={true}
					onSaveButtonClicked={() => this.productPutRequest()}
					onDeleteButtonClicked={() => this.setState({
						deleteDialog: true
					})} />}
					
				<TabOptions
					defaultValue={tab}
					onTabButtonClicked={tab => this.setState({ tab })}
					data={[
						'Product',
						'Options',
						//'Page',
						//'Additional fields'
					]} />

				<Grid container 
					spacing={24} 
					className={classes.root}
					style={{display: tab === 0 ? 
						'flex' : 
						'none'}}>
				
					<Grid item xs={9}>
						{completed === 100 && <PaperContentForm
							inputDefaultValue={data.title}
							editorDefaultValue={data.description}
							onEditorAreaInputed={value => {
								data['description'] = value;
								this.setState({ data });
							}}
							onTitleFieldInputed={value => {
								data['title'] = value;
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

export default withStyles(styles)(EditProductContainer);