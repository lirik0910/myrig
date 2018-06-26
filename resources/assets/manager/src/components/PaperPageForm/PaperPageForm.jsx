/**
 * Select page module
 * @module PriceField
 * @author Ihor Bielchenko
 * @requires react
 */

import React, { Component } from 'react';

import { connect } from 'react-redux';

import Paper from 'material-ui/Paper';
import InputLink from '../FormControl/InputLink/InputLink.jsx';
import SelectContext from '../FormControl/SelectContext/SelectContext.jsx';
import SelectView from '../FormControl/SelectView/SelectView.jsx';
import InputSelectPage from '../FormControl/InputSelectPage/InputSelectPage.jsx';
import InputPublishedDate from '../FormControl/InputPublishedDate/InputPublishedDate.jsx';
import InputDatePicker from '../FormControl/InputDatePicker/InputDatePicker.jsx';
import CheckboxActive from '../FormControl/CheckboxActive/CheckboxActive.jsx';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Component for selecting page
 * @extends Component
 */
class PaperPageForm extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		flag: true,
		parentDefaultValue: null,
		viewDefaultValue: 0,
		linkDefaultValue: '',
		contextDefaultValue: 0,
		createDefaultValue: new Date(),
		publishedAtDefaultValue: 0,
		onLinkInputed: () => {},
		onDateSelected: () => {},
		onViewSelected: () => {},
		onParentSelected: () => {},
		onContextSelected: () => {},
		onPublishedChanged: () => {},
		classes: PropTypes.object.isRequired,
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { 
			flag,
			classes,
			linkDefaultValue,
			viewDefaultValue,
			parentDefaultValue,
			createDefaultValue,
			contextDefaultValue,
			publishedDefaultValue,
			publishedAtDefaultValue
		} = this.props;

		return <Paper className={classes.paper}>
				<SelectContext
					title={this.props.lexicon.select_context_label}
					defaultValue={contextDefaultValue}
					onItemSelected={value => this.props.onContextSelected(value)} />

				<SelectView
					title={this.props.lexicon.select_view_label}
					defaultValue={Number(viewDefaultValue)}
					onItemSelected={value => this.props.onViewSelected(value)} />

				<InputSelectPage
					title={this.props.lexicon.parent_select_label}
					defaultValue={parentDefaultValue}
					placeholder={this.props.lexicon.input_parent_page_label}
					onItemSelected={value => this.props.onParentSelected(value)} />

				{flag === true && <InputLink
					title={this.props.lexicon.page_link_label}
					defaultValue={linkDefaultValue}
					onFieldInputed={value => this.props.onLinkInputed(value)} />}

				<InputDatePicker
					title={this.props.lexicon.created_date_label}
					defaultValue={createDefaultValue}
					onDateFieldChanged={value => this.props.onDateSelected(value)} />
				{publishedAtDefaultValue ? <InputPublishedDate
                    title={this.props.lexicon.publish_date_label}
                    defaultValue={publishedAtDefaultValue}
                    disabled={true}/> : null}
				<CheckboxActive
					title={this.props.lexicon.published_label}
					defaultValue={publishedDefaultValue}
					onCheckboxValueChanged={value => this.props.onPublishedChanged(value)} />
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

export default connect(mapStateToProps)(withStyles(styles)(PaperPageForm));