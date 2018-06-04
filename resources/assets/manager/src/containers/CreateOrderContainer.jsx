/**
 * Base module of manager users container
 * @module OrderContainers
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
import PaperOrderForm from '../components/PaperOrderForm/PaperOrderForm.jsx';
import PaperOrderPaymentForm from '../components/PaperOrderForm/PaperOrderPaymentForm.jsx';
import PaperOrderDeliveryForm from '../components/PaperOrderForm/PaperOrderDeliveryForm.jsx';
import PaperOrderProductsForm from '../components/PaperOrderForm/PaperOrderProductsForm.jsx';

import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Users base container
 * @extends Component
 */
class CreateOrderContainers extends Component {

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
		curUser: {},
		data: {},
		orderID: 0,
		completed: 100,
		category_id: 1,
		cart: [],
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
		let {data} = this.state; 
		let value = new Date();
		let date = value.toISOString().split('T')[0];
		let time = value.toLocaleTimeString();
		data['created_at'] = date +' '+ time;
		this.setState({ data });
		this.setState({ completed: 100});
	}

	/**
	 * Request for adding new product
	 * @param {Object} e
	 */
	orderPostRequest = e => {
		let { cart,  data } = this.state;

		this.setState({ 
			completed: 0 
		});

		let infoFields = ['p_first_name', 'p_last_name', 'p_email', 'p_phone', 'p_city', 'p_state', 'p_address', 'd_first_name', 'd_last_name', 'd_email', 'd_phone', 'd_city', 'd_state', 'd_address', 'd_passport', 'd_office', 'd_zendesk', 'd_warranty'];
		
		infoFields.forEach((f) => {
			let v = document.getElementById(f).value;
			data[f] = v;
		}) 

		data['cart'] = JSON.stringify(cart);

		App.api({
			type: 'POST',
			model: 'order',
			name: 'create',
			data,
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
						resultDialogTitle: 'Error',
						resultDialogMessage: <div><b>{r.message}</b> {l}</div>
					});
				}
			},
			success: (r) => {
				r = JSON.parse(r.response)
				if (r) {
					this.setState({ 
						completed: 100,
						resultDialog: true,
						resultDialogTitle: 'Success',
						resultDialogMessage: 'The request was successful',
						a: App.name() + '/order'
					}, () => {
						setTimeout(() => {
							var a = document.getElementById('orders');
							if (a) {
								a.click();
							}
						}, 824);
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
			curUser,
			completed,
			orderID,
			category_id,
			resultDialog,
			resultDialogTitle,
			resultDialogMessage,
		} = this.state;

		return <div className="order__container">
				{completed === 0 && 
					<LinearProgress color="secondary" variant="determinate" value={completed} />}

				<Header
					title={'Create new order'} />

				<Menu />

				<TopTitle
					title={'Новый Заказ'}
					onSaveButtonClicked={() => this.orderPostRequest()} />
					
				<TabOptions
					defaultValue={tab}
					onTabButtonClicked={tab => this.setState({ tab })}
					data={[
						'General Details',
						'Payment Details',
						'Delivery Details',
						'Products',
						//'tabs'
					]} />

				<Grid container 
					spacing={24} 
					className={classes.root}
					style={{display: tab === 0 ? 
						'flex' : 
						'none'}}>

					

					<Grid item xs={6}>
						<PaperOrderForm

							onUserSelected={id => {
								this.setState({curUser: {}});
								if(id) App.api({
							            type: 'GET',
							            name: 'one',
							            model: 'user',
										resource: id,
							            //data: data,
							            success: (r) => {
						                    let infoFields = ['p_first_name', 'p_last_name', 'p_email', 'p_phone', 'p_city', 'p_state', 'p_address'];
											infoFields.forEach((f) => {
												let v = document.getElementById(f).value = '';
											}) 
							                r = JSON.parse(r.response);
							                if (r) {
												data['user_id'] = r.id;
												this.setState({ data });
							                    this.setState({
							                        curUser: r,
							                    });

							                }
							            }
							        });
							}}

							onDateSelected={value => {
								var date = value._d.toISOString().split('T')[0],
									time = value._d.toLocaleTimeString();
				
								data['created_at'] = date +' '+ time;
								this.setState({ data });
							}}

							onStatusSelected={value=>{
								data['status_id'] = value;
								this.setState({ data });
							}}

							onPaymentSelected={value => {
								data['payment_type_id'] = value
								this.setState({ data });
							}}

							onContextSelected={value => {
								data['context_id'] = value
								this.setState({ data });
							}}
							/>

					</Grid>

				</Grid>


				<Grid container 
					spacing={24} 
					className={classes.root}
					style={{display: tab === 1 ? 
						'flex' : 
						'none'}}>

					<Grid item xs={6}>
						<PaperOrderPaymentForm
							data = {curUser}

							onCountrySelected={v => {
								data['p_country'] = v
								this.setState({ data });
							}}
						/>

					</Grid>


				</Grid>

				<Grid container 
					spacing={24} 
					className={classes.root}
					style={{display: tab === 2 ? 
						'flex' : 
						'none'}}>
					<Grid item xs={6}>
						<PaperOrderDeliveryForm
							onDeliverySelected={value => {
								data['delivery_id'] = value
								this.setState({ data });
							}}
							onCountrySelected={v => {
								data['d_country'] = v
								this.setState({ data });
							}}
						/>
					</Grid>
										

				</Grid>

				<Grid container 
					spacing={24} 
					className={classes.root}
					style={{display: tab === 3 ? 
						'flex' : 
						'none'}}>
					<Grid item xs={12}>
						<PaperOrderProductsForm
							category_id={category_id}

							onCategorySelected={c=>{
								this.setState({category_id: c});
							}}

							onCartChanged={c=>{
								this.setState({cart:c})
							}}
						/>
					</Grid>
										

				</Grid>

				{resultDialog === true && <DialogError 
					title={resultDialogTitle}
					defaultValue={resultDialog}
					message={resultDialogMessage}
					onDialogClosed={() => this.setState({
						resultDialog: false
					})} />}

				<Link 
					id="order" 
					to={App.name() + '/orders'} 
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

export default withStyles(styles)(CreateOrderContainers);