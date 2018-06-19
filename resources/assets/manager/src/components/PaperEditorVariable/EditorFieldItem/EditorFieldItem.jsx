/**
 * Select page module
 * @module PriceField
 * @author Ihor Bielchenko
 * @requires react
 */

import React, { Component } from 'react';

import { connect } from 'react-redux';

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
class EditorFieldItem extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		data: {},
		placeholder: 'Input text',
		onImageSet: () => {},
		onDeletedField: () => {},
		onFieldInputed: () => {},
		classes: PropTypes.object.isRequired,
	}

	/** 
	 *
	 */
	componentDidMount() {
		let img = document.getElementsByClassName('rdw-image-wrapper');
		console.log(img)
		if (img[0]) {
			console.log(img)
		}
		this.openImageField();
	}

	/**
	 * Open select image paper
	 */
	openImageField() {

	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { classes, data, placeholder } = this.props;

		return <div>
				<TextField
					type="text"
					placeholder={placeholder}
					defaultValue={data.content}
					onChange={e => {
						this.props.onFieldInputed(e.target.value, data);
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
						<Delete />{this.props.lexicon.remove_field_label}
				</Button>
			</div>
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

export default connect(mapStateToProps)(withStyles(styles)(EditorFieldItem));