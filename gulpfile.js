const elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

    elixir(mix => {
        mix.styles([
        './node_modules/admin-lte/bootstrap/css/bootstrap.min.css',
        './node_modules/admin-lte/dist/css/AdminLTE.min.css',
        './node_modules/admin-lte/dist/css/skins/skin-blue.min.css'
    ]);

    mix.sass([
        './node_modules/bootstrap-sass/assets/stylesheets/_bootstrap.scss',
        './resources/assets/sass/app.scss'
    ]);

    mix.scripts([
        './node_modules/admin-lte/plugins/jQuery/jQuery-2.2.3.min.js',
        './node_modules/admin-lte/dist/js/app.min.js',
        './node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js',
        './resources/assets/js/app.js'
    ]);

    elixir(function(mix) {
        mix.version(['css/all.css', 'css/app.css', 'js/all.js']);
    });

    mix.copy('./resources/assets/images/**/*.*', 'public/images');
});

