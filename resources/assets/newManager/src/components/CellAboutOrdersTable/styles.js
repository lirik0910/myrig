export default theme => {
	return {
		allOrders: {
			margin: '0 4px',
			cursor: 'pointer',
			textDecoration: 'underline',
			color: theme.defaultColor,
			'&:hover': {
				textDecoration: 'none'
			}
		}
	}
}