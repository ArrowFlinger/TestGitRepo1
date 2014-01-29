        <?php defined('SYSPATH') OR die("No direct access allowed."); 
$srch_from_date = isset($srch['fromdate'])?$srch['fromdate']:"";
$srch_to_date = isset($srch['todate'])?$srch['todate']:"";
//For sort All jobs order status
$sort_val = isset($srch["order_search"]) ? trim($srch["order_search"]) :''; 
//For search username

$username_list = isset($srch["username_search"]) ? $srch["username_search"] :'';

//For CSS class deefine in the table if the data's available
$total_transactions=count($all_transaction_list);
$table_css=$export_excel_button="";
$table_css="";
if($total_transactions > 0)
{  $table_css='class="table_border"';  }?>
<!--<link rel="stylesheet" type="text/css" href="<?php echo ADMINCSSPATH.'ui.datepicker.css';?>" title="alt" />-->
<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
    <div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
    <div class="content_middle">
        <form method="post" class="admin_form" name="frmtransaction" id="frmtransaction" action="index">
            <table class="list_table1 fl clr" border="0" width="110%" cellpadding="5" cellspacing="0">
                <tr>
					 <td valign="top"><label><?php echo __('user_label'); ?></label></td>
                    <td valign="top">
                        <select name="username_search" id="username_search">
							<option value=""><?php echo __('select_label'); ?></option>
				            <?php 
							//code to display username drop down
								foreach($all_username as $userlist) { 
								$selected_username="";  	
								$selected_username=($userlist['id']==trim($username_list)) ? " selected='selected' " : "";
								array_filter($userlist); 
							 ?>
                                <option value="<?php echo $userlist['id']; ?>"  <?php echo $selected_username; ?>><?php echo ucfirst($userlist['username']);?></option>
							
							<?php } ?>
                        </select>

                    </td>                  
             
                    <td valign="top"><label> <?php echo __('product_order',array(':param'=> $product_settings[0]['alternate_name']));?></label></td>

                    <td valign="top">
									<input type="text" name="order_search"  maxlength = "32" id="order_search" value="<?php echo isset($sort_val) ? trim($sort_val) :'';  ?>" />
										 <span class="search_info_label"><?php echo __('srch_info_order_keyword');?></span>
                    </td>
                    </tr>
 		    <tr>
		                     <td valign="top"><label><?php echo __('from_date_label');?></label></td>
		                     <td valign="top">
		                     <input type="text" name="fromdate" id="fromdate" value="<?php echo $srch_from_date; ?>" class="DatePicker" >
		                     </td>
	 
	                             <td valign="top"><label><?php echo __('to_date_label');?></label></td>
		                     <td valign="top">             
		                     <input type="text" name="todate" id="todate" value="<?php echo $srch_to_date; ?>" class="DatePicker" > 
		                     </td> 
                    </tr> 
                  <tr>
		                <td colspan="4" style="padding-left:300px;">
		                   		<input type="submit" value="<?php echo __('button_search'); ?>" title="<?php echo __('button_search'); ?>" name="search_transaction" />
                           		<input type="button" value="<?php echo __('button_cancel'); ?>" title="<?php echo __('button_cancel'); ?>" onclick="location.href='<?php echo URL_BASE;?>transaction/index'" />
                        </td>                    
                 </tr>
            </table>
