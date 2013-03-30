<?php 

class Account_session_model extends CI_model {
			
	function __construct(){
		parent::__construct();
		
		$this->load->library('session');
	}
	
	public function isLogin(){
		$account = $this->session->userdata('account');
		return empty($account) ? FALSE : TRUE;
	}
	
	public function get(){
		return $this->session->userdata('account');
	}
	
	public function set($account){
		if( isset($account['password']) ){
			unset($account['password']);
		}
		
		$data = array(
			'account'=>$account,
		);
		$this->session->set_userdata($data);
	}
	
	public function clear(){
		$this->session->unset_userdata('account');
	}
}
