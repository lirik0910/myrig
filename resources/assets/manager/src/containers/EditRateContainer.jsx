/**
 * Base module of manager users container
 * @module ProductContainers
 * @author Ihor Bielchenko
 * @requires react
 * @requires react#Component
 * @requires redux#bindActionCreators
 * @requires react-redux#connect
 */

import App from '../App.js';
import React, { Component } from 'react';

import Grid from 'material-ui/Grid';
import Paper from 'material-ui/Paper';
import Button from 'material-ui/Button';
import Radio, { RadioGroup } from 'material-ui/Radio';
import Menu from '../components/Menu/Menu.jsx';
import Header from '../components/Header/Header.jsx';
import { LinearProgress } from 'material-ui/Progress';
import { FormLabel, FormControl, FormControlLabel } from 'material-ui/Form';
import InputPrice from '../components/FormControl/InputPrice/InputPrice.jsx';
//import InputNumber from '../components/FormControl/InputNumber/InputNumber.jsx';

import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Users base container
 * @extends Component
 */
class EditRateContainer extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		classes: PropTypes.object.isRequired,
	}

	state = {
		data: {},
		amount: 'min',
		type: '$'
	}

	/**
	 * Invoked just before mounting occurs
	 * @fires componentWillMount
	 */
	componentWillMount() {
	}

	amountHandleChange = (event, amount) => {
		this.setState({ amount });
	}

	typeHandleChange = (event, type) => {
		this.setState({ type });
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { classes } = this.props;
		let { 
			data, 
			completed,
		} = this.state;

		return <div className="products__container">
				{completed === 0 && 
					<LinearProgress color="secondary" variant="determinate" value={completed} />}
				
				<Header
					title={'Edit BTC rate'} />
				<Menu />

				<Grid 
					container 
					spacing={24} 
					className={classes.root}>
					
					<Grid item xs={8}>

						<Paper className={classes.paper}>
							<InputPrice
								title="Blockchain"
								inputID="blockchain-value" />

							<InputPrice
								title="Coinbase"
								inputID="coinbase-value" />

							<InputPrice
								title="Bitstamp"
								inputID="bitstamp-value" />

							<FormControl className={classes.formControl} style={{ display: 'block' }}>
								<FormLabel>Min/max</FormLabel>
								<RadioGroup
									aria-label="Amount"
									name="amount"
									className={classes.group}
									value={this.state.amount}
									onChange={this.amountHandleChange}>

									<FormControlLabel 
										value="min" 
										label="Min"
										control={
											<Radio />
										} />

									<FormControlLabel 
										value="max" 
										label="Max"
										control={
											<Radio />
										} />
								</RadioGroup>
							</FormControl>

							<FormControl className={classes.formControl} style={{ display: 'block' }}>
								<FormLabel>$/%</FormLabel>
								<RadioGroup
									aria-label="Amount"
									name="type"
									className={classes.group}
									value={this.state.type}
									onChange={this.typeHandleChange}>

									<FormControlLabel 
										value="usd" 
										label="$"
										control={
											<Radio />
										} />

									<FormControlLabel 
										value="percent" 
										label="%"
										control={
											<Radio />
										} />
								</RadioGroup>
							</FormControl>

							<InputPrice
								title="Change value"
								inputID="change-value" />

							<InputPrice
								title="Result"
								inputID="result-value" />

							<InputPrice
								disabled
								title="Rate of last price conversion"
								inputID="last-rate-value" />

							<Button color="primary" className={classes.button}>
								Save
							</Button>
						</Paper>
					</Grid>
				</Grid>
			</div>
	}
}

let styles = theme => ({
	root: {
		width: '100%',
		margin: 0,
		padding: 0,
	},
	paper: {
		marginTop: '12px',
		marginBottom: '12px',
		padding: theme.spacing.unit * 2,
		textAlign: 'center',
		color: theme.palette.text.secondary,
	},
});

export default withStyles(styles)(EditRateContainer);