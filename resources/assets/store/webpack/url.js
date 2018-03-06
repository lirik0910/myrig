module.exports = function(path) {
	return {
		module: {
			rules: [{
				test: /\.(woff|woff2|eot|ttf|svg)$/,
				loader: 'url-loader?limit=100000'
			}]
		}
	}
};