<?php

namespace Models;

use Core\Model;

class Broadcast extends Model {

	public function __construct(){
		parent::__construct();
	}

//查看自己的身份
	public function query_user_authority($user_id){
		return $this->db->select("SELECT `authority_id` FROM `users_authority` WHERE `user_id` = :user_id", 
			array(
				':user_id' => $user_id
			))[0] -> authority_id;
	}

//查询几篇可以播送的稿件
	public function query_contributions_to_broadcast($user_id, $institution_id, $amount=7, $random=false){
		$query_prepared=$this -> db -> select("SELECT `contributions`.`id`,`contributions`.`institution_id`,`contributions`.`originality`,`contributions`.`text`,`contributions`.`created` FROM `contributions`, `contributions_action`, `contributions_status` WHERE `contributions`.`id`=`contributions_status`.`id` AND `contributions`.`id`=`contributions_action`.`contribution_id` AND `contributions_status`.`status_id`=51 AND `contributions_action`.`user_id`=:user_id",
			array(
				':user_id'=>$user_id));
		if(!empty($query_prepared)){
			foreach($query_prepared as $k_=>$o_){
				$o_->text="<font style=\"color:red\">已备稿但未播送的稿件：</font><br />".$o_->text;
			}
			return $query_prepared;
		}
		$where_parametner1_='';
		if(count($institution_id)!=0){
			foreach($institution_id as $k_=>$v_){
				if($k_==0)
					$where_parameter1_=' AND `contributions`.`institution_id` in ( '.$v_;
				else
					$where_parameter1_.=', '.$v_;
			}
			$where_parameter1_.=')';
		}
		$user_level=self::query_user_authority(\Helpers\Session::get('ID'));
		if($user_level=='A3' || $user_level=='C6')
			$where_parameter2_=' AND  (`contributions_status`.`status_id`=31 OR `contributions_status`.`status_id`=41)';
		else
			return 'error: you are not in charge of audition';
		if($random===false)
			return $this->db->select("SELECT `contributions`.`id`,`contributions`.`institution_id`,`contributions`.`originality`,`contributions`.`text`,`contributions`.`created` FROM `contributions`, `contributions_status` WHERE `contributions`.`id`=`contributions_status`.`id`".$where_parameter1_.$where_parameter2_." ORDER BY `contributions`.`id` ASC LIMIT ".$amount);
		elseif($random===true){
			return $this->db->select("SELECT `contributions`.`id`,`contributions`.`institution_id`,`contributions`.`originality`,`contributions`.`text`,`contributions`.`created` FROM `contributions`, `contributions_status` WHERE `contributions`.`id`=`contributions_status`.`id`".$where_parameter1_.$where_parameter2_." ORDER BY RAND() LIMIT ".$amount);
		}
	}
//准备备稿
	public function prepare_to_broadcast($user_id, $contribution_id){
		$query_if_prepared=$this -> db -> select("SELECT `user_id` FROM `contributions_action` WHERE `contributions_action`.`action_id`=51 AND `contributions_action`.`contribution_id`=:contribution_id", 
			array(
				':contribution_id'=>$contribution_id
				))[0]-> user_id;
		$query_if_broadcasted=$this -> db -> select("SELECT `user_id` FROM `contributions_action` WHERE `contributions_action`.`action_id`=55 AND `contributions_action`.`contribution_id`=:contribution_id", 
			array(
				':contribution_id'=>$contribution_id
				));
		if((empty($query_if_prepared) && empty($query_if_broadcasted))){
			$insert_ = array(
				'contribution_id' => $contribution_id,
				'user_id' => $user_id,
				'action_id' => '51',
				'created' => date("Y-m-d H:i:s", time())
			);
			$this->db->insert('contributions_action', $insert_);
			return $this->db->select("SELECT `contributions`.`id`, `contributions`.`text`, `institutions`.`name`  FROM `contributions`, `contributions_status`, `institutions` WHERE `contributions`.`id`=`contributions_status`.`id` AND `contributions_status`.`status_id`=51 AND `contributions`.`id`=:contribution_id AND `contributions`.`institution_id`=`institutions`.`id` LIMIT 1",
				array(
					':contribution_id'=>$contribution_id
					));
		}
		elseif(($query_if_prepared==$user_id && empty($query_if_broadcasted))){
			return $this->db->select("SELECT `contributions`.`id`, `contributions`.`text`, `contributions`.`institution_id`, `institutions`.`name` FROM `contributions`, `contributions_status`, `institutions` WHERE `contributions`.`id`=`contributions_status`.`id` AND `contributions_status`.`status_id`=51 AND `contributions`.`institution_id`=`institutions`.`id` AND `contributions`.`id`=:contribution_id LIMIT 1",
				array(
					':contribution_id'=>$contribution_id
					));
		}
		else{
			return array('ERROR'=>array('ID'=>0, 'MSG'=>'The contribution has been prepared by someone else.'));
		}
	}

//已播出
	public function broadcasted($user_id, $contribution_id){
		$insert_ = array(
			'contribution_id' => $contribution_id,
			'user_id' => $user_id,
			'action_id' => '55',
			'created' => date("Y-m-d H:i:s", time())
		);
		$this->db->insert('contributions_action', $insert_);
		return $this->db->select("SELECT MAX(`contributions_status`.`status_id`) 'max_status_id' FROM `contributions_status` WHERE `contributions_status`.`id`=:contribution_id",
			array(
				':contribution_id'=>$contribution_id
				))[0]-> max_status_id;
	}


//查看自己负责的学院
	public function query_institutions_in_charge_by_user($user_id, $return_type=0){
		$user_authority=self::query_user_authority($user_id);
		if($user_authority=='B6' || $user_authority=='C6'){
			$institutions=array();
			$institutions_=$this->db->select("SELECT `institution_id` FROM `users_institution` WHERE `user_id` = :user_id ORDER BY `institution_id` ASC", 
				array(
					':user_id' => $user_id
				));
		}
		elseif($user_authority=='B3' OR $user_authority=='A3'){
			$institutions_=$this->db->select("SELECT `id` 'institution_id' FROM `institutions` ORDER BY `id` ASC");
		}
		else
			return null;
		if($return_type==0){
			foreach($institutions_ as $i_=>$o_)
				$institutions[] = $o_ -> institution_id;
		}
		elseif($return_type==1){
			foreach($institutions_ as $i_=>$o_){
				$ins_name_=$this->db->select("SELECT `name` FROM `institutions` WHERE `id`=:id",
					array(
						':id' => $o_ -> institution_id
					))[0];
				$institutions[] = $ins_name_ -> name;
			}
		}
		return $institutions;
	}


//查询全部排队数量
	public function query_contributions_amount_to_broadcast($user_id, $user_level=null, $institution_id=false){
		$where_parametner1_='';
		if($institution_id!==false)
			$where_parameter1_='AND `contributions`.`institution_id` = '.$institution_id;
		if($user_level==null){
			$user_level=self::query_user_authority($user_id);
		}
		if($user_level=='A3' || $user_level=='C6')
			$where_parameter2_='AND (`contributions_status`.`status_id`=31 OR `contributions_status`.`status_id`=41)';
		else
			return 'error: you are not in charge of broadcast';
		return $this->db->select("SELECT COUNT(*) 'amount' FROM `contributions`, `contributions_status` WHERE `contributions`.`id`=`contributions_status`.`id` ".$where_parameter1_." ".$where_parameter2_." ORDER BY `contributions`.`id` ASC")[0]->amount;
	}
//查询全部已播
	public function query_contributions_amount_broadcasted($user_id=null, $institution_id=null){
		if($institution_id!=null)
			$where_parameter1_=' AND `contributions`.`institution_id` = '.$institution_id;
		if($user_id!=null)
			$where_parameter2_=' AND `contributions_action`.`user_id` = '.$user_id;
		return $this->db->select("SELECT COUNT(*) 'amount' FROM `contributions` JOIN `contributions_action` ON `contributions`.`id`=`contributions_action`.`contribution_id` WHERE `contributions_action`.`action_id`=55".$where_parameter1_.$shere_parameter2)[0]->amount;
	}
	


}