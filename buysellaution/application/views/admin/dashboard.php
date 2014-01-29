<?php defined('SYSPATH') OR die("No direct access allowed.");?>
<head>
<style>
.customer-type
{

padding-left:5px;
height:600px;
width:800px;
}
#customer
{
float:left;
padding-left:5px;
height:400px;
width:360px;
}
#customer-details{float:left;margin-left:40px;background-color:white;padding-left:5px;height:300px;width:360px;border:2px solid #4572A7;}

#customer-login-details{float:left;margin-left:40px;background-color:white;padding-left:5px;height:300px;width:360px;border:2px solid #4572A7;margin-top:20px;}
.HighlightableRow:hover,a:hover
{
  background-color: lightgray;
  text-decoration:none;
}
</style>
</head>
<div class="customer-type"> 
	<div id="customer"> </div>
	<div id="customer-details">
	<table border="0" cellspacing="0" width="75%" cellpadding="13" frame="box">
	<h3><center><?php echo __('web_customer_details');?></center></h3>
		<tr width="55">
			<th colspan="2"><?php echo __('customer_details');?></th>
		</tr>
		<tr>
			<td width=""><b><?php echo __('type');?></b></td>
			<td><b><?php echo __('count');?></b></td>
		</tr>
		<tr class="HighlightableRow">
			<td id="wb_cust" width=""><a href=""><?php echo __('website_customer');?></a></td>
			<td><?php echo $get_total_web_customers_count;?></td>
		</tr><hr>		
		<tr class="HighlightableRow">
			<td id="fb_cust" width=""><a href=""><?php echo __('facebook_customer');?></a></td>
			<td><?php echo $total_facebook_users;?></td>
		</tr>
		<tr class="HighlightableRow">
			<td id="tw_cust" width=""><a href=""><?php echo __('twitter_customer');?></a></td>
			<td><?php echo $total_twitter_users;?></td>
		</tr>
	
	</table>
	</div>
	<div id="customer-login-details">
	<table border="0" cellspacing="0" width="75%" cellpadding="13" frame="box">
	
		<tr width="55">
			<th colspan="2"><?php echo __('customer_login_date_details');?></th>
		</tr>
		<tr>
			<td width=""><b><?php echo __('web_customer');?></b></td>
			<td><b><?php echo __('count');?></b></td>
		</tr>
		<tr class="HighlightableRow">
			<td id="" width=""><?php echo __('today');?></td>
			<td><?php echo $todays_users_count;?></td>
		</tr>
		<tr class="HighlightableRow">
			<td id="" width=""><?php echo __('last_7days');?></td>
			<td><?php echo $get7days_users_count;?></td>
		</tr>
		<tr class="HighlightableRow">
			<td id="" width=""><?php echo __('last_30days');?></td>
			<td><?php echo $get30days_users_count;?></td>
		</tr>
		<tr class="HighlightableRow">
			<td id="" width=""><?php echo __('last _12months');?></td>
			<td><?php echo $get1year_users_count;?></td>
		</tr>
		<tr class="HighlightableRow">
			<td id="" width=""><?php echo __('last _10years');?></td>
			<td><?php echo $get10years_users_count;?></td>
		</tr>
	
	</table>
	</div>
</div>
<div id="" style="min-width: 400px; height: 50px; margin: 0 auto"></div>
<div id="userlist" style="min-width: 400px;padding-left:5px; height: 400px; margin: 0 auto"></div>
<div id="" style="min-width: 400px; height: 50px; margin: 0 auto;"></div>
<div class="displaygraph_trans">
<div id="transaction" style="min-width: 400px;padding-left:5px; height: 400px; margin: 0 auto;overflow-x:scroll ; overflow-y: hidden; padding-bottom:10px;"></div>
</div>

