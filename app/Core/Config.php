<?php
namespace Core;

use Helpers\Session;

/*
 * config - an example for setting up system settings
 * When you are done editing, rename this file to 'config.php'
 *
 * @author David Carr - dave@daveismyname.com - http://daveismyname.com
 * @author Edwin Hoksberg - info@edwinhoksberg.nl
 * @version 2.2
 * @date June 27, 2014
 * @date updated May 18 2015
 */
class Config
{
    public function __construct()
    {
        //turn on output buffering
        ob_start();

        //site address
        define('DIR', 'http://192.168.53.198:8023/');

        //set default controller and method for legacy calls
        define('DEFAULT_CONTROLLER', 'login');
        define('DEFAULT_METHOD', 'index');

        //set the default template
        define('TEMPLATE', 'default');

        //set a default language
        define('LANGUAGE_CODE', 'en');

        //database details ONLY NEEDED IF USING A DATABASE
        define('DB_TYPE', 'mysql');
        define('DB_HOST', 'localhost:9306');
        define('DB_NAME', 'sportsmeeting');
        define('DB_USER', 'SQL_USER_SPMT');
        define('DB_PASS', 'SPspMt@SQL_937');
        define('PREFIX', '');

        //set prefix for sessions
        define('SESSION_PREFIX', 'sm2_');

        //optionall create a constant for the name of the site
        define('SITETITLE', '运动会空中宣传阵地');

        //optionall set a site email address
        //define('SITEEMAIL', '');

        //turn on custom error handling
        set_exception_handler('Core\Logger::ExceptionHandler');
        set_error_handler('Core\Logger::ErrorHandler');

        //set timezone
        date_default_timezone_set('Asia/ShangHai');

        //start sessions
        Session::init();
    }
}
