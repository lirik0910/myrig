/**
 * Select page module
 * @module PriceField
 * @author Ihor Bielchenko
 * @requires react
 */
import App from '../../App.js';

import React, { Component } from 'react';
import Grid from 'material-ui/Grid';

import Add from 'material-ui-icons/Add';
import Paper from 'material-ui/Paper';
import InputPrice from '../FormControl/InputPrice/InputPrice.jsx';
import InputWarranty from '../FormControl/InputWarranty/InputWarranty.jsx';
import CheckboxActive from '../FormControl/CheckboxActive/CheckboxActive.jsx';
import InputSelectUser from '../FormControl/InputSelectUser/InputSelectUser.jsx';
import SelectCategory from '../FormControl/SelectCategory/SelectCategory.jsx';
import SelectOrderStatus from '../FormControl/SelectOrderStatus/SelectOrderStatus.jsx';
import InputDatePicker from '../FormControl/InputDatePicker/InputDatePicker.jsx';
import SelectUser from '../FormControl/SelectUser/SelectUser.jsx';
import SelectPayment from '../FormControl/SelectPayment/SelectPayment.jsx';
import SelectProduct from '../FormControl/SelectProduct/SelectProduct.jsx';
import SelectContext from '../FormControl/SelectContext/SelectContext.jsx';
import Button from 'material-ui/Button';
import PaperOrderProductForm from './PaperOrderProductForm.jsx';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Component for selecting page
 * @extends Component
 */
class PaperOrderProductsForm extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		priceDefaultValue: '',
		statusDefaultValue: 1,
		userDefaultValue: 0,
		paymentDefaultValue: 2,
		createDefaultValue: new Date(),
		activeDefaultValue: true,
		onAddButtonClicked: () => {},
		onProductSelected: () => {},
		onCategorySelected: () => {},
		onCartChanged: () => {},
		classes: PropTypes.object.isRequired,
		category_id: 1

	}

	state = {
		products: [],
		product_id: 0,
		cart: [],
		contexts: []
	}

	/**
	 * Invoked just before mounting occurs
	 * @fires componentWillMount
	 */
	componentWillMount() {
		this.setState({ 
			value: this.props.defaultValue,
		}, () => {
			this.contextDataGetRequest();
			this.productsDataGetRequest();
		});
	}

	/**
	 * Get data about contexts
	 * @param {Function} callback
	 */
	contextDataGetRequest(callback = () => {}) {
		App.api({
			type: 'GET',
			name: 'all',
			model: 'context',
			success: (r) => {
				r = JSON.parse(r.response);
				let contexts = [];
				r.forEach((i) => {
					contexts[i.id] = i.title;
				})

				if (r) {
					this.setState({ contexts: contexts }, () => callback(r));
				}
			}
		});
	}

	productsDataGetRequest(callback = () => {}) {
		App.api({
			type: 'GET',
			name: 'all',
			model: 'product',
			data: this.props.category_id > 0 ? 
				{ category_id: this.props.category_id } :
				{},
			success: (r) => {
				r = JSON.parse(r.response).data;
				if (r) {
					this.setState({ products: r });
				}
			}
		});
	}



	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { 
			classes,
			category_id,
			userDefaultValue,
			createDefaultValue,
			contextDefaultValue,
			paymentDefaultValue,
			statusDefaultValue,
		} = this.props;

		let { products, product_id, cart, contexts} = this.state;

		return <Paper className={classes.paper}>
				<Grid container 
					spacing={24} 
					className={classes.root}>

				<Grid item xs={6}>
					<SelectCategory
						defaultValue={category_id}
						onItemSelected={v=>{
							this.props.onCategorySelected(v)
							App.api({
								type: 'GET',
								name: 'all',
								model: 'product',
								data: v > 0 ?
									{ category_id: v } :
									{},
								success: (r) => {
									console.log(r);
									r = JSON.parse(r.response).data;
									if (r) {
										this.setState({ products: r });
									}
								}
							});
						}}
					/>

					<SelectProduct
						products={products}
						contexts={contexts}
						onItemSelected={i => {
							this.props.onProductSelected(i)
							product_id = i;
							this.setState({product_id: i}); 
						}}
					/>

					<Button 
						onClick={e => {
							this.props.onAddButtonClicked()
							App.api({
								type: 'GET',
								name: 'one',
								model: 'product',
								resource: product_id, 
								success: (r) => {
									r = JSON.parse(r.response);
									if (r && r.product) {
										r.product['count'] = 1;
										r.product['discount'] = 0

										cart.push(r.product);
										//cart = cart.map((c) => {
										//	c.count = 1;
										//	c.discount = 0;
										//	return c;
										//});

										console.log(194, cart)

										this.setState({ cart });
										this.props.onCartChanged(cart);
									}
								}
							});
						}}
						className={classes.button} 
						variant="raised">
							<Add className={classes.leftIcon} />
							{"Add product"}
					</Button>
				</Grid>
				<Grid item xs={6}>
					<div>
					<span className={classes.costItem}> Cost :{cart.length && cart.reduce((sum, i) => sum + (i.price * i.count), 0)}</span>
					<span className={classes.costItem}> Discount : {cart.length && cart.reduce((sum, i) => sum + i.discount * i.count, 0)}</span>
					<span className={classes.costItem}> Total : {cart.length && cart.reduce((sum, i) => sum + (i.price - i.discount) * i.count, 0)}</span>
					</div>
				
				{cart.map((item, i) => {
					return <PaperOrderProductForm
						key={i}
						data={item}
						onItemChanged={(i,key) => {
							cart[key] = i;
							this.setState({ cart });

							console.log(223, cart)
							this.props.onCartChanged(cart);
						}}
						onItemRemoved={(key) => {
							cart.splice(key-1, 1);
							this.setState({ cart });

							console.log(230, cart)
							this.props.onCartChanged(cart);
						}}
					/>}
				)}

				</Grid>
				</Grid>

			</Paper>
	}
}

export default withStyles(styles)(PaperOrderProductsForm);