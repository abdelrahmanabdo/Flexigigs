let mix = require('laravel-mix');

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

// mix.js('resources/assets/js/app.js', 'public/js')
   // .sass('resources/assets/sass/app.scss', 'public/css');

mix.styles([
	    'public/css/jquery-ui.structure.min.css',
	    'public/css/jquery-ui.min.css',
	    'public/css/fontawesome.css',
	    'public/css/style.min.css',
	    'public/css/owl.carousel.min.css',
	], 'public/css/all.css')
	.styles([
	    'public/css/style-rtl.min.css',
	], 'public/css/all.rtl.css')
	.scripts([
		'public/js/modernizr.custom.js',
		'public/js/jquery.min.js',
		'public/js/sweetalert.min.js',
		'public/js/core.min.js',
		'public/js/bluebird.min.js',
		'public/js/chosen.jquery.min.js',
		'public/js/simplebar.js',
		'public/js/reloadAsGet.js',
		'public/js/jquery-ui.min.js',
		'public/js/popper.min.js',
		'public/js/bootstrap.min.js',
		'public/js/owl.carousel.min.js',
		'public/js/classie.js',
		'public/js/jquery.barrating.min.js',
		'public/js/script.js',
		'public/js/validate.min.js',
		// 'public/js/client_validation.js',
		'public/js/slider_fire.js',
	], 'public/js/all.js')
	.scripts([
    	'public/js/modernizr.custom.js',
    	'public/js/jquery.min.js',
    	'public/js/sweetalert.min.js',
    	'public/js/core.min.js',
    	'public/js/bluebird.min.js',
    	'public/js/chosen.jquery.min.js',
    	'public/js/simplebar.js',
    	'public/js/reloadAsGet.js',
    	'public/js/jquery-ui.min.js',
    	'public/js/popper.min.js',
    	'public/js/bootstrap.min.js',
    	'public/js/owl.carousel.min.js',
    	'public/js/classie.js',
    	'public/js/jquery.barrating.min.js',
    	'public/js/script.js',
		'public/js/validate.min.js',
		// 'public/js/client_validation.js',
    	'public/js/slider_fire.rtl.js',
	], 'public/js/all.rtl.js'); 