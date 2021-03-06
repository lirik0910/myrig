/**
 * Select page module
 * @module PriceField
 * @author Ihor Bielchenko
 * @requires react
 */

import React, { Component } from 'react';

import { connect } from 'react-redux';

import Add from 'material-ui-icons/Add';
import Grid from 'material-ui/Grid';
import Button from 'material-ui/Button';
import Paper from 'material-ui/Paper';
import { FormControl } from 'material-ui/Form';
import Input, { InputLabel } from 'material-ui/Input';
import Delete from 'material-ui-icons/Delete';
import InputLink from '../FormControl/InputLink/InputLink.jsx';
import InputNumber from '../FormControl/InputNumber/InputNumber.jsx';
import SelectContext from '../FormControl/SelectContext/SelectContext.jsx';
import SelectView from '../FormControl/SelectView/SelectView.jsx';
import InputSelectPage from '../FormControl/InputSelectPage/InputSelectPage.jsx';
import InputDatePicker from '../FormControl/InputDatePicker/InputDatePicker.jsx';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Component for selecting page
 * @extends Component
 */
class PaperOrderProductForm extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		createDefaultValue: new Date(),
	
		onItemRemoved: () => {},
		onItemChanged: () => {},
		classes: PropTypes.object.isRequired,
		data: {}
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { 
			flag,
			classes,
			linkDefaultValue,
			viewDefaultValue,
			parentDefaultValue,
			createDefaultValue,
			contextDefaultValue,	
			data,
			key
		} = this.props;

		return <Paper className={classes.paper}>
			<div className={classes.right} >
				<Button 
					onClick={e => {
						this.props.onItemRemoved(key)
					}}
					className={classes.button} 
					variant="raised">
						<Delete className={classes.leftIcon} />
						{this.props.lexicon.delete_button}
				</Button>
			</div>

			<p>{data.title} / <span className={classes.costItem}>Price: {data.price}</span></p>
			<Grid container 
				spacing={24} 
				className={classes.root}>
				<Grid item xs={6}>

					<InputNumber
						title={this.props.lexicon.count_label}
						defaultValue={1}
						value={data.count}
						onFieldInputed={(num) => {
							data['count'] = num;
							this.props.onItemChanged(data, key)
						}}
					/>
				</Grid>
				<Grid item xs={6}>
					<InputNumber
						title="Discount"
						defaultValue={0}
						value={data.discount}
						onFieldInputed={(num) => {
							data['discount'] = num;
							this.props.onItemChanged(data, key)
						}}
					/>
				</Grid>
			</Grid>
			<FormControl fullWidth className={classes.formControl}>
				<InputLabel htmlFor={"serial_number"}>
					{this.props.lexicon.serial_number}
				</InputLabel>
				<Input
					id="serial_number"
					name="serial_number"
					value={data.serial_number}
					onChange={(e) => {
						data['serial_number'] = e.target.value;
						this.props.onItemChanged(data, key)

					}} />
        	</FormControl>

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
		lexicon: state.lexicon
	}
}

export default connect(mapStateToProps)(withStyles(styles)(PaperOrderProductForm));