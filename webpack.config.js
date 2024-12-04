const Encore = require('@symfony/webpack-encore');

Encore
  .setOutputPath('public/build/')
  .setPublicPath('/build')
  .addEntry('app', './assets/app.js')
  .enableSassLoader()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning(Encore.isProduction())
  .enableStimulusBridge('./assets/controllers.json')
  .autoProvidejQuery()
  .enableSingleRuntimeChunk();

module.exports = Encore.getWebpackConfig();
