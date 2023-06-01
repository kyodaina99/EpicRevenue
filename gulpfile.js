const elixir = require('laravel-elixir');

require('laravel-elixir-vue');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {

    elixir.config.sourcemaps = false;
    var admin = false;
    var copy = true;

    mix.sass('app.scss', 'public/assets/css/main.css');

    if(admin) {
        mix.sass('admin.scss', 'resources/assets/css/admin.css');
        mix.styles('angular-chart.js/dist/angular-chart.css', 'resources/assets/css/angular-chart.css', 'bower_components/');
        mix.styles('ui-select/dist/select.css', 'resources/assets/css/ui-select.css', 'bower_components/');
        mix.styles(['admin.css', 'ui-select.css', 'angular-chart.css'], 'public/assets/css/admin.css');

        mix.scripts(['angular-bootstrap/ui-bootstrap-tpls.min.js'], 'resources/assets/js/build/ui-bootstrap.js','bower_components/');
        mix.scripts(['angular-route/angular-route.js'], 'resources/assets/js/build/angular-route.js','bower_components/');
        mix.scripts(['ui-select/dist/select.js'], 'resources/assets/js/build/ui-select.js','bower_components/');
        mix.scripts(['angular-sanitize/angular-sanitize.js'], 'resources/assets/js/build/angular-sanitize.js','bower_components/');
        mix.scripts(['bootstrap-sass/assets/javascripts/bootstrap.min.js'], 'resources/assets/js/build/bootstrap.js','bower_components/');
        mix.scripts(['ng-file-upload/ng-file-upload.min.js'], 'resources/assets/js/build/ng-file-upload.js','bower_components/');

        mix.scripts([
            'resources/assets/js/build/ui-bootstrap.js',
            'resources/assets/js/build/angular-route.js',
            'resources/assets/js/build/ui-select.js',
            'resources/assets/js/build/angular-sanitize.js',
            'resources/assets/js/build/ng-file-upload.js'
        ], 'public/assets/js/admin.js');

        mix.scripts(['angular/app.js','angular/routes.js'], 'resources/assets/js/build/angular/admin/app.js');
        mix.scriptsIn('resources/assets/js/angular/controllers/admin', 'resources/assets/js/build/angular/admin/angular.js');

        mix.scripts([
            'resources/assets/js/build/angular/admin/app.js',
            'resources/assets/js/build/angular/admin/angular.js'
        ], 'public/assets/js/admin-angular.js');

        mix.copy(['resources/assets/js/angular/partials'], 'public/build/assets/js/partials');
    }

    if(copy) {
        mix.copy([
            'node_modules/bootstrap-sass/assets/fonts',
            'bower_components/components-font-awesome/fonts',
            'resources/assets/fonts'
        ], 'public/assets/fonts');

        mix.copy([
            'node_modules/bootstrap-sass/assets/fonts',
            'bower_components/components-font-awesome/fonts',
            'resources/assets/fonts'
        ], 'public/build/assets/fonts');
    }

    //mix.webpack(['app.js', 'jquery.selectbox-0.2.js', 'slick.min.js'], 'public/assets/js/main.js');
  
    mix.version([
        'assets/css/admin.css',
        'assets/js/admin.js',
        'assets/js/admin-angular.js',
        'assets/css/main.css',
        'assets/js/main.js'
    ]);
});
