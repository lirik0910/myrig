import { lighten } from 'material-ui/styles/colorManipulator';

const toolbarStyles = theme => ({
	root: {
		paddingRight: theme.spacing.unit,
	},
	highlight:
		theme.palette.type === 'light' ? {
			color: theme.palette.secondary.dark,
			backgroundColor: lighten(theme.palette.secondary.light, 0.4),
		} : {
			color: lighten(theme.palette.secondary.light, 0.4),
			backgroundColor: theme.palette.secondary.dark,
		},
		spacer: {
			flex: '1 1 100%',
		},
		actions: {
			color: theme.palette.text.secondary,
		},
		title: {
			flex: '0 0 auto',
		},
	}
);

export default toolbarStyles;