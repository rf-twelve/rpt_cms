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

mix.js('resources/js/app.js', 'public/js')
		.sass('resources/sass/app.scss', 'public/css')
		.copyDirectory('node_modules/admin-lte/plugins/fontawesome-free', 'public/plugins/fontawesome-free')
		.copyDirectory('node_modules/admin-lte/plugins/jquery', 'public/plugins/jquery')
		.copyDirectory('node_modules/admin-lte/plugins/bootstrap', 'public/plugins/bootstrap')
        .copyDirectory('node_modules/admin-lte/plugins/sweetalert2', 'public/plugins/sweetalert2')
		.copyDirectory('node_modules/admin-lte/plugins/sweetalert2-theme-bootstrap-4', 'public/plugins/sweetalert2-theme-bootstrap-4')
		// .copyDirectory('node_modules/alpinejs', 'public/plugins/alpinejs')
    .sourceMaps(true, 'source-map')

