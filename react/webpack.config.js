const path = require('path');

module.exports = {
  entry: path.resolve(__dirname, '../react/components/SearchComponent.jsx'), // Ensure correct path
  output: {
    path: path.resolve(__dirname, '../public/reactbuild'),
    filename: 'bundle.js', // Single bundled file
  },
  module: {
    rules: [
      {
        test: /\.(js|jsx)$/, // Match both .js and .jsx files
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: [
              '@babel/preset-env', // For modern JavaScript
              '@babel/preset-react', // For React JSX
            ],
          },
        },
      },
    ],
  },
  resolve: {
    extensions: ['.js', '.jsx'], // Resolve both .js and .jsx
  },
  mode: 'production',
};