const webpack = require('webpack');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const path = require('path');

var PROD = 0;//JSON.parse(process.env.PROD_ENV || '0');
var pathTo = {
    dist: path.resolve(__dirname, 'dist'),
    js: path.resolve(__dirname, 'src/js/'),
    css: path.resolve(__dirname, 'src/css/')
};

// webpack --progress --colors --watch
module.exports = {

    entry: {
        main: pathTo.js + '/main.js',
        // signup: pathTo.js + '/repo/sign/signup.js'
    },
    output: {
        filename: PROD ? '[name].min.js' : '[name].js',
        path: pathTo.dist
    },

    plugins: PROD ? [
            new ExtractTextPlugin('main.css'),
            new webpack.ProvidePlugin({$: 'jquery'}),
            new webpack.optimize.UglifyJsPlugin()
        ] : [
            new ExtractTextPlugin('main.css'),
            new webpack.ProvidePlugin({$: 'jquery'})
        ],

    resolve: { // path to scripts for imports & require in .js
        modules: [pathTo.js, 'node_modules']
    },

    module: {
        rules: [

            { // it need if we want use Uglify with es6
                test: /\.js$/,
                exclude: /(node_modules|bower_components)/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['env']
                    }
                }
            },

            { // Extract css
                test: /\.scss$/,
                loader: ExtractTextPlugin.extract({
                    fallback: 'style-loader',
                    use: 'css-loader!sass-loader',

                    use: [{loader: 'css-loader'},{
                            loader: 'sass-loader',
                            options: {
                                includePaths: [
                                    pathTo.css
                                ]
                            }
                        }
                    ]
                })
            },

            {test: /\.(png||svg)$/, loader: 'url-loader?limit=100000'},
            {test: /\.jpg$/, loader: 'file-loader'},
            {test: /\.twig$/, loader: "twig-loader"}
        ]
    }

};