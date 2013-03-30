<?php $this->load->view('/common/header'); ?>

		<div class="content div-main">
			<div class="div-login">
				<form id="loginForm" action="/account/doLogin" method="POST">
					<div class="item">
						<span>账号</span>
						<input name="name" class="basic-input" />
					</div>
					
					<div class="item">
						<span>密码</span>
						<input name="password" type="password" class="basic-input" />
					</div>
		
					<div class="item">
						<span>&nbsp;</span>
						<input type="submit" value="登陆" class="btn-login" />
						<span class="span-register" style="width:140px;">>还没有帐号？<a href="/account/register">立即注册</a></span>
					</div>
				</form>
			</div>
		</div>
		<script>
			$(document).ready(function() {
				$('#loginForm').ajaxForm({
					dataType: 'json',
					success: function(response) {
						if(response['retcode'] != 0){
							alert('账户不存在或密码错误');
							return;
						}

						location = '/inout/';
					}
				});
			});
		</script>

<?php $this->load->view('/common/footer'); ?>