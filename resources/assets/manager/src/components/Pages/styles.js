const styles = theme => ({
	root: {
		width: '100%',
		boxShadow: '0 0 1px rgba(0, 0, 0, 0.5)'
	},
	summary: {
		minHeight: '50px',
		boxShadow: '0 0 1px rgba(0, 0, 0, 0.2)'
	},
	heading: {
		fontSize: theme.typography.pxToRem(20),
		lineHeight: 2.5,
	},
	button: {
		margin: theme.spacing.unit,
	},
	options: {
		textAlign: 'right'
	},
	expansion: {
		boxShadow: 'none'
	},
	details: {
		display: 'block',
		paddingTop: 0
	}
});

export default styles;