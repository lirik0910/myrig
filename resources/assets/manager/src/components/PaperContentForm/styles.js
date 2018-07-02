const styles = theme => ({
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
	textField: {
		margin: '8px 8px 14px 8px',
		width: '100%',
	},
	toolbarEditor: {
		fontFamily: 'arial'
	},
	contentEditor: {
		fontFamily: 'arial',
		color: '#000',
		height: '594px'
	},
});

export default styles;