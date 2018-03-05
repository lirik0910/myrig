const styles = theme => ({
	root: {
		margin: 0,
		width: '100%',
		boxShadow: '0 0 1px rgba(0, 0, 0, 0.5)'
	},
	control: {
		width: '40px',
		minWidth: '40px',
		padding: '8px',
		display: 'inline-block'
	},
	search: {
		minWidth: '36px',
		minHeight: '36px',
		padding: 0,
		margin: '0 2px',
		borderRadius: 1000
	},
	textFieldInput: {
		borderRadius: 4,
		backgroundColor: theme.palette.common.white,
		border: '1px solid #ced4da',
		fontSize: 14,
		padding: '8px 10px',
		margin: '6px 0 0 6px'
	},
	formControl: {
		display: 'block',
		margin: '12px 0'
	},
	textField: {
		width: '328px'
	}
});

export default styles;