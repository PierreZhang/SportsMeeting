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
        $this -> _model_ = new \Models\Sm2();
    }

    /**
     * Define Index page title and load template files
     */
    public function index()
    {
        
    }

    public function login()
    {
        if(\Helpers\Session::get('LOGGED_IN') == true){            
           $this->redirect(\Helpers\Session::get('ROLES'));
        }

        $data['system_on'] = $this -> _model_ -> systemon();
        $data['site_name'] = $this -> _model_ -> query_site_name();

        if(isset($_POST['submit'])){
            if($data['system_on'] == 1 OR strpos($this -> _model_ -> getroles($_POST['id']), 'A') OR strpos($this -> _model_ -> getroles($_POST['id']), 'B') OR strpos($this -> _model_ -> getroles($_POST['id']), 'C') OR strpos($this -> _model_ -> getroles($_POST['id']), 'Z')) {
                $result = $this -> _model_ -> login($_POST['id']);
                if(\Helpers\Password::verify($_POST['credential'], $result[0]->credential)){
                    $roles = $this -> _model_ -> getroles($_POST['id']);
                    \Helpers\Session::set('ID', $result[0]->id);
                    \Helpers\Session::set('NAME', $result[0]->name);
                    \Helpers\Session::set('LOGGED_IN', true);
                    \Helpers\Session::set('ROLES', $roles);
                    $this->redirect();
                } else {
                    $data['status'] = 3;
                }
            } else {
                $data['status'] = 2;
            }
        }
        View::render('login', $data);
    }

    public function logout()
    {
        \Helpers\Session::destroy();
        \Helpers\Url::redirect('login');
    }


    private function redirect($roles='') {
        if($roles=='')
            $roles=\Helpers\Session::get('ROLES');
        if(strpos($roles, 'Z')) {
            \Helpers\Url::redirect('admin');
        }
        elseif(strpos($roles, 'A')) {
            \Helpers\Url::redirect('director');
        }
        elseif(strpos($roles, 'B')) {
            \Helpers\Url::redirect('edit');
        }
        elseif(strpos($roles, 'C')) {
            \Helpers\Url::redirect('anchor');
        }
        elseif(strpos($roles, 'D')) {
            \Helpers\Url::redirect('contribution');
        }
        else{
            \Helpers\Url::redirect('login');
        }
    }
}
