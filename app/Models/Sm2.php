<?php

namespace Models;

use Core\Model;

class Sm2 extends Model {

	public function __construct(){
		parent::__construct();
	}	
		
	//////////////////Login                ////////////////////
	public function login($user_id) {
		return $this -> db -> select("SELECT `id`, `name`, `credential` FROM `users` WHERE `enabled`='1' AND `id` = :user_id", 
			array(
				':user_id' => $user_id
			));
	}
	///////////////////////////////////////////////////////////

	//////////////////SystemOn?            ////////////////////
	public function systemon() {
		return $this -> db -> select("SELECT `value` FROM `system_configurations` WHERE `id`='1' AND `property` = 'allow_login'")[0]->value;
	}
	///////////////////////////////////////////////////////////
	
	//////////////////Get Roles            ////////////////////
	public function getroles($user_id='') {
		if($user_id=='')
			$user_id = \Helpers\Session::get('ID');
		$role = $this -> db -> select("SELECT `authority_id` FROM `users_authority` WHERE `user_id` = :user_id", 
			array(
				':user_id' => $user_id
			));

		$role['assembly']='';

		foreach($role as $k_ => $o_) {
			if($o_ -> authority_id != null)
				$role['assembly'] = $role['assembly'] . '#' . $o_ -> authority_id;
		}

		return $role['assembly'];
	}
	///////////////////////////////////////////////////////////	

	//////////////////Institutions         ////////////////////
	public function institutions($id='') {
		if($id=='')
			$id=\Helpers\Session::get('ID');
		return $this -> db -> select("SELECT `users_institution`.`institution_id`, `institutions`.`name` FROM `users_institution`, `institutions` WHERE `users_institution`.`institution_id` = `institutions`.`id` AND `users_institution`.`user_id` = :user_id", 
			array(
				':user_id' => $id
			));
	}
	///////////////////////////////////////////////////////////	
	
	public function query_site_name(){
		return $this->db->select("SELECT `value` FROM `system_configurations` WHERE `id`=6 AND `property` = 'site_name'")[0]->value;
	}

	public function self_chg_pwd($user_id, $old_cred, $new_cred){
		if($old_cred=="" || $old_cred==null){
			return array("STATUS"=>array("ID"=>4, "MSG"=>'New password cannot be null.'));//不能为空
		}
		if($user_id==\Helpers\Session::get('ID')){
			$old_cred_in_db=$this->db->select("SELECT `credential` FROM `users` WHERE `id`=:user_id",
				array(
					':user_id' => $user_id
					))[0]->credential;
			if(\Helpers\Password::verify($old_cred, $old_cred_in_db)){
				if($old_cred==$new_cred)
					return array("STATUS"=>array("ID"=>3, "MSG"=>'Old and new password cannot be the same.'));//不能为同一值
				$update_ = array(
					'credential' => \Helpers\Password::make($new_cred)
				);
				$where_ = array(
					'id' => $user_id
				);
				$this->db->update('users', $update_, $where_);
				return array("STATUS"=>array("ID"=>0, "MSG"=>'Password changed successfully.'));//成功完成
			}
			else
				return array("STATUS"=>array("ID"=>1, "MSG"=>'You provided a wrong old password.'));//旧密码错误
		}
		else 
			return array("STATUS"=>array("ID"=>2, "MSG"=>'You cannot change password of others.'));//不能修改其他人的密码
		
	}


}