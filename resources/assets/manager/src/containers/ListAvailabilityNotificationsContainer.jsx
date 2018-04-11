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
    };

    /**
     * Invoked just before mounting occurs
     * @fires componentWillMount
     */
    componentWillMount() {
        this.notificationsDataGetRequest();
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
                                onCheckButtonClicked={item => {
                                    this.setState({
                                        editNotificationDialog: true,
                                        editNotificationItem: item,
                                        editNotificationId: item.id
                                    });
                                }}
                                onDeleteButtonClicked={item => {
                                    this.setState({
                                        deleteDialog: true,
                                        deleteUserId: item.id,
                                    });
                                }} />
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
                            resultDialogTitle: 'Success',
                            resultDialogMessage: 'Notification status has been changed'
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
                            resultDialogTitle: 'Error',
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
                            resultDialogTitle: 'Success',
                            resultDialogMessage: 'The request was successful'
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
                            resultDialogTitle: 'Error',
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

        return <div className="users-list__container">
            {completed === 0 &&
            <LinearProgress color="secondary" variant="determinate" value={completed} />}

            <Header
                title={'Notifications list'} />
            <Menu />

            <TopTitle
                title={''}
                addButtonDisplay={false}
                saveButtonDisplay={false}
                deleteButtonDisplay={selected.length > 0 ?
                    true :
                    false}
                addButtonTitle={'Add new notification'}
                deleteButtonTitle={'Delete selected'}
                onCheckButtonClicked={() => {
                    this.setState({
                        editNotificationDialog: true
                    });
                }}
                onDeleteButtonClicked={() => {
                    this.setState({
                        deleteDialog: true
                    });
                }} />

            <PaperToolBar
                searchShow={false}
                contextShow={false}
                notificationStatusShow
                statusTitle={'Filter by status'}
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
                            label: 'Name'
                        }, {
                            id: 'email',
                            numeric: false,
                            disablePadding: true,
                            label: 'Email'
                        }, {
                            id: 'phone',
                            numeric: false,
                            disablePadding: true,
                            label: 'Phone'
                        }, {
                            id: 'created_at',
                            numeric: false,
                            disablePadding: true,
                            label: 'Created date'
                        }, {
                            id: 'updated_at',
                            numeric: false,
                            disablePadding: true,
                            label: 'Updated date'
                        }, {
                            id: 'products',
                            numeric: false,
                            disablePadding: true,
                            label: 'Products'
                        }, {
                            id: 'control',
                            numeric: false,
                            disablePadding: true,
                            cssClassName: 'buttonField',
                            label: 'Manage'
                        }]}
                        onRowsSelected={selected => this.setState({ selected })}
                        onStartValueChanged={start => {
                            this.setState({
                                start,
                            }, () => this.notificationsDataGetRequest());
                        }}
                        onLimitValueChanged={limit => this.setState({ limit })} />}
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
                defaultValue={deleteDialog}
                onDialogClosed={() => this.setState({
                    deleteDialog: false,
                })}
                onDialogConfirmed={() => this.notificationDeleteRequest()} />}

            {editNotificationDialog && <DialogNotification
                data={editNotificationItem}
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

export default withStyles(styles)(ListAvailabilityNotificationsContainer);