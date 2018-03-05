const styles = theme => ({
	root: {
		margin: 0,
		width: '100%',
		height: '100%',
	},
	paper: {
		height: '100%',
	},
	overflow: {
		height: 'calc(100% - 106px)',
	},
	inner: {
		margin: 0,
		width: '100%',
	},
	pathField: {
		width: '100%'
	},
	button: {
		padding: 0,
		minWidth: '32px',
	},
	add: {
		fontSize: '18px',
		margin: '8px'
	},
	folder: {
		boxShadow: 'none',
		borderBottom: '1px solid #B9B9B9'
	},
	folderName: {
		width: '100%',
		fontSize: '18px',
		display: 'block',
		textAlign: 'left',
		textTransform: 'initial',
	},
	img: {
		display: 'block',
		maxHeight: '72px'
	},
	fileName: {
		fontSize: '13px'
	}
});

export default styles;