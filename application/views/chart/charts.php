<?php $this->load->view('/common/header'); ?>
	<link rel="stylesheet" type="text/css" href="/css/jquery.jqChart.css" />
    <link rel="stylesheet" type="text/css" href="/css/jquery.jqRangeSlider.css" />
    <script src="/js/jquery.jqChart.min.js" type="text/javascript"></script>
    <script src="/js/jquery.jqRangeSlider.min.js" type="text/javascript"></script>
    
    <script type="text/javascript">
    	/*
    	 *  JQChart：
		 *    http://www.jqchart.com/jquery/chart/ChartTypes/ColumnChart
		 */
		function showPeiDetail(e, data){
			var percentage = data.series.getPercentage(data.value);
	        percentage = data.chart.stringFormat(percentage, '%.2f%%');
	
	        return '<b>' + data.dataItem[0] + '</b></br>' + data.value + ' (' + percentage + ')';
		}

		$(document).ready(function () {
            $('#cmc').jqChart({
                title: { text: '本月支出比例', },
                legend: { title: '支出类型', font: '15px Helvetica,Arial,sans-serif', },
                border: { strokeStyle : '#E9E9FF', lineWidth: 1},
                background: '#edf6ed',
                animation: { duration: 1 },
                shadows: {
                    enabled: true
                },
                series: [
                            {
                                type: 'pie',
                                labels: {
                                    stringFormat: '%.1f%%',
                                    valueType: 'percentage',
                                    font: '15px Helvetica,Arial,sans-serif',
                                    fillStyle: 'white'
                                },
                                data: <?php echo json_encode($cmc);?>
                            }
                        ]
            });
            $('#cmc').bind('tooltipFormat', showPeiDetail);

            
            $('#lmc').jqChart({
                title: { text: '上月支出比例', },
                legend: { title: '支出类型', font: '15px Helvetica,Arial,sans-serif', },
                border: { strokeStyle : '#E9E9FF', lineWidth: 1},
                background: '#edf6ed',
                animation: { duration: 1 },
                shadows: {
                    enabled: true
                },
                series: [
                            {
                                type: 'pie',
                                labels: {
                                    stringFormat: '%.1f%%',
                                    valueType: 'percentage',
                                    font: '15px Helvetica,Arial,sans-serif',
                                    fillStyle: 'white'
                                },
                                data: <?php echo json_encode($lmc);?>
                            }
                        ]
            });
            $('#lmc').bind('tooltipFormat', showPeiDetail);

            $('#yearc').jqChart({
                title: { text: '最近一年支出' },
                border: { strokeStyle : '#E9E9FF', lineWidth: 1},
                background: '#edf6ed',
                animation: { duration: 1 },
                shadows: {
                    enabled: true
                },
                series: [
                            {
                                type: 'column',
                                title: '支出金额',
                                data: <?php echo json_encode($yearc);?>
                            },
                        ]
            });
	});
    </script>
    <div class="content" >
			<div id="cmc" class="pie_chart_content" style="width: 440px; height: 400px;"></div>
			<div id="lmc" class="pie_chart_content" style="width: 440px; height: 400px;"></div>
			<div id="yearc" class="pie_chart_content" style="width: 900px; height: 400px;"></div>
    </div>
<?php $this->load->view('/common/footer'); ?>