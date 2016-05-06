<?php

namespace Models;

use Core\Model;

class Admin extends Model {

	public function __construct(){
		parent::__construct();
	}

	//////////////////All Profiles        /////////////////////
	public function profiles(){
		return \Helpers\CreateTable::get_a_table_with_comments($this->db, 'users', array(0=>'id', 1=>'name', 2=>'enabled', 3=>'description'));
	}

	public function profiles_core(){
		return $this->db->select("SELECT * FROM `users`");
	}
	///////////////////////////////////////////////////////////

	//////////////////All Institutions    /////////////////////
	public function institutions(){
		return \Helpers\CreateTable::get_a_table_with_comments($this->db, 'institutions');
	}
	///////////////////////////////////////////////////////////

	//////////////////Getaprofile          /////////////////////
	public function getaprofile($id='', $name=''){
		if($id!='' && $name!=''){
			$match=$this->db->select("SELECT `enabled` FROM `users` WHERE `id` = :id AND `name` = :name", 
			array(
				':id' => $id,
				':name' => $name
			));
		}
		elseif($name!=''){
			$id=$this->db->select("SELECT `id` FROM `users` WHERE `name` = :name", 
			array(
				':name' => $name
			))[0]->id;
		}
		elseif($id!=''){
			$id=$id;
		}
		else{
			return 'error';
		}

		$users=$this->db->select("SELECT `name`, `enabled`, `description` FROM `users` WHERE `id` = :id", 
			array(
				':id' => $id
			));
		$users_authority=$this->db->select("SELECT `authority_id` FROM `users_authority` WHERE `user_id` = :id", 
			array(
				':id' => $id
			));
		$users_institution=$this->db->select("SELECT `institution_id` FROM `users_institution` WHERE `user_id` = :id", 
			array(
				':id' => $id
			));

		return array_merge($users, $users_authority, $users_institution);

	}
	///////////////////////////////////////////////////////////	

	//////////////////Newprofile          /////////////////////
	public function newprofile($name, $credential, $enabled, $authority, $institution, $description){
		$insert_ = array(
			'name' => $name,
			'enabled' => $enabled,
			'credential' => $credential,
			'description' => $description
		);
		$this->db->insert('users', $insert_);

		$id = $this->db->select("SELECT `id` FROM `users` WHERE `name` = :name", 
			array(
				':name' => $name
			))[0]->id;

		$insert_ = array(
			'user_id' => $id,
			'authority_id' => $authority
		);
		$this->db->insert('users_authority', $insert_);

		foreach($institution as $i_=>$v_){
			$insert_ = array(
				'user_id' => $id,
				'institution_id' => $v_
			);
			$this->db->insert('users_institution', $insert_);
		}

		return 0;
	}
	///////////////////////////////////////////////////////////	


	//////////////////Editprofile          /////////////////////
	public function editprofile($id, $name, $enabled, $authority, $institution, $description){
		$update_ = array(
			'name' => $name,
			'enabled' => $enabled,
			'description' => $description
		);
		$where_ = array(
			'id' => $id
		);
		$this->db->update('users', $update_, $where_);

		$update_ = array(
			'authority_id' => $authority
		);
		$where_ = array(
			'user_id' => $id
		);
		$this->db->update('users_authority', $update_, $where_);

		$this->db->raw('DELETE FROM `users_institution` WHERE `user_id`='.$id);

		foreach($institution as $i_=>$v_){
			$insert_ = array(
				'user_id' => $id,
				'institution_id' => $v_
			);
			$this->db->insert('users_institution', $insert_);
		}

		return 0;
	}
	///////////////////////////////////////////////////////////	

	//////////////////Resetpassword        /////////////////////
	public function resetpassword($id){
		$update_ = array(
			'credential' => \Helpers\Password::make('123456')
		);
		$where_ = array(
			'id' => $id
		);
		$this->db->update('users', $update_, $where_);
		return 0;
	}
	///////////////////////////////////////////////////////////	

	//////////////////Removeprofile        /////////////////////
	public function removeprofile($id){
		$where_ = array('id' => $id);
		$this->db->delete('users', $where_);
		$where_ = array('user_id' => $id);
		$this->db->delete('users_authority', $where_);
		$this->db->raw('DELETE FROM `users_institution` WHERE `user_id`='.$id);
		return 0;
	}
	///////////////////////////////////////////////////////////	

	//////////////////Configurations      /////////////////////
	public function login(){
		return $this->db->select("SELECT `value` FROM `system_configurations` WHERE `property` = 'allow_login'")[0]->value;
	}

	public function contribute(){
		return $this->db->select("SELECT `value` FROM `system_configurations` WHERE `property` = 'allow_contribute'")[0]->value;
	}

	public function loginswitch($value){
		$update_ = array(
			'value' => $value
		);
		$where_ = array(
			'property' => 'allow_login'
		);
		$this->db->update('system_configurations', $update_, $where_);
		return 0;
	}

