<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {
	public function login(){
		$this->load->model('account_session_model');
		if($this->account_session_model->isLogin()){
			redirect('/');
			return;
		}
		
		$this->load->view('account/login');
	}
	
	public function register(){
		$this->load->model('account_session_model');
		if($this->account_session_model->isLogin()){
			redirect('/');
			return;
		}
		
		$this->load->view('account/register');
	}
	
	public function profile(){
		$this->load->model('account_session_model');
		if( ! $this->account_session_model->isLogin()){
			redirect('/account/login');
			return;
		}
		
		$data['account'] = $this->account_session_model->get();
		$this->load->view('account/profile', $data);
	}
	
	public function doLogin(){
		$filters = array(
			'name'=>$this->input->get_post('name'),
			'password'=>md5($this->input->get_post('password')),
		);
		
		$this->load->model('account_model');
		$account = $this->account_model->getOne($filters);
		
		if( empty($account) ){
			$this->output->set_output( json_encode(array('retcode'=>1, 'msg'=>'not exist')) );
			return;
		}
		
		$this->load->model('account_session_model');
		$this->account_session_model->set($account);
		
		$this->output->set_output( json_encode(array('retcode'=>0, 'msg'=>'success')) );
	}
	
	public function doRegister(){
		$account = array(
			'name'=>$this->input->get_post('name'),
			'password'=>$this->input->get_post('password'),
			'email'=>$this->input->get_post('email'),
		);
		
		if( empty($account['name']) ){
			$this->output->set_output( json_encode(array('retcode'=>1, 'msg'=>'name is invalid')) );
			return;
		}
		
		if( empty($account['password']) ){
			$this->output->set_output( json_encode(array('retcode'=>2, 'msg'=>'password is invalid')) );
			return;
		}else{
			$account['password'] = md5($account['password']);
		}
		
		if( empty($account['email']) ){
			$this->output->set_output( json_encode(array('retcode'=>3, 'msg'=>'email is invalid')) );
			return;
		}
		
		$this->load->model('account_model');
		
		$filters = array(
			'name'=>$account['name'],
		);
		$oldAccount = $this->account_model->getOne($filters);
		if( ! empty($oldAccount)){
			$this->output->set_output( json_encode(array('retcode'=>4, 'msg'=>'account is exist')) );
			return;
		}
		
		$ret = $this->account_model->insert($account);
		if( ! $ret){
			$this->output->set_output( json_encode(array('retcode'=>5, 'msg'=>'save failed')) );
			return;
		}
		
		// do login
		$filters = array(
			'name'=>$account['name'],
			'password'=>$account['password'],
		);
		$account = $this->account_model->getOne($filters);
		if( empty($account) ){
			$this->output->set_output( json_encode(array('retcode'=>6, 'msg'=>'account not exist')) );
			return;
		}
		
		$this->load->model('account_session_model');
		$this->account_session_model->set($account);
		
		$this->output->set_output( json_encode(array('retcode'=>0, 'msg'=>'success')) );
	}

	public function doUpdate(){
		$password = $this->input->get_post('password');
		if(empty($password)){
			echo json_encode(array('retcode'=>1, 'msg'=>'password is invalid'));	
			return;
		}
		
		$this->load->model('account_session_model');
		if( ! $this->account_session_model->isLogin()){
			echo json_encode(array('retcode'=>2, 'msg'=>'logout'));	
			return;
		}
		
		$account = $this->account_session_model->get();
		$this->load->model('account_model');
		
		$data = array('password'=>md5($password));
		$wheres = array('id'=>$account['id']);
		 
		$ret = $this->account_model->update($data, $wheres);
		if(empty($ret)){
			echo json_encode(array('retcode'=>3, 'msg'=>'update failed'));	
			return;
		}
		
		echo json_encode(array('retcode'=>0, 'msg'=>'successed'));
	}
	
	public function doLogout(){
		$this->load->model('account_session_model');
		$this->account_session_model->clear();
	}
	
}