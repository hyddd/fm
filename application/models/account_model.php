<?php 
include_once(APPPATH . 'models/base_model.php');

class Account_model extends Base_model {
	var $tableName = 'accounts';
	var $primaryKey = 'id';
			
	function __construct(){
		parent::__construct();
	}
	
	public function insert($data){
		$data['ctime'] = date('Y-m-d H:i:s');
		return parent::insert($data); 
	}
	
	public function update($data, $where=null){
		$data['mtime'] = date('Y-m-d H:i:s');
		return parent::update($data, $where);
	}
}