<div class="clr">&nbsp;</div>
<div class="products_graph">
<div id="container_total"></div>
<div id="container_details">


 <div class="invest-cm">
                <p class="clearfix"> <span></span> <span class="right_1"> </span> </p>
                <div class="prcess_bar3">
                  <div class="pro_left"></div>
                 
                  <div class="pro_mid" style="width:95%"> </div>
                  <div class="pro_rgt"> </div>
                </div>
                <p class="clearfix"> <span> </span> <span class="right_1"></span> </p>
                <div class="prcess_bar1">
                                                      <div class="pro_left"></div>
                  <div class="pro_mid" style="width:95%;"> </div>
                  <div class="pro_rgt"> </div>
                                  </div>
                <p class="clearfix"> <span></span> <span class="right_1"> </span> </p>
                <div class="prcess_bar2">
                                                       
                </div>
                <div class="dash_market_info" style="background-color:white;">
                  <div class="transaction-table">
                    <div class="invest-tl">
                      <div class="trans_table_top">
                       <div class="trans_table_tl"> </div>
                        <div class="trans_table_tm"> </div>
                        <div class="trans_table_tr"> </div>
                      </div>
                      <div class="trans_table_mid">
                        <div class="trans_table_ml"> </div>
                        <div class="trans_table_mm">
                          <h3 class="market"><?php echo __('products_transaction_Details') ;?></h3>
                          <table border="0" cellspacing="0" width="75%" cellpadding="13" frame="box">
                            <tbody><tr width="55">
                              <th align="left" class="mar-bor-r"><?php echo __('transaction') ;?></th>
                              <th align="left" class="mar-bor-r"><?php echo __('count') ;?></th>
                              <th align="left"><?php echo __('amount') ;?></th>
                            </tr>                                                        
                            <tr class="HighlightableRow">
                              <td class="mar-bor-r"><?php echo __('today') ;?></td>
                              <td class="mar-bor-r"><?php echo $count_of_todayprod?$count_of_todayprod:'0';?></td>
                              <td><?php echo $site_currency.$sum_of_todayprod?$site_currency.$sum_of_todayprod:$site_currency.'0';?></td>
                            </tr>
                            <tr class="HighlightableRow">
                              <td class="mar-bor-r"><?php echo __('last_7days') ;?></td>
                              <td class="mar-bor-r"><?php echo $count_of_last30days?$count_of_last30days:'0';?></td>
                              <td><?php echo $site_currency.$sum_of_last30days?$site_currency.$sum_of_last30days:$site_currency.'0';?></td>
                            </tr>
                            <tr class="HighlightableRow">
                              <td class="mar-bor-r"><?php echo __('last_year') ;?></td>
                              <td class="mar-bor-r"><?php echo $count_of_last10year?$count_of_last10year:'0';?></td>
                              <td><?php echo $site_currency.$sum_of_last10year?$site_currency.$sum_of_last10year:$site_currency.'0';?></td>
                            </tr>
                            <tr class="HighlightableRow">
                              <td class="mar-bor-r"><?php echo __('total') ;?></td>
                              <td class="mar-bor-r"><?php echo $count_of_allproducts?$count_of_allproducts:'0';?></td>
                              <td><?php echo $site_currency.$sum_of_allproducts?$site_currency.$sum_of_allproducts:$site_currency.'0';?></td>
                            </tr>
                          </tbody></table>
                       </div>
                        <div class="trans_table_mr"> </div>
                      </div>
                      <div class="trans_table_bot">
                        <div class="trans_table_bl"> </div>
                        <div class="trans_table_bm"> </div>
                        <div class="trans_table_br"> </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>




</div>

<script type="text/javascript" src="<?php echo SCRIPTPATH; ?>chart/script.js"></script>
<script src="jquery.js"></script>
<script>
$(document).ready(function(){
  $("#select_container_days").click(function(){
    $("#container_days_line").show();
    $("#container_month_line").hide();
    $("#container_year_line").hide();
  });
  $("#select_container_months").click(function(){
    $("#container_month_line").show();
    $("#container_days_line").hide();
    $("#container_year_line").hide();
  });
$("#select_container_years").click(function(){
    $("#container_year_line").show();
    $("#container_month_line").hide();
    $("#container_days_line").hide();
  });
});
</script>
<div class="select_container">
	<div id="select_container_days" style="cursor:pointer;"><a><?php echo __('select_container_days_div');?></a></div>
	<div id="select_container_months" style="cursor:pointer"><a><?php echo __('select_container_months_div');?></a></div>
	<div id="select_container_years" style="cursor:pointer"><a><?php echo __('select_container_years_div');?></a></div>
</div>
<div id="container_space"></div>
<div class="displaygraph">
<div style=" width: 750px; display: hidden;">
	<div id="container_days_line" style="position: relative;min-width: 1600px; height: 400px; text-align: left; line-height: normal; font-family: &#39;Lucida Grande&#39;, &#39;Lucida Sans Unicode&#39;, Verdana, Arial, Helvetica, sans-serif; font-size: 12px; ">
	</div>
</div>
<div style="width: 750px; display: hidden;">
	<div id="container_month_line" style="position: relative; min-width: 1200px; height: 400px; text-align: left; line-height: normal; font-family: &#39;Lucida Grande&#39;, &#39;Lucida Sans Unicode&#39;, Verdana, Arial, Helvetica, sans-serif; font-size: 12px; ">
	</div>
