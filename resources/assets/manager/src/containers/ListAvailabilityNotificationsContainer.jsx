/**
 * Base module of manager notifications container
 * @module AvailabilittNotificationsContainers
 * @author Ivan Bastryhin
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
import Menu from '../components/Menu/Menu.jsx';
import Header from '../components/Header/Header.jsx';
import { LinearProgress } from 'material-ui/Progress';
import TopTitle from '../components/TopTitle/TopTitle.jsx';
import DialogNotification from '../components/DialogNotification/DialogNotification.jsx';
import PaperTable from '../components/PaperTable/PaperTable.jsx';
import DialogError from '../components/DialogError/DialogError.jsx';
import PaperToolBar from '../components/PaperToolBar/PaperToolBar.jsx';
import DialogDelete from '../components/DialogDelete/DialogDelete.jsx';
import ControlOptions from '../components/ControlOptions/ControlOptions.jsx';

import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

import * as StateLexiconAction from 'actions/StateLexiconAction.js';

/**
 * Notifications base container
 * @extends Component
 */

class ListAvailabilityNotificationsContainer extends Component
{
    /**
     * Init default props
     * @type {Object}
     * @inner
     * @property {Object} classes Material default classes collection
     */
    static defaultProps = {
        classes: PropTypes.object.isRequired,
       // childs: PropTypes.object.products.isRequired,
    };


    state = {
        data: [],
        start: 0,
        limit: 10,
        total: 0,
        selected: [],
        products: [],
        status: 0,
        completed: 100,
        editNotificationId: 0,
        editNotificationItem: {},
        editNotificationDialog: false,
        deleteNotificationId: 0,
        resultDialog: false,
        resultDialogTitle: '',
        resultDialogMessage: '',
        deleteDialog: false,
        langLoaded: false
    };

