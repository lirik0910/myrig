/**
 * Header block module
 * @module Users
 * @author Ihor Bielchenko
 * @requires react
 * @requires react#Component
 * @requires redux#bindActionCreators
 * @requires react-redux#connect
 */

//import App from '../../App.js';
import React, { Component } from 'react';

import Grid from 'material-ui/Grid';
import Button from 'material-ui/Button';
import Typography from 'material-ui/Typography';

import Add from 'material-ui-icons/Add';
import Save from 'material-ui-icons/Save';
import Delete from 'material-ui-icons/Delete';
import ContentCopy from 'material-ui-icons/ContentCopy';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Header block
 * @extends Component
 */
class TopTitle extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {String} title Title text 
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		title: 'Title',
		addButtonTitle: 'Add',
		addButtonDisplay: false,
		saveButtonTitle: 'Save',
		saveButtonDisplay: true,
		trashButtonDisplay: false,
		trashButtonTitle: 'Empty trash',
		duplicateButtonTitle: 'Duplicate',
		duplicateButtonDisplay: false,
		deleteButtonTitle: 'Delete',
		deleteButtonDisplay: false,
		classes: PropTypes.object.isRequired,
		onAddButtonClicked: () => {},
		onSaveButtonClicked: () => {},
		onTrashButtonClicked: () => {},
		onDeleteButtonClicked: () => {},
		onDuplicateButtonClicked: () => {},
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { 
			title,
			classes, 
			addButtonTitle,
			addButtonDisplay,
			saveButtonTitle,
			saveButtonDisplay,
			duplicateButtonTitle,
			duplicateButtonDisplay,
			deleteButtonTitle,
			deleteButtonDisplay,
			trashButtonDisplay,
			trashButtonTitle
		} = this.props;

		return <Grid container spacing={24} className={classes.root}>
				<Grid item xs={8}>
					<Typography className={classes.title}>
						{title}
					</Typography>
				</Grid>
					
				<Grid item xs={4} className={classes.right}>
					{addButtonDisplay && <Button 
						onClick={e => this.props.onAddButtonClicked()}
						className={classes.button} 
						variant="raised">
							<Add className={classes.leftIcon} />
							{addButtonTitle}
					</Button>}

					{saveButtonDisplay && <Button 
						onClick={e => this.props.onSaveButtonClicked()}
						className={classes.button} 
						variant="raised">
							<Save className={classes.leftIcon} />
							{saveButtonTitle}
					</Button>}

					{duplicateButtonDisplay && <Button 
						onClick={e => this.props.onDuplicateButtonClicked()}
						className={classes.button} 
						variant="raised"
						color="primary">
							<ContentCopy className={classes.leftIcon} />
							{duplicateButtonTitle}
					</Button>}

					{deleteButtonDisplay && <Button 
						onClick={e => this.props.onDeleteButtonClicked()}
						className={classes.button} 
						variant="raised"
						color="secondary">
							<Delete className={classes.leftIcon} />
							{deleteButtonTitle}
					</Button>}

					{trashButtonDisplay && <Button 
						onClick={e => this.props.onTrashButtonClicked()}
						className={classes.button} 
						variant="raised"
						color="secondary">
							<Delete className={classes.leftIcon} />
							{trashButtonTitle}
					</Button>}
				</Grid>
			</Grid>
	}
}

export default withStyles(styles)(TopTitle);