</div>
<div style=" width: 750px; display: hidden;">
	<div id="container_year_line" style="position: relative;min-width: 1200px; height: 400px; text-align: left; line-height: normal; font-family: &#39;Lucida Grande&#39;, &#39;Lucida Sans Unicode&#39;, Verdana, Arial, Helvetica, sans-serif; font-size: 12px; ">
	</div>
</div>
</div>
<!--<button id="sday">day</button>
<button id="smon">month</button>
<button id="syear">year</button>

<div id="days" style="height:100px;width:200px;background-color:green;"></div>
<div id="months" style="height:100px;width:200px;background-color:blue;display:none;"></div>
<div id="years" style="height:100px;width:200px;background-color:grey;display:none;"></div>-->

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
				  plotBorderWidth: 1,
				 
				  
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
    $(document).ready(function() {
    chart = new Highcharts.Chart({
		chart: {
			renderTo: 'container_days_line',
			type: 'line',
			marginRight: 20,
			marginBottom:25,
			spacingBottom: 30 
		},
		title: {
			text: "Last 30 Days Transaction Report",
			x: -10 //center
		},
		
		xAxis: {
			categories:
			[<?php  foreach($last_30_days as $dates)
                { echo "'".$dates."',";} ?>] 
                		},
		yAxis: {
			title: {
				text: 'Transaction Count'
			},
			plotLines: [{
				value: 0,
				width: 1,
				color: '#808080'
			}]
		},
		tooltip: {
			formatter: function() {
					return '<b>'+ this.series.name +'</b>'+
					this.x +': '+ this.y ;
			}
		},		
		
		series: [{
			name: 'Transaction',
			data: [<?php  foreach($last_30_days as $dates)
                { echo $last_30_days_values[$dates].",";} ?>] 
		}]
	});
});


//Last 12 Month's Transaction Reports

var chart;
$(document).ready(function() {
    chart = new Highcharts.Chart({
		chart: {
			renderTo: 'container_month_line',
			type: 'line',
			marginRight: 20,
			marginBottom:25,
			spacingBottom: 30 
		},
		title: {
			text: "Last 12 Months Transaction Report",
			x: -30 //center
		},
		
		xAxis: {
			categories: 
			[<?php  foreach($last_12_months as $months)
                { echo "'".$months."',";} ?>] 
		},
		yAxis: {
			title: {
				text: 'Transaction Count'
			},
			plotLines: [{
				value: 0,
				width: 1,
				color: '#808080'
			}]
		},
		tooltip: {
			formatter: function() {
					return '<b>'+ this.series.name +'</b><br />'+
					this.x +': '+ this.y ;
			}
		},		
		
		series: [{
			name: 'Transaction',
			data: [<?php  foreach($last_12_months as $months)
                { echo $last_12_months_values[$months].",";} ?>] 
		}]
	});
});


// Last 10 year's Transaction Reports

var chart;
$(document).ready(function() {
    chart = new Highcharts.Chart({
		chart: {
			renderTo: 'container_year_line',
			type: 'line',
			marginRight: 0,
			marginBottom:25,
			spacingBottom: 30 
		},
		title: {
			text: "Last 10 years Transaction Report",
			x: -30 //center
		},
		
		xAxis: {
			categories: [<?php  foreach($last_10_years_products as $year)
                { echo "'".$year."',";} ?>]
		},
		yAxis: {
			title: {
				text: 'Transaction Count'
			},
			plotLines: [{
				value: 0,
				width: 1,
				color: '#808080'
			}]
		},
		tooltip: {
			formatter: function() {
					return '<b>'+ this.series.name +'</b><br />'+
					this.x +': '+ this.y ;
			}
		},		
		
		series: [{
			name: 'Transaction',
			data: [<?php  foreach($last_10_years_products as $year)
                { echo $last_10_years_values[$year].",";} ?>]
		}]
	});
});

});




    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
    
            chart: {
                renderTo: 'container_total',
                type: 'column'
            },
    
            title: {
                text: 'Total Transactions Count'
            },
    
            xAxis: {
                categories: ['Transactions Count']
            },
    
            yAxis: {
                allowDecimals: false,
                min: 0,
                title: {
                    text: 'Number Of Transactions'
                }
                
            },
    
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.x +'</b><br />'+
                        this.series.name +': '+ this.y +'<br />'+
                        'Total: '+ this.point.stackTotal;
                }
            },
    
            plotOptions: {
                column: {
                    stacking: 'normal'
                }
            },
    
            series: [ {
                name: 'Total products',
                data: [<?php echo $total_products; ?>],
                stack: 'male'
            }]
        });
    });

    </script>