    /**
     * Invoked just before mounting occurs
     * @fires componentWillMount
     */
    componentWillMount() {
        this.notificationsDataGetRequest();

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

    /**
     * Request for getting notifications array
     * @param {Function} callback
     */
    notificationsDataGetRequest(callback = () => {}) {
        let {
            start,
            limit,
            status,
            checkButton,
        } = this.state;

        this.setState({
            completed: 0
        }, () => {
            var data = {
                limit,
                start: start + 1,
                status: status
            };

            if (status && status > 0) {
                if (status === 1) {
                    data['check'] = 0;
                } else{
                    data['check'] = 1;
                }
            }

            App.api({
                type: 'GET',
                name: 'all',
                model: 'report',
                data: data,
                success: (r) => {
                    r = JSON.parse(r.response);
                    if (r) {
                        console.log(r);
                        const ulStyle = {
                            listStyleType: 'none',
                            paddingLeft: '0',
                            marginTop: '0'
                        };
                        const liStyle = {
                          marginBottom: '5px',
                          fontWeight: 'semi-bold'
                        };
                        const li_head = {
                            marginBottom: '3px',
                            display: 'inline-block',
                            fontSize: '0.70rem'
                        };
                        const productTitle = {
                            cssFloat: 'left',
                            marginBottom: '5px'
                        };
                        const productCount = {
                            cssFloat: 'right'
                        };

                        for (var i in r.data) {
                            //console.log(r.data[i].check);
                            if(r.data[i].check == 0){
                                checkButton = true
                                r.data[i].updated_at = '—';
                            } else{
                                checkButton = false
                            }
                            r.data[i]['products'] =
                                <ul style={ulStyle}>
                                    {r.data[i]['products'].map((item, i) => {
                                        //console.log(item, i);
                                        return <li style={liStyle} key={i}><span style={productTitle}>{item.product.title}</span><span style={productCount}>{item.count}</span></li>
                                    })}
                                </ul>;
                            r.data[i]['control'] = <ControlOptions
                                item={r.data[i]}
                                checkButton={checkButton}
                                deleteButton={false}
                                onCheckButtonClicked={item => {
                                    this.setState({
                                        editNotificationDialog: true,
                                        editNotificationItem: item,
                                        editNotificationId: item.id
                                    });
                                }} />

/*                                onDeleteButtonClicked={item => {
                                    this.setState({
                                        deleteDialog: true,
                                        deleteUserId: item.id,
                                    });
                                }} />*/
                        }

                        this.setState({
                            data: r.data,
                            products: r.data.products,
                            total: r.total,
                            completed: 100
                        }, () => callback());
                    }
                }
            });
        });
    };

    /**
     * Request for update notification
     * @param {Object} data
     */
    notificationPutRequest = data => {
        let { editNotificationItem } = this.state;
        console.log(editNotificationItem);
        this.setState({
            completed: 0
        }, () => {
            App.api({
                name: 'one',
                type: 'PUT',
                model: 'report',
                resource: editNotificationItem.id,
                data: data,
                success: (r) => {
                    r = JSON.parse(r.response);
                    if (r) {
                        this.setState({
                            selected: [],
                            completed: 100,
                            deleteNotificationId: 0,
                            editNotificationItem: {},
                            resultDialog: true,
                            deleteDialog: false,
                            editNotificationDialog: false,
                            resultDialogTitle: this.props.lexicon.success_title,
                            resultDialogMessage: this.props.lexicon.request_successful
                        }, () => this.notificationsDataGetRequest());
                    }
                },
                error: (r) => {
                    r = JSON.parse(r.response);
                    if (r.message) {
                        this.setState({
                            selected: [],
                            completed: 100,
                            deleteNotificationId: 0,
                            editNotificationItem: {},
                            resultDialog: true,
                            deleteDialog: false,
                            editNotificationDialog: false,
                            resultDialogTitle: this.props.lexicon.error_title,
                            resultDialogMessage: r.message
                        });
                    }
                }
            });
        });
    };

    /**
     * Request for delete notification
     * @param {Object} e
     */
    notificationDeleteRequest = e => {
        let { deleteNotificationId, selected } = this.state;

        this.setState({
            completed: 0
        }, () => {
            App.api({
                name: selected.length > 0 ?
                    'many' :
                    'one',
                model: 'report',
                type: 'DELETE',
                resource: selected.length === 0 && deleteNotificationId,
                data: selected.length > 0 && selected,
                success: (r) => {
                    r = JSON.parse(r.response);
                    if (r) {
                        this.setState({
                            selected: [],
                            completed: 100,
                            deleteNotificationId: 0,
                            editNotificationItem: {},
                            resultDialog: true,
                            deleteDialog: false,
                            resultDialogTitle: this.props.lexicon.success_title,
                            resultDialogMessage: this.props.lexicon.request_successful,
                        }, () => this.notificationsDataGetRequest());
                    }
                },
                error: (r) => {
                    r = JSON.parse(r.response);
                    if (r.message) {
                        this.setState({
                            selected: [],
                            completed: 100,
                            deleteNotificationId: 0,
                            editNotificationItem: {},
                            resultDialog: true,
                            deleteDialog: false,
                            resultDialogTitle: this.props.lexicon.error_title,
                            resultDialogMessage: r.message
                        });
                    }
                }
            });
        });
    };


    /**
     * Render component
     * @return {Object} jsx object
     */
    render() {
        let { classes } = this.props;
        let {
            data,
            start,
            limit,
            total,
            status,
            selected,
            completed,
            editNotificationItem,
            deleteDialog,
            resultDialog,
            editNotificationDialog,
            resultDialogTitle,
            resultDialogMessage,
        } = this.state;

        if (this.state.langLoaded === false) 
            return <div className="create-page__container">
                <LinearProgress color="secondary" variant="determinate" value={0} />
            </div>

        return <div className="users-list__container">
            {completed === 0 &&
            <LinearProgress color="secondary" variant="determinate" value={completed} />}

            <Header
                title={this.props.lexicon.notifications_list} />
            <Menu />

            <TopTitle
                title={''}
                addButtonDisplay={false}
                saveButtonDisplay={false}
                deleteButtonDisplay={false}

                addButtonTitle={this.props.lexicon.new_notification}
                saveButtonTitle={this.props.lexicon.save_label}
                trashButtonTitle={this.props.lexicon.empty_trash_label}
                duplicateButtonTitle={this.props.lexicon.duplicate_label}
                deleteButtonTitle={this.props.lexicon.delete_selected_button}
                recoveryButtonTitle={this.props.lexicon.recovery_button}

                onCheckButtonClicked={() => {
                    this.setState({
                        editNotificationDialog: true
                    });
                }}
/*                onDeleteButtonClicked={() => {
                    this.setState({
                        deleteDialog: true
                    });
                }}*/ />

            <PaperToolBar
                searchShow={false}
                contextShow={false}
                notificationStatusShow
                statusTitle={this.props.lexicon.filter_status}
                notificationStatusDefaultValue={status}
                onNotificationStatusSelected={status => {
                    this.setState({ status }, () => {
                        this.notificationsDataGetRequest();
                    });
                }} />

            <Grid container spacing={24} className={classes.root}>
                <Grid item xs={12}>
                    {completed === 100 && <PaperTable
                        data={data}
                        page={start}
                        limit={limit}
                        total={total}
                        except={[
                            'id',
                            'check',
                        ]}
                        columns={[{
                            id: 'name',
                            numeric: false,
                            disablePadding: true,
                            label: this.props.lexicon.login_name
                        }, {
                            id: 'email',
                            numeric: false,
                            disablePadding: true,
                            label: this.props.lexicon.table_email
                        }, {
                            id: 'phone',
                            numeric: false,
                            disablePadding: true,
                            label: this.props.lexicon.phone_label
                        }, {
                            id: 'created_at',
                            numeric: false,
                            disablePadding: true,
                            label: this.props.lexicon.table_created_date
                        }, {
                            id: 'updated_at',
                            numeric: false,
                            disablePadding: true,
                            label: this.props.lexicon.table_updated_date
                        }, {
                            id: 'products',
                            numeric: false,
                            disablePadding: true,
                            label: this.props.lexicon.products_tab
                        }, {
                            id: 'control',
                            numeric: false,
                            disablePadding: true,
                            cssClassName: 'buttonField',
                            label: this.props.lexicon.table_manage
                        }]}
                        onRowsSelected={selected => this.setState({ selected })}
                        onStartValueChanged={start => {
                            this.setState({
                                start,
                            }, () => this.notificationsDataGetRequest());
                        }}
                        onLimitValueChanged={limit => this.setState({ limit }, () => { this.notificationsDataGetRequest() })} />}
                </Grid>
            </Grid>

            {resultDialog === true && <DialogError
                title={resultDialogTitle}
                defaultValue={resultDialog}
                message={resultDialogMessage}
                onDialogClosed={() => this.setState({
                    resultDialog: false
                })} />}

            {deleteDialog === true && <DialogDelete

                title={this.props.lexicon.delete_button}
                content={this.props.lexicon.delete_confirm}

                defaultValue={deleteDialog}
                onDialogClosed={() => this.setState({
                    deleteDialog: false,
                })}
                onDialogConfirmed={() => this.notificationDeleteRequest()} />}

            {editNotificationDialog && <DialogNotification
                data={editNotificationItem}
                title={this.props.lexicon.change_status}
                content={this.props.lexicon.notification_status}
                defaultValue={editNotificationDialog}
                onDialogClosed={() => this.setState({
                    editNotificationDialog: false,
                    editNotificationItem: {},
                    editNotificationId: 0
                })}
                onDialogConfirmed={data => this.notificationPutRequest(data)} />}
        </div>
    }
}

let styles = theme => ({
    root: {
        width: '100%',
        margin: 0,
        padding: 0,
    },
    buttonField: {
        textAlign: 'center'
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

export default connect(mapStateToProps, mapDispatchToProps)(withStyles(styles)(ListAvailabilityNotificationsContainer));