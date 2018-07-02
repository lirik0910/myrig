/**
 * App theme styles
 * @requires @material-ui/core/styles#createMuiTheme
 * @requires @material-ui/core/colors/green
 */

import { createMuiTheme } from '@material-ui/core/styles';
import green from '@material-ui/core/colors/green';

/**
 * Custom theme creating
 */
export default createMuiTheme({
	palette: {
		primary: green,
	},
	Header: {
		color: '#FFF',
		space: {
			marginRight: 12
		}
	},
	typography: {
		title: {
			padding: 12
		},
		headline: {
			color: '#FFF'
		},
		display1: {
			color: '#60A645'
		},
		display2: {
			fontSize: 18
		},
		subheading: {
			fontSize: 14,
			margin: '4px 0'
		}
	},
	defaultColor: '#60A645'
});