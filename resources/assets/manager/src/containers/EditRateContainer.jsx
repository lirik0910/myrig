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

import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';

import Grid from 'material-ui/Grid';
import Paper from 'material-ui/Paper';
import Button from 'material-ui/Button';
import Radio, { RadioGroup } from 'material-ui/Radio';
import Menu from '../components/Menu/Menu.jsx';
import Header from '../components/Header/Header.jsx';
import { LinearProgress } from 'material-ui/Progress';
import DialogError from '../components/DialogError/DialogError.jsx';
import { FormLabel, FormControl, FormControlLabel } from 'material-ui/Form';
import InputPrice from '../components/FormControl/InputPrice/InputPrice.jsx';
//import InputNumber from '../components/FormControl/InputNumber/InputNumber.jsx';

import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

import * as StateLexiconAction from 'actions/StateLexiconAction.js';

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
		data: [],
		current: {},
		amount: 'min',
		type: 'usd',
		completed: 100,
		amountValue: 0,
		customValue: 0,
		flag: true,
		result: 0,
		resultDialog: false,
		resultDialogTitle: '',
		resultDialogMessage: '',
		langLoaded: false
	}

	/**
	 * Invoked just before mounting occurs
	 * @fires componentWillMount
	 */
	componentWillMount() {
		this.setState({
			completed: 0
		}, () => this.getRatesDataRequest(() => this.countResult()));

		App.defineCurrentLang((r) => {
			if (App.isEmpty(r) === false) {
				this.props.StateLexiconAction.get(r, () => {
					this.setState({
						langLoaded: true
					});
				});
			}
		});
	}

	updateResultRequest(callback = () => {}) {
		let { result, type, amount, customValue } = this.state;

		App.api({
			name: 'one',
			type: 'PUT',
			model: 'rate',
			data: {
				type,
				amount,
				customValue
			},
			success: (r) => {
				r = JSON.parse(r.response);
				if (r) {
					this.setState({ 
						resultDialog: true,
						resultDialogTitle: this.props.lexicon.success_title,
						resultDialogMessage: this.props.lexicon.request_successful
					}, () => callback());
				}
			},
			error: (r) => {
				r = JSON.parse(r.response);
				if (r.message) {
					this.setState({ 
						completed: 100,
						resultDialog: true,
						resultDialogTitle: this.props.lexicon.error_title,
						resultDialogMessage: r.message
					});
				}
			}
		});
	}

	getRatesDataRequest(callback = () => {}) {
		App.api({
			name: 'one',
			type: 'GET',
			model: 'rate',
			success: (r) => {
				r = JSON.parse(r.response);
				if (r) {
					var i,
						current,
						data = [];
					for (i = 0; i < r.length; i++) {
						if (r[i].title === 'coinbase' || r[i].title === 'blockchain' || r[i].title === 'bitstamp') {
							data.push(r[i]);
						}

						if (r[i].title === 'BTC/USD') {
							current = r[i];
						}
					}

					this.setState({ 
						data,
						current,
						completed: 100,
					}, () => callback());
				}
			},
		});
	}

	amountHandleChange = (event, amount) => {
		let { data } = this.state;
		var i,
			v,
			total = 0;
		
		this.setState({ flag: false }, () => {
			if (amount === 'max') {
				for (i = 0; i < data.length; i++) {
					v = parseFloat(data[i].value);

					if (total < v) {
						total = v;
					}
				}
			}

			if (amount === 'min') {
				var min = data[0].value;
				for (i = 0; i < data.length; i++) {
					v = parseFloat(data[i].value);
					if (min > v) {
						min = v;
					}
				}
				total = min;
			}

			this.setState({ amountValue: total, amount }, () => {
				this.countResult();
				//this.setState({ amount, flag: true })
			});
		});
	}

	typeHandleChange = (event, type) => {
		this.setState({ type }, () => this.countResult());
	}

	countResult() {
		let { amountValue, customValue, type, data } = this.state;
		
		this.setState({
			flag: false
		}, () => {
			var a,
				i,
				v;

			if (amountValue === 0) {
				var min = data[0].value;
				for (i = 0; i < data.length; i++) {
					v = parseFloat(data[i].value);
					if (min > v) {
						min = v;
					}
				}
				this.setState({ amountValue: min });
				amountValue = min;
			}

			if (type === 'usd') {
				a = parseFloat(amountValue) + parseFloat(customValue);
			}

			if (type === 'percent') {
				var x = (parseFloat(customValue) * parseFloat(amountValue)) / 100;
				a = parseFloat(amountValue) + x;
			}

			this.setState({ 
				result: a, 
				flag: true 
			});
		});
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { classes } = this.props;
		let { 
			data, 
			flag,
			current,
			completed,
			resultDialog,
			resultDialogTitle,
			resultDialogMessage,
		} = this.state;

		return <div className="products__container">
				{completed === 0 && 
					<LinearProgress color="secondary" variant="determinate" value={completed} />}
				
				<Header
					title={this.props.lexicon.edit_BTC_rate} />
				<Menu />

				<Grid 
					container 
					spacing={24} 
					className={classes.root}>
					
					<Grid item xs={8}>

						<Paper className={classes.paper}>
							{data.map((item, i) => {
								if (item.title === 'coinbase') {
									return <InputPrice
										key={i}
										title={this.props.lexicon.coinbase_label}
										defaultValue={item.value}
										inputID="coinbase-value" />
								}

								if (item.title === 'blockchain') {
									return <InputPrice
										key={i}
										title={this.props.lexicon.blockchain_label}
										defaultValue={item.value}
										inputID="blockchain-value" />
								}

								if (item.title === 'bitstamp') {
									return <InputPrice
										key={i}
										title={this.props.lexicon.bitstamp_label}
										defaultValue={item.value}
										inputID="bitstamp-value" />
								}
							})}

							<FormControl className={classes.formControl} style={{ display: 'block' }}>
								<FormLabel>{this.props.lexicon.min_max}</FormLabel>
								<RadioGroup
									aria-label={this.props.lexicon.amount_label}
									name="amount"
									className={classes.group}
									value={this.state.amount}
									onChange={this.amountHandleChange}>

									<FormControlLabel 
										value="min" 
										label={this.props.lexicon.min_label}
										control={
											<Radio />
										} />

									<FormControlLabel 
										value="max" 
										label={this.props.lexicon.max_label}
										control={
											<Radio />
										} />
								</RadioGroup>
							</FormControl>

							<FormControl className={classes.formControl} style={{ display: 'block' }}>
								<FormLabel>$/%</FormLabel>
								<RadioGroup
									aria-label={this.props.lexicon.amount_label}
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
								title={this.props.lexicon.change_value}
								inputID="change-value"
								defaultValue={this.state.customValue}
								onFieldInputed={value => {
									if (value !== '') {
										this.setState({
											customValue: value
										}, () => this.countResult());
									}
								}} />

							{flag === true && <InputPrice
								title={this.props.lexicon.result_label}
								inputID="result-value"
								defaultValue={this.state.result} />}

							{(completed === 100 && App.isEmpty(current) === false) && <InputPrice
								disabled
								title={this.props.lexicon.rate_conversion}
								inputID="last-rate-value"
								defaultValue={current.value} />}

							<Button 
								color="primary" 
								className={classes.button}
								onClick={e => {
									if (parseFloat(this.state.result) > 0) {
										this.setState({
											completed: 0
										}, () => this.updateResultRequest(() => this.getRatesDataRequest()))
									}
								}}>
								{this.props.lexicon.save_label}
							</Button>
						</Paper>
					</Grid>
				</Grid>

				{resultDialog === true && <DialogError 
					title={resultDialogTitle}
					defaultValue={resultDialog}
					message={resultDialogMessage}
					onDialogClosed={() => this.setState({
						resultDialog: false
					})} />}
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

/**
 * Init redux actions
 * @param {Function} dispatch
 * @return {Object}
 */
function mapDispatchToProps(dispatch) {
	return {
		StateLexiconAction: bindActionCreators(StateLexiconAction, dispatch)
	}
}

export default connect(mapStateToProps, mapDispatchToProps)(withStyles(styles)(EditRateContainer));