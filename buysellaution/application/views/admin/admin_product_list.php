<?php defined('SYSPATH') OR die("No direct access allowed.");
//For search category
//===================
$category_val = isset($srch["category_search"]) ? $srch["category_search"] :'';
//For search username
//===================
$username_list = isset($srch["username_search"]) ? $srch["username_search"] :'';
//For sort All products
//=================
$sort_val = isset($srch["sort_by"]) ? $srch["sort_by"] :''; 
$auctiontype = isset($srch["sort_auction"]) ? $srch["sort_auction"] :'';
//For CSS class deefine in the table if the data's available
$total_products=count($all_product_list);
$table_css=$export_excel_button="";
$table_css="";
if($total_products > 0)
{  $table_css='class="table_border"';  }?>

<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
    <div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
    <div class="content_middle">
        <form method="post" class="admin_form" name="frmproduct" id="frmproduct" action="index">
            <table class="list_table1 fl clr" border="0" width="100%" cellpadding="5" cellspacing="0">
                <tr>
                    <td valign="top"><label style="padding-top:5px;display:block;"><?php echo __('keyword_label'); ?></label></td>
                    <td>
                    	<input type="text" name="keyword_search"  id="keyword_search" maxlength="256" value="<?php echo isset($srch['keyword_search']) ? trim($srch['keyword_search']) :''; ?>" />
                    	 <span class="search_info_label"><?php echo __('srch_info_product_keyword');?></span>
                    </td>
					<td><label><?php echo __('user_label'); ?></label></td>
                    <td>
                        <select name="username_search" id="username_search">
							<option value=""><?php echo __('select_label'); ?></option>
				          		  <?php 
							 	//code to display username drop down					
								foreach($all_username as $userlist) { 
								$selected_username="";  	
								$selected_username=($userlist['userid']==trim($username_list)) ? " selected='selected' " : "";
								array_filter($userlist); 
							 ?>
                                <option value="<?php echo $userlist['userid']; ?>"  <?php echo $selected_username; ?>><?php echo ucfirst($userlist['username']);?></option>							
			                                  <?php }?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label><?php echo __('category');?></label></td>
                    <td>
                        <select name="category_search" id="category_search">
                            <option value=""><?php echo __('select_label'); ?></option>
						  <?php
							 //code to display product categories drop down
                     		foreach($all_category as $category){
								$selected_product_category="";	
								$selected_product_category=($category['id']==$category_val) ? " selected='selected' " : ""; 
						  ?>          
                             <option value="<?php echo $category['id']; ?>"  <?php echo $selected_product_category; ?>>
							<?php echo ucfirst($category['category_name']);?></option>
					    <?php }?> 
                        </select>
                    </td>
                     <td><label><?php echo __('sort_label');?>
                   <?php echo $product_settings[0]['alternate_name'];?></label></td>
                    <td>
                        <select name="sort_by" id="sort_by">
                            <option value=""><?php echo __('select_label'); ?></option>
                                                                <?php 
                                                                //Code to display sort all products  
                                                                $selected_product_sort_by="";
                                                                foreach($sort_product_by  as $_sort_product_key => $sort_product) 
                                                                {   	
                                                        $selected_product_sort_by=($_sort_product_key==$sort_val) ? " selected='selected' " : ""; ?>
                                                                <option value="<?php echo $_sort_product_key; ?>"  <?php echo $selected_product_sort_by; ?>>
                                                                <?php echo $sort_product;?>
            		   </option>				
								<?php }?>
                        </select>                        
                    </td>             
                 </tr>
		<tr>
			<td><label><?php echo __('auction_type_label');?></td>
			<td>
			<select name="sort_auction" id="sort_by">
				<option value=""><?php echo __('select_label');?></option>
					<?php $selected_product_sort_by_aution_type="";
					 foreach($auction_types as $value=>$key){
					$selected_product_sort_by_auction_type=($value==$auctiontype) ? " selected='selected' " : ""; ?>
					
				<option value="<?php echo $value;?>" <?php echo $selected_product_sort_by_auction_type; ?>><?php echo ucfirst($key);?></option>
					<?php }	?>
			</select>
			</td>

		</tr>
                 <tr>
		                <td colspan="4" style="padding-left:300px;">
		                   		<input type="submit" value="<?php echo __('button_search'); ?>" name="search_product" title="<?php echo __('button_search'); ?>"/>
                           		<input type="button" value="<?php echo __('button_cancel'); ?>" onclick="location.href='<?php echo URL_BASE;?>manageproduct/'" title="<?php echo __('button_cancel'); ?>"/>
                        </td>                    
                 </tr>
            </table>
