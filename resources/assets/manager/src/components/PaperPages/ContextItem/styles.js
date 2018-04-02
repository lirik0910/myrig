const styles = theme => ({
	page: {
		margin: 0,
		width: '100%'
	},
	pageButton: {
		margin: 0,
		width: '100%',
		padding: '0 !important',
	},
	heading: {
		fontSize: theme.typography.pxToRem(20),
		lineHeight: 2.5,
	},
	'@global': {
		'.in-trash h3': {
			color: 'red',
			textDecoration: 'line-through'
		}
	}
});

export default styles;