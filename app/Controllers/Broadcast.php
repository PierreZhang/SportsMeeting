<?php
namespace Controllers;

use Core\View;
use Core\Controller;

class Broadcast extends Controller
{

    /**
     * Call the parent construct
     */
    public function __construct()
    {
        if((strpos(\Helpers\Session::get('ROLES'),'A')||strpos(\Helpers\Session::get('ROLES'),'C'))===false)
            \Helpers\Url::redirect('login');
        parent::__construct();
        $this -> _model_ = new \Models\Broadcast();
    }

    /**
     * Define Index page title and load template files
     */
    public function index()
    {
        $data['broadcast_to_go_amount']=$this -> _model_ -> query_contributions_amount_to_broadcast(\Helpers\Session::get('ID'));
        $data['query_contributions_amount_broadcasted']=$this -> _model_ -> query_contributions_amount_broadcasted();
        $data['query_contributions_amount_broadcasted_myself']=$this -> _model_ -> query_contributions_amount_broadcasted(\Helpers\Session::get('ID'));
        View::renderTemplate('header', $data);
        View::render('broadcast/index', $data);
        View::renderTemplate('footer', $data);
    }


    public function query()
    {
        $institutions= array();
        $institutions_ = $this -> _model_ -> query_institutions_in_charge_by_user(\Helpers\Session::get('ID'));
        foreach($institutions_ as $k_=>$v_){
            if($v_!=1)
                $institutions[]=$v_;
        }
        $data['broadcast_query']=$this -> _model_ -> query_contributions_to_broadcast(\Helpers\Session::get('ID'), $institutions, 7, true);
        if(!empty($data['broadcast_query'])){
            View::render('broadcast/query', $data);
        }
        else
            echo "<script type=\"text/javascript\">alert('没有更多的稿件了。请耐心等待。');window.location.reload();</script>";
    }

    public function prepare()
    {
        $contribution=$this -> _model_ -> prepare_to_broadcast(\Helpers\Session::get('ID'), $_POST["contribution_id"]);
        if(!empty($contribution)){
            echo json_encode($contribution);
        }
    }

    public function broadcast()
    {
        $broadcast=$this -> _model_ -> broadcasted(\Helpers\Session::get('ID'), $_POST["contribution_id"]);
        echo $broadcast;
    }

}
