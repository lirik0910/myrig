/**
 * Select page module
 * @module PriceField
 * @author Ihor Bielchenko
 * @requires react
 */

import React, { Component } from 'react';

import Button from 'material-ui/Button';
import TextField from 'material-ui/TextField';

import Delete from 'material-ui-icons/Delete';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Component for selecting page
 * @extends Component
 */
class OptionFieldItem extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		data: {},
		nameLabel: 'Name',
		valueLabel: 'Value',
		namePlaceholder: 'Input name',
		valuePlaceholder: 'Input value',
		onImageSet: () => {},
		onDeletedField: () => {},
		onFieldNameInputed: () => {},
		onFieldValueInputed: () => {},
		classes: PropTypes.object.isRequired,
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { 
			data,
			classes, 
			nameLabel, 
			valueLabel, 
			namePlaceholder, 
			valuePlaceholder 
		} = this.props;

		return <div>
				<TextField
					type="text"
					label={nameLabel}
					defaultValue={data.name}
					placeholder={namePlaceholder}
					onChange={e => {
						this.props.onFieldNameInputed(e.target.value, data);
					}}
					InputLabelProps={{
						shrink: true
					}}
					style={{
						width: '100%'
					}} />

				<TextField
					type="text"
					label={valueLabel}
					defaultValue={data.value}
					placeholder={valuePlaceholder}
					onChange={e => {
						this.props.onFieldValueInputed(e.target.value, data);
					}}
					InputLabelProps={{
						shrink: true
					}}
					style={{
						width: '100%'
					}} />
			
				<Button 
					className={classes.button} 
					variant="raised" 
					color="secondary"
					onClick={e => this.props.onDeletedField(data)}>
						<Delete />{'Remove field'}
				</Button>
			</div>
	}
}

export default withStyles(styles)(OptionFieldItem);