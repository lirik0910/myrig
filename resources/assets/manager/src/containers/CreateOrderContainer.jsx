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
import PaperOrderForm from '../components/PaperOrderForm/PaperOrderForm.jsx';
import PaperOrderPaymentForm from '../components/PaperOrderForm/PaperOrderPaymentForm.jsx';
import PaperOrderDeliveryForm from '../components/PaperOrderForm/PaperOrderDeliveryForm.jsx';
import PaperOrderProductsForm from '../components/PaperOrderForm/PaperOrderProductsForm.jsx';

import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

import * as StateLexiconAction from 'actions/StateLexiconAction.js';

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
		category_id: 1,
		cart: [],
		deliveryDefault: 0,
		completed: 100,
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
		let {data} = this.state; 
		let value = new Date();
		let date = value.toISOString().split('T')[0];
		let time = value.toLocaleTimeString();
		data['created_at'] = date +' '+ time;
		this.setState({ data });
		this.setState({ completed: 100});

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
	 * Request for adding new product
	 * @param {Object} e
	 */
	orderPostRequest = e => {
		let { cart,  data } = this.state;

		this.setState({ 
			completed: 0 
		});

		let infoFields = ['p_first_name', 'p_last_name', 'p_email', 'p_phone', 'p_city', 'p_state', 'p_address', 'd_first_name', 'd_last_name', 'd_waybill', 'd_email', 'd_phone', 'd_city', 'd_state', 'd_address', 'd_passport', 'd_office', 'd_zendesk', 'd_warranty'];
		
		infoFields.forEach((f) => {
			let v = document.getElementById(f).value;
			data[f] = v;
		}) 

		//console.log(cart);
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
							var a = document.getElementById('change-page');
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
			deliveryDefault,
			resultDialog,
			resultDialogTitle,
			resultDialogMessage,
		} = this.state;

		if (this.state.langLoaded === false) 
			return <div className="create-page__container">
				<LinearProgress color="secondary" variant="determinate" value={0} />
			</div>

		return <div className="order__container">
				{completed === 0 && 
					<LinearProgress color="secondary" variant="determinate" value={completed} />}

				<Header
					title={this.props.lexicon.create_new_order} />
				<Menu />

				<TopTitle

					addButtonTitle={this.props.lexicon.add_label}
					saveButtonTitle={this.props.lexicon.save_label}
					trashButtonTitle={this.props.lexicon.empty_trash_label}
					duplicateButtonTitle={this.props.lexicon.duplicate_label}
					deleteButtonTitle={this.props.lexicon.delete_button}
					recoveryButtonTitle={this.props.lexicon.recovery_button}
					deleteButtonTitle={this.props.lexicon.delete_selected_button}

					title={this.props.lexicon.new_order}
					onSaveButtonClicked={() => this.orderPostRequest()} />
					
				<TabOptions
					defaultValue={tab}
					onTabButtonClicked={tab => this.setState({ tab })}
					data={[
						this.props.lexicon.general_details_tab,
						this.props.lexicon.payment_details_tab,
						this.props.lexicon.delivery_details_tab,
						this.props.lexicon.products_tab,
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
								data['context_id'] = value;
								this.setState({ data });
							}}

							onActiveChanged={
								value => {
									data['send'] = value;
									this.setState({ data });
                                }
							}
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
							countryDefaultValue={data['p_country']}
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
							onCartChanged={c => {
								this.setState({cart: c})
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
					id="change-page" 
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

export default connect(mapStateToProps, mapDispatchToProps)(withStyles(styles)(CreateOrderContainers));