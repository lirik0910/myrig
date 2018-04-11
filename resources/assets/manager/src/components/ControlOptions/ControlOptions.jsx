/**
 * Base module of manager users container
 * @module ProductContainers
 * @author Ihor Bielchenko
 * @requires react
 * @requires react#Component
 * @requires redux#bindActionCreators
 * @requires react-redux#connect
 */

import React, { Component } from 'react';

import Button from 'material-ui/Button';

import Check from 'material-ui-icons/ErrorOutline';
import Add from 'material-ui-icons/Add';
import Edit from 'material-ui-icons/Edit';
import Delete from 'material-ui-icons/Delete';
import Replay from 'material-ui-icons/Replay';
import ExpandLess from 'material-ui-icons/ExpandLess';
import ExpandMore from 'material-ui-icons/ExpandMore';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Users base container
 * @extends Component
 */
class ControlOptions extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		item: {},
		checkButton: false,
		addButton: false,
		editButton: false,
		deleteButton: true,
		expandButton: false,
        onCheckButtonClicked: () => {},
		onAddButtonClicked: () => {},
		onEditButtonClicked: () => {},
		onDeleteButtonClicked: () => {},
		onExpandButtonClicked: () => {},
		classes: PropTypes.object.isRequired,
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { item, classes, checkButton, addButton, editButton, expandButton, deleteButton } = this.props;

		return <div className={classes.root}>
				{expandButton && <Button 
					size="small"
					className={classes.control}
					title={'Expand'}
					onClick={e => this.props.onExpandButtonClicked(item)}>
					
					{item.openChilds ? 
						<ExpandLess /> :
						<ExpandMore />}
				</Button>}

				{checkButton && <Button
					size="small"
					className={classes.control}
					title={'Check'}
					onClick={e => this.props.onCheckButtonClicked(item)}>

					<Check />
				</Button>}

				{addButton && <Button 
					size="small"
					className={classes.control}
					title={'Add'}
					onClick={e => this.props.onAddButtonClicked(item)}>
					
					<Add />
				</Button>}

				{editButton && <Button 
					size="small"
					className={classes.control}
					title={'Edit'}
					onClick={e => this.props.onEditButtonClicked(item)}>
					
					<Edit />
				</Button>}
				
				{deleteButton && 
					(typeof this.props.item !== 'undefined' && this.props.item.delete === 1) ? <Button 
						size="small"
						className={classes.control}
						title={'Delete'}
						onClick={e => this.props.onDeleteButtonClicked(item)}>
						
						<Replay />
					</Button> :
					<Button 
						size="small"
						className={classes.control}
						title={'Delete'}
						onClick={e => this.props.onDeleteButtonClicked(item)}>
						
						<Delete />
					</Button>}
			</div>
	}
}

export default withStyles(styles)(ControlOptions);