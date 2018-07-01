/**
 * InputMultiSelectDefault module
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
import Chip from '@material-ui/core/Chip';

import styles from './styles.js';
import { withStyles } from '@material-ui/core/styles';

/**
 * InputMultiSelectDefault block
 * @extends PureComponent
 */
class InputMultiSelectDefault extends PureComponent {
	
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
		data: [],
		label: null,
		field: 'title',
		defaultValue: '',
		placeholder: 'placeholderInputMultiSelect',
		id: 'placeholder-input-multi-select',
		onInputChanged: (e, items) => {},
	}

	/**
	 * Current component state object
	 * @type {object}
	 * @property {string} inputValue
	 * @property {array} selectedItem
	 */
	state = {
		inputValue: '',
		selectedItem: []
	}

	/**
	 * Get a list of items
	 * @fires onInput
	 * @param {string} inputValue
	 */
	getSuggestions(inputValue) {
		let count = 0,
			{ field, data } = this.props;

		return data.filter((item) => {
			const keep = 
				(!inputValue || 
					item[field].toLowerCase().indexOf(inputValue.toLowerCase()) !== -1) && 
				count < 5;

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
		this.setState({ inputValue: e.target.value });
	}

	/**
	 * Change item
	 * @fires onChange
	 * @param {string} onChange
	 */
	handleChange = (item) => {
		let { selectedItem } = this.state;

		if (selectedItem.indexOf(item) === -1) {
			selectedItem = [...selectedItem, item];
		}

		this.setState({
			inputValue: '',
			selectedItem
		}, () => this.props.onInputChanged(item, selectedItem));
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
			{ inputValue, selectedItem } = this.state;

		return <Downshift 
			inputValue={inputValue} 
			onChange={this.handleChange} 
			selectedItem={selectedItem}>

			{({
				getInputProps,
				getItemProps,
				isOpen,
				inputValue: inputValue2,
				selectedItem: selectedItem2,
				highlightedIndex
			}) => <div className={classes.container}>
				<TextField
					label={label}
					InputProps={{
						classes: {
							root: classes.inputRoot,
						},
						...getInputProps({
							startAdornment: selectedItem.map((item) => <Chip
								key={item}
								tabIndex={-1}
								label={item}
								color="primary"
								className={classes.chip}
								onDelete={this.handleDelete(item)} />),
							onChange: this.handleInputChange,
							onKeyDown: this.handleKeyDown,
							placeholder: langs[placeholder],
							id
						})
					}}
					fullWidth={true}
					onInput={this.props.onInputChanged} />

				{isOpen ? <Paper className={classes.paper} square>
					{this.getSuggestions(inputValue2).map((suggestion, index) => {
						let isHighlighted = highlightedIndex === index,
							isSelected = (selectedItem || '').indexOf(suggestion[field]) > -1;

						return <MenuItem
							{...getItemProps({ item: suggestion[field] })}
							key={suggestion[field]}
							selected={isHighlighted}
							component="div"
							style={{
								fontWeight: isSelected ? 500 : 400
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

export default connect(mapStateToProps)(withStyles(styles)(InputMultiSelectDefault));