/**
 * TablePages module
 * @requires react
 * @requires react#PureComponent
 * @requires prop-types
 * @requires @material-ui/core/Grid
 * @requires @material-ui/core/Button
 * @requires @material-ui/core/IconButton
 * @requires @material-ui/core/Paper
 * @requires components/TableDefault
 * @requires components/BreadCrumbs
 * @requires components/MenuDefault
 * @requires components/FilterPages
 * @requires @material-ui/icons/Add
 * @requires @material-ui/icons/Delete
 * @requires @material-ui/icons/Create
 * @requires @material-ui/icons/ContentCopy
 * @requires @material-ui/core/styles#withStyles
 */

import React, { PureComponent } from 'react';
import PropTypes from 'prop-types';

import Grid from '@material-ui/core/Grid';
import Button from '@material-ui/core/Button';
import IconButton from '@material-ui/core/IconButton';
import Paper from '@material-ui/core/Paper';
import TableDefault from 'components/TableDefault';
import BreadCrumbs from 'components/BreadCrumbs';
import MenuDefault from 'components/MenuDefault';
import FilterPages from 'components/FilterPages';

import Add from '@material-ui/icons/Add';
import Delete from '@material-ui/icons/Delete';
import Create from '@material-ui/icons/Create';
import ContentCopy from '@material-ui/icons/ContentCopy';

import styles from './styles.js';
import { withStyles } from '@material-ui/core/styles';

/**
 * TablePages block
 * @extends PureComponent
 */
class TablePages extends PureComponent {
	
	/**
	 * Props validators
	 * @type {object}
	 * @property {function} classes
	 */
	static propTypes = {
		classes: PropTypes.object.isRequired
	}

	/**
	 * Page manage list
	 * @type {array}
	 */
	static itemOptions = [
		'optionPageView',
		'optionPageEdit',
		'optionPageBlankEdit',
		'optionPageCopy',
		'optionPageDelete'
	]

	/**
	 * Default properties
	 * @type {object}
	 * @property {array} data
	 */
	static defaultProps = {
		data: [{
			id: 1,
			title: 'Title',
			description: 'Description',
			view: 'IndexView',
			manage: <MenuDefault
				menu={TablePages.itemOptions}
				switchEl={(obj) => {
					return <IconButton 
						color="primary"
						onClick={(e) => obj.setState({
							anchorEl: e.currentTarget
						})}>

						<Create />
					</IconButton>
				}} />,
		}]
	}

	/**
	 * Current component state object
	 * @type {object}
	 * @property {boolean} selected
	 */
	state = {
		selected: false
	}

	/**
	 * Clicked on create page button
	 * @fires onClick
	 * @param {object} e
	 */
	onPageCreate = (e) => {

	}

	/**
	 * Clicked on copy pages button
	 * @fires onClick
	 * @param {object} e
	 */
	onPageCopy = (e) => {

	}

	/**
	 * Delete pages from trash
	 * @fires onClick
	 * @param {object} e
	 */
	onPageTrash = (e) => {

	}

	onRowSelected = (rows) => {
		let i = 0;
		while (i < rows.length) {
			if (rows[i] === true) {
				return this.setState({ selected: true });
			}
			i++;
		}
		this.setState({ selected: false });
	}

	/**
	 * Render component
	 * @return {object} jsx object
	 */
	render() {
		let { classes, data } = this.props;

		return <div 
			className={classes.root}>
			
			<Grid container spacing={24} style={{ margin: 0 }}>
				<Grid item xs={12} sm={5}>
					<BreadCrumbs
						showTitle />
				</Grid>

				<Grid item xs={12} sm={7} className={classes.toolBar}>
					<Button 
						onClick={this.onPageCreate}>
						
						<Add />
						toolbarePageCreate
					</Button>

					<Button 
						disabled={!this.state.selected}
						onClick={this.onPageCopy}>
						
						<ContentCopy />
						toolbarePageCopy
					</Button>

					<Button 
						disabled={!this.state.selected}
						color="secondary"
						onClick={this.onPageTrash}>
						
						<Delete />
						toolbarePageTrash
					</Button>
				</Grid>
			</Grid>

			<Grid container spacing={24} style={{ margin: 0, width: '100%' }}>
				<Grid item xs={12} sm={9}>
					<Paper>
						<TableDefault
							data={data}
							paggination
							checkbox
							onRowSelected={this.onRowSelected}
							onAllSelected={this.onRowSelected} />
					</Paper>
				</Grid>

				<Grid item xs={12} sm={3}>
					<Paper>
						<FilterPages />
					</Paper>
				</Grid>
			</Grid>
		</div>
	}
}

export default withStyles(styles)(TablePages);