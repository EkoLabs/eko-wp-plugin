'use srtict';

// Require path.
const path = require( 'path' );

// Configuration object.
const config = {

	// Create the entry points.
	// One for frontend and one for the admin area.
	entry: {
		videoPostType: './src/js/videoPostType.js',
		shortcodeIframe: './src/js/shortcodeIframe.js'
	},

	// Create the output files.
	// One for each of our entry points.
	output: {

		// [name] allows for the entry object keys to be used as file names.
		filename: 'js/[name].js',

		// Specify the path to the JS files.
		path: path.resolve( __dirname, 'dist' )
	},

	// Setup a loader to transpile down the latest and great JavaScript so older browsers
	// can understand it.
	module: {
		rules: [
			{

				// Look for any .js files.
				test: /\.js$/,

				// Exclude the node_modules folder.
				exclude: /node_modules/,

				// Use babel loader to transpile the JS files.
				loader: 'babel-loader'
			},
			{
				test: /\.css$/,
				use: [ 'style-loader', 'css-loader' ]
			},
			{
				test: /\.(png|svg|jpg|gif)$/,
				use: [ 'file-loader' ]
			}
		]
	}
};

// Export the config object.
module.exports = config;
