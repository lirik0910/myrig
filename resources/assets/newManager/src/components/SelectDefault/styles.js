export default theme => {
	return {
		root: {
			display: 'flex',
			flexWrap: 'wrap',
		},
		formControl: {
			marginTop: 2,
			marginBottom: 8,
			width: '100%',
		},
		selectEmpty: {
			marginTop: theme.spacing.unit * 2,
		},
		helper: {
			marginLeft: 12,
			marginRight: 12
		}
	}
}