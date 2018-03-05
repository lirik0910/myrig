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
import PaperContentForm from '../components/PaperContentForm/PaperContentForm.jsx';
import PaperProductForm from '../components/PaperProductForm/PaperProductForm.jsx';
import PaperImageVariable from '../components/PaperImageVariable/PaperImageVariable.jsx';
import PaperOptionVariable from '../components/PaperOptionVariable/PaperOptionVariable.jsx';

import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Users base container
 * @extends Component
 */
class CreateProductContainers extends Component {

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
		productID: 0,
		completed: 100,
		resultDialog: false,
		resultDialogTitle: '',
		resultDialogMessage: ''
	}

	/**
	 * Request for adding new product
	 * @param {Object} e
	 */
	productPostRequest = e => {
		let { data } = this.state;

		this.setState({ 
			completed: 0 
		});

		App.api({
			type: 'POST',
			name: 'create',
			model: 'product',
			data,
			success: (r) => {
				r = JSON.parse(r.response);
				if (r) {
					this.setState({ 
						productID: r.id,
						completed: 100,
						resultDialog: true,
						resultDialogTitle: 'Success',
						resultDialogMessage: 'The request was successful'
					}, () => {
						setTimeout(() => {
							var a = document.getElementById('product-edit');
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
			tab, 
			data, 
			completed,
			productID,
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
					
				<TopTitle
					onSaveButtonClicked={() => this.productPostRequest()} />
					
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
						<PaperContentForm
							onEditorAreaInputed={value => {
								data['description'] = value;
								this.setState({ data });
							}}
							onTitleFieldInputed={value => {
								data['title'] = value;
								this.setState({ data });
							}} />

						<PaperImageVariable
							onImageSet={images => {
								data['images'] = JSON.stringify(images);
								this.setState({ data });
							}}
							onAddedField={images => {
								data['images'] = JSON.stringify(images);
								this.setState({ data });
							}}
							onDeletedField={images => {
								data['images'] = JSON.stringify(images);
								this.setState({ data });
							}} />
					</Grid>

					<Grid item xs={3}>
						<PaperProductForm
							onPageSelected={value => {
								data['page_id'] = value;
								this.setState({ data });
							}}
							onContextSelected={value => {
								data['context_id'] = value;
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
							}} />
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
							onVariableUpdated={fields => {
								data['options'] = JSON.stringify(fields);
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

				<Link 
					id="product-edit" 
					to={App.name() + '/products/'+ productID} 
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

export default withStyles(styles)(CreateProductContainers);