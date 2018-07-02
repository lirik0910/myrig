export default theme => {
	return {
		appBar: {
			position: 'relative',
		},
		flex: {
			flex: 1
		},
		iconButton: {
			color: theme.Header.color,
			...theme.Header.space
		}
	}
}