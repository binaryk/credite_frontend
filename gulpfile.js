var elixir = require("laravel-elixir");

require("laravel-elixir-webpack");

elixir(function(mix) {
    mix.scripts([
      "jquery/jquery.min.js",
      "jquery/jquery-migrate.min.js",
        "../../../public/assets/global/plugins/bootstrap/js/bootstrap.min.js",
    ]);

	/*mix.webpack("main.js", {
		outputDir: "public/js",
    module: {
      test: /\.js?$/,
      loader: 'babel-loader',
      exclude: /node_modules/,
      query: {
        presets: ['es2015']
      }
    },
		output: {
			filename: "bundle.js"
		}
	});*/

/*	mix.babel([
		'main.js',
	]);*/
});
