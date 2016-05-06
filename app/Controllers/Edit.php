<?php
namespace Controllers;

use Core\View;
use Core\Controller;

class Edit extends Controller
{

    /**
     * Call the parent construct
     */
    public function __construct()
    {
        if((strpos(\Helpers\Session::get('ROLES'),'A')||strpos(\Helpers\Session::get('ROLES'),'B'))===false)
            \Helpers\Url::redirect('login');
        parent::__construct();
        $this -> _model_ = new \Models\Edit();
        $this -> model_statistics = new \Models\Statistics();
    }

    /**
     * Define Index page title and load template files
     */
    public function index()
    {
        $data['statistics']=array();
        $data['edit_level']=explode('#', \Helpers\Session::get('ROLES'))[1];
        $data['institutions_in_charge']= $this -> _model_ -> query_institutions_in_charge_by_user(\Helpers\Session::get('ID'),2);
        $data['institutions_name'] = $this -> model_statistics -> query_institutions_name();
        foreach($data['institutions_in_charge'] as $k_ => $a_){
            $data['statistics_for_institutions'][]=$this -> model_statistics -> statistics($a_[0]);
        }
        View::renderTemplate('header', $data);
        View::render('edit/index', $data);
        View::renderTemplate('footer', $data);
    }


    public function smallbatch(){
        if($_POST['submit']==true){
            foreach($_POST['audit_result'] as $contribution_id_=>$audit_result_){
                if($this -> _model_ -> query_session_present_audition($contribution_id_)){
                    $this -> _model_ -> audit_contribution($contribution_id_, \Helpers\Session::get('ID'), $audit_result_);
                }
            }
            $next_contribution = $this -> _model_ -> query_contributions_to_audit(\Helpers\Session::get('ID'),null,false,5,false);
            if(!empty($next_contribution)){
                $this -> _model_ -> set_session_present_audition($next_contribution);
                echo json_encode($next_contribution);
            }
        }
        elseif($_POST['select_institution_amount']==true){
            $amount=$this -> _model_ -> query_contributions_amount_to_audit(\Helpers\Session::get('ID'), explode('#', \Helpers\Session::get('ROLES'))[1], $_POST['institution_id']);
            echo json_encode($amount);
        }
        elseif($_POST['select_institution']==true){
            $next_contribution = $this -> _model_ -> query_contributions_to_audit(\Helpers\Session::get('ID'),null,$_POST["institution_id"],5,false);
            if(!empty($next_contribution)){
                $this -> _model_ -> set_session_present_audition($next_contribution);
                echo json_encode($next_contribution);
            }
        }
        else{
            $data['institutions_in_charge']= $this -> _model_ -> query_institutions_in_charge_by_user(\Helpers\Session::get('ID'),2);
            $data['contributions']=$this -> _model_ -> query_contributions_to_audit(\Helpers\Session::get('ID'),null,false,5,false);
            if(!empty($data['contributions'])){
                $this -> _model_ -> set_session_present_audition($data['contributions']);
                View::render('edit/smallbatch', $data);
            }
            else
                echo "<script type=\"text/javascript\">alert('没有更多的稿件了。请耐心等待。');window.location.reload();</script>";
        }
    }
    public function seperately(){
        if($_POST['submit']==true){
            if($this -> _model_ -> query_session_present_audition($_POST['id'])){
                $this -> _model_ -> audit_contribution($_POST['contribution_id'], \Helpers\Session::get('ID'), $_POST['accept']);
                $next_contribution=$this -> _model_ -> query_contributions_to_audit(\Helpers\Session::get('ID'),null,false,1,false);
                if(!empty($next_contribution)){
                    $this -> _model_ -> set_session_present_audition($next_contribution);
                    echo json_encode($next_contribution);
                }
            }
        }
        else{
            $data['contribution']=$this -> _model_ -> query_contributions_to_audit(\Helpers\Session::get('ID'),null,false,1,false);
            if(!empty($data['contribution'])){
                $this -> _model_ -> set_session_present_audition($data['contribution']);
                View::render('edit/seperately', $data);
            }
            else
                echo "<script type=\"text/javascript\">alert('没有更多的稿件了。请耐心等待。');window.location.reload();</script>";
        }
    }

    public function interval(){
        if($_POST['submit']==true){
            $this -> _model_ -> set_interval($_POST['interval']);
            echo json_encode(array('STATUS'=>array('ID'=>0, 'MSG'=>'Applied successfully.')));
        }
        elseif($_POST['get_interval']==true){
            echo $this -> _model_ -> get_interval();
        }
        else{
            View::render('edit/interval', $data);
        }
    }
}
