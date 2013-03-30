<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('amountTypeFormatter')){
	function amountTypeFormatter($val){
		$CI = get_instance();
		$CI->load->config('app');
		$amountTypes = $CI->config->item('amount_type', 'app');
		
		if( ! isset($amountTypes[$val])){
			return '-';
		}
		
		return $amountTypes[$val];
	}
}

if ( ! function_exists('ioTypeFormatter')){
	function ioTypeFormatter($val){
		$CI = get_instance();
		$CI->load->config('app');
		$ioTypes = $CI->config->item('io_type', 'app');
		
		if( ! isset($ioTypes[$val])){
			return '-';
		}
		
		return $ioTypes[$val];
	}
}

if ( ! function_exists('amountFormatter')){
	function amountFormatter($val){
		return sprintf("%01.2f", $val);
	}
}