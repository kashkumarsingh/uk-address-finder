const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const ImageMinimizerPlugin = require('image-minimizer-webpack-plugin');

const isProduction = process.env.NODE_ENV === 'production';

module.exports = {
    entry: {
        'uk-address-finder': './assets/src/js/uk-address-finder.js', // Entry JS file for UK Address Finder
    },
    output: {
        path: path.resolve(__dirname, 'assets/dist'), // Output directory for assets
        filename: 'js/[name].min.js', // Output JavaScript file
    },
    module: {
        rules: [
            {
                test: /\.scss$/, // SCSS processing
                use: [
                    MiniCssExtractPlugin.loader, // Extract CSS into separate files
                    'css-loader',
                    'sass-loader', // Compiles SCSS to CSS
                ],
            },
            {
                test: /\.js$/, // JS processing with Babel
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env'], // Transpile ES6+ to ES5
                    },
                },
            },
        ],
    },
    resolve: {
      extensions: ['.js', '.json'],  // Ensure .js and .json files are resolved automatically
    },
    plugins: [
        new CleanWebpackPlugin(), // Clean old builds from output directory
        new MiniCssExtractPlugin({
            filename: 'css/[name].min.css', // Output CSS file
        }),
        new ImageMinimizerPlugin({
            test: /\.(png|jpe?g|gif|webp)$/i,
            minimizer: {
                implementation: ImageMinimizerPlugin.imageminGenerate,
                options: {
                    plugins: [['imagemin-webp', { quality: 50 }]], // Convert images to WebP format
                },
            },
        }),
    ],
    optimization: {
        minimize: isProduction,
        minimizer: [
            new TerserPlugin(), // Minify JS
            new CssMinimizerPlugin(), // Minify CSS
        ],
    },
    mode: isProduction ? 'production' : 'development', // Set mode based on environment
    devtool: isProduction ? false : 'source-map', // Source maps for debugging in development
};
