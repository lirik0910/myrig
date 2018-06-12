export default {
	'@global': {
		'.paper-table__container': {
			fontSize: 12,
			fontFamily: 'arial',
		},

		'.paper-table__container > table': {
			width: '100%',
			fontFamily: 'arial',
			borderCollapse: 'collapse'
		},

		'.paper-table__container .header__container': {
			height: 54,
			fontSize: 12,
			color: '#727272',
			borderBottom: '1px solid #EFEFEF'
		},

		'.paper-table__container .tr__container': {
			borderBottom: '1px solid #EFEFEF',
			'&:hover': {
				cursor: 'pointer',
				backgroundColor: '#F7F7F7'
			}
		},

		'.paper-table__container td': {
			padding: 10,
			position: 'relative'
		},

		'.paper-table__container .footer__container': {
			height: 54,
			display: 'flex',
			color: '#727272',
			alignItems: 'center',
			borderBottom: '1px solid #EFEFEF'
		},

		'.paper-table__container .footer__container .footer__item': {
			marginLeft: 12,
			marginRight: 12,
			display: 'flex',
			alignItems: 'center'
		},

		'.paper-table__container .pagging__button': {
			cursor: 'pointer',
			'&:hover': {
				color: '#A5A5A5'
			}
		}
	},
};