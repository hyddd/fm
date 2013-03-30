	<?php $this->load->view('/common/header'); ?>
	
		<style>
			span.label { 
				margin-left:10px;
				font-size:14px;
				display: inline-block;
				width:80px;
				vertical-align: middle;
				text-align: right;
 			}
 			
			.div-inout {
				padding: 10px;
 			}
			.div-inout-filters {
				padding: 10px;
 			}
 			div legend{
				padding-top: 10px; 
				padding-bottom: 20px; 
 			}
 			.div-inout-item {
				margin-top: 8px;
				margin-bottom: 8px;
 			}
 			div .sep{
				border-bottom: 1px solid #eaeaea; margin-top:10px; margin-bottom:10px;
 			}
		</style>
		
		<div id="log" class="content2">
			<div class="div-main3">
				<div class="div-inout">
					<form action="/inout/submit" method="post" id="dataForm" >
						<div class="div-inout-item">
							<span class="label">类型：</span>
							<select name="io_type" id="io_type" class="short-select">
								<?php if( ! empty($ioTypes)):?>
								<?php foreach ($ioTypes as $key=>$val):?>
								<option value="<?php echo $key;?>"><?php echo $val;?></option>
								<?php endforeach?>
								<?php endif?>
							</select>
						</div>
					
						<div class="div-inout-item">
							<span class="label">日期：</span>
							<input name="date" id="datepicker" class="short-input"/>
						</div>
						
						<div class="div-inout-item">
							<span id="amount_type_label" class="label">用途：</span>
							<select name="amount_type" id="amount_type" class="short-select">
								<?php if( ! empty($amountTypes)):?>
								<?php foreach ($amountTypes as $key=>$val):?>
								<option value="<?php echo $key?>"><?php echo $val;?></option>
								<?php endforeach?>
								<?php endif?>
							</select>
						</div>
						
						<div class="div-inout-item">
							<span class="label">金额：</span>
							<input name="amount" class="short-input" onkeyup="if(!this.value.match(/^[\+\-]?\d*?\.?\d*?$/))this.value=this.t_value;else this.t_value=this.value;if(this.value.match(/^(?:[\+\-]?\d+(?:\.\d+)?)?$/))this.o_value=this.value" />
						</div>
						
						<div class="div-inout-item">
							<span class="label">说明：</span>
							<input name="description" class="long-input" />
						</div>
						
						<div class="div-inout-item">
							<span class="label">&nbsp;</span>
							<input type="submit" value="录入" class="btn-submit2"/>
						</div>
					</form>
				</div>
			</div>
		
			<div class="sep"></div>
			<!-- ---------------------------- -->
			
			<div id="table_filter">
				<div class="div-main2 div-inout-filters">
					<form action="/inout/page" method="post" id="filterForm" >
						<?php 
							$beginYear = 2012;
							$endYear = 2016;
							$beginMonth = 1;
							$endMonth = 13;
							$defaultYear = date('Y');
							$defaultMonth = date('m');
						?>
						<div class="div-inout-item">
							<span class="label">时间：</span>
							<select name="begin_year" class="short-select">
								<?php for($i=$beginYear; $i<$endYear; $i++):?>
								<option <?php if($defaultYear == $i){ echo 'selected="selected"';}?> value="<?php echo $i;?>"><?php echo $i;?></option>
								<?php endfor?>
							</select>
							
							<select name="begin_month" class="short-select">
								<?php for($i=$beginMonth; $i<$endMonth; $i++):?>
								<option <?php if($defaultMonth == $i){ echo 'selected="selected"';}?> value="<?php echo $i;?>"><?php echo $i;?></option>
								<?php endfor?>
							</select>
							
							<span>--</span>
							<select name="end_year" class="short-select">
								<?php for($i=$beginYear; $i<$endYear; $i++):?>
								<option <?php if($defaultYear == $i){ echo 'selected="selected"';}?> value="<?php echo $i;?>"><?php echo $i;?></option>
								<?php endfor?>
							</select>
							
							<select name="end_month" class="short-select">
								<?php for($i=$beginMonth; $i<$endMonth; $i++):?>
								<option <?php if($defaultMonth == $i){ echo 'selected="selected"';}?> value="<?php echo $i;?>"><?php echo $i;?></option>
								<?php endfor?>
							</select>
						</div>

						<div class="div-inout-item">
							<span class="label">款项类型：</span>
							<select name="amount_type" class="short-select">
								<?php if( ! empty($amountTypes)):?>
								<option value="">-请选择-</option>
								<?php foreach ($amountTypes as $key=>$val):?>
								<option value="<?php echo $key?>"><?php echo $val;?></option>
								<?php endforeach?>
								<?php endif?>
							</select>
						</div>
						
						<div class="div-inout-item">
							<span class="label">支出类型：</span>
							<select name="io_type" class="short-select">
								<?php if( ! empty($ioTypes)):?>
								<option value="">-请选择-</option>
								<?php foreach ($ioTypes as $key=>$val):?>
								<option value="<?php echo $key;?>"><?php echo $val;?></option>
								<?php endforeach?>
								<?php endif?>
							</select>
						</div>
						
						<div class="div-inout-item">
							<span class="label"></span>
							<input type="submit" value="搜索" class="btn-submit2"/>
							<input type="reset" value="重置" class="btn-submit2"/>
						</div>
					</form>
				</div>
			</div>

			<div class="sep"></div>
			<!-- ---------------------------- -->
			 
			<div id="table">
			</div>
		
		</div>
	
	  <script>
			var loadTable = function(){
				$('#filterForm').submit();
			};
	  
			$(document).ready(function() {
				$('#dataForm').ajaxForm({
					dataType: 'json',
					success: function(response) {
						var msgs = {
									0: '数据保存成功',
									1: '数据保存失败',
								};
						alert(msgs[response['retcode']]);
						loadTable();
						$('#dataForm').resetForm();
					}
				});

				$('#filterForm').ajaxForm({
					dataType: 'html',
					success: function(response) {
						$('#table').html(response);
					}
				});
			     
			    $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
			    
			    $('#io_type').change(function(){
			    	var val = $('#io_type').val();
				    if(val == 1){
					    $('#amount_type_label').css('display', '');
					    $('#amount_type').css('display', '');
					}else{
						$('#amount_type_label').css('display', 'none');
					    $('#amount_type').css('display', 'none');
					}
				});

			    //loadTable();
			});
	  </script>	
	  <?php $this->load->view('/common/footer'); ?>
