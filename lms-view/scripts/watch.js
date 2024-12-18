const webpack = require('webpack');
const configFactory = require('../config/webpack.config');

// Provide a callback function for the watch option

process.env.BABEL_ENV = 'development';
process.env.NODE_ENV = 'development'; 
require('../config/env');
const config = configFactory('development');
webpack(config).watch({}, (err, stats) => {
  if (err || stats.hasErrors()) {
    console.error(err || stats.compilation.errors);
  }
  console.log(stats.toString({
    colors: true
  }));
});
