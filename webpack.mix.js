const mix = require('laravel-mix');
const theme = process.env.BLOG_THEME;

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/admin.js', 'public/js')
    .js('resources/js/close.js', 'public/js')
    .sass(`resources/sass/admin/admin.scss`, 'public/css')
    .sass(`resources/sass/${theme}/app.scss`, 'public/css');

if (mix.inProduction()){
    mix.sass(`resources/sass/fontawesome.scss`, 'public/css');
}
