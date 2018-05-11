/**
 * Select page module
 * @module PriceField
 * @author Ihor Bielchenko
 * @requires react
 */

import App from '../../../App.js';
import React, { Component } from 'react';

import Button from 'material-ui/Button';
import TextField from 'material-ui/TextField';
import DialogFileManager from '../../DialogFileManager/DialogFileManager.jsx';

import Delete from 'material-ui-icons/Delete';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Component for selecting page
 * @extends Component
 */
class ImageFieldItem extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		data: {},
		placeholder: 'Image URL',
		onImageSet: () => {},
		onDeletedField: () => {},
		onFieldInputed: () => {},
		classes: PropTypes.object.isRequired,
	}

	state = {
		open: false,
		ready: true,
		remove: true,
		value: this.props.data
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { open, value, ready } = this.state;
		let { classes, data, placeholder, remove } = this.props;

		return <div>
				{ready === true && <TextField
					type="text"
					placeholder={placeholder}
					defaultValue={value.name}
					onChange={e => {
						this.props.onFieldInputed(e.target.value, data);
					}}
					onClick={e => this.setState({ open: true })}
					InputLabelProps={{
						shrink: true
					}}
					style={{
						width: '100%'
					}}
					{...this.props} />}

				{value.name && 
					<img src={App.uploads() +'/'+ value.name} 
						alt="img"
						className={classes.img} />}
			
				{remove === true && <Button 
					className={classes.button} 
					variant="raised" 
					color="secondary"
					onClick={e => this.props.onDeletedField(data)}>
						<Delete />{'Remove field'}
				</Button>}

				<DialogFileManager
					open={open}
					onDialogClosed={() => this.setState({
						open: false
					})}
					onFileSelected={data => {
						value.name = data.link;
						this.setState({ ready: false }, () => {
							this.setState({ 
								value,
								open: false,
								ready: true
							}, () => this.props.onImageSet(value));
						});
					}} />
			</div>
	}
}

export default withStyles(styles)(ImageFieldItem);