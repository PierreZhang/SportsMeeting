<?php
namespace Helpers;

class CreateTable
{

	public function get_a_table_with_comments($db, $table_name, $theads='')
	{
		if(is_array($theads)) {
			$thead_sql_extra_para='AND COLUMN_NAME IN ';
			$tbody_sql_extra_para='';
			foreach($theads as $k_=>$v_){
				if($k_==count($theads)-1 && $k_=='0') {					
					$thead_sql_extra_para.='(\''.$v_.'\')';
					$tbody_sql_extra_para.='`'.$v_.'`';
				}
				elseif($k_=='0') {
					$thead_sql_extra_para.='(\''.$v_.'\', ';
					$tbody_sql_extra_para.='`'.$v_.'`, ';
				}
				elseif($k_==count($theads)-1) {
					$thead_sql_extra_para.='\''.$v_.'\')';
					$tbody_sql_extra_para.='`'.$v_.'`';
				}
				else {
					$thead_sql_extra_para.='\''.$v_.'\', ';
					$tbody_sql_extra_para.='`'.$v_.'`, ';
				}
			}
		}
		else {
			$thead_sql_extra_para='';
			$tbody_sql_extra_para='*';
		}		
		
		$thead_array=$db->select("SELECT `COLUMN_COMMENT` FROM `information_schema`.`columns` WHERE `TABLE_SCHEMA` = :database_name AND `TABLE_NAME` = :table_name ".$thead_sql_extra_para,
			array(
				':database_name' => DB_NAME,
				':table_name' => $table_name
			));
		$tbody_array=$db->select("SELECT ".$tbody_sql_extra_para." FROM ".$table_name);
		$result=array($thead_array, $tbody_array);
		return $result;
	}

	public function get_tables_with_comments($db, $array)
	{
		if(is_array($theads)) {
			$thead_sql_extra_para='AND COLUMN_NAME IN ';
			$tbody_sql_extra_para='';
			foreach($theads as $k_=>$v_){
				if($k_==count($theads)-1 && $k_=='0') {					
					$thead_sql_extra_para.='(\''.$v_.'\')';
					$tbody_sql_extra_para.='`'.$v_.'`';
				}
				elseif($k_=='0') {
					$thead_sql_extra_para.='(\''.$v_.'\', ';
					$tbody_sql_extra_para.='`'.$v_.'`, ';
				}
				elseif($k_==count($theads)-1) {
					$thead_sql_extra_para.='\''.$v_.'\')';
					$tbody_sql_extra_para.='`'.$v_.'`';
				}
				else {
					$thead_sql_extra_para.='\''.$v_.'\', ';
					$tbody_sql_extra_para.='`'.$v_.'`, ';
				}
			}
		}
		else {
			$thead_sql_extra_para='';
			$tbody_sql_extra_para='*';
		}		
		
		$thead_array=$db->select("SELECT `COLUMN_COMMENT` FROM `information_schema`.`columns` WHERE `TABLE_SCHEMA` = :database_name AND `TABLE_NAME` = :table_name ".$thead_sql_extra_para,
			array(
				':database_name' => DB_NAME,
				':table_name' => $table_name
			));
		$tbody_array=$db->select("SELECT ".$tbody_sql_extra_para." FROM ".$table_name);
		$result=array($thead_array, $tbody_array);
		return $result;
	}
	

    public static function array_table($table_body_array, $table_name)
    {
		//foreach($table_body_array as $k0_=>$arr0_) {
			echo '<table name=\'',$table_name,'\'class=\'table table-striped table-hover table-condensed table-responsive\'>';
			foreach($table_body_array as $k1_=>$arr1_){
				if($k1_==0) {
					echo '<thead><tr>';
					foreach($arr1_ as $k2_=>$obj2_) {
						echo '<th>',$obj2_->COLUMN_COMMENT,'</th>';
					}
					echo '</tr></thead><tbody>';
				}
				else {
					foreach($arr1_ as $k2_=>$obj2_) {
						echo '<tr ';
						if(isset($obj2_->id)) 
							echo 'realid=\'',$obj2_->id,'\'';
						echo '>';
						foreach($obj2_ as $k3_=>$v3_) {
							echo '<td >',$v3_,'</td>';
						}
						echo '</tr>';
					}
					
				}
			}
			echo '</tbody></table>';
		//}
    }
	
    
}
