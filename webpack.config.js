const Encore = require("@symfony/webpack-encore");
const path = require("path");

if (!Encore.isRuntimeEnvironmentConfigured()) {
  Encore.configureRuntimeEnvironment(process.env.NODE_ENV || "dev");
}

Encore.setOutputPath("public/build/")
  .setPublicPath("/build")
  .addEntry("app", "./assets/app.js")
  .splitEntryChunks()
  .enableReactPreset()
  .enableTypeScriptLoader()
  .enableStimulusBridge("./assets/controllers.json")
  .enableSingleRuntimeChunk()
  .cleanupOutputBeforeBuild()
  .enableBuildNotifications()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning(Encore.isProduction())
  .configureBabelPresetEnv((config) => {
    config.useBuiltIns = "usage";
    config.corejs = "3.23";
  })
  .enableSassLoader()
  .enablePostCssLoader()
  .addAliases({
    "@": path.resolve(__dirname, "assets"),
  })
  .copyFiles({
    from: "./assets/img/",
    to: "img/[path][name].[ext]",
  });

// TWIG
const fullConfig = Encore.getWebpackConfig();
fullConfig.devServer = {
  headers: {
    "Access-Control-Allow-Origin": "*",
  },
  watchFiles: {
    paths: ["templates/**/*.html.twig"],
  },
};

module.exports = fullConfig;
