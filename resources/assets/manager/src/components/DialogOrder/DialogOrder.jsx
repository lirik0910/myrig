/**
 * Select page module
 * @module PriceField
 * @author Ihor Bielchenko
 * @requires react
 */

import App from '../../App.js';
import React, { Component } from 'react';

import Grid from 'material-ui/Grid';
import Button from 'material-ui/Button';
import Typography from 'material-ui/Typography';
import Slide from 'material-ui/transitions/Slide';
import TabOptions from '../TabOptions/TabOptions.jsx';
import Dialog, {
	DialogActions,
	DialogContent,
	DialogContentText,
	DialogTitle,
} from 'material-ui/Dialog';

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
class DialogOrder extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		defaultValue: false,
		classes: PropTypes.object.isRequired,
		onDialogSaved: () => {},
		onDialogClosed: () => {}
	}

	/**
	 * State object of component
	 * @type {Object} 
	 * @inner
	 */
	state = {
		tab: 0,
		open: this.props.defaultValue,
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { tab, open } = this.state;
		let { classes, order } = this.props;

		return <Dialog
				open={open}
				transition={Transition}
				keepMounted
				maxWidth="md"
				aria-labelledby="dialog-order-slide-title"
				aria-describedby="dialog-order-slide-text">

				<DialogTitle id="dialog-order-slide-title"
					style={{width: 720}}>
					{'Edit'}
				</DialogTitle>

				<DialogContent>
					<Grid container spacing={24} className={classes.root}>
						<Grid item xs={12}>
							<TabOptions
								defaultValue={tab}
								onTabButtonClicked={tab => this.setState({ tab })}
								data={[
									'Order',
									'History',
								]} />
						</Grid>
					</Grid>

					{tab === 0 && <Grid container spacing={24} className={classes.root}>
						<Grid item xs={8}>
							<Typography style={{fontSize: 26}}>
								# {order.number}
							</Typography>

							<Typography style={{fontSize: 16}}>
								Products:
							</Typography>

							{order.carts && order.carts.map((item, i) => {
								return <Grid key={i} container spacing={24} className={classes.product}>
									<Grid item xs={4}>
										{typeof item.product.images[0] !== 'undefined' ?
											<img src={App.name() +'/'+ item.product.images[0].name} 
												alt={item.product.id} /> : null}
									</Grid>
									<Grid item xs={8}>
										<Typography style={{fontSize: 14}}>
											{item.product.title}
										</Typography>
									</Grid>
								</Grid>
							})}
						</Grid>
					</Grid>}

					{tab === 1 && <Grid container spacing={24} className={classes.root}>
						<Grid item xs={12}>hello</Grid>
					</Grid>}
				</DialogContent>

				<DialogActions>
					<Button color="primary"
						onClick={e => this.props.onDialogClosed()}>
						Cancel
					</Button>
					<Button color="primary"
						onClick={e => this.props.onDialogSaved()}>
						Save
					</Button>
				</DialogActions>
			</Dialog>
	}
}

export default withStyles(styles)(DialogOrder);