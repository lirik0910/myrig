const styles = theme => ({
	root: {
		width: '100%',
		margin: 0,
		padding: 0,
	},
	title: {
		fontSize: '20px',
		textAlign: 'left'
	},
	paper: {
		padding: theme.spacing.unit * 2,
		textAlign: 'center',
		color: theme.palette.text.secondary,
	},
	textField: {
		margin: '8px 8px 14px 8px',
		width: '100%',
	},
	formControl: {
		margin: theme.spacing.unit,
		minWidth: '100%',
	},
	toolbarEditor: {
		fontFamily: 'arial'
	},
	contentEditor: {
		fontFamily: 'arial',
		color: '#000',
		height: '226px'
	}
});

export default styles;