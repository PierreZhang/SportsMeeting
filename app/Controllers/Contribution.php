<?php
namespace Controllers;

use Core\View;
use Core\Controller;

class Contribution extends Controller
{

    /**
     * Call the parent construct
     */
    public function __construct()
    {
        if((strpos(\Helpers\Session::get('ROLES'),'A')||strpos(\Helpers\Session::get('ROLES'),'D'))===false)
            \Helpers\Url::redirect('login');
        parent::__construct();
        $this -> _model_sm2_ = new \Models\Sm2();
        $this -> _model_ctbt_ = new \Models\Contribution();
    }

    /**
     * Define Index page title and load template files
     */
    public function index()
    {
        $institution_id= $this -> _model_ctbt_ -> query_institution_id(\Helpers\Session::get('ID'));
        $data['total-amount'] = $this -> _model_ctbt_ -> get_amount(11, $institution_id);
        $data['audit-1-amount'] = $this -> _model_ctbt_ -> get_amount(2, $institution_id);
        $data['audit-1-pass-amount'] = $this -> _model_ctbt_ -> get_amount(21, $institution_id);
        $data['audit-2-amount'] = $this -> _model_ctbt_ -> get_amount(3, $institution_id);
        $data['audit-2-pass-amount'] = $this -> _model_ctbt_ -> get_amount(31, $institution_id);
        $data['broadcast-amount'] = $this -> _model_ctbt_ -> get_amount(55, $institution_id);
        $data['emergency_contact'] = $this -> _model_ctbt_ -> query_emergency_contact();
        $data['contribute_on'] = $this -> _model_ctbt_ -> contribute_on();
        $data['institutions'] = $this -> _model_sm2_ -> institutions();
        $data['site_name'] = $this -> _model_sm2_ -> query_site_name();
        if($data['total-amount']!=0)
            $data['audit-rate'] = ($data['audit-1-amount']*$data['audit-2-amount'])/($data['total-amount']*$data['total-amount']);
        else
            $data['audit-rate'] = 0;
        if($data['audit-2-pass-amount']!=0)
            $data['broadcast-rate'] = $data['broadcast-amount']/$data['audit-2-pass-amount'];
        else
            $data['broadcast-rate'] = 0;
        $data['query_next_submit_time']=$this -> _model_ctbt_ -> query_next_submit_time(10001, 101);
        View::renderTemplate('header', $data);
        View::render('contribution/index', $data);
        View::renderTemplate('footer', $data);
    }

    public function contribute()
    {
        $data['contribute_on'] = $this -> _model_ctbt_ -> contribute_on();
        if(isset($_POST['submit'])){
        	if($data['contribute_on']==1){
	            if($this->_model_ctbt_->query_next_submit_time(\Helpers\Session::get('ID'), $_POST['institution'])<=time()) {
	                $contribution = $this -> _model_ctbt_ -> contribute(\Helpers\Session::get('ID'), $_POST['institution'], $_POST['originality'], $_POST['text']);
	                if($contribution==0){
	                    echo json_encode(array("STATUS"=>array("ID"=>0, "MSG"=>'Contribute successfully.')));
	                } else{
	                    echo json_encode(array("STATUS"=>array("ID"=>1, "MSG"=>'Unknown error.')));
	                }
	            }
	            else{
	                echo json_encode(array("STATUS"=>array("ID"=>11, "MSG"=>'Interval too short. Please try again later.')));
	            }
	        }
	        else {
	        	echo json_encode(array("STATUS"=>array("ID"=>12, "MSG"=>'Contribute function shut down temporarily. Please try again later.')));
	        }
	    }
        else{
            $data['institutions'] = $this -> _model_sm2_ -> institutions();
            View::render('contribution/contribute', $data);
        }
    }
}
