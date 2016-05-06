<?php

namespace Models;

use Core\Model;

class Contribution extends Model {

	public function __construct(){
		parent::__construct();
	}

	//////////////////Contribute          /////////////////////
	public function contribute($user_id, $institution_id, $originality, $text){
		$now=date("Y-m-d H:i:s", time());
		$insert_ = array(
			'user_id' => $user_id,
			'institution_id' => $institution_id,
			'originality' => $originality,
			'text' => $text,
			'created' => $now
		);
		$this->db->insert('contributions', $insert_);

		$insert_ = array(
			'contribution_id' => $this->db->lastInsertId('id'),
			'user_id' => $user_id,
			'action_id' => '11',
			'created' => $now
		);
		$this->db->insert('contributions_action', $insert_);
		return 0;
	}
	///////////////////////////////////////////////////////////

	//////////////////Getamountofcontribution//////////////////
	public function count($user_id=''){
		if($user_id=='')
			$user_id=\Helpers\Session::get('ID');
		return $this -> db -> select("SELECT count(*) totalamount FROM `contributions` WHERE `user_id`=:user_id",
			array(
				':user_id' => $user_id
			))[0];
	}
	///////////////////////////////////////////////////////////


	public function get_amount($status_id, $institution_id=null){//typeid: 2=>2*, 21=>21, 25=>25, 3=>3*, 31=>31, 35=>35, 55=>55
		if($institution_id!=null){
			$where_string=" AND `contributions`.`institution_id`=".$institution_id;
		}
		if(in_array($status_id, array(11,2,21,25,3,31,35,41,45,51,55)))
		switch($status_id) {
			case 2: //已初审篇数
				$query="SELECT COUNT(*) 'count' FROM `contributions` JOIN `contributions_action` ON `contributions`.`id`=`contributions_action`.`contribution_id` WHERE (`contributions_action`.`action_id`>20 AND `contributions_action`.`action_id`<30)".$where_string;
				break;
			case 3: //已终审篇数
				$query="SELECT COUNT(*) 'count' FROM `contributions` JOIN `contributions_action` ON `contributions`.`id`=`contributions_action`.`contribution_id` WHERE (`contributions_action`.`action_id`>30 AND `contributions_action`.`action_id`<40)".$where_string;
				break;
			default: //已提交篇数,已初审通过篇数,已初审但未通过篇数,已终审通过篇数,已终审但未通过篇数,已播送篇数
				$query="SELECT COUNT(*) 'count' FROM `contributions` JOIN `contributions_action` ON `contributions`.`id`=`contributions_action`.`contribution_id` WHERE `contributions_action`.`action_id`=".$status_id.$where_string;
				break;
		}
		elseif($status_id=0) //查询所有单位提交稿件总数
			$query="SELECT COUNT(*) 'count' FROM `contributions`";
		else //其他情况
			exit();
		return $this -> db -> select($query)[0]-> count;

	}

	public function query_institution_id($user_id){
        $authority_id_=$this -> db -> select("SELECT `authority_id` FROM `users_authority` WHERE `user_id`=:user_id",
        	array(
        		':user_id' => $user_id
        	))[0] -> authority_id;
        if($authority_id_=='D6'){
        	return $this -> db -> select("SELECT `institution_id` FROM `users_institution` WHERE `user_id`=:user_id",
        		array(
        			':user_id' => $user_id
        		))[0] -> institution_id;
        }
    }

    public function query_next_submit_time($user_id, $institution_id){
    	$time_string=$this -> db -> select("SELECT `contributions_action`.`created` FROM `contributions` JOIN `contributions_action` ON `contributions`.`id`=`contributions_action`.`contribution_id` WHERE `contributions_action`.`action_id`=11 AND `contributions`.`institution_id`=:institution_id AND `contributions`.`user_id`=:user_id ORDER BY `contributions_action`.`created` DESC LIMIT 1",
    		array(
    			':institution_id'=>$institution_id,
    			':user_id'=>$user_id
    			))[0]->created;
    	return strtotime($time_string) + $this -> db -> select("SELECT `value` FROM `system_configurations` WHERE `id`=3 AND `property`='contribute_interval' LIMIT 1")[0]->value;
    }

    public function contribute_on(){
    	return $this -> db -> select("SELECT `value` FROM `system_configurations` WHERE `id`='2' AND `property` = 'allow_contribute'")[0]->value;
    }

	public function query_emergency_contact(){
    	return $this -> db -> select("SELECT `value` FROM `system_configurations` WHERE `id`=7 AND `property` = 'emergency_contact'")[0]->value;
    }    
}
