<?php $this->load->view('/common/header'); ?>
		
		<div class="content div-main">
			<div class="div-register">
				<form id="registerForm" action="/account/doRegister" method="POST">
					<div class="item">
						<span>账号</span>
						<input name="name" class="basic-input" />
					</div>
					
					<div class="item">
						<span>密码</span>
						<input name="password" type="password" class="basic-input" />
					</div>
					
					<div class="item">
						<span>邮箱</span>
						<input name="email" class="basic-input" />
					</div>
					
					<div class="item">
						<span>&nbsp;</span>
						<input type="submit" value="注册" class="btn-login" />
						<span class="span-register" style="width:140px;">>已经拥有帐号? <a href="/account/login">直接登录</a></span>
					</div>
				</form>
			</div>
		</div>
		<script>
			$(document).ready(function() {
				$('#registerForm').ajaxForm({
					dataType: 'json',
					success: function(response) {
						if(response['retcode'] != 0){
							var msgs = {
										1: '用户名不合法',
										2: '密码不合法',
										3: '邮箱不合法',
										4: '账号已存在',
										5: '创建账号失败',
										6: '账号不存在',
									}
							alert(msgs[response['retcode']]);
							return;
						}

						location = '/inout/';
					}
				});
			});
		</script>
		
<?php $this->load->view('/common/footer'); ?>