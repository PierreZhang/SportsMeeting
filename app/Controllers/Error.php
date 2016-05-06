<?php
namespace Controllers;

use Core\View;
use Core\Controller;

class Login extends Controller
{

    /**
     * Call the parent construct
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Define Index page title and load template files
     */
    public function index()
    {
        
    }

    public function login()
    {
        $data['title'] = '登陆';
        
        View::renderTemplate('header', $data);
        View::render('welcome/login', $data);
        View::renderTemplate('footer', $data);
    }
}
