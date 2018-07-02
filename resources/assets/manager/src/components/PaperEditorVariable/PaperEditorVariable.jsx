/**
 * Select page module
 * @module PriceField
 * @author Ihor Bielchenko
 * @requires react
 */

import React, { Component } from 'react';

import { connect } from 'react-redux';

import Paper from 'material-ui/Paper';
import Button from 'material-ui/Button';
import Typography from 'material-ui/Typography';
import { FormControl, FormHelperText  } from 'material-ui/Form';
import InputFieldItem from './InputFieldItem/InputFieldItem.jsx';

import AddIcon from 'material-ui-icons/Add';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Component for selecting page
 * @extends Component
 */
class PaperEditorVariable extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		title: 'Input',
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
		data: [{
			id: 1,
			content: 'test'
		}, {
			id: 2,
			content: 'test2'
		}],
	}

	/**
	 * Invoked just before mounting occurs
	 * @fires componentWillMount
	 */
	componentWillMount() {
	}

	/**
	 * Add field
	 * @param {Object} e
	 */
	handleAddField = e => {
		let { data } = this.state;

		data.push({
			id: Date.now(),
			content: ''
		});

		this.setState({ data }, () => {
			this.props.onAddedField(data);
		});
	}

	/** 
	 * Delete field
	 * @param {Object} field Current field
	 */
	handleDeleteField = field => {
		let { data } = this.state;
		var i;

		this.setState({ completed: false }, () => {
			for (i in data) {
				if (data[i].id === field.id) {
					data.splice(i, 1);
					break;
				}
			}

			this.setState({ data, completed: true }, () => {
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
		let { data } = this.state;
		var i;

		for (i in data) {
			if (data[i].id === field.id) {
				data[i].content = value;
				break;
			}
		}

		this.setState({ data });
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { classes, title} = this.props;
		let { data, completed } = this.state;

		return <Paper className={classes.paper}>
				<Typography className={classes.title}>
					{title}
				</Typography>

				{completed === true && <FormControl className={classes.formControl}>
					{data.map((item, i) => {
						return <InputFieldItem 
							key={i}
							data={item}
							placeholder={this.props.lexicon.input_text_label}
							onFieldInputed={(value, field) => this.handleFieldValue(value, field)}
							onDeletedField={(field) => this.handleDeleteField(field)} />
					})}

					<FormHelperText>
						<Button 
							variant="fab" 
							color="primary" 
							aria-label="add" 
							className={classes.button}
							onClick={this.handleAddField}>
								<AddIcon />
								{this.props.lexicon.add_field_label}
						</Button>
					</FormHelperText>
				</FormControl>}
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

export default connect(mapStateToProps)(withStyles(styles)(PaperEditorVariable));