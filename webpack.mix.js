const mix = require('laravel-mix');

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
const path = require('path')

mix.setPublicPath('public')

mix.alias({
    '@': path.join(__dirname, 'resources/js')
})

mix.js('resources/js/app.js', 'public/js').vue().sourceMaps()
    // .postCss('resources/css/app.css', 'public/css', [
    //     //
    // ]);

if (mix.inProduction()) {
    mix.version()
}
