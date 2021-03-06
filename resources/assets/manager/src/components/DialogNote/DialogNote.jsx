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

import { connect } from 'react-redux';

import Dialog, {
    DialogActions,
    DialogContent,
    DialogContentText,
    DialogTitle,
} from 'material-ui/Dialog';
import Button from 'material-ui/Button';
import TextField from 'material-ui/TextField';
import { FormControl } from 'material-ui/Form';
import SelectNoticeType from '../FormControl/SelectNoticeType/SelectNoticeType.jsx'
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
     * @property {Object} classes Material default classes collection
     */
    static defaultProps = {
        data: {},
        defaultValue: false,
        title: 'Create note',
        inputDefaultValue: '',
        noteTypes: {},
        onDialogClosed: () => {},
        onDialogConfirmed: () => {},
        onNoteTypeSelected: () => {},
        onNoteFieldInputed: () => {},
        classes: PropTypes.object.isRequired,
        content: 'Text your note for this order',
    };

    state = {
        createDialogOpen: this.props.defaultValue,
    };

    handleChangeType = value => {
        //var target = e.target;
        this.props.onNoteTypeSelected(value);
        //console.log(value);
    }

    handleInputField = e => {
        var target = e.target;
        this.props.onNoteFieldInputed(target.value);
    }

    /**
     * Render component
     * @return {Object} jsx object
     */
    render() {
        let { title, content, noteTypes } = this.props;
        let { createDialogOpen } = this.state;
console.log(noteTypes);
        return <Dialog
            open={createDialogOpen}
            fullWidth={true}
            maxWidth={"md"}
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
                <SelectNoticeType
                    defaultValue={0}
                    data={noteTypes}
                    required={false}
                    title={'Select type'}
                    onItemSelected={value => this.handleChangeType(value)}
                />
                <TextField
                    multiline={true}
                    rows={2}
                    rowsMax={10}
                    fullWidth={true}
                    onInput={this.handleInputField}
                />
            </DialogContent>

            <DialogActions>
                <Button
                    color="primary"
                    onClick={e => this.setState({
                        editDialogOpen: false
                    }, () => this.props.onDialogClosed())}>
                    {this.props.lexicon.cancel_label}
                </Button>

                <Button color="primary"
                        onClick={e => this.props.onDialogConfirmed()}>
                    {this.props.lexicon.save_label}
                </Button>
            </DialogActions>
        </Dialog>
    }
}

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

export default connect(mapStateToProps)(withStyles(styles)(DialogNotification));