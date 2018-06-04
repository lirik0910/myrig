/**
 * Custom table module
 * @author ihor bielchenko
 * @requires react
 * @requires react#Component
 * @requires redux#bindActionCreators
 * @requires react-redux#connect
 * @requires material-ui/Checkbox
 * @requires material-ui/Menu
 * @requires material-ui-icons#MoreVertIcon
 * @requires material-ui-icons#KeyboardArrowLeft
 * @requires material-ui-icons#KeyboardArrowRight
 * @requires material-ui/Menu#MenuItem
 * @requires styles.js
 * @requires material-ui/styles#withStyles
 * @requires actions/StateElementAction.js
 */

import React, { Component } from 'react';

import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';

import Checkbox from 'material-ui/Checkbox';
import Menu, { MenuItem } from 'material-ui/Menu';

import MoreVertIcon from 'material-ui-icons/MoreVert';
import KeyboardArrowLeft from 'material-ui-icons/KeyboardArrowLeft';
import KeyboardArrowRight from 'material-ui-icons/KeyboardArrowRight';

import styles from './styles.js';
import { withStyles } from 'material-ui/styles';

import * as StateElementAction from '../../../actions/StateElementAction.js';

/**
 * Custom table
 * @extends Component
 * @property {Number} page Current page number
 * @property {Number} total Amount of table lines
 * @property {Number} limit Table lines limit items
 * @property {Array} dataItems Lines of the table
 * @property {Array} controlItems Control items array
 * @property {Array} headerItems Headers of the table
 * @property {Boolean} select Show selection checkbox 
 * @property {Object} styleLine Style object of table line
 * @property {Function} onNextPageClicked If next pagging page has clicked
 * @property {Function} onPrevPageClicked If prev pagging page has clicked
 */
class PaperTable extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Number} page Current page number
	 * @property {Array} dataItems Lines of the table
	 * @property {Number} total Amount of table lines
	 * @property {Number} limit Table lines limit items
	 * @property {Array} controlItems Control items array
	 * @property {Array} headerItems Headers of the table
	 * @property {Boolean} select Show selection checkbox 
	 * @property {Object} styleLine Style object of table line
	 * @property {Function} onNextPageClicked If next pagging page has clicked
	 * @property {Function} onPrevPageClicked If prev pagging page has clicked
	 */
	static defaultProps = {
		page: 0,
		total: 0,
		limit: 10,
		styleLine: {},
		dataItems: [],
		select: false,
		headerItems: [],
		controlItems: [],
		onNextPageClicked: () => {},
		onPrevPageClicked: () => {}
	}

	/**
	 * State object of component
	 * @type {Object} 
	 * @inner
	 * @property {Number} anchorI Current line index
	 * @property {Boolean} mainCheckbox Checked all checkbox flags 
	 * @property {Array} checkboxes Checkboxes checking flags array
	 * @property {Object} anchorEl The DOM element used to set the position of the menu
	 */
	state = {
		anchorI: 0,
		checkboxes: [],
		anchorEl: null,
		mainCheckbox: false,
	}

	/** 
	 * Invoked just before mounting occurs 
	 * @fires componentWillMount
	 */
	componentWillMount() {
		this.setCheckboxesState();
	}

	/**
	 * Create table lines array for checkboxes state
	 */
	setCheckboxesState() {
		let { dataItems } = this.props;

		let i,
			checkboxes = [];
		for (i = 0; i < dataItems.length; i++) {
			checkboxes.push(false);
		}

		this.setState({ checkboxes });
	}

	/** 
	 * Close context control menu 
	 * @fires onClick
	 * @param {Object} e
	 */
	handleCloseControlMenu = e => {
		this.setState({ anchorEl: null, anchorI: 0 });
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let k,
			n,
			line,
			headerTitles = [],
			{ page, select, limit, total, headerItems, dataItems, styleLine, controlItems } = this.props;

		return <div className="paper-table__container paper__container">
			<table>
				<tbody>
				{headerItems.length > 0 && <tr className="header__container">
					{headerItems.map((item, i) => {
						headerTitles.push(item.name);
						
						return <td 
							key={i}
							id={'td-'+ item.name +'-'+ i}>
							
							{i === 0 && select === true ?
								<Checkbox
									onChange={e => this.setState({ mainCheckbox: !this.state.mainCheckbox }, () => {
										let i,
											checkboxes = this.state.checkboxes;

										for (i = 0; i < checkboxes.length; i++) {
											checkboxes[i] = this.state.mainCheckbox;
										}
										this.setState({ checkboxes });
									})} /> :
								item.title}
						</td>
					})}
				</tr>}

				{dataItems.map((item, i) => {
					n = 0;
					line = [];
					
					for (k in item) {
						if (headerTitles.indexOf(k) === -1) {
							continue;
						}
						
						line.push(<td key={n}>
							<div style={{ display: 'flex', alignItems: 'center' }}>
								<div style={{ 
									width: controlItems.length > 0 && headerTitles.length - 1 === n ? 
										'calc(100% - 32px)' :
										'100%' }}>
									
									{n === 0 && select === true ? 
										<Checkbox
											checked={this.state.checkboxes[i]}
											onChange={e => {
												let checkboxes = this.state.checkboxes;
												checkboxes[i] = !checkboxes[i];
												this.setState({ checkboxes });
											}} /> : 
										item[k]}
								</div>
								
								{controlItems.length > 0 && headerTitles.length - 1 === n && <div>
									<MoreVertIcon
										style={{ 
											width: 32 
										}}
										className="pagging__button"
										onClick={e => this.setState({
											anchorI: i + 1, 
											anchorEl: e.currentTarget
										})} />

									{this.state.anchorI === i + 1 && <Menu
										anchorEl={this.state.anchorEl}
										open={Boolean(this.state.anchorEl)}
										onClose={this.handleCloseControlMenu}>
											
										{controlItems.map((control, c) => {
											return <MenuItem
												key={c}
												onClick={e => control.onItemClicked(e, item)}>

												{control.title}
											</MenuItem>})}
									</Menu>}
								</div>}
							</div>
						</td>);
						n++;
					}

					return <tr 
						key={i}
						style={styleLine}
						className="tr__container">

						{line}
					</tr>
				})}
				</tbody>
			</table>

			<div className="footer__container">
				<div className="footer__item">
					{limit * (page + 1) - (limit - 1)} - 
					{limit * (page + 1) >= total ?
						total :
						limit * (page + 1)} из {total === 0 ? dataItems.length + 1 : total}</div>
				
				<div className="footer__item">
					<KeyboardArrowLeft
						className="pagging__button"
						onClick={e => page > 0 && this.props.onPrevPageClicked(e)} />
				</div>

				<div className="footer__item">
					<KeyboardArrowRight
						className="pagging__button"
						onClick={e => Math.ceil(total / limit) > (page + 1) && this.props.onNextPageClicked(e)} />
				</div>
			</div>
		</div>
	}
}

/**
 * Init redux states
 * @param {Object} state
 * @return {Object}
 */
function mapStateToProps(state) {
	return {
		elements: state.elements,
	}
}

/**
 * Init redux actions
 * @param {Function} dispatch
 * @return {Object}
 */
function mapDispatchToProps(dispatch) {
	return {
		StateElementAction: bindActionCreators(StateElementAction, dispatch),
	}
}

export default connect(mapStateToProps, mapDispatchToProps)(withStyles(styles)(PaperTable));