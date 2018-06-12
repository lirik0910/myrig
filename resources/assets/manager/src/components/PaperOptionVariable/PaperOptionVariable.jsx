/**
 * Select page module
 * @module PriceField
 * @author Ihor Bielchenko
 * @requires react
 */

import App from '../../App.js';
import React, { Component } from 'react';

import Paper from 'material-ui/Paper';
import Button from 'material-ui/Button';
import Typography from 'material-ui/Typography';
import { FormControl, FormHelperText  } from 'material-ui/Form';
import OptionFieldItem from './OptionFieldItem/OptionFieldItem.jsx';

import AddIcon from 'material-ui-icons/Add';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Component for selecting page
 * @extends Component
 */
class PaperOptionVariable extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		data: [],
		title: 'Input',
		onVariableUpdated: () => {},
		classes: PropTypes.object.isRequired,
	}

	/**
	 * State object of component
	 * @type {Object} 
	 * @inner
	 */
	state = {
		options: [],
		completed: true,
	}

	/**
	 * Invoked just before mounting occurs
	 * @fires componentWillMount
	 */
	componentWillMount() {
		this.setState({ 
			completed: false,
		}, () => {
			this.optionsDataGetRequest(data => {
				this.setState({
					completed: true
				});
			});
		});
	}

	/**
	 * Get policy array from server
	 * @param {Function} callback
	 */
	optionsDataGetRequest(callback = () => {}) {
		App.api({
			type: 'GET',
			name: 'options',
			model: 'product',
			success: (r) => {
				r = JSON.parse(r.response);
				if (r) {
					this.setState({ options: r }, () => callback(r));
				}
			}
		});
	}

	/**
	 * Add field
	 * @param {Object} e
	 */
	handleAddField = e => {
		let { data } = this.props;

		data.push({
			id: Date.now(),
			value: ''
		});

		this.props.onVariableUpdated(data);
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
				this.props.onVariableUpdated(data);
			});
		});
	}

	/**
	 * Write new field name in state
	 * @param {String} value
	 * @param {Object} frield
	 */
	handleNameFieldValue = (value, field) => {
		let { data } = this.props;
		var i;

		for (i in data) {
			if (data[i].id === field.id) {
				data[i].name = value;
				break;
			}
		}

		this.props.onVariableUpdated(data);
	}

	/**
	 * Write new field value in state
	 * @param {String} value
	 * @param {Object} frield
	 */
	handleValueFieldValue = (value, field) => {
		let { data } = this.props;
		var i;

		for (i in data) {
			if (data[i].id === field.id) {
				data[i].value = value;
				break;
			}
		}

		this.props.onVariableUpdated(data);
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { classes, title, data } = this.props;
		let { completed, options } = this.state;

		return <Paper className={classes.paper}>
				<Typography className={classes.title}>
					{title}
				</Typography>

				{completed === true && <FormControl className={classes.formControl}>
					{data.map((item, i) => {
						return <OptionFieldItem 
							key={i}
							data={item}
							options={options}
							onDeletedField={(field) => this.handleDeleteField(field)}
							onFieldNameInputed={(value, field) => {
								this.handleNameFieldValue(value, field)
							}}
							onFieldValueInputed={(value, field) => {
								this.handleValueFieldValue(value, field)}
							}
							onFieldTypeSelected={value => {
								data[i].type_id = value;
								this.setState({ data }, () => this.props.onVariableUpdated(data));
							}} />
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

export default withStyles(styles)(PaperOptionVariable);