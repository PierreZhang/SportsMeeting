<?php
namespace Controllers;

use Core\View;
use Core\Controller;

class Admin extends Controller
{

    /**
     * Call the parent construct
     */
    public function __construct()
    {
        if((strpos(\Helpers\Session::get('ROLES'),'A')||strpos(\Helpers\Session::get('ROLES'),'Z'))===false)
            \Helpers\Url::redirect('login');
        parent::__construct();
        $this -> _model_ = new \Models\Admin();
    }

    /**
     * Define Index page title and load template files
     */
    public function index()
    {
        View::renderTemplate('header', $data);
        View::render('admin/index', $data);
        View::renderTemplate('footer', $data);
    }

    public function profiles()
    {
        $data['profiles'] = $this -> _model_ -> profiles();
        View::render('admin/profiles', $data);
    }

    public function newprofile()
    {
        if(isset($_POST['submit'])){
            //echo "<script type=\"text/javascript\">console.log('";
            //var_dump($_POST);
            //echo "')</script>";
            $institution=array();
            foreach($_POST['institution'] as $i_=>$a_)
                $institution[]=$a_["value"];
            $newprofile = $this -> _model_ -> newprofile($_POST['name'], \Helpers\Password::make($_POST['credential_raw']), $_POST['enabled'], $_POST['authority'], $institution, $_POST['description']);
            if($newprofile==0){
                echo '0';
            }
            else{
                echo '1';
            }
        }
        else{
            $data['institutions'] = $this -> _model_ -> institutions();
            View::render('admin/newprofile', $data);
        }        
    }

    public function editprofile()
    {
        if($_POST['getaprofile']=="true"){
            $data['profile'] = $this -> _model_ -> getaprofile($_POST['id']);
            echo json_encode($data['profile']);
        }
        elseif($_POST['editprofile']=="true"){
            $institution=array();
            foreach($_POST['institution'] as $i_=>$a_)
                $institution[]=$a_["value"];
            $editprofile = $this -> _model_ -> editprofile($_POST['id'], $_POST['name'], $_POST['enabled'], $_POST['authority'], $institution, $_POST['description']);
            if($editprofile==0){
                echo 0;
            }
            else{
                echo 1;
            }
        }
        else {
            $data['institutions'] = $this -> _model_ -> institutions();
            $data['profiles_core'] = $this -> _model_ -> profiles_core();
            View::render('admin/editprofile', $data);
        }
    }

    public function resetpassword()
    {
        if($_POST['verifiedtoresetpassword']=="true"){
            $resetpassword = $this -> _model_ -> resetpassword($_POST['id']);
            if($resetpassword==0){
                echo 0;
            }
            else{
                echo 1;
            }
        }
        else {
            $data['profiles_core'] = $this -> _model_ -> profiles_core();
            View::render('admin/resetpassword', $data);
        }
    }

    public function removeprofile()
    {
        if($_POST['verifiedtoremoveprofile']=="true"){
            $removeprofile = $this -> _model_ -> removeprofile($_POST['id']);
            if($removeprofile==0){
                echo 0;
            }
            else{
                echo 1;
            }
        }
        else {
            $data['profiles_core'] = $this -> _model_ -> profiles_core();
            View::render('admin/removeprofile', $data);
        }
    }

    public function institutions()
    {
        $data['institutions'] = $this -> _model_ -> institutions();
        View::render('admin/institutions', $data);
    }

    public function configurations()
    {
        if($_POST['loginswitch']=="true"){
            $loginswitch = $this -> _model_ -> loginswitch($_POST['value']);
            if($loginswitch==0){
                echo 0;
            }
            else{
                echo 1;
            }
        }
        elseif($_POST['contributeswitch']=="true"){
            $contributeswitch = $this -> _model_ -> contributeswitch($_POST['value']);
            if($contributeswitch==0){
                echo 0;
            }
            else{
                echo 1;
            }
        }
        elseif($_POST['site_name']=='true'){
            $site_name = $this -> _model_ -> site_name(true, $_POST['value']);
            if($site_name==0){
                echo 0;
            }
            else{
                echo 1;
            }
        }
        elseif($_POST['emergency_contact']=='true'){
            $emergency_contact = $this -> _model_ -> emergency_contact(true, $_POST['value']);
            if($emergency_contact==0){
                echo 0;
            }
            else{
                echo 1;
            }
        }
        else {
            $data['login']=($this -> _model_ -> login()=='1')?"\"on\"":"\"off\"";
            $data['contribute']=($this -> _model_ -> contribute()=='1')?"\"on\"":"\"off\"";
            $data['site_name']=$this -> _model_ -> site_name();
            $data['emergency_contact']=$this -> _model_ -> emergency_contact();
            View::render('admin/configurations', $data);
        }
    }

    public function database(){
        if($_POST['truncate']=='true'){
            if(\Helpers\Password::verify($_POST['verification'], $this -> _model_ -> get_password_string(\Helpers\Session::get('ID')))) {
                $this -> _model_ -> truncate();
                echo 0;
            }
            else
                echo 1;
        }
        else{
            View::render('admin/database', $data);
        }
    }
}
