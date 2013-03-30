<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inout extends CI_Controller {
	var $accountId = null;
	
	function __construct(){
		parent::__construct();
		$this->load->model('account_session_model');
		$ret = $this->account_session_model->isLogin();
		if( ! $ret){
			redirect('/account/login');
			return;
		}
		$account = $this->account_session_model->get();
		$this->accountId = $account['id'];
	}
	
	public function index(){
		$this->load->config('app');
		$data = array(
			'amountTypes'=>$this->config->item('amount_type', 'app'),
			'ioTypes'=>$this->config->item('io_type', 'app')
		);
		$this->load->view('inout', $data);
	}
	
	public function submit(){
		$data = array(
			'io_type'=>intval($this->input->get_post('io_type')),
			'amount'=>intval($this->input->get_post('amount')),
			'amount_type'=>$this->input->get_post('amount_type'),
			'date'=>$this->input->get_post('date'),
			'description'=>$this->input->get_post('description'),
		);

		$data['account_id'] = $this->accountId;
		if($data['io_type'] == 2){
			$data['amount_type'] = 0;
		}
		
		$this->load->model('inout_model');
		$ret = $this->inout_model->insert($data);
		
		if( ! $ret){
			$this->output->set_output(json_encode(array('retcode'=>1, 'msg'=>'save failed')));
			return;
		}
		
		$this->output->set_output( json_encode(array('retcode'=>0, 'msg'=>'success')) );
	}
	
	public function page(){
		$pageno = 1;
		$pagesize = 999999;
		
		$beginYear = intval($this->input->get_post('begin_year'));
		$beginMonth = intval($this->input->get_post('begin_month'));
		$endYear = intval($this->input->get_post('end_year'));
		$endMonth = intval($this->input->get_post('end_month'));
		$amountType = intval($this->input->get_post('amount_type')); 
		$ioType = intval($this->input->get_post('io_type')); 
		
		$filters = array(
			'groupOp'=>'AND',
			'rules'=>array(
				array(
					'field'=>'account_id',
					'op'=>'eq',
					'data'=>$this->accountId,
				),
			),
		);
		if( ! empty($beginYear) && ! empty($beginMonth)){
			$date = $beginYear . '-' . $beginMonth . '-1';
			$filters['rules'][] = array(
					'field'=>'date',
					'op'=>'ge',
					'data'=>$date,
				);
		}
		if( ! empty($endYear) && ! empty($endMonth)){
			$date = $endYear . '-' . ($endMonth+1) . '-1';
			$filters['rules'][] = array(
					'field'=>'date',
					'op'=>'lt',
					'data'=>$date,
				);
		}
		if( ! empty($amountType)){
			$filters['rules'][] = array(
					'field'=>'amount_type',
					'op'=>'eq',
					'data'=>$amountType,
				);
		}
		if( ! empty($ioType)){
			$filters['rules'][] = array(
					'field'=>'io_type',
					'op'=>'eq',
					'data'=>$ioType,
				);
		}
		
		$sorts = array(
			array(
				'sidx'=>'date',
				'sord'=>'desc',
			),
			array(
				'sidx'=>'io_type',
				'sord'=>'desc',
			),
		);
		$this->load->model('inout_model');
		$data['page'] = $this->inout_model->getPage($pageno, $pagesize, $filters, $sorts);
		
		$this->load->config('app');
		$data['amountTypes'] = $this->config->item('amount_type', 'app');
		$data['ioTypes'] = $this->config->item('io_type', 'app');
		 
		$this->load->view('show_inouts', $data);	
	}
}