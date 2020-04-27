const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');

function recursiveIssuer(m) {
	if (m.issuer) {
		return recursiveIssuer(m.issuer);
	} else if (m.name) {
		return m.name;
	} else {
		return false;
	}
}

module.exports = {
	context: __dirname,
	entry: {
		'main': ['../assets/js/builds/index.js', '../assets/scss/main.scss' ],
		'editor-style': '../assets/js/builds/editor-style.js',
		'editor-layout': '../assets/js/builds/editor-layout.js'
	},
	output:{
		path: path.resolve(__dirname, '../dist' ),
		filename: '[name]-bundle.js'
	},
	plugins: [
		new MiniCssExtractPlugin({
			filename: '/css/[name].css',
			chunkFilename: '[id].css'
		}),
		new BrowserSyncPlugin(
			{
			files: '**/*.php',
			host: 'localhost',
			port: '3000',
			proxy: 'https://UPDATEDOMAIN.test'
			}
		)
	],
	module: {
		rules: [
			{
				test: /\.(css|scss)$/,
				use: [
					MiniCssExtractPlugin.loader,
					'css-loader',
					{
						loader: 'postcss-loader' },
					{
						loader: 'resolve-url-loader' },
					{
						/* for resolver-url-loader:
							source maps must be esnabled on any preceding loader */
						loader: 'sass-loader?sourceMap' }
				]
			},
			{
				test: /\.svg$/,
				loader: 'svg-inline-loader'
			},
			{
				enforce: 'pre',
				exclude: /node_modules/,
				test: /\.jsx$/,
				loader: 'eslint-loader'
			},
			{
				// Look for any .js files.
				test: /\.js$/,
				// Exclude the node_modules folder.
				exclude: /node_modules/,
				// Use babel loader to transpile the JS files.
				loader: 'babel-loader'
			}
		]
	}
}