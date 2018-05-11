/**
 * Base module of manager users container
 * @module ProductContainers
 * @author Ihor Bielchenko
 * @requires react
 * @requires react#Component
 * @requires redux#bindActionCreators
 * @requires react-redux#connect
 */

import App from '../../../App.js';
import React, { Component } from 'react';

import ExpansionPanel, {
	ExpansionPanelSummary,
	ExpansionPanelDetails,
} from 'material-ui/ExpansionPanel';
import Grid from 'material-ui/Grid';
import { Link } from 'react-router-dom';
import Typography from 'material-ui/Typography';
import Collapse from 'material-ui/transitions/Collapse';
import ControlOptions from '../../ControlOptions/ControlOptions.jsx';
import List, { ListItem, ListItemIcon, ListItemText } from 'material-ui/List';

import ExpandMore from 'material-ui-icons/ExpandMore';
import Description from 'material-ui-icons/Description';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Users base container
 * @extends Component
 */
class ContextItem extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		parentID: 0,
		classes: PropTypes.object.isRequired,
		onDeleteButtonClicked: () => {},
		onCreateChildPageClicked: () => {}
	}

	state = {
		data: [],
		loadedParents: [],
		parentID: this.props.parentID
	}

	/**
	 * Invoked just before mounting occurs
	 * @fires componentWillMount
	 */
	componentWillMount() {
		this.pagesGetDataRequest();
	}

	/**
	 * Request for getting contexts array
	 * @param {Function} callback
	 */
	pagesGetDataRequest(callback = () => {}) {
		let { context } = this.props;
		let { parentID, data, loadedParents } = this.state;
		
		if (loadedParents.indexOf(parentID) === -1) {
			App.api({
				type: 'GET',
				name: 'all',
				model: 'page',
				data: {
					parent_id: parentID,
					context_id: context.id
				},
				success: (r) => {
					r = JSON.parse(r.response);
					if (r) {
						for (var i in r.data) {
							r.data[i].openChilds = false;
						}
						this.setState({ 
							data: this.iteratePageData(data, r.data) 
						}, () => callback(r));
					}
				}
			});
		}
	}

	/**
	 * Add childs to parent page
	 * @param {Array} data
	 * @param {Array} childs
	 * @return {Array}
	 */
	iteratePageData(data, childs) {
		var i;

		for (i = 0; i < data.length; i++) {
			if (data[i].id === this.state.parentID) {
				data[i]['childs'] = childs;
				break;
			}

			else if (typeof data[i]['childs'] !== 'undefined' && data[i]['childs'].length > 0) {
				data[i]['childs'] = this.iteratePageData(data[i]['childs'], childs);
			}
		}
		return data.length > 0 ? data : childs;
	}

	/**
	 * Open or close parent page
	 * @param {Array} data
	 * @param {Number} id
	 */
	openPageParentElement(data, id) {
		var i;

		for (i = 0; i < data.length; i++) {
			if (data[i].id === id) {
				data[i].openChilds = !data[i].openChilds;
				break;
			}

			else if (typeof data[i]['childs'] !== 'undefined' && data[i]['childs'].length > 0) {
				data[i]['childs'] = this.openPageParentElement(data[i]['childs'], id);
			}
		}
		return data;
	}

	/**
	 * Build pages list
	 * @param {Array} data
	 * @param {Number} deep
	 */
	buildPagesElements(data, deep = 0) {
		let { classes } = this.props;

		return data.map((item, i) => {
			return <Grid key={i} 
					container 
					spacing={24} 
					className={classes.page}
					style={{paddingLeft: (32 * deep) +'px'}}>
					
					<Grid item xs={10} className={classes.pageButton}>
						<Link to={App.name() + '/pages/'+ item.id}>
							<ListItem button>
								<ListItemIcon>
									<Description />
								</ListItemIcon>
								<ListItemText 
									inset 
									primary={item.title}
									className={item.delete === 1 && 'in-trash'} />
							</ListItem>
						</Link>
					</Grid>

					<Grid item xs={2} className={classes.pageButton}>
						<ControlOptions
							item={item}
							addButton={true}
							expandButton={item.issetChilds ? 
								true : 
								false}
							onExpandButtonClicked={item => {
								this.setState({ 
									parentID: item.id,
									data: this.openPageParentElement(this.state.data, item.id)
								}, () => {
									this.pagesGetDataRequest(() => {
										let { loadedParents } = this.state;
										loadedParents.push(item.id);

										this.setState({ loadedParents });
									});
								});
							}}
							onAddButtonClicked={item => this.props.onCreateChildPageClicked(item)}
							onDeleteButtonClicked={item => this.props.onDeleteButtonClicked(item)} />
					</Grid>

					{(item.childs && item.issetChilds) && 
						<Collapse 
							unmountOnExit
							timeout="auto"
							in={item.openChilds} 
							style={{width: '100%'}}>
							
							{this.buildPagesElements(item.childs, deep + 1)}
						</Collapse>}
				</Grid>
		});
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { classes, context } = this.props;
		let { data } = this.state;

		return <ExpansionPanel 
				className={classes.expansion}>

				<ExpansionPanelSummary 
					className={classes.summary} 
					expandIcon={<ExpandMore />}>
					
					<Typography className={classes.heading}>
						Context: {context.title}
					</Typography>
				</ExpansionPanelSummary>

				<ExpansionPanelDetails className={classes.details}>
					<List component="nav">
						{this.buildPagesElements(data)}
					</List>
				</ExpansionPanelDetails>
			</ExpansionPanel>
	}
}

export default withStyles(styles)(ContextItem);