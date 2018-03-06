/**
 * @module webpack.config
 * @author ihor bielchenko
 * @requires path
 * @requires webpack
 * @requires html-webpack-plugin
 * @requires webpack-merge
 * @requires webpack/pug
 * @requires webpack/sass
 * @requires webpack/css
 * @requires webpack/css.extract
 * @requires webpack/js.uglify
 * @requires webpack/images
 * @requires webpack/babel
 * @requires webpack/url
 */

/** 
 * Module provides utilities for working with file and directory paths
 * @constant path
 * @type {Object}
 */
const path = require('path');

/** 
 * Webpack object
 * @type {Object}
 */
const webpack = require('webpack');

/** 
 * Webpack plugin for generate html files
 * @type {Object}
 */
const HtmlWebpackPlugin  = require('html-webpack-plugin');

/** 
 * Provides a merge function that concatenates arrays and merges objects creating a new object. 
 * @type {Function}
 */
const merge = require('webpack-merge');

/** 
 * Webpack pag config module
 * @type {Function}
 */
const pug = require('./webpack/pug');

/** 
 * Webpack devserver config module 
 * @type {Function}
 */
const devserver = require('./webpack/devserver');

/** 
 * Webpack sass config module 
 * @type {Function}
 */
const sass = require('./webpack/sass');

/** 
 * Webpack css config module 
 * @type {Function}
 */
const css = require('./webpack/css');

/** 
 * Webpack css.extract config module 
 * @type {Function}
 */
const extractCSS = require('./webpack/css.extract');

/** 
 * Webpack js.uglify config module 
 * @type {Function}
 */
const uglifyJS = require('./webpack/js.uglify');

/** 
 * Webpack images config module 
 * @type {Function}
 */
const images = require('./webpack/images');

/** 
 * Webpack babel config module 
 * @type {Function}
 */
const babel = require('./webpack/babel');

/** 
 * Webpack url config module 
 * @type {Function}
 */
const url = require('./webpack/url');

const PATHS = {
	src: path.join(__dirname, 'src'),
	build: path.join(__dirname, 'build')
}

const common = merge([
	{
		entry: {
			//'index': PATHS.src +'/pages/index/index.js',
			//'about': PATHS.src +'/pages/about/about.js',
			'shop': PATHS.src +'/pages/shop/shop.js'
		},
		output: {
			path: PATHS.build,
			filename: 'js/[name].js'
		},
		plugins: [
			/*new HtmlWebpackPlugin({
				filename: 'index.html',
				chunks: ['index', 'common'],
				template: PATHS.src +'/pages/index/index.pug'
			}),*/
			/*new HtmlWebpackPlugin({
				filename: 'about.html',
				chunks: ['about', 'common'],
				template: PATHS.src +'/pages/about/about.pug'
			}),*/
			new HtmlWebpackPlugin({
				filename: 'shop.html',
				chunks: ['shop', 'common'],
				template: PATHS.src +'/pages/shop/shop.pug'
			}),
			new webpack.optimize.CommonsChunkPlugin({
				name: 'common'
			}),
			new webpack.ProvidePlugin({
				$: 'jquery',
				jQuery: 'jquery'
			})
		]
	},
	pug(),
	images(),
	url(),
])

module.exports = (env) => {
	if(env === 'production')
		return merge([
			common,
			extractCSS(),
			babel(),
			uglifyJS()
		])

	if(env === 'development') {
		return merge([
			common,
			devserver(),
			sass(),
			css(),
		])
	}
}