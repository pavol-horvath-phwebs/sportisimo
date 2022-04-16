let mix = require('laravel-mix')
require('laravel-mix-polyfill')

mix.sass('resources/app.scss', 'www/app.css')
    .polyfill()

mix.js('resources/app.js', 'www/app.js')
    .polyfill()