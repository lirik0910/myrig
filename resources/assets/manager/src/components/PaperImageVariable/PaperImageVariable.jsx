/**
 * Select page module
 * @module PriceField
 * @author Ihor Bielchenko
 * @requires react
 */

import React, { Component } from 'react';

import Paper from 'material-ui/Paper';
import Button from 'material-ui/Button';
import Typography from 'material-ui/Typography';
import { FormControl, FormHelperText  } from 'material-ui/Form';
import ImageFieldItem from './ImageFieldItem/ImageFieldItem.jsx';

import AddIcon from 'material-ui-icons/Add';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Component for selecting page
 * @extends Component
 */
class PaperImageVariable extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		data: [],
		title: 'Images',
		onImageSet: () => {},
		onAddedField: () => {},
		onDeletedField: () => {},
		classes: PropTypes.object.isRequired,
	}

	/**
	 * State object of component
	 * @type {Object} 
	 * @inner
	 */
	state = {
		completed: true,
	}

	/**
	 * Add field
	 * @param {Object} e
	 */
	handleAddField = e => {
		let { data } = this.props;

		data.push({
			id: Date.now(),
			name: ''
		});

		this.props.onAddedField(data);
	}

	/** 
	 * Delete field
	 * @param {Object} field Current field
	 */
	handleDeleteField = field => {
		let { data } = this.props;
		var i;

		this.setState({ completed: false }, () => {
			for (i in data) {
				if (data[i].id === field.id) {
					data.splice(i, 1);
					break;
				}
			}

			this.setState({ completed: true }, () => {
				this.props.onDeletedField(data);
			});
		});
	}

	/**
	 * Write new field value in state
	 * @param {String} value
	 * @param {Object} frield
	 */
	handleFieldValue = (value, field) => {
		let { data } = this.props;
		var i;

		for (i in data) {
			if (data[i].id === field.id) {
				data[i].name = value;
				break;
			}
		}
		
		this.props.onImageSet(data);
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { classes, title, data } = this.props;
		let { completed } = this.state;

		return <Paper className={classes.paper}>
				<Typography className={classes.title}>
					{title}
				</Typography>

				{completed === true && <FormControl className={classes.formControl}>
					{data.map((item, i) => {
						return <ImageFieldItem 
							key={i}
							data={item}
							remove={true}
							onImageSet={field => {
								for (var i in data) {
									if (field.id === data[i].id) {
										data[i] = field;
										break;
									}
								}
								this.props.onImageSet(data);
							}}
							onFieldInputed={(value, field) => this.handleFieldValue(value, field)}
							onDeletedField={field => this.handleDeleteField(field)} />
					})}

					<FormHelperText>
						<Button 
							variant="fab" 
							color="primary" 
							aria-label="add" 
							className={classes.button}
							onClick={this.handleAddField}>
								<AddIcon />
								{'Add field'}
						</Button>
					</FormHelperText>
				</FormControl>}
			</Paper>
	}
}

export default withStyles(styles)(PaperImageVariable);