</div>


<table cellspacing="1" cellpadding="10" align="center" width="100%" <?php echo $table_css; ?>>
<?php if($total_transactions > 0){ ?>
	<!--** transactions Listings Starts Here ** -->
        <tr class="rowhead">
                <th align="left" width="3%"><?php echo __('sno_label'); ?></th>
               
                <th align="center" width="15%"><?php echo __('username_label'); ?></th>
                <th align="left" width="25%"><?php echo __('description_label'); ?></th>
                <th align="left" width="15%"><?php echo __('credit_label',array(':param'=>$site_settings[0]['site_paypal_currency'])); ?></th>
                <th align="center" width="15%"><?php echo __('debit_label',array(':param'=>$site_settings[0]['site_paypal_currency'])); ?></th>
                <th align="left" width="7%"><?php echo __('transactions_type'); ?></th>
                 <th align="center" width="10%"><?php echo __('transactions_created_date'); ?></th>
        </tr>    
        <?php 
         
         $sno=$offset; /* For Serial No */
         
         foreach($all_transaction_list as $all_transaction_list){
         
         $sno++;
         
         $trcolor=($sno%2==0) ? 'oddtr' : 'eventr'; ?>
         <tr class="<?php echo $trcolor; ?>">
       
                <td align="left">
                <?php echo $sno; ?>
                </td>
                          
                <td align="left">
                <span style="color:#0B61B1">
                <?php echo ucfirst($all_transaction_list['username']);?></span>
                </td> 
                <td align="left">
                <b class="fl"><?php if($all_transaction_list['username']!=""){echo __('username_label').":"."&nbsp"." ";}else{echo "";}?></b>

                <span style="color:#0B61B1">	
                <?php echo ucfirst($all_transaction_list['username']);?>
                </span>	
                <b class="fl clr mt5"><?php
		if(isset($all_transaction_list['order_no'])){
		if($all_transaction_list['order_no']){ echo __('product_order',array(':param'=> $product_settings[0]['alternate_name'])).":".""."".$all_transaction_list['order_no']."<br/>";}else{echo "";}}?>
                </b> 
                <table style="clear:both;float:left;width:100%;">
                </table>
                </td>                               
                <td align="center">
                <?php if($all_transaction_list['amount_type'] == CREDIT){echo $site_currency." ".Commonfunction::numberformat($all_transaction_list['amount']+$all_transaction_list['shippingamount']);}else{echo "_ _";} ?>
                </td>                               
                <td align="center">
                <?php if($all_transaction_list['amount_type'] == DEBIT){echo $site_currency." ".Commonfunction::numberformat($all_transaction_list['amount']+$all_transaction_list['shippingamount']);}else{ echo "_ _";} ?>
                </td> 
                <td align="center">
               <?php echo $all_transaction_list['transaction_type'];?>	
                </td> 
                 <td align="center">
                <?php echo $all_transaction_list['transaction_date']; ?>
                </td>      
                </tr>
		<?php } 
		 }
	// ** transaction Listings Ends Here ** //
		 else { 
	// ** transaction is Found Means ** //
		?>
       	<tr>
        	<td class="nodata"><?php echo __('no_data'); ?></td>
        </tr>
        <?php } ?>
        
</table>
</form>
	</div>
	<div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>	
<div class="clr">&nbsp;</div>
<div class="pagination">
	<?php if(($action != 'transaction_search') && $total_transactions > 0): ?>
	 <p><?php echo $pag_data->render(); ?></p> 
	<?php endif; ?>
</div>
<div class="clr">&nbsp;</div>

</div>

<script type="text/javascript">
$(function() {
		var dates = $( "#fromdate, #todate" ).datepicker({
			defaultDate: "+1w",
			changeMonth: false,
			dateFormat: 'yy-mm-dd',
			numberOfMonths: 1,
			onSelect: function( selectedDate ) {
				var option = this.id == "fromdate" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" ),
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
		});
	});
$(document).ready(function(){
      toggle(7);
});
</script>

