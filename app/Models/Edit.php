<?php

namespace Models;

use Core\Model;

class Edit extends Model {

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

//查看自己负责的学院
	public function query_institutions_in_charge_by_user($user_id, $return_type=0){
		$user_authority=self::query_user_authority($user_id);
		if($user_authority=='B6'){
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
		elseif($return_type==2){
			foreach($institutions_ as $i_=>$o_){
				$ins_name_=$this->db->select("SELECT `name` FROM `institutions` WHERE `id`=:id",
					array(
						':id' => $o_ -> institution_id
					))[0];
				$institutions[] = array($o_ -> institution_id, $ins_name_ -> name);
			}
		}
		return $institutions;
	}
//查询下面将要审查的稿件
	public function query_contributions_to_audit($user_id, $audit_level=null, $institution_id=false, $amount=1, $random=false){
		$institutions=self::query_institutions_in_charge_by_user($user_id);
		$where_parametner1_='';
		if($institution_id===false){
			foreach($institutions as $k_=>$v_){
				if($k_==0){
					$where_parameter1_='AND (`contributions`.`institution_id` = '.$v_;
				}
				else{
					$where_parameter1_.=' OR `contributions`.`institution_id` = '.$v_;
				}
			}
			$where_parameter1_.=')';
		}
		else{
			if(array_search($institution_id, $institutions)!==false)
				$where_parameter1_='AND `contributions`.`institution_id` = '.$institution_id;
			else
				return 'error: you are not in charge of this institution';
		}
		if($audit_level==null){
			$audit_level=self::query_user_authority($user_id);
		}
		if($audit_level=='A3')
			$where_parameter2_='AND `contributions_status`.`status_id`<40 AND ';
		elseif($audit_level=='B3')
			$where_parameter2_='AND (`contributions_status`.`status_id`<25 AND `contributions_status`.`status_id`>=20)';
		elseif($audit_level=='B6')
			$where_parameter2_='AND (`contributions_status`.`status_id`<20 AND `contributions_status`.`status_id`>=10)';
		else
			return 'error: you are not in charge of audition';
		if($random===false){
			return $this->db->select("SELECT `contributions`.`id`,`contributions`.`user_id`,`contributions`.`institution_id`,`contributions`.`originality`,`contributions`.`text`,`contributions`.`created` FROM `contributions`, `contributions_status` WHERE `contributions`.`id`=`contributions_status`.`id` ".$where_parameter1_." ".$where_parameter2_." ORDER BY `contributions`.`id` ASC LIMIT ".$amount);
		}
		elseif($random===true){
			return $this->db->select("SELECT `contributions`.`id`,`contributions`.`user_id`,`contributions`.`institution_id`,`contributions`.`originality`,`contributions`.`text`,`contributions`.`created` FROM `contributions`, `contributions_status` WHERE `contributions`.`id`=`contributions_status`.`id`".$where_parameter1_." ".$where_parameter2_." ORDER BY RAND() LIMIT ".$amount);
		}

	}

//查询全部排队数量
	public function query_contributions_amount_to_audit($user_id, $audit_level=null, $institution_id=false){
		$institutions=self::query_institutions_in_charge_by_user($user_id);
		$where_parametner1_='';
		if($institution_id===false){
			foreach($institutions as $k_=>$v_){
				if($k_==0){
					$where_parameter1_='AND (`contributions`.`institution_id` = '.$v_;
				}
				else{
					$where_parameter1_.=' OR `contributions`.`institution_id` = '.$v_;
				}
			}
			$where_parameter1_.=')';
		}
		else{
			if(array_search($institution_id, $institutions)!==false)
				$where_parameter1_='AND `contributions`.`institution_id` = '.$institution_id;
			else
				return 'error: you are not in charge of this institution';
		}
		if($audit_level==null){
			$audit_level=self::query_user_authority($user_id);
		}
		if($audit_level=='A3')
			$where_parameter2_='AND (`contributions_status`.`status_id`<40)';
		elseif($audit_level=='B3')
			$where_parameter2_='AND `contributions_status`.`status_id`=21';
		elseif($audit_level=='B6')
			$where_parameter2_='AND `contributions_status`.`status_id`=11';
		else
			return 'error: you are not in charge of audition';
		return $this->db->select("SELECT COUNT(*) 'amount' FROM `contributions`, `contributions_status` WHERE `contributions`.`id`=`contributions_status`.`id` ".$where_parameter1_." ".$where_parameter2_." ORDER BY `contributions`.`id` ASC");
	}
//审查
	public function audit_contribution($contribution_id, $user_id, $audit_pass, $audit_level=null){
		$user_authority=self::query_user_authority($user_id);
		if($user_authority=='B6'){
			$action_id_=($audit_pass==1)?21:25;
		}
		elseif($user_authority=='B3'){
			$action_id_=($audit_pass==1)?31:35;
		}
		elseif($user_authority=='A3'){
			if($audit_level!=null){
				if($audit_level=='B6'){
					$action_id_=($audit_pass==1)?21:25;
				}
				elseif($audit_level=='B3'){
					$action_id_=($audit_pass==1)?31:35;
				}
			}
			else
				$action_id_=($audit_pass==1)?41:45;
		}
		$insert_ = array(
			'contribution_id' => $contribution_id,
			'user_id' => $user_id,
			'action_id' => $action_id_,
			'created' => date("Y-m-d H:i:s", time())
		);
		$this->db->insert('contributions_action', $insert_);
	}
//查询session:present_audition
	public function query_session_present_audition($contribution_id){
    	return in_array($contribution_id, explode('|', \Helpers\Session::get('PRESENT_AUDITION')));
    }
//设置session:present_audition
    public function set_session_present_audition($contributions){
    	$string_='';
		foreach($contributions as $k_ => $o_)
			$string_.=$o_-> id.'|';
		\Helpers\Session::set('PRESENT_AUDITION', $string_);
    }

    public function set_interval($interval){
		$update_ = array(
			'value' => $interval
		);
		$where_ = array(
			'id' => 3,
			'property' => 'contribute_interval'
		);
		$this->db->update('system_configurations', $update_, $where_);
    }
    public function get_interval(){
		return $this->db->select("SELECT `value` FROM `system_configurations` WHERE `id`=3 AND `property`='contribute_interval' LIMIT 1")[0]->value;
    }




}