<div class="clr">&nbsp;</div>
<!-- Code Starts Here- Block For Displaying all product Count -->
        <div class="job_listing_counts" >
        <!--Active product Count-->
        <span>
                <?php echo __('active_product_count');?>
                </span>
        <span class="c" title=""><?php echo $all_active_product_list_count;?></span>		
        <!--In active product Count-->
        <span>
                <?php echo __('inreview_product_count');?>
                </span>
        <span class="c" title=""><?php echo $all_inactive_product_list_count;?></span>	
          <!--In sold product Count-->
        <span>
                <?php echo __('sold_product_count');?>
        </span>
        <span class="c" title=""><?php echo $all_sold_product_list_count;?></span>
        <!--In unsold product Count-->
        <span>
                <?php echo __('unsold_product_count');?>
        </span>
        <span class="c" title=""><?php echo $all_unsold_product_list_count;?></span>
         <!-- In delete product Count-->
         <span>
                <?php echo __('delete_lable');?>
        </span>
        <span class="c" title=""><?php echo $deleted_product_list;?></span>
        <!--In future product Count-->
        <span>  
        </span>       
                <!--Total product Count-->
                <span>
                <?php echo __('total');?>
                </span>
        <span class="c" title=""><?php echo $count_product_list;?></span>
</div>
<div class="products_graph">
<div id="container_total"></div>
<div id="container_details">


 <div class="invest-cm">
                <p class="clearfix"> <span><?php echo __('total_products_count');?></span> <span class="right_1"> <?php echo  $total_products_details; ?></span> </p>
                <div class="prcess_bar3">
                  <div class="pro_left"></div>
                 
                  <div class="pro_mid" style="width:95%"> </div>
                  <div class="pro_rgt"> </div>
                </div>
                <p class="clearfix"> <span><?php echo __('active_products_count');?></span> <span class="right_1"> <?php echo  $total_active_products; ?></span> </p>
                <div class="prcess_bar1">
                                                      <div class="pro_left"></div>
                  <div class="pro_mid" style="width:95%;"> </div>
                  <div class="pro_rgt"> </div>
                                  </div>
                <p class="clearfix"> <span><a href=""><?php echo __('inactive_products_count');?></a></span> <span class="right_1"> <?php echo  $total_inactive_products; ?></span> </p>
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
                              <td class="mar-bor-r"><?php echo $count_of_allproducts;?></td>
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
    $("#container_days_line").click(function(){
    $(this).hide();
  });
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
<script>
/*$(document).ready(function(){
  $("#select_container_days").mouseenter(function(){
    $("#select_container_days").css("background-color","crimson");
  });
  $("#select_container_days").mouseleave(function(){
    $("#select_container_days a").css("color","white");    
  });
});*/
</script>

<div class="select_container">
	<div id="select_container_days" style="cursor:pointer"><a><?php echo __('select_container_days_div');?></a></div>
	<div id="select_container_months" style="cursor:pointer"><a><?php echo __('select_container_months_div');?></a></div>
	<div id="select_container_years" style="cursor:pointer"><a><?php echo __('select_container_years_div');?></a></div>
</div>
<div id="container_space"></div>
<div class="displaygraph">
<div style="width: 750px; display: hidden;">
	<div id="container_days_line" style="position: relative; min-width: 1600px; height: 400px; text-align: left; line-height: normal; font-family: &#39;Lucida Grande&#39;, &#39;Lucida Sans Unicode&#39;, Verdana, Arial, Helvetica, sans-serif; font-size: 12px; ">
	</div>
