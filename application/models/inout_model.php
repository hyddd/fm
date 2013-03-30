<?php 
include_once(APPPATH . 'models/base_model.php');

class Inout_model extends Base_model {
	var $tableName = 'in_outs';
	var $primaryKey = 'id';
			
	function __construct(){
		parent::__construct();
	}
	
	function insert($data){
		$data['ctime'] = date('Y-m-d H:i:s');
		return parent::insert($data); 
	}
}
