const mix = require('laravel-mix');

// Compilar arquivos JS e CSS para o diretório public
mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('tailwindcss'),
    ])
    .version();