</div>
<div style="width: 750px;">
	<div id="container_month_line" style="position: relative;min-width: 1200px; height: 400px; text-align: left; line-height: normal; font-family: &#39;Lucida Grande&#39;, &#39;Lucida Sans Unicode&#39;, Verdana, Arial, Helvetica, sans-serif; font-size: 12px; ">
	</div>
</div>
<div style="width: 750px;">
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
			x: -30 //center
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
                { echo $last_30_days_values[$dates].",";} ?>] ,
                
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
			marginRight: 20,
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
                text: 'Total products Count'
            },
    
            xAxis: {
                categories: ['Products Count']
            },
    
            yAxis: {
                allowDecimals: false,
                min: 0,
                title: {
                    text: 'Number Of Products'
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
                name: 'Active Products',
                data: [<?php echo $total_active_products_details; ?>],
                stack: 'male'
            },{
                name: 'Inacive  Products',
                data: [<?php echo $total_inactive_products_details; ?>],
                stack: 'male'
            }]
        });
    });

    </script>






</div>


<!--Code Ends Here  - Block For Displaying all Product Count-->
<div style="float: right;">
<div style="float:right;">
<span>


<input type="button" class="button" value="<?php echo __('button_add'); ?>" onclick="location.href='<?php echo URL_BASE;?>manageproduct/add'" title="<?php echo __('button_add'); ?>" />

