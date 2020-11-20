const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
	entry: ['./www/assets/src/css/main.scss', './www/assets/src/js/main.js'],
	output: {
		filename: 'js/main.js',
		path: path.resolve(__dirname, 'www/assets/dist'),
		publicPath: '../'
	},
	plugins: [
		new MiniCssExtractPlugin({
			filename: 'css/style.css',
		}),
	],
	module: {
		rules: [
			{
				test: /\.scss$/,
				use: [
					{
						loader: MiniCssExtractPlugin.loader
					},
					'css-loader',
					'sass-loader'
				]
			},
			{
				test: /\.(woff(2)?|ttf|eot|svg)(\?v=\d+\.\d+\.\d+)?$/,
				use: [
					{
						loader: 'file-loader',
						options: {
							name: '[name].[ext]',
							outputPath: 'fonts/'
						}
					}
				]
			}
		]
	}
};