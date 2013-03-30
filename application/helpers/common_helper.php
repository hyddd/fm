<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('getMonthFirstDate')){
	function getMonthFirstDate($year, $month){
		if ($month < 1 OR $month > 12){
			return null;
		}
		
		return $year . '-' . $month . '-01';
	}
}

if ( ! function_exists('getMonthLastDate')){
	function getMonthLastDate($year, $month){
		$days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

		if ($month < 1 OR $month > 12){
			return null;
		}

		// Is the year a leap year?
		if ($month == 2){
			if ($year%400 == 0 OR ($year%4 == 0 AND $year%100 != 0)){
				return $year.'-'.$month.'-29';
			}
		}

		return $year.'-'.$month.'-'.$days_in_month[$month - 1];
	}
}