	public function contributeswitch($value){
		$update_ = array(
			'value' => $value
		);
		$where_ = array(
			'property' => 'allow_contribute'
		);
		$this->db->update('system_configurations', $update_, $where_);
		return 0;
	}
	///////////////////////////////////////////////////////////	

	public function site_name($if_edit=false, $value=null){
		if($if_edit===true){
			$update_ = array(
				'value' => $value
			);
			$where_ = array(
				'id' => 6,
				'property' => 'site_name'
			);
			$this->db->update('system_configurations', $update_, $where_);
			return 0;
		}
		else 
			return $this->db->select("SELECT `value` FROM `system_configurations` WHERE `id`=6 AND `property` = 'site_name'")[0]->value;
	}

	public function emergency_contact($if_edit=false, $value=null){
		if($if_edit===true){
			$update_ = array(
				'value' => $value
			);
			$where_ = array(
				'id' => 7,
				'property' => 'emergency_contact'
			);
			$this->db->update('system_configurations', $update_, $where_);
			return 0;
		}
		else 
			return $this->db->select("SELECT `value` FROM `system_configurations` WHERE `id`=7 AND `property` = 'emergency_contact'")[0]->value;
	}

	public function truncate($table_name=null){
		if($table_name==null){
			$tables_=$this -> db -> select("SELECT `TABLE_NAME` FROM `information_schema`.`tables` WHERE `TABLE_TYPE`='BASE TABLE' AND `TABLE_SCHEMA`='".DB_NAME."'");
			foreach($tables_ as $k_=>$o_) {
				$this->db->truncate($o_->TABLE_NAME);
			}
			$this -> db -> raw("INSERT INTO `sportsmeeting2`.`users` (`id`, `name`, `credential`, `enabled`, `description`) VALUES ('1', 'peter', '\$2y\$10\$KLQEB5lu18SU1zNTKi1eqOO.Mma2tzcLzd7f9s8knih4oYl8hSx/C', '1', '系统管理员');INSERT INTO `sportsmeeting2`.`users_authority` (`user_id`, `authority_id`) VALUES ('1', 'Z0');INSERT INTO `sportsmeeting2`.`institutions` (`id`, `name`) VALUES ('1', '校园之声');INSERT INTO `sportsmeeting2`.`institutions` (`name`) VALUES ('机电学院');INSERT INTO `sportsmeeting2`.`institutions` (`name`) VALUES ('光电学院');INSERT INTO `sportsmeeting2`.`institutions` (`name`) VALUES ('自动化学院');INSERT INTO `sportsmeeting2`.`institutions` (`name`) VALUES ('通信学院');INSERT INTO `sportsmeeting2`.`institutions` (`name`) VALUES ('计算机学院');INSERT INTO `sportsmeeting2`.`institutions` (`name`) VALUES ('经济管理学院');INSERT INTO `sportsmeeting2`.`institutions` (`name`) VALUES ('信息管理学院');INSERT INTO `sportsmeeting2`.`institutions` (`name`) VALUES ('政教学院');INSERT INTO `sportsmeeting2`.`institutions` (`name`) VALUES ('公共管理与传媒学院');INSERT INTO `sportsmeeting2`.`institutions` (`name`) VALUES ('外国语学院');INSERT INTO `sportsmeeting2`.`institutions` (`name`) VALUES ('理学院');INSERT INTO `sportsmeeting2`.`institutions` (`name`) VALUES ('国际交流学院');INSERT INTO `sportsmeeting2`.`system_configurations` (`id`, `property`, `value`) VALUES ('1', 'allow_login', '0');INSERT INTO `sportsmeeting2`.`system_configurations` (`id`, `property`, `value`) VALUES ('2', 'allow_contribute', '0');INSERT INTO `sportsmeeting2`.`system_configurations` (`id`, `property`, `value`) VALUES ('3', 'contribute_interval', '10');INSERT INTO `sportsmeeting2`.`system_configurations` (`id`, `property`, `value`) VALUES ('4', 'audit_1_ideal_pass_rate', '0.5');INSERT INTO `sportsmeeting2`.`system_configurations` (`id`, `property`, `value`) VALUES ('5', 'audit_2_ideal_pass_rate', '0.5');INSERT INTO `sportsmeeting2`.`system_configurations` (`id`, `property`, `value`) VALUES ('6', 'site_name', '2016信息科大运动会空中宣传阵地');INSERT INTO `sportsmeeting2`.`system_configurations` (`id`, `property`, `value`) VALUES ('7', 'emergency_contact', '如有任何紧急情况，请您与运动会联络人联系：张三13800138000，李四13700137000。');");
		}
		else{
			$this->db->truncate($table_name);
		}
	}



	public function get_password_string($user_id){
		return $this->db->select("SELECT `credential` FROM `users` WHERE `id`=:user_id", 
			array(
				':user_id' => $user_id
				))[0]->credential;
	}

}