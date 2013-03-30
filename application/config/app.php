<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$app['amount_type'] = array(
	'1'=>'车费',
	'2'=>'电话费',
	'3'=>'餐费',
	'5'=>'数码',
	'6'=>'家电',
	'9'=>'零食',
	'11'=>'医药',
	'12'=>'图书',
	'99'=>'请客/送礼',
	'100'=>'其他',
);

$app['io_type'] = array(
	1=>'支出',	
	2=>'收入',	
);

$config['app'] = $app;