<body screen_capture_injected="true">     

	<script type="text/javascript" src="<?php echo SCRIPTPATH; ?>chart/script.js"></script>	
	<script type="text/javascript" src="<?php echo SCRIPTPATH; ?>chart/highcharts.js"></script>
	<script type="text/javascript" src="<?php echo SCRIPTPATH; ?>chart/exporting.js"></script>
	
         <script type="text/javascript">

			Highcharts.theme = {
			   colors: ['#058DC7', '#50B432', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
			   chart: {
				  backgroundColor: {
					 linearGradient: [0, 0, 500, 500],
					 stops: [
						[0, 'rgb(255, 255, 255)'],
						[1, 'rgb(240, 240, 255)']
					 ]
				  },
				  borderWidth: 2,
				  plotBackgroundColor: 'rgba(255, 255, 255, .9)',
				  plotShadow: true,
				  plotBorderWidth: 1
			   },
			   title: {
				  style: {
					 color: '#000',
					 font: 'bold 16px "Trebuchet MS", Verdana, sans-serif'
				  }
			   },
			   subtitle: {
				  style: {
					 color: '#666666',
					 font: 'bold 12px "Trebuchet MS", Verdana, sans-serif'
				  }
			   },
			   xAxis: {
				  gridLineWidth: 1,
				  lineColor: '#000',
				  tickColor: '#000',
				  labels: {
					 style: {
						color: '#000',
						font: '11px Trebuchet MS, Verdana, sans-serif'
					 }
				  },
				  title: {
					 style: {
						color: '#333',
						fontWeight: 'bold',
						fontSize: '12px',
						fontFamily: 'Trebuchet MS, Verdana, sans-serif'

					 }
				  }
			   },
			   yAxis: {
				  minorTickInterval: 'auto',
				  lineColor: '#000',
				  lineWidth: 0,
				  tickWidth: 0,
				  tickColor: '#000',
				  labels: {
					 style: {
						color: '#000',
						font: '11px Trebuchet MS, Verdana, sans-serif'
					 }
				  },
				  title: {
					 style: {
						color: '#333',
						fontWeight: 'bold',
						fontSize: '12px',
						fontFamily: 'Trebuchet MS, Verdana, sans-serif'
					 }
				  }
			   },
			   legend: {
				  itemStyle: {
					 font: '9pt Trebuchet MS, Verdana, sans-serif',
					 color: 'black'

				  },
				  itemHoverStyle: {
					 color: '#039'
				  },
				  itemHiddenStyle: {
					 color: 'gray'
				  }
			   },
			   labels: {
				  style: {
					 color: '#99b'
				  }
			   }
			};

// Apply the theme
var highchartsOptions = Highcharts.setOptions(Highcharts.theme);
// Last 30 Day's Transaction Reports

$(function () {
    var chart;
    
    
    $(document).ready(function () {
        
        // Build the chart
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'customer',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                spacingBottom: 30 
            },
            title: {
                text: 'Total customer count'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage}%</b>',               
                formatter: function() {
				return '<b>'+ this.point.name +'</b>: '+ Math.round(this.percentage) +' %';
				}
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                type: 'pie',
                name: 'Customer Count',
                data: [
                    ['<?php echo __('website_customer');?>',   <?php echo $get_total_web_customers_count;?>],
                    
                    {
                        name: '<?php echo __('facebook_customer');?>',
                        y:  <?php echo $total_facebook_users;?>,
                        sliced: true,
                        selected: true
                    },
                    {
                        name: '<?php echo __('twitter_customer');?>',
                        y:  <?php echo $total_twitter_users;?>,
                        sliced: true,
                        selected: true
                    }                  
 
                    
                ]
            }]
        });
    });
    
    
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'userlist',
                type: 'column'
                
            },
            title: {
                text: 'Total Registered Users'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: [<?php foreach($last_12_months_user as $months)
                { echo "'".$months."',";} ?>
                ]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Registered Users '
                }
            },
            legend: {
                layout: 'vertical',
                backgroundColor: '#FFFFFF',
                align: 'left',
                verticalAlign: 'top',
                x: 100,
                y: 70,
                floating: true,
                shadow: true
            },
            tooltip: {
                formatter: function() {
                    return ''+
                        this.x +': '+ this.y +'';
                }
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 1
                }
            },
                series: [{
                name: 'Users',
                data: [<?php  foreach($last_12_months_user as $months)
                { echo $last_12_months_values_user[$months].",";} ?>]
    
            }]
        });
    });  


    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'transaction',
				type: 'area',
				width: 1300,
				marginBottom:40
			
            },
            title: {
                text: 'Last 30 days transaction report'
                
            },
            subtitle: {
                text: '',
                floating: true,
                align: 'right',
                verticalAlign: 'bottom',
                y: 15
            },
            legend: {
                layout: 'vertical',
                align: 'left',
                verticalAlign: 'top',                
                floating: true,
                borderWidth: 1,
                backgroundColor: '#FFFFFF'
            },
            xAxis: {
                categories: [<?php  foreach($last_30_days as $dates)
                { echo "'".$dates."',";} ?>]
            },
            yAxis: {
                title: {
                    text: 'Transaction count'
                },
                
                labels: {
                    formatter: function() {
                        return this.value;
                    }
                }
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.series.name +'</b><br/>'+
                    this.x +': '+ this.y;
                }
            },
            plotOptions: {
                area: {
                    fillOpacity: 0.5
                }
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Transaction',
                data: [<?php  foreach($last_30_days as $dates)
                { echo $last_30_days_values[$dates].",";} ?>]
            },],
                        
        });
    });
    
    
});

</script>


