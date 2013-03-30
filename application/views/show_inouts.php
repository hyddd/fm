<!-- 
	//table { text-align: center;border: 1px solid #C0C0C0; }
	//table tbody td { border: 1px solid #C0C0C0; }
 -->
<style>
<!--

	span.total { display:block; }
	
	
 			
.olt {
width: 100%;
padding: 0;
margin-bottom: 3px;
} 		
tbody {
display: table-row-group;
vertical-align: middle;
border-color: inherit;
}
.pl {
font: 12px Arial,Helvetica,sans-serif;
line-height: 150%;
color: #666;
}
tr {
display: table-row;
vertical-align: inherit;
border-color: inherit;
}

.olt th {
	border: 1px solid #b8d9be;
color: #589c66;
background: #deede0;
	
border-bottom: 1px solid #ededed;
border-top: 1px solid #ededed;
padding: 3px 3px 3px 0;
word-wrap: break-word;
word-break: break-word;
}
.olt td {
padding: 3px;
padding: 6px 3px;
border-bottom: 1px dashed #ddd;
padding: 3px 3px 3px 0;
word-wrap: break-word;
word-break: break-word;
text-align: center;
}
-->
</style>
	<?php $this->load->helper('formatter'); ?>
	<div>
		<table id="log_details" class="olt">
			<thead>
				<tr class="pl">
					<th width=3%></th>
					<th width=15%>费用产生时间</th>
					<th width=10%>类型</th>
					<th width=10%>用途</th>
					<th width=10%>金额</th>
					<th width=52%>说明</th>
				</tr>
			</thead>
			
			<?php if( ! empty($page['rows']) ):?>
				<?php 
					$income = 0;
					$payout = 0;
				?>
				<tbody>
				<?php foreach ($page['rows'] as $row):?>
				<?php 
					$row['amount'] = floatval($row['amount']);
					if($row['io_type'] == 1){
						$payout += $row['amount'];
					}else if($row['io_type'] == 2){
						$income += $row['amount'];
					}
				?>
				<tr class="pl">
					<td></td>
					<td><?php echo $row['date'];?></td>
					<td><?php echo ioTypeFormatter($row['io_type']);?></td>
					<td><?php echo amountTypeFormatter($row['amount_type']);?></td>
					<td><?php echo amountFormatter($row['amount']);?></td>
					<td><?php echo $row['description'];?></td>
				</tr>
				<?php endforeach?>
				</tbody>
			<?php endif?>
		</table>
		
		<?php if( ! empty($page['rows']) ):?>
		<span class="total">收入：<?php echo amountFormatter($income);?></span>
		<span class="total">支出：<?php echo amountFormatter($payout);?></span>
		<?php endif?>
		
	</div>