</span>
</div>
</div>
<div class="clr">&nbsp;</div>
<div  <?php if($total_products > 0){ ?>class= "overflow-block"<?php }?>>
<table cellspacing="1" cellpadding="12" border="0" align="center" <?php echo $table_css; ?> >
<?php if($total_products > 0){ ?>
	<!--Product Listings Starts Here-->
		<tr class="rowhead">
		<th align="left" nowrap="nowrap"></th>
		<th align="left" nowrap="nowrap" width="30"><?php echo __('sno_label'); ?></th>
		<th width="120" align="center" nowrap="nowrap" colspan="4" ><?php echo __('action_label'); ?></th>
		<th align="center" nowrap="nowrap"><?php echo __('auction_type_label');?></th>
		<th align="left" nowrap="nowrap"><?php echo __('product_title'); ?></th>
		<th align="center" nowrap="nowrap"><?php echo __('start_date');?>-<?php echo __('maximum_days_complete');?></th>
		<!-- Product Status Details -->
		<th align="left" nowrap="nowrap"><?php echo __('status_label'); ?></th>
        </tr>    
        <?php          
         $sno=$offset; /* For Serial No */         
         foreach($all_product_list as $all_product_list){    
         if(array_key_exists($all_product_list['auction_type'],$auction_types)){
         $sno++;         
         $trcolor=($sno%2==0) ? 'oddtr' : 'eventr'; 
		//code to display product image in products listings
		
		$user_image_path=ADMINIMGPATH.NO_IMAGE;
		$light_box_class=$atag_start=$atag_end="";
		$image_title=__('no_photo');
		//check if file exists or not
		if(((isset($all_product_list)) && $all_product_list['product_image']) && (file_exists(DOCROOT.PRODUCTS_IMGPATH.$all_product_list['product_image'])))
		{ 
		   $user_image_path = URL_BASE.PRODUCTS_IMGPATH_THUMB.$all_product_list['product_image'];
		   $image_title = $all_product_list['product_name'];
		   $light_box_class="class='lightbox'";
		   $link = ''.URL_BASE.'auctions/product_name/';
		   $atag_start='<a href='.$link.$all_product_list['product_url'].' title='.$image_title.'>'; 
		   $atag_end='</a>';										   
		}	
		
			 $class2 =  ($all_product_list['product_status']== ACTIVE) ? " "."active" : " "."inactive"; 

		?>
<tr class="<?php echo $trcolor; ?>">
        <td align="center">
                <input type="checkbox" name="job_chk[]" id="job_chk<?php echo $all_product_list['product_id'];?>" value="<?php echo $all_product_list['product_id'];?>" class="<?php echo $class2;?>"  />
                </td>
                        <td align="center">
                        <?php echo $sno; ?>
                        </td>
                                <td width="20"> 
                                <?php 
                                $editurl =URL_BASE.'manageproduct/edit/'.$all_product_list['product_id'];
                                if(count($auction_types)>0 && array_key_exists($all_product_list['auction_type'],$auction_types))
                                {
									$editurl = URL_BASE.'admin/'.$auction_types[$all_product_list['auction_type']].'/edit?pid='.$all_product_list['product_id'];
								}?>
                                <?php echo '<a href="'.$editurl.' " title ="Auction Edit" class="auction-editicon"></a>' ; ?>                </td>
<td width="20"> 
                                <?php 
                                $editurl =URL_BASE.'manageproduct/edit/'.$all_product_list['product_id'];
                                if(count($auction_types)>0)
                                {
									$editurl = URL_BASE.'manageproduct/edit/'.$all_product_list['product_id'];
								}?>
                                <?php echo '<a href="'.$editurl.' " title ="Product Edit" class="editicon"></a>' ; ?>                </td>
                                <td width="20">
                                <?php 
                                if($all_product_list['product_status'] == 'D')
                                {
                                 echo "--";
                                }
                                else if($all_product_list['product_process'] == 'L')
                                {  
                       
                              echo '<a  onclick="frmdel_products('.$all_product_list['product_id'].',1);" class="deleteicon" title="Delete"></a>';
                                
                                }else
                                {
                                echo '<a  onclick="frmdel_products('.$all_product_list['product_id'].',2);" class="deleteicon" title="Delete"></a>';
                                }
                                
                                 ?> 
                                 
                                   </td>
                                
                                <td width="20" >
                                <?php 

                                $class = 'blockicon';$title =__('Resumes'); $suspend_status = 0;
                                if($all_product_list['auction_process']== RESUMES){$class = 'unsuspendicon'; $title =__('Hold');  $suspend_status = 1; }
                                echo "<a  onclick='frm_auction(".$all_product_list['product_id'].','.$suspend_status.")' class='$class' title='$title'></a>"; ?>  
                                </td>
        <td align="center" width="20" >
        <span style="width:80px;" class="fl clr"> <?php echo ucfirst($auction_types[$all_product_list['auction_type']]);  ?></span>
        </td>
        <td align="center">

        <span class=""></span>
        <img src="<?php echo $user_image_path; ?>"  title="<?php echo $image_title;?>" class="fl ml20" width="<?php echo USER_SMALL_IMAGE_WIDTH;?>" height="<?php echo USER_SMALL_IMAGE_HEIGHT;?>"><br style="clear:both;" /><?php echo ucfirst($all_product_list['product_name']);?>
        <span class="thumb_video_list fl"></span>
        <span class="fl clr" style="width:123px;">
        
         </span>
                 <?php echo $atag_end;?>
        </td>
	<td align="center"><?php echo $all_product_list['startdate']." - ".$all_product_list['enddate'];?>
	</td>
        <td align="center">
        <?php if($all_product_list['product_status'] == 'D')
			{
			    echo "Delete";
			}
			else
			{
			 echo ($all_product_list['product_status'] == 'A')?__('active_label'):__('inactive_label'); 
			 }?>
			 </td>
        
        
        </tr>
        <?php } 
	}//Array_key_exists end
        }
                //Product Listings Ends Here 
                else { 
                // No Product is Found Means 
        ?>
                <tr>
                     <td class="nodata"><?php echo __('no_data'); ?></td>
                </tr>
        <?php } ?>

</table>
</div>
</form>
</div>
<div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
</div>

<div class="clr">&nbsp;</div>
<!--Select All & More Actions Div-->
 <?php if($total_products > 0){ ?>
<div>
    <div class="select_all">
        <b><a rel="group_1" href="#select_all">
        <?php echo __('all_label');?></a></b><span class="pr2 pl2"> | </span><b><a rel="group_1" href="#select_none">
        <?php echo __('select_none');?></a> | <b>
        
         <a rel="group_1" href="#select_active" class="select-active"> <?php echo __('active_label');?></a> | <b>
         <a rel="group_1" href="#select_inactive" class="select-inactive"> <?php echo __('inactive_label');?></a><b>
        <span style="padding-left:10px;">
            <select name="more_action" id="more_action">
                <option value=""><?php echo __('more_label'); ?></option>
                <option value="active"><?php echo __('active_label');?></option>
                <option value="inactive"><?php echo __('inactive_label');?></option>
            </select>
         </span>
	</div>
</div>
<?php }?>
<!--Select All & More Actions Div -->
<div class="pagination">
	<?php if(($action != 'search') && $total_products > 0): ?>
	 <p><?php echo $pag_data->render(); ?></p>  
	<?php endif; ?>
</div>
<div class="clr">&nbsp;</div>

</div>

<script type="text/javascript" language="javascript">

//For Delete the product images
//========================
function frmdel_photo(productid)
{
    var answer = confirm("<?php echo __('delete_alert_job_image');?>")
    if (answer){
        window.location="/manageusers/delete_userphoto/"+userid;
    }

    return false;  
} 

	function selectToggle(toggle, form) {
		var myForm = document.forms[form];
		for( var i=0; i < myForm.length; i++ ) { 
		    if(toggle) {
		        myForm.elements[i].checked = "checked";
		    } 
		    else
		    { myForm.elements[i].checked = ""; }
		}
	}
	//For Delete the single products
	//===========================
	function frmdel_products(productid,live)
	{
	
	if(live=='2'){
	  var answer = confirm("<?php echo __('delete_alert_adminjob');?>")
		if (answer){
		    window.location="<?php echo URL_BASE;?>manageproduct/delete/"+productid;
		}
		}else{
		alert("<?php echo __('delete_alert_admin_live');?>");		
		}
		return false;  
	} 

	//for More action Drop Down
	
	$('#more_action').change(function() {

		//select drop down option value
		
		var selected_val= $('#more_action').val();
	
		//perform more action like delete,suspend,active,inactive,feature,unfeature,unsuspend
		
		switch (selected_val){
				//	Current Action "DELETE"
				//=========================
				case "del":
				var confirm_msg =  "<?php echo __('delete_alert_adminjob');?>";
				break;
				
				//	Current Action "ACTIVE"	
			
				case "active":
				var confirm_msg =  "<?php echo __('active_alert_adminjob');?>";
				break;
				
				break;
				//	Current Action "INACTIVE"
			
				case "inactive":
				var confirm_msg =  "<?php echo __('inactive_alert_adminjob');?>";
				break;					
			}			
			//Find checkbox whether selected or not and do more action			
			if($('input[type="checkbox"]').is(':checked'))
			{
		   		 var ans = confirm(confirm_msg)
		   		 if(ans){
					 document.frmproduct.action="<?php echo URL_BASE;?>manageproduct/more_product_action/"+selected_val;
					 document.frmproduct.submit();
				 }else{
				 	$('#more_action').val('');
				 }
			}
			else{
			//alert for no record select
			
				alert("<?php echo __('alert_adminjob_select');?>")	
				$('#more_action').val('');
			}			
			return false;  
	});
	$(document).ready(function(){
		//select option empty means remove		
		$('select option:empty').remove();
		//For auto complete
		//=================
		$('#user_search').focus(function() { 
		}
	);  
});
//function for product resumes/hold status
	function frm_auction(productid,sus_status)
	{
		switch (sus_status)
		{
			//if resumes means 			
			case 0:
			var answer = confirm("<?php echo __('resumes_alert_auction');?>")	
			break;
			//if hold means 		
			case 1:
			var answer = confirm("<?php echo __('hold_alert_auction');?>")
			break;					
		}
			if (answer){
				//redirect to manageusers controller for update status of flag
				
	window.location="<?php echo URL_BASE;?>manageproduct/resumes/"+"?id="+productid+"&&susstatus="+sus_status;
			}
	}

$(document).ready(function(){
      toggle(3);
});
</script>
<style>
.HighlightableRow:hover
{
  background-color: lightgray;
  text-decoration:none;
}

</style>
