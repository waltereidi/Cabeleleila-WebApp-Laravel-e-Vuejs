
const mix = require('laravel-mix');


// mix.css('resources/css/bootstrap.min.css.map' , 'public/css'); 
// mix.css('resources/css/bootstrap.min.css');
// mix.js('resources/js/bootstrap.min.js' , 'public/js');
// mix.js('resources/js/bootstrap.min.js.map' , 'public/js')
// mix.js('resources/js/app.js', 'public/js').vue().copy('node_modules/jquery/dist/jquery.min.js', 'public/js');

// mix.css('resources/css/layout.css', 'public/css');



// mix.css('resources/css/login.css', 'public/css');
// mix.js('resources/js/login.js', 'public/js');

// mix.css('resources/css/paginaInicial.css', 'public/css');

// mix.js('resources/js/clientes/clientes.js' , 'public/js/clientes');
// mix.css('resources/css/clientes/clientes.css' , 'public/css/clientes');

// mix.js('resources/js/servicos/servicos.js' , 'public/js/servicos');
// mix.css('resources/css/servicos/servicos.css' , 'public/css/servicos');

// mix.js('resources/js/gerenciamento/gerenciamento.js' , 'public/js/gerenciamento');
// mix.css('resources/css/gerenciamento/gerenciamento.css' , 'public/css/gerenciamento');

mix.browserSync('localhost:8000');
