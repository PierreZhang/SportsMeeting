<?php
namespace Controllers;

use Core\View;
use Core\Controller;

class Publ extends Controller
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
    public function changepwd()
    {
        View::renderTemplate('header', $data);
        View::render('public/changepwd', $data);
        View::renderTemplate('footer', $data);
    }

    public function changepwd1()
    {
        echo json_encode($this -> _model_ -> self_chg_pwd(\Helpers\Session::get('ID'), $_POST['oldpwd'], $_POST['newpwd']));
    }

}
