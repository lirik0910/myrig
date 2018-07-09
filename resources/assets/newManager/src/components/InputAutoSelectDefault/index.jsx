/**
 * InputAutoSelectDefault module
 * @requires react
 * @requires react#PureComponent
 * @requires prop-types
 * @requires keycode
 * @requires downshift
 * @requires @material-ui/core/TextField
 * @requires @material-ui/core/Paper
 * @requires @material-ui/core/MenuItem
 * @requires @material-ui/core/Chip
 * @requires @material-ui/core/styles
 */

import React, { PureComponent } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import keycode from 'keycode';
import Downshift from 'downshift';
import TextField from '@material-ui/core/TextField';
import Paper from '@material-ui/core/Paper';
import MenuItem from '@material-ui/core/MenuItem';

import styles from './styles.js';
import { withStyles } from '@material-ui/core/styles';

/**
 * InputAutoSelectDefault block
 * @extends PureComponent
 */
class InputAutoSelectDefault extends PureComponent {
	menuItems = {};

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
	 * @property {string} label
	 * @property {string} title
	 * @property {string} defaultValue
	 * @property {string} placeholder
	 * @property {string} id
	 * @property {function} onInputChanged
	 */
	static defaultProps = {
		name: 'inputMultiSelect',
		data: [],
		label: null,
		field: 'title',
		fieldValue: 'id',
		defaultValue: '',
		inputedValue: null,
		placeholder: 'placeholderInputMultiSelect',
		id: 'placeholder-input-auto-select',
		onInputChanged: (value, item) => {}
	}

	/**
	 * Current component state object
	 * @type {object}
	 * @property {string} inputValue
	 * @property {array} selectedItem
	 */
	state = {
		inputValue: String(this.props.defaultValue),
		selectedItem: []
	}

	/**
	 * Get a list of items
	 * @fires onInput
	 * @param {string} inputValue
	 */
	getSuggestions(inputValue) {
		let count = 0,
			{ field, data, inputedValue } = this.props;

		return data.filter((item) => {
			let query = inputedValue === null ? item[field] : inputedValue;
			const keep = 
				(!inputValue || 
					String(query).toLowerCase().indexOf(inputValue.toLowerCase()) !== -1) && 
				count < 20;

			if (keep) {
				count += 1;
			}

			return keep;
		});
	}

	/**
	 * Clear item
	 * @fires onKeyDown
	 * @param {Object} e
	 */
	handleKeyDown = (e) => {
		let { inputValue, selectedItem } = this.state;

		if (selectedItem.length && !inputValue.length && keycode(e) === 'backspace') {
			this.setState({
				selectedItem: selectedItem.slice(0, selectedItem.length - 1)
			});
		}
	}

	/**
	 * Get current input value
	 * @fires onChange
	 * @param {Object} e
	 */
	handleInputChange = (e) => {
		let target = e.target;

		this.setState({ inputValue: target.value }, () => {
			this.props.onInputChanged(target.value);
		});
	}

	/**
	 * Select item
	 * @fires onChange
	 * @param {string} onChange
	 */
	handleSelect = (item, menu) => {
		this.setState({
			inputValue: item
		}, () => this.props.onInputChanged(item, this.menuItems[item]));
	}

	/**
	 * Delete item
	 * @fires onDelete
	 * @param {string} item
	 */
	handleDelete = (item) => () => {
		let selectedItem = [...this.state.selectedItem];
		selectedItem.splice(selectedItem.indexOf(item), 1);

		this.setState({ selectedItem });
	}

	/**
	 * Render component
	 * @return {object} jsx object
	 */
	render() {
		let { classes, placeholder, id, field, label, langs } = this.props,
			{ inputValue } = this.state;

		return <Downshift 
			inputValue={inputValue}
			onChange={this.handleSelect}>

			{({
				getInputProps, 
				getItemProps, 
				isOpen, 
				inputValue, 
				selectedItem, 
				highlightedIndex 
			}) => <div className={classes.container}>
				<TextField
					onInput={this.handleInputChange}
					label={langs[label]}
					InputProps={{
						classes: {
							root: classes.inputRoot,
						},
						...getInputProps({
							placeholder: langs[placeholder],
							id
						})
					}}
					fullWidth={true} />

				{isOpen ? <Paper className={classes.paper} square>
					{this.getSuggestions(inputValue).map((suggestion, index) => {
						let isHighlighted = highlightedIndex === index,
							isSelected = (selectedItem || '').indexOf(suggestion[field]) > -1;

						return <MenuItem
							{...getItemProps({ 
								item: suggestion[field]
							})}
							ref={(node) => this.menuItems[suggestion[field]] = suggestion}
							val={'dqwokfo'}
							key={suggestion[field]}
							selected={isHighlighted}
							component="div"
							style={{
								fontWeight: isSelected ? 
									500 : 
									400
							}}>

							{suggestion[field]}
						</MenuItem>
					})}
				</Paper> : null}
			</div>}
		</Downshift>
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

export default connect(mapStateToProps)(withStyles(styles)(InputAutoSelectDefault));