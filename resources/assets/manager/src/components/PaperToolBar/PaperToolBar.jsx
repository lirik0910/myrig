/**
 * Base module of manager users container
 * @module ProductContainers
 * @author Ihor Bielchenko
 * @requires react
 * @requires react#Component
 * @requires redux#bindActionCreators
 * @requires react-redux#connect
 */

//import App from '../App.js';
import React, { Component } from 'react';

import Grid from 'material-ui/Grid';
import Paper from 'material-ui/Paper';
import Button from 'material-ui/Button';
import InputSearch from '../FormControl/InputSearch/InputSearch.jsx';
import SelectDelete from '../FormControl/SelectDelete/SelectDelete.jsx';
import SelectStatus from '../FormControl/SelectStatus/SelectStatus.jsx';
import SelectNotificationStatus from '../FormControl/SelectNotificationStatus/SelectNotificationStatus.jsx';
import SelectPayment from '../FormControl/SelectPayment/SelectPayment.jsx';
import SelectContext from '../FormControl/SelectContext/SelectContext.jsx';
import SelectDelivery from '../FormControl/SelectDelivery/SelectDelivery.jsx';
import InputDatePicker from '../FormControl/InputDatePicker/InputDatePicker.jsx';
import SelectOrderAction from '../FormControl/SelectOrderAction/SelectOrderAction.jsx';

import styles from './styles.js';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Users base container
 * @extends Component
 */
class PaperToolBar extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		searchShow: true,
		statusShow: false,
		notificationStatusShow: false,
		contextShow: true,
		paymentShow: false,
		deliveryShow: false,
		deleteFilterShow: false,
		dateFromDefaultValue: '',
		dateToDefaultValue: '',
		orderActionShow: false,
		dateCreatedShow: false,
		notificationStatusDefaultValue: 0,
		statusDefaultValue: 0,
		actionDefaultValue: 0,
		contextDefaultValue: 0,
		paymentDefaultValue: 0,
		deliveryDefaultValue: 0,
		searchDefaultValue: null,
		onDateToSelected: () => {},
		onDateFromSelected: () => {},
		onActionSelected: () => {},
        onNotificationStatusSelected: () => {},
		onStatusSelected: () => {},
		onDeleteSelected: () => {},
		onContextSelected: () => {},
		onPaymentSelected: () => {},
		dateFieldsCleared: () => {},
		onDeliverySelected: () => {},
		onSearchFieldSubmited: () => {},
		classes: PropTypes.object.isRequired,
		actionsData: []
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { 
			classes, 
			statusShow,
            notificationStatusShow,
			searchShow,
			contextShow,
			paymentShow,
			deliveryShow,
			actionsData,
			orderActionShow,
			dateCreatedShow,
			deleteFilterShow,
			dateFromDefaultValue,
			dateToDefaultValue,
			actionDefaultValue,
			searchDefaultValue, 
			statusDefaultValue,
            notificationStatusDefaultValue,
			paymentDefaultValue,
			contextDefaultValue,
			deliveryDefaultValue,
		} = this.props;

		return <Paper className={classes.paper}>
				<Grid container spacing={24} className={classes.root}>
					{searchShow && <Grid item xs={12} sm={2}>
						<InputSearch
							defaultValue={searchDefaultValue}
							onFieldSubmited={value => this.props.onSearchFieldSubmited(value)} />
					</Grid>}

					{contextShow && <Grid item xs={12} sm={2}>
						<SelectContext
							title={this.props.contextTitle}
							defaultValue={contextDefaultValue}
							onItemSelected={value => this.props.onContextSelected(value)} />
					</Grid>}

                    {notificationStatusShow && <Grid item xs={12} sm={2}>
                        <SelectNotificationStatus
                            title={this.props.statusTitle}
                            defaultValue={notificationStatusDefaultValue}
                            onItemSelected={value => this.props.onNotificationStatusSelected(value)} />
                    </Grid>}

					{statusShow && <Grid item xs={12} sm={2}>
						<SelectStatus
							title={this.props.statusTitle}
							defaultValue={statusDefaultValue}
							onItemSelected={value => this.props.onStatusSelected(value)} />
					</Grid>}

					{paymentShow && <Grid item xs={12} sm={2}>
						<SelectPayment
							title={this.props.paymentTitle}
							defaultValue={paymentDefaultValue}
							onItemSelected={value => this.props.onPaymentSelected(value)} />
					</Grid>}

					{deliveryShow && <Grid item xs={12} sm={2}>
						<SelectDelivery
							title={this.props.deliveryTitle}
							defaultValue={deliveryDefaultValue}
							onItemSelected={value => this.props.onDeliverySelected(value)} />
					</Grid>}

					{orderActionShow && <Grid item xs={12} sm={2}>
						<SelectOrderAction
							actionsData={actionsData}
							defaultValue={actionDefaultValue}
							onItemSelected={value => this.props.onActionSelected(value)} />
					</Grid>}

					{deleteFilterShow && <Grid item xs={12} sm={2}>
						<SelectDelete
							data={[{
								name: 'Not in the trash',
								value: 0
							}, {
								name: 'In trash',
								value: 1
							}]}
							defaultValue={0}
							onItemSelected={value => this.props.onDeleteSelected(value)} />
					</Grid>}

					{dateCreatedShow && <Grid item xs={12} sm={2}>
						<InputDatePicker
							title={this.props.dateFromTitle}
							defaultValue={dateFromDefaultValue}
							onDateFieldChanged={date => this.props.onDateFromSelected(date)} />
					</Grid>}

					{dateCreatedShow && <Grid item xs={12} sm={2}>
						<InputDatePicker
							title={this.props.dateToTitle}
							defaultValue={dateToDefaultValue}
							onDateFieldChanged={date => this.props.onDateToSelected(date)} />
					</Grid>}

					{dateCreatedShow && 
						<Button size="small" className={classes.button}
							onClick={e => {
								var el = document.getElementsByClassName('date-picker__container');
								if (el) {
									for (var i = 0; i < el.length; i++) {
										if (el[i].children[0].children[0]) {
											el[i].children[0].children[0].value = '';
										}
									}
									this.props.dateFieldsCleared();
								}
							}}>
							Clear date
						</Button>}
				</Grid>
			</Paper>
	}
}

export default withStyles(styles)(PaperToolBar);