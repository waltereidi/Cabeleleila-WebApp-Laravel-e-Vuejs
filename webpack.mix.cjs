
const mix = require('laravel-mix');



mix.js('resources/js/app.js', 'public/js').vue().copy('node_modules/jquery/dist/jquery.min.js', 'public/js');

mix.browserSync('localhost:8000');
