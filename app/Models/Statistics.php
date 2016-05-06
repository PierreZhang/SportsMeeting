<?php

namespace Models;

use Core\Model;

class Statistics extends Model {

	public function __construct(){
		parent::__construct();
	}	
	
	public function statistics($institution_id=null, $action_id=null, $sum_up=false) {
		if($sum_up===false){
			$where_parameter1='';
			if($institution_id!=null && $action_id==null)
				$where_parameter1=" WHERE `institution_id` = ".$institution_id;
			if($action_id==null)
				return $this -> db -> select("SELECT * FROM `statistics_a0`".$where_parameter1." ORDER BY `institution_id` ASC");
			else
				return $this -> db -> select("SELECT `A".$action_id."` FROM `statistics_a0`".$where_parameter1." ORDER BY `institution_id` ASC");
		} else {
			return $this -> db -> select("SELECT * FROM `statistics_a0_sum`");
		}
	}

	public function query_institutions_name($institution_id=null){
		if($institution_id!=null)
		return $this -> db -> select("SELECT `name` FROM `institutions` WHERE $id=:id", 
			array(
				':id' => $institution_id
				))[0]->name;
		else{
			$institutions_name=array();
			$institutions_name_ = $this -> db -> select("SELECT `id`, `name` FROM `institutions`");
			foreach($institutions_name_ as $k_ => $o_)
				$institutions_name[$o_->id]=$o_->name;
			return $institutions_name;
		}
	}
		
}