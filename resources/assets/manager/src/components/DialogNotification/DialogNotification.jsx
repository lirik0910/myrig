/**
 * Header block module
 * @module Notifications
 * @author Ivan Bastryhin
 * @requires react
 * @requires react#Component
 * @requires redux#bindActionCreators
 * @requires react-redux#connect
 */

import React, { Component } from 'react';

import Dialog, {
    DialogActions,
    DialogContent,
    DialogContentText,
    DialogTitle,
} from 'material-ui/Dialog';
import Button from 'material-ui/Button';
import TextField from 'material-ui/TextField';
import { FormControl } from 'material-ui/Form';
import Slide from 'material-ui/transitions/Slide';
import SelectPolicy from '../FormControl/SelectPolicy/SelectPolicy.jsx';

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
 * Header block
 * @extends Component
 */
class DialogNotification extends Component {

    /**
     * Init default props
     * @type {Object}
     * @inner
     * @property {Object} classes Material defult classes collection
     */
    static defaultProps = {
        data: {},
        defaultValue: false,
        title: 'Change Status',
        onDialogClosed: () => {},
        onDialogConfirmed: () => {},
        classes: PropTypes.object.isRequired,
        content: 'Are you sure want to change notification status?',
    };

    state = {
        editDialogOpen: this.props.defaultValue,
    };

    /**
     * Render component
     * @return {Object} jsx object
     */
    render() {
        let { title, content } = this.props;
        let { editDialogOpen } = this.state;

        return <Dialog
            open={editDialogOpen}
            transition={Transition}
            keepMounted
            aria-labelledby="dialog-delete-slide-title"
            aria-describedby="dialog-delere-slide-content">

            <DialogTitle id="dialog-delete-slide-title">
                {title}
            </DialogTitle>

            <DialogContent>
                <DialogContentText id="dialog-delete-slide-text">
                    {content}
                </DialogContentText>
            </DialogContent>

            <DialogActions>
                <Button
                    color="primary"
                    onClick={e => this.setState({
                        editDialogOpen: false
                    }, () => this.props.onDialogClosed())}>
                    Cancel
                </Button>

                <Button color="primary"
                        onClick={e => this.props.onDialogConfirmed()}>
                    YES
                </Button>
            </DialogActions>
        </Dialog>
    }
}

export default withStyles(styles)(DialogNotification);