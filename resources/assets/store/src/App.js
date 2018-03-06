/**
 * Base app class. It contains base props and initializations base events
 * @class Base
 * @author ihor bielchenko
 */
export default class App {

	/**
	 * @constructor
	 * @param {Object} props
	 */
	constructor(props) {
		/** 
		 * Parent's props
		 * @member {Object} parent
		 */
		this.parent = this.__proto__;

		/** 
		 * There are parameters were sent to component via creating object
		 * @member {Object} props
		 */
		this.props = props;

		/** 
		 * Object of saved useful dom elements
		 * @inner
		 */
		this.dom = {
			window: $(window),
			document: $(document),
		}

		this.dom.window.resize((e) => this.onResize(e));

		this.dom.window.on('load', e => this.onReady(e));

		this.dom.window.on('scroll', e => this.onScroll(e));
	}

	/**
	 * It runs when window was loaded
	 * @fires load
	 * @param {Object} e
	 */
	onReady(e) {}

	/**
	 * Runs when window is scrolling
	 * @fires scroll
	 * @param {Object} e
	 */
	onScroll(e) {}

	/**
	 * Runs when window was changed sizes
	 * @fires resize
	 * @param {Object} e
	 */
	onResize(e) {}
}