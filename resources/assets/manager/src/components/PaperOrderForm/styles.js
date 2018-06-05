const styles = theme => ({
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
	root: {
		width: '100%',
		margin: 0,
		padding: 0,
	},
	numberCell: {
		margin: '12px 0',
	},
	numberItem: {
		fontSize: 32,
		marginLeft: 8,
		marginRight: 8
	},
	statusItem: {
		fontSize: 15,
		marginLeft: 4,
		marginRight: 4 
	},
	costItem: {
		color: '#000000',
		fontFamily: 'Arial',
		fontSize: 18,
		marginLeft: 4
	},
	fieldItem: {
		fontSize: 13,
		margin: '6px 0'
	},
	right: {
		textAlign: 'right'
	},
});

export default styles;