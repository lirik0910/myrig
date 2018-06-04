/**
 * Select page module
 * @module PriceField
 * @author Ihor Bielchenko
 * @requires react
 */

import React, { Component } from 'react';

import Grid from 'material-ui/Grid';
import Dialog from 'material-ui/Dialog';
import Typography from 'material-ui/Typography';
import IconButton from 'material-ui/IconButton';
import Slide from 'material-ui/transitions/Slide';
import PaperFileManager from '../PaperFileManager/PaperFileManager.jsx';
import PaperFolderManager from '../PaperFolderManager/PaperFolderManager.jsx';

import CloseIcon from 'material-ui-icons/Close';

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
class DialogFileManager extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		open: false,
		title: 'Select image',
		classes: PropTypes.object.isRequired,
		onDialogClosed: () => {},
		onFileSelected: () => {}
	}

	state = {
		path: '/',
		ready: true
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { ready, path } = this.state;
		let { classes, title, open } = this.props;

		return <Dialog
				fullScreen
				open={open}
				transition={Transition}>
				
				<Grid container spacing={24} className={classes.root}>
					<Grid item xs={11}>
						<Typography className={classes.title}>
							{title}
						</Typography>
					</Grid>

					<Grid item xs={1}>
						<IconButton 
							className={classes.button} 
							color="secondary"
							aria-label="Close"
							onClick={e => this.props.onDialogClosed()}>
							
							<CloseIcon />
						</IconButton>
					</Grid>
				</Grid>

				<Grid container spacing={24} className={classes.root}>
					<Grid item xs={6}>
						<PaperFolderManager
							defaultPath={path}
							onFolderChanged={path => this.setState({ ready: false }, () => {
								this.setState({
									path,
									ready: true
								});
							})} />
					</Grid>

					<Grid item xs={6}>
						{ready === true && <PaperFileManager
							onFileSelected={data => this.props.onFileSelected(data)}
							defaultPath={path} />}
					</Grid>
				</Grid>
			</Dialog>
	}
}

export default withStyles(styles)(DialogFileManager);