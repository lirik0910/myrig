/**
 * InputNumberDefault module
 * @requires react
 * @requires react#PureComponent
 */

import React, { PureComponent } from 'react';

import TextField from '@material-ui/core/TextField';

/**
 * InputNumberDefault block
 * @extends PureComponent
 */
class InputNumberDefault extends PureComponent {

	/**
	 * Default properties
	 * @type {object}
	 */
	static defaultProps = {
		label: null,
		defaultValue: 0,
		floatInput: false,
		handleFieldChanged: () => {}
	}

	/**
	 * Get value that inputed to field
	 * @fires input
	 * @param {Object} e
	 */
	handleInputField = (e) => {
		if (this.props.floatInput === true) {
			e.target.value = e.target.value.replace(/[^\d.]/g, '');
		}
		else e.target.value = e.target.value.replace(/[^\d]/g, '');
		
		this.props.handleFieldChanged(e.target.value);
	}

	/**
	 * Render component
	 * @return {object} jsx object
	 */
	render() {
		let { label, floatInput, handleFieldChanged, ...other } = this.props;

		return <TextField
			label={label}
			onChange={this.handleInputField}
			onBlur={(e) => {
				if (e.target.value === '') {
					e.target.value = 0;
					handleFieldChanged(e.target.value);
				}
			}}
			{...other} />
	}
}

export default InputNumberDefault;