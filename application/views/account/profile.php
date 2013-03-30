<?php $this->load->view('/common/header'); ?>
		
		<div class="content div-main">
			<div class="div-register">
				<form id="registerForm" action="/account/doUpdate" method="POST">
					<div class="item">
						<span>账号</span>
						<input class="basic-input" value="<?php echo $account['name'];?>" disabled="disabled"/>
					</div>
					
					<div class="item">
						<span>新密码</span>
						<input id="password" name="password" type="password" class="basic-input" />
					</div>
					
					<div class="item">
						<span>邮箱</span>
						<input class="basic-input" value="<?php echo $account['email'];?>" disabled="disabled"/>
					</div>
					
					<div class="item">
						<span>&nbsp;</span>
						<input type="submit" value="更新" class="btn-login" />
					</div>
				</form>
			</div>
		</div>
		<script>
			$(document).ready(function() {
				$('#registerForm').ajaxForm({
					dataType: 'json',
					success: function(response) {
						var msgs = {
									0: '更新成功',
									1: '密码不能为空',
									2: '用户已登',
									3: '更新失败',
								}
						alert(msgs[response['retcode']]);
						$('#password').val('');
						return;
					}
					
				});
			});
		</script>
		
<?php $this->load->view('/common/footer'); ?>