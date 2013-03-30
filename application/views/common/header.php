<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="/css/jquery-ui-1.9.2.custom.min.css" />
		<link rel="stylesheet" href="/css/main.css" />
 		<script src="/js/jquery-1.8.3.js"></script>
 		<script src="/js/jquery-ui-1.9.2.custom.min.js"></script>
 		<script src="/js/jquery.form.js"></script>
		<title></title>
	</head>
	<body>
		<div class="global-top">
			
			<div class="global-top-items">
	      		<ul>
		            <li><a href="/inout">收入支出</a></li>
		            <li><a href="/chart">财政报表</a></li>
	      		</ul>
			</div>
		
			<div class="top-nav-info">
				<?php 
					$CI = get_instance();
					$CI->load->model('account_session_model');
					$_account = $CI->account_session_model->get();
				?>
				<?php if( ! empty($_account)): ?>
				<ul>
					<li><span><?php echo $_account['name'] . '，你好！'; ?><span></li>
					<li><a href="/account/profile">个人资料</a></li>
					<li><a onclick="logout();">登出</a></li>
				</ul>
				<script>
					function logout(){
						$.get('/account/doLogout', function(){
							location.reload();
						});
						return false;
					}
				</script>
				<?php endif?>
			</div>
		</div>
		<div class="top"></div>
		<div class="leftbar"></div>
		<div class="rightbar"></div>
		
		