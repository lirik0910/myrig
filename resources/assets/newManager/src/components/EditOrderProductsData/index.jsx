/**
 * EditOrderProductsData module
 * @requires react
 * @requires react#PureComponent
 */

import React, { Component } from 'react';
import { connect } from 'react-redux';

import cloneDeep from 'clone-deep';
import Dialog from '@material-ui/core/Dialog';
import DialogContent from '@material-ui/core/DialogContent';
import DialogTitle from '@material-ui/core/DialogTitle';
import DialogActions from '@material-ui/core/DialogActions';
import Button from '@material-ui/core/Button';
import Paper from '@material-ui/core/Paper';
import Grid from '@material-ui/core/Grid';
import Typography from '@material-ui/core/Typography';
import TextField from '@material-ui/core/TextField';
import InputNumberDefault from 'components/InputNumberDefault';
import FilterProductCategory from 'components/FilterProductCategory';
import FilterProduct from 'components/FilterProduct';
import Add from '@material-ui/icons/Add';

/**
 * EditOrderProductsData block
 * @extends PureComponent
 */
class EditOrderProductsData extends Component {

	/**
	 * Default properties
	 * @type {object}
	 */
	static defaultProps = {
		order: {},
		onCartUpdated: (carts) => {}
	}

	state = {
		add: false,
		category: null,
		newProduct: {},
		carts: this.props.order.carts
	}

	handleDeleteProduct(e, i) {
		let { carts } = this.state;

		carts.splice(i, 1);
		this.setState({ carts }, () => 
			this.props.onCartUpdated(carts));
	}

	addNewProduct = (e) => {
		let { carts, newProduct } = this.state;

		carts.push({
			id: typeof newProduct.product_id === 'undefined' ?
				newProduct.id : 
				newProduct.product_id,
			cost: newProduct.price,
			btcCost: 0,
			count: 1,
			product: cloneDeep(newProduct)
		});
		this.setState({ carts, add: false, newProduct: {} }, () => {
			this.props.onCartUpdated(carts);
		});
	}

	/**
	 * Render component
	 * @return {object} jsx object
	 */
	render() {
		let { carts, add, category } = this.state,
			{ langs } = this.props;

		return <Paper style={{ marginBottom: 24 }}>
			<Typography variant="title">
				{langs['orderEditProductsTitle']}
			</Typography>

			{carts.map((item, i) => {
				return <Grid 
					key={i}
					container 
					spacing={24} 
					style={{ 
						width: '100%', 
						margin: 0 
					}}>
					
					<Grid 
						item 
						xs={12} 
						sm={5} 
						style={{ 
							position: 'relative', 
							overflow: 'hidden' 
						}}>
					
						<img 
							src={item.product.images[0] ?
								window.uploads + item.product.images[0].name :
								window.defaultImage} 
							alt="icon"
							style={{
								width: '100%'
							}} />

						<Button 
							color="secondary"
							onClick={(e) => this.handleDeleteProduct(e, i)}>
							{langs['labelDeleteProductButton']}
						</Button>
					</Grid>

					<Grid item xs={12} sm={7}>
						<Typography variant="display2">{ item.product.title }</Typography>

						<Typography variant="subheading">
							{langs['txtOrderTotalSum']}: <b>{ parseFloat(item.cost).toFixed(2) }</b>
						</Typography>

						<Typography variant="subheading">
							{langs['txtOrderTotalBtcSum']}: <b>{ item.btcCost.toFixed(2) }</b>
						</Typography>

						<InputNumberDefault
							floatInput
							defaultValue={item.cost}
							label={langs['txtOrderTotalSum']}
							handleFieldChanged={(value) => {
								carts[i]['cost'] = value;
								this.setState({ carts }, () => this.props.onCartUpdated(carts));
							}} />

						<InputNumberDefault
							defaultValue={item.count}
							label={langs['labelProductsCount']}
							handleFieldChanged={(value) => {
								carts[i]['count'] = value;
								this.setState({ carts }, () => this.props.onCartUpdated(carts));
							}} />

						<InputNumberDefault
							defaultValue={item.discount}
							label={langs['labelProductsDicount']}
							handleFieldChanged={(value) => {
								carts[i]['discount'] = value;
								this.setState({ carts }, () => this.props.onCartUpdated(carts));
							}} />

						<TextField
							defaultValue={item.serial_number}
							label={langs['labelProductsSerialNumber']}
							onChange={(e) => {
								carts[i]['serials_number'] = e.target.value;
								this.setState({ carts }, () => this.props.onCartUpdated(carts));
							}} />
					</Grid>
				</Grid>
			})}

			<div style={{ padding: 12, textAlign: 'center' }}>
				<Button 
					onClick={(e) => this.setState({ add: true })}>
					
					<Add />
					{langs['labelAddProductButton']}
				</Button>
			</div>

			{add === true && <Dialog
				open={add}
				onClose={(e) => this.setState({ 
					add: false 
				})}>
				<DialogTitle>
					{langs['dialogAddProductTitle']}
				</DialogTitle>

				<DialogContent>
					<FilterProductCategory
						onCategoryChanged={(e, category) => this.setState({ category })} />
					<FilterProduct
						category={category}
						onProductSelected={(newProduct) => this.setState({ newProduct })} />
				</DialogContent>

				<DialogActions>
					<Button 
						color="secondary"
						onClick={(e) => this.setState({ 
							add: false, 
							newProduct: {} 
						})}>
						{langs['labelCancelButton']}
					</Button>

					<Button onClick={this.addNewProduct}>
						{langs['labelOkButton']}
					</Button>
				</DialogActions>
			</Dialog>}
		</Paper>
	}
}

/**
 * Init redux states
 * @param {Object} state
 * @return {Object}
 */
function mapStateToProps(state) {
	return {
		langs: state.langs
	}
}

export default connect(mapStateToProps)(EditOrderProductsData);