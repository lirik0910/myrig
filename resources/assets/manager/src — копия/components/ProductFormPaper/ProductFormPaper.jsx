/**
 * Select page module
 * @module PriceField
 * @author Ihor Bielchenko
 * @requires react
 */

import React, { Component } from 'react';

import Paper from 'material-ui/Paper';
import PriceField from '../PriceField/PriceField.jsx';
import ContextSelect from '../ContextSelect/ContextSelect.jsx';
import PageInputSelect from '../PageInputSelect/PageInputSelect.jsx';

import Button from 'material-ui/Button';
import Typography from 'material-ui/Typography';
import { FormControl, FormHelperText, FormControlLabel  } from 'material-ui/Form';
import Input, { InputLabel } from 'material-ui/Input';
import TextField from 'material-ui/TextField';
import Checkbox from 'material-ui/Checkbox';

import AddIcon from 'material-ui-icons/Add';
import Delete from 'material-ui-icons/Delete';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';
import 'react-draft-wysiwyg/dist/react-draft-wysiwyg.css';

/**
 * Component for selecting page
 * @extends Component
 */
class ProductFormPaper extends Component {

	/**
	 * State object of component
	 * @type {Object} 
	 * @inner
	 * @property {Object} data Component data
	 * @property {Number} defaultValue Component data
	 */
	state = {
		data: [],
		activeChecked: true,
	}

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		title: 'Images',
		classes: PropTypes.object.isRequired,
		onSetImage: () => {},
		onAddedField: () => {},
		onDeletedField: () => {},
	}

	handleChange = name => event => {
		this.setState({ [name]: event.target.checked });
	};

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { classes, title } = this.props;
		let { activeChecked } = this.state;

		return <Paper className={classes.paper}>
				<ContextSelect />

				<PageInputSelect
					title={'Page select'}
					placeholder={'Input page link for current product'}
					onItemSelected={value => console.log(value)} />

				<PriceField />

				<TextField
					id="created_at"
					label={'Publish date'}
					type="date"
					name="created_at"
					defaultValue={''}
					className={classes.textField}
					InputLabelProps={{
						shrink: true,
					}} />

				<FormControlLabel
					control={
						<Checkbox
							checked={activeChecked}
							onChange={this.handleChange('activeChecked')}
							value="active"
							color="primary" />
					}
					label="Active" />
			</Paper>
	}
}

export default withStyles(styles)(ProductFormPaper);