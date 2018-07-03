/**
 * SelectDefault module
 * @requires react
 * @requires react#PureComponent
 * @requires prop-types
 * @requires @material-ui/core/Input
 * @requires @material-ui/core/MenuItem
 * @requires @material-ui/core/FormHelperText
 * @requires @material-ui/core/FormControl
 * @requires @material-ui/core/Select
 * @requires @material-ui/core/InputLabel
 * @requires @material-ui/core/styles#withStyles
 */

import React, { PureComponent } from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';

import Input from '@material-ui/core/Input';
import MenuItem from '@material-ui/core/MenuItem';
import FormHelperText from '@material-ui/core/FormHelperText';
import FormControl from '@material-ui/core/FormControl';
import Select from '@material-ui/core/Select';
import InputLabel from '@material-ui/core/InputLabel';

import styles from './styles.js';
import { withStyles } from '@material-ui/core/styles';

/**
 * SelectDefault block
 * @extends PureComponent
 */
class SelectDefault extends PureComponent {
	
	/**
	 * Props validators
	 * @type {object}
	 * @property {function} classes
	 */
	static propTypes = {
		classes: PropTypes.object.isRequired
	}

	/**
	 * Default properties
	 * @type {object}
	 * @property {array} data
	 * @property {string} value
	 * @property {string} field
	 * @property {string} defaultValue
	 * @property {string} name
	 * @property {string} id
	 * @property {string} helperText
	 * @property {string} title
	 * @property {function} onItemChanged
	 */
	static defaultProps = {
		none: false,
		data: [],
		value: 'id',
		field: 'title',
		defaultValue: '',
		name: 'defaultSelect',
		id: 'defautl-select',
		formId: '',
		helperText: 'helperSelectDefaultText',
		title: 'filterSelectDefaultTitle',
		onItemChanged: (e, value) => {}
	}

	/**
	 * Current component state object
	 * @type {object}
	 * @property {string} [this.props.name] Select name
	 */
	state = {
		[this.props.name]: this.props.defaultValue
	}

	/**
	 * Change current value
	 * @fires onChange
	 * @param {object} e
	 */
	handleChange = (e) => {
		let { data } = this.props;
		this.setState({ [e.target.name]: e.target.value }, () => {
			this.props.onItemChanged(e, e.target.value, data);
		});
	}

	/**
	 * Render component
	 * @return {object} jsx object
	 */
	render() {
		let { classes, name, id, helperText, data, field, value, title, none, langs, formId } = this.props;

		return <FormControl id={formId} className={classes.formControl}>
			{title && <InputLabel 
				htmlFor="age-helper"
				className={classes.helper}>{title}</InputLabel>}
			
			<Select
				value={this.state[name]}
				onChange={this.handleChange}
				input={<Input name={name} id={id} />}
				className={classes.helper}>

				{none === true && 
					<MenuItem 
						value={''}>
						<i>{langs['labelNoneSelected']}</i>
					</MenuItem>}

				{data.map((item, i) => {
					return <MenuItem 
						key={i}
						value={item[value]}>
						{item[field]}
					</MenuItem>
				})}
			</Select>

			{helperText && 
				<FormHelperText className={classes.helper}>
					{helperText}
				</FormHelperText>}
		</FormControl>
	}
}

/**
 * Init redux states
 * @param {Object} state
 * @return {Object}
 */
function mapStateToProps(state) {
	return {
		langs: state.langs
	}
}

export default connect(mapStateToProps)(withStyles(styles)(SelectDefault));