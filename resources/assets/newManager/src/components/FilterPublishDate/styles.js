export default theme => {
	return {
		root: {
			width: 'calc(100% - 24px)',
			padding: 12,
			display: 'block',
			position: 'relative'
		},
		picker: {
			display: 'block',
			'@global': {
				'div': {
					width: '100%'
				}
			},
		},
		clearBtn: {
			margin: 0,
			padding: 0,
			width: '100%'
		}
	}
}