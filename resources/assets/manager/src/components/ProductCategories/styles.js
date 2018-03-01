const styles = theme => ({
	root: {
		width: '100%',
		maxWidth: 360,
		backgroundColor: theme.palette.background.paper,
	},
	nested: {
		paddingLeft: theme.spacing.unit * 4,
	},
	nested2: {
		paddingLeft: theme.spacing.unit * 8,
	},
});

export default styles;