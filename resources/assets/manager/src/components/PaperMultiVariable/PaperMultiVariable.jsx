/**
 * Select page module
 * @module PriceField
 * @author Ihor Bielchenko
 * @requires react
 */

import React, { Component } from 'react';

import Paper from 'material-ui/Paper';
import Button from 'material-ui/Button';
import Typography from 'material-ui/Typography';
import PaperTable from '../PaperTable/PaperTable.jsx';
import DialogDelete from '../DialogDelete/DialogDelete.jsx';
import EditMultiItem from './EditMultiItem/EditMultiItem.jsx';
import ControlOptions from '../ControlOptions/ControlOptions.jsx';

import AddIcon from 'material-ui-icons/Add';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Component for selecting page
 * @extends Component
 */
class PaperMultiVariable extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		title: 'Input',
		onAddedField: () => {},
		onDeletedField: () => {},
		onFieldInputed: () => {},
		classes: PropTypes.object.isRequired,
	}

	/**
	 * State object of component
	 * @type {Object} 
	 * @inner
	 */
	state = {
		data: [],
		columns: [],
		completed: true,
		editItem: [],
		editItemId: 0,
		editDialog: false,
		deleteItemId: 0,
		deleteDialog: false,
	}

	/**
	 * Invoked just before mounting occurs
	 * @fires componentWillMount
	 */
	componentWillMount() {
		let { data, columns } = this.props;

		this.setState({
			data: this.buildData(data),
			columns: this.buildColumns(columns)
		});
	}

	/**
	 * Build table data
	 * @param {Array} data
	 * @return {Array}
	 */
	buildData(data = []) {
		var a = [],
			l,
			i,
			k;

		for (i in data) {
			l = {};
			for (k = 0; k < data[i].content.length; k++) {
				l['item-'+ k] = data[i].content[k].content;
			}

			l['control'] = <ControlOptions
				key={i}
				item={data[i]}
				editButton={true}
				onDeleteButtonClicked={item => {
					this.setState({
						deleteDialog: true,
						deleteItemId: item.id,
					});
				}}
				onEditButtonClicked={item => {
					this.setState({
						editItem: item,
						editDialog: true,
						editItemId: item.id
					})
				}} />
			a.push(l);
		}
		return a;
	}

	/**
	 * Add control column title to tables
	 * @param {Array} columns
	 * @return {Array}
	 */
	buildColumns(columns = []) {
		var a = [],
			i;

		for (i in columns) {
			a.push({
				id: columns[i].id,
				numeric: false, 
				disablePadding: true, 
				label: columns[i].description
			});
		}

		a.push({
			id: 'control',
			numeric: false, 
			disablePadding: true, 
			label: 'Control'
		});

		return a;
	}

	/**
	 * Add field
	 * @param {Object} e
	 */
	handleAddField = e => {
		let { pageId, variableId, data, columns } = this.props;
		var i,
			el,
			content = [];

		this.setState({ completed: false }, () => {
			for (i = 0; i < columns.length; i++) {
				content.push({
					id: Date.now() + i,
					content: '',
					multi_variable: columns[i]
				});
			}

			data.push({
				id: Date.now(),
				page_id: pageId,
				variable_id: variableId,
				content: content
			});

			this.setState({ 
				completed: true,
				data: this.buildData(data)
			}, () => this.props.onAddedField(data));
		});
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { classes, title } = this.props;
		let { 
			data,
			columns,
			editItem,
			completed, 
			editItemId,
			editDialog,
			deleteDialog } = this.state;

		return <Paper className={classes.paper}>
				<Typography className={classes.title}>
					{title}
				</Typography>

				<div style={{margin: '12px 0'}}>
					{completed === true && <PaperTable 
						data={data}
						columns={columns}

						limit={100}
						footer={false}
						selecting={false}
						defaultSort={false} />}
				</div>

				{deleteDialog === true && <DialogDelete
					defaultValue={deleteDialog}
					onDialogClosed={() => this.setState({
						deleteDialog: false,
						deleteItemId: 0
					})}
					onDialogConfirmed={() => {
						var i,
							data = this.props.data;

						this.setState({ completed: false }, () => {
							for (i = 0; i < data.length; i++) {
								if (data[i].id === this.state.deleteItemId) {
									data.splice(i, 1);
									
									this.setState({ 
										data: this.buildData(data)
									}, () => this.setState({ 
										completed: true,
										deleteItemId: 0,
										deleteDialog: false,
									}), () => this.props.onDeletedField(data));
									break;
								}
							}
						});
					}} />}

				{editDialog === true && <EditMultiItem
					data={editItem}
					defaultValue={editDialog}
					columns={this.props.columns}
					onDialogClosed={() => this.setState({
						editDialog: false,
						editItemId: 0,
						editItem: []
					})}
					onDialogConfirmed={values => {
						var i,
							a,
							data = this.props.data;

						this.setState({ completed: false }, () => {
							for (i = 0; i < data.length; i++) {
								if (data[i].id === this.state.editItemId) {
									for (a = 0; a < data[i].content.length; a++) {
										data[i].content[a].content = values[data[i].content[a].multi_variable.title];
									}
									
									this.setState({ 
										data: this.buildData(data)
									}, () => this.setState({ 
										completed: true,
										editItemId: 0,
										editItem: [],
										editDialog: false
									}), () => this.props.onFieldInputed(data));
									break;
								}
							}
						});
					}} />}

					<Button 
						variant="fab" 
						color="primary" 
						aria-label="add" 
						className={classes.button}
						onClick={this.handleAddField}>
							<AddIcon />
							{'Add field'}
					</Button>
			</Paper>
	}
}

export default withStyles(styles)(PaperMultiVariable);