/**
 * Select page module
 * @module PriceField
 * @author Ihor Bielchenko
 * @requires react
 */

import React, { Component } from 'react';

import { connect } from 'react-redux';

import Dialog, {
	DialogActions,
	DialogContent,
	DialogTitle,
} from 'material-ui/Dialog';
import Button from 'material-ui/Button';
import TextField from 'material-ui/TextField';
import { FormControl } from 'material-ui/Form';
import Slide from 'material-ui/transitions/Slide';
import ImageFieldItem from '../../PaperImageVariable/ImageFieldItem/ImageFieldItem.jsx';
import EditorFieldItem from '../../PaperRichtextVariable/EditorFieldItem/EditorFieldItem.jsx';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Animate opening dialog
 * @param {Object} props
 * @return {Object} JSX object
 */
function Transition(props) {
	return <Slide direction="up" {...props} />;
}

/**
 * Component for selecting page
 * @extends Component
 */
class EditMultiItem extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		data: [],
		defaultValue: false,
		onDialogClosed: () => {},
		onDialogConfirmed: () => {},
		classes: PropTypes.object.isRequired,
	}

	state = {
		editDailogOpen: this.props.defaultValue,
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { classes, data, columns } = this.props;
		let { editDailogOpen } = this.state;

		return <Dialog
				open={editDailogOpen}
				transition={Transition}
				keepMounted
				aria-labelledby="edit-dialog-multi-title"
				aria-describedby="edit-dialog-multi-content">
				
				<DialogTitle id="edit-dialog-multi-title">
					{this.props.lexicon.edit_label}
				</DialogTitle>

				<form id="edit-multi-form" onSubmit={e => {
					e.preventDefault();
					var data = {},
						i;

					for (i = 0; i < e.target.elements.length; i++) {
						if (e.target.elements[i].name) {
							data[e.target.elements[i].name] = e.target.elements[i].value;
						}
					}
					this.props.onDialogConfirmed(data);
				}}>	
					<DialogContent>
					{data.content.map((item, i) => {
						if (item.multi_variable.type === 'input') {
							return <FormControl key={i} className={classes.formControl}>
								<TextField
									type="text"
									name={columns[i].title}
									label={this.props.lexicon['var_multi_'+ columns[i].title]}
									defaultValue={item.content}
									className={classes.textField}
									InputLabelProps={{
										shrink: true
									}} />
							</FormControl>
						}

						if (item.multi_variable.type === 'richtext') {
							return <EditorFieldItem
								name={columns[i].title}
								remove={false}
								data={{
									content: item.content
								}} />
						}

						if (item.multi_variable.type === 'image') {
							return <ImageFieldItem
								data={{
									name: item.content
								}}
								name={columns[i].title}
								remove={false} />
						}
					})}
					</DialogContent>

					<DialogActions>
						<Button color="primary"
							onClick={e => this.props.onDialogClosed()}>
							{this.props.lexicon.cancel_label}
						</Button>

						<Button color="primary"
							type="submit">
							{this.props.lexicon.ok_label}
						</Button>
					</DialogActions>
				</form>
			</Dialog>
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

export default connect(mapStateToProps)(withStyles(styles)(EditMultiItem));