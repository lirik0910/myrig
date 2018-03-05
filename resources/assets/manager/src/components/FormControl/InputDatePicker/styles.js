const styles = theme => ({
	formControl: {
		margin: theme.spacing.unit,
		width: '100%',
	},
	dateInput: {
		width: '100%',
	},
	label: {
		fontSize: '12px',
		textAlign: 'left',
		color: 'rgba(0, 0, 0, 0.54)',
	},
	'@global': {
		'.date-picker__container input': {
			padding: '3px 0'
		}
	}
});

export default styles;