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

mix.js('resources/assets/js/app.js', 'public/js') 
   	.sass('resources/assets/sass/app.scss', 'public/css')
   	.copy('resources/assets/sass/animate.css','public/css/animate.css')
      .copy('resources/assets/js/nivo-slider/nivo-slider.css','public/css/nivo-slider.css')
   	.copy('resources/assets/js/nivo-slider/jquery.nivo.slider.js','public/js/jquery.nivo.slider.js')
   	.copyDirectory('resources/assets/fonts','public/fonts')
      .copyDirectory('resources/assets/images','public/images')
      .copy('resources/assets/js/nprogress/nprogress.js', 'public/js/nprogress.js')
      .copy('resources/assets/js/nprogress/nprogress.css', 'public/css/nprogress.css')
      .copy('resources/assets/js/custom.js', 'public/js/custom.js')
   	.copyDirectory('resources/assets/sass/themes','public/css/themes');
