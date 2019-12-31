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
   	.sass('resources/assets/sass/live.scss', 'public/css')
   	.copy('resources/assets/sass/nivo-slider.css','public/css/nivo-slider.css')
   	.copy('resources/assets/sass/animate.css','public/css/animate.css')
   	.copy('resources/assets/js/jquery.nivo.slider.js','public/js/jquery.nivo.slider.js')
   	.copy('resources/assets/js/zoom-meeting-1.3.0.min.js','public/js/zoom-meeting-1.3.0.min.js')
   	.copy('resources/assets/sass/bootstrap.css','public/css/bootstrap.css')
   	.copy('resources/assets/sass/react-select.css','public/css/react-select.css')
   	.copyDirectory('resources/assets/js/lib','public/js/lib')
   	.copyDirectory('resources/assets/fonts','public/fonts')
      .copyDirectory('resources/assets/images','public/images')
      .copy('resources/assets/js/nprogress/nprogress.js', 'public/js/nprogress.js')
      .copy('resources/assets/js/nprogress/nprogress.css', 'public/css/nprogress.css')
      .copy('resources/assets/js/custom.js', 'public/js/custom.js')
   	.copyDirectory('resources/assets/sass/themes','public/css/themes');
