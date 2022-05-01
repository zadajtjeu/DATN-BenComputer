const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.postCss('resources/css/default.css', 'public/css')
    .postCss('resources/css/responsive.css', 'public/css')
    .postCss('resources/css/style.css', 'public/css')
    .postCss('resources/css/meanmenu.css', 'public/css')
    .postCss('resources/css/app.css', 'public/css/custom.css')
    .js('resources/js/modernizr.js', 'public/js')
    .js('resources/js/main.js', 'public/js')
    .js('resources/js/plugins.js', 'public/js');
