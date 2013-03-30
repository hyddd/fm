<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chart extends CI_Controller {
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
		$data['cmc'] = $this->currMonthCost();
		$data['lmc'] = $this->lastMonthCost();
		$data['yearc'] = $this->yearCost();
		
		$this->load->view('chart/charts', $data);	
	}
	
	private function currMonthCost(){
		$this->load->helper('common');

		$year = date('Y');
		$month = date('m');
		$bTime = getMonthFirstDate($year, $month);
		$eTime = getMonthLastDate($year, $month);
		
		$filters = array('date >='=>$bTime, 'date <='=>$eTime, 'account_id'=>$this->accountId, 'io_type'=>1);
		$this->load->model('inout_model');
		$outs = $this->inout_model->get($filters, 'amount, amount_type');
		if( ! empty($outs)){
			$tmp = array();
			foreach($outs as $out){
				if( ! isset($tmp[$out['amount_type']]) ){
					$tmp[$out['amount_type']] = floatval($out['amount']);
				}else{
					$tmp[$out['amount_type']] += floatval($out['amount']);
				}
			}
		}

		//$cost = array( array('支出类型','金额'), );
		$cost = array( );
		$this->load->helper('formatter');
		if( ! empty($tmp)){
			foreach($tmp as $k=>$v){
				$cost[] = array(amountTypeFormatter($k), $v);
			}
		}
		
		return $cost; 
	}
	
	private function lastMonthCost(){
		$year = date('Y');
		$month = date('m');
		
		if($month == 1){
			$year = 1;
			$month = 12;
		}else{
			$month--;
		}
		
		$bTime = getMonthFirstDate($year, $month);
		$eTime = getMonthLastDate($year, $month);
		
		$filters = array('date >='=>$bTime, 'date <='=>$eTime, 'account_id'=>$this->accountId, 'io_type'=>1);
		$this->load->model('inout_model');
		$outs = $this->inout_model->get($filters, 'amount, amount_type');
		if( ! empty($outs)){
			$tmp = array();
			foreach($outs as $out){
				if( ! isset($tmp[$out['amount_type']]) ){
					$tmp[$out['amount_type']] = floatval($out['amount']);
				}else{
					$tmp[$out['amount_type']] += floatval($out['amount']);
				}
			}
		}

		$cost = array();
		$this->load->helper('formatter');
		if( ! empty($tmp)){
			foreach($tmp as $k=>$v){
				$cost[] = array(amountTypeFormatter($k), $v);
			}
		}
		
		return $cost; 
	}
	
	private function yearCost(){
		$year = date('Y');
		$lyear = date('Y') - 1;
		$month = date('m');
		$lymonth = $month + 1; 
		$bTime = getMonthFirstDate($lyear, $lymonth);
		$eTime = getMonthLastDate($year, $month);
		
		$filters = array('date >='=>$bTime, 'date <='=>$eTime, 'account_id'=>$this->accountId, 'io_type'=>1);
		$this->load->model('inout_model');
		$outs = $this->inout_model->get($filters, 'amount, date');
		
		$tmp = array();
		do{
			$tmp[$lyear . '-' . $lymonth] = 0;
			$lymonth++;
			if($lymonth>12){
				$lymonth = 1;
				$lyear++;
			}
			
			if($lymonth < 10){
				$lymonth = '0' . $lymonth;
			}
		}while( ! ($lyear == $year && $lymonth == $month + 1) );
		
		if( ! empty($outs)){
			foreach($outs as $out){
				$dates = explode('-', $out['date']);
				$key = $dates[0] . '-' . $dates[1];  
				
				$tmp[$key] += floatval($out['amount']);
			}
		}
		
		$cost = array();
		if( ! empty($tmp)){
			foreach($tmp as $k=>$v){
				$cost[] = array($k, $v);
			}
		}
		
		return $cost; 
	}
}