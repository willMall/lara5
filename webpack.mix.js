let mix = require('laravel-mix');

mix.js('resources/assets/js/dashboard.js', 'public/js')
  .sass('resources/assets/sass/dashboard.scss', 'public/css')
  .js('resources/assets/js/app.js', 'public/js')
  .less('resources/assets/less/app.less', 'public/css')
