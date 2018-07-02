export default theme => {
	return {
		root: {
			flexGrow: 1,
		},
		flex: {
			flex: 1
		},
		iconButton: {
			color: theme.Header.color,
			...theme.Header.space
		},
		'@global': {
			'.header-lang__container': {
				width: 154,
				height: 64,
				overflow: 'hidden',
			},
			'.header-lang__container > div': {
				margin: '4px 0 0',
				padding: 0,
				height: 'calc(100% - 4px)',
				'&:before': {
					color: '#FFF !important',
					backgroundColor: '#FFF !important'
				},
				'&:after': {
					color: '#FFF !important',
					backgroundColor: '#FFF !important'
				},
				'&:focus': {
					color: '#FFF !important',
					backgroundColor: '#FFF !important'
				}
			},
			'.header-lang__container > div > div': {
				'&:before': {
					borderBottom: '1px solid #FFF !important'
				},
				'&:after': {
					borderBottom: '2px solid #FFF !important'
				}
			},
			'.header-lang__container > div > div > div > div': {
				padding: 0,
				color: '#FFF !important'
			},
			'.header-lang__container label': {
				color: '#FFF !important'
			},
			'.header-lang__container svg': {
				color: '#FFF !important'
			},
			'.header-lang__container p': {
				color: '#FFF !important'
			}
		},
	}
}