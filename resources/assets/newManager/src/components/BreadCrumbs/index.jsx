/**
 * BreadCrumbs module
 * @requires react
 * @requires react#PureComponent
 * @requires prop-types
 * @requires @material-ui/core/Button
 * @requires @material-ui/core/Typography
 * @requires components/MenuDefault
 * @requires @material-ui/core/styles#withStyles
 */

import React, { PureComponent } from 'react';
import PropTypes from 'prop-types';

import Button from '@material-ui/core/Button';
import Typography from '@material-ui/core/Typography';
import MenuDefault from 'components/MenuDefault';

import styles from './styles.js';
import { withStyles } from '@material-ui/core/styles';

/**
 * BreadCrumbs block
 * @extends PureComponent
 */
class BreadCrumbs extends PureComponent {
	
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
	 * @property {string} path
	 * @property {object} data
	 * @property {string} title
	 * @property {boolean} showTitle
	 */
	static defaultProps = {
		path: 'EN/shop/category1/category2',
		data: {
			'EN': [
				'EN',
				'RU',
				'UA'
			]
		},
		title: 'breadCrumbsTitle',
		showTitle: false

	}

	/**
	 * Current component state object
	 * @type {object}
	 * @property {object} anchorEl Current crumb element
	 */
	state = {
		anchorEl: null
	}

	/**
	 * Render component
	 * @return {object} jsx object
	 */
	render() {
		let { classes, path, data, title, showTitle } = this.props,
			crumbs = path.split('/');

		return <div className={classes.root}>
			{showTitle && <Typography className={classes.title}>
				{title}
			</Typography>}

			{crumbs.map((item, i) => {
				return <div key={i} style={{ whiteSpace: 'nowrap' }}>
					{data[item] && data[item].length > 0 ? <MenuDefault
						menu={data[item]}
						switchEl={(obj) => {
							return <Button 
								className={classes.item}
								onClick={(e) => obj.setState({
									anchorEl: e.currentTarget
								})}>

								{item}
							</Button>
						}} /> : 
						<Button 
							className={classes.item}>

							{item}
						</Button>}

					{crumbs.length > i + 1 &&
						<span className={classes.arrow}>/</span>}
				</div>
			})}
		</div>
	}
}

export default withStyles(styles)(BreadCrumbs);