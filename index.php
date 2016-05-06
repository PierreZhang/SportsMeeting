<?php
if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
} else {
    echo "<h1>Please install via composer.json</h1>";
    echo "<p>Install Composer instructions: <a href='https://getcomposer.org/doc/00-intro.md#globally'>https://getcomposer.org/doc/00-intro.md#globally</a></p>";
    echo "<p>Once composer is installed navigate to the working directory in your terminal/command promt and enter 'composer install'</p>";
    exit;
}

if (!is_readable('app/Core/Config.php')) {
    die('No Config.php found, configure and rename Config.example.php to Config.php in app/Core.');
}

/*
 *---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 *---------------------------------------------------------------
 *
 * You can load different configurations depending on your
 * current environment. Setting the environment also influences
 * things like logging and error reporting.
 *
 * This can be set to anything, but default usage is:
 *
 *     development
 *     production
 *
 * NOTE: If you change these, also change the error_reporting() code below
 *
 */
    define('ENVIRONMENT', 'development');
/*
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
 *
 * Different environments will require different levels of error reporting.
 * By default development will show errors but production will hide them.
 */

if (defined('ENVIRONMENT')) {
    switch (ENVIRONMENT) {
        case 'development':
            error_reporting(E_ALL);
            break;
        case 'production':
            error_reporting(0);
            break;
        default:
            exit('The application environment is not set correctly.');
    }
}

//initiate config
new Core\Config();

//create alias for Router
use Core\Router;

//define routes
Router::any('', 'Controllers\Login@login');
Router::any('login', 'Controllers\Login@login');
Router::any('logout', 'Controllers\Login@logout');

Router::any('admin', 'Controllers\Admin@index');
    Router::any('admin/profiles', 'Controllers\Admin@profiles');
        Router::any('admin/newprofile', 'Controllers\Admin@newprofile');
        Router::any('admin/removeprofile', 'Controllers\Admin@removeprofile');
        Router::any('admin/editprofile', 'Controllers\Admin@editprofile');
        Router::any('admin/resetpassword', 'Controllers\Admin@resetpassword');
        Router::any('admin/database', 'Controllers\Admin@database');
    Router::any('admin/institutions', 'Controllers\Admin@institutions');
        //Router::any('admin/newinstitution', 'Controllers\Admin@newinstitution');
        //Router::any('admin/removeinstitution', 'Controllers\Admin@removeinstitution');
        //Router::any('admin/editinstitution', 'Controllers\Admin@editinstitution');
    Router::any('admin/configurations', 'Controllers\Admin@configurations');

Router::any('contribution', 'Controllers\Contribution@index');
    Router::any('contribution/contribute', 'Controllers\Contribution@contribute');
    Router::any('contribution/viewall', 'Controllers\Contribution@viewall');

Router::any('edit', 'Controllers\Edit@index');
    Router::any('edit/smallbatch', 'Controllers\Edit@smallbatch');
    Router::any('edit/seperately', 'Controllers\Edit@seperately');
    Router::any('edit/interval', 'Controllers\Edit@interval');

Router::any('anchor', 'Controllers\Broadcast@index');
    Router::any('anchor/query', 'Controllers\Broadcast@query');
    Router::any('anchor/prepare', 'Controllers\Broadcast@prepare');
    Router::any('anchor/broadcast', 'Controllers\Broadcast@broadcast');

Router::any('director', 'Controllers\Director@index');
    Router::any('director/statistics_for_institutions', 'Controllers\Director@statistics_for_institutions');
    Router::any('director/prepare', 'Controllers\Director@prepare');
    Router::any('director/broadcast', 'Controllers\Director@broadcast');
    
Router::any('public/changepwd', 'Controllers\Publ@changepwd');
    Router::any('public/changepwd1', 'Controllers\Publ@changepwd1');


//if no route found
Router::error('Controllers\Login@login');
#Router::error('Core\Error@index');

//turn on old style routing
Router::$fallback = false;

//execute matched routes
Router::dispatch();