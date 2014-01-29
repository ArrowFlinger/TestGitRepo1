<?php defined('SYSPATH') OR die('No direct access allowed.');		
echo html::script('public/ckeditor/ckeditor.js');
$total_count=count($all_transaction_list);

foreach($all_transaction_list as $orders):
 $currentprice=$orders['total'];	
?>

<style>
    table{ margin-bottom: 20px;}
    thead td{ border:1px solid #ccc; background: #ccc; font-weight: bold; padding: 8px;}
    tbody td{ border:1px solid #ccc; padding: 8px;}
    .tabs ul{ float:left; list-style: none;}
    .tabs ul li{ float: left; margin:0 5px;}
    .tabs ul li a{ display: block; padding:5px 10px; background: #fff; border:1px solid #ccc; border-bottom:none;}
    .tabscontent { border-top:1px solid #ccc;}
    .tabscontent ul li{ clear: left;padding:8px; border-bottom: 1px dashed #ccc;}
    .tabscontent ul li span.title{padding:0 10px; font-weight: bold;}
    .tabscontent ul li span{padding:0 10px; display: block; float: left; width:200px;}
    .admin_form td,.admin_form table{border: none;}
</style>
<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
    <div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
    <div class="content_middle">
<h2><?php echo __('Order History Details');?> 
</h2>
		    <div class="tabs">
			<ul>
			    <li><a href="javascript:;" rel="tabs1" class="tablink" title="<?php echo __('order_details'); ?>"><?php echo __('order_details'); ?></a></li>
			    <li><a href="javascript:;" rel="tabs2" class="tablink" title="<?php echo __('payment_details');?>"><?php echo __('payment_details');?></a></li>
			    <li><a href="javascript:;" rel="tabs3" class="tablink" title="<?php echo __('products_label'); ?>"><?php echo __('products_label'); ?></a></li>
			    <li><a href="javascript:;" rel="tabs4" class="tablink" title="<?php echo __('order_history'); ?>"><?php echo __('order_history'); ?></a></li>
			</ul>
		    </div>
		    
		    <!--Tab1-->
		    <div id="tabs1" class="tabscontent" style="clear: both;">
			
			<ul>
			    <li><span class="title"><?php echo __('order_id_label');?>: </span> <span>#<?php echo $orders['order_id'];?></span></li>  
			    <li><span class="title"><?php echo __('customer_name');?>: </span> <span><?php echo $orders['username'];?></span></li>
			    <li><span class="title"><?php echo __('email');?>: </span> <span><?php echo $orders['email'];?></span></li>
			    <li><span class="title"><?php echo __('order_status');?>: </span> <span>
			    <?php $status=$orders['order_status'];
		    
					    switch($status)
					    {
						case 'P':
						    
						    echo __('pending_status');
						    break;
						case 'C':
						    echo __('completed_status');
						    break;
						default:
						     echo __('success_status');
						
					    }
					    
		    
			    ?>
		    </span></li>
				<li><span class="title"><?php echo __('product_cost');?>: </span> <span><?php echo $site_currency." ".Commonfunction::numberformat(($currentprice*$orders['quantity']));?></span></li>
				
				<li><span class="title"><?php echo __('shipping_fee');?>: </span> <span><?php echo $site_currency." ".$orders['shipping_fee'];?></span></li>
				
			    <li><span class="title"><?php echo __('total_amount');?>: </span> <span><?php echo $site_currency." ".Commonfunction::numberformat(($currentprice*$orders['quantity'])+$orders['shipping_fee']);?></span></li>
			    
			    <li><span class="title"><?php echo __('auction_type_label'); ?>: </span> <span><?php echo $orders['bidmethod'];?></span></li>
			    <li><span class="title"><?php echo __('date_lable');?>: </span> <span><?php echo Commonfunction::getdateFormat($orders['order_date']);?></span></li>
			</ul>
			
		    </div>
		    
		    <!--Tab2-->
		    <div id="tabs2" class="tabscontent" style="clear: both;display: none;">
			<ul id="transactionlog">
			    <li style="text-align:center; "><img src="<?php echo IMGPATH.'ajax-loader.gif';?>"/></li>
			</ul>
			
		    </div>
		    
		    <!--Tab3-->
		    <div id="tabs3" class="tabscontent" style="clear: both;display: none;">
                <table border="0"  width="99%" >
		    <thead>
			<tr><td><?php echo __('order_details');?></td></tr>
		    </thead>
		    <tbody>
			<tr>
			    <td style="line-height:20px;"> <div><b><?php echo __('order_id_label'); ?>:</b> #<?php echo $orders['order_id'];?></div>
			    <div><?php echo "<b>". __('ordered_date').":</b> ".Commonfunction::getdateFormat($orders['order_date']);?></div></td>
			    
			</tr>
		       </tbody>                                        

                </table>
		
		<table border="0"  width="99%" >
		    <thead>
			<tr><td><?php echo __('Billing_Address'); ?></td>
			<td><?php echo __('shipping_address'); ?></td>
			</tr>
		    </thead>
		    <tbody>
			<tr>
			    <td style="line-height:20px;"> <?php
			     
			    if(!empty($billing)){
						$billinginfo ="";
						$billinginfo .= "<div>";
						$billinginfo .= $billing['name']."<br>";
						$billinginfo .= $billing['address']."<br>";
						$billinginfo .= $billing['town']."<br>";
						$billinginfo .= $billing['city']." - ";
						$billinginfo .= $billing['zipcode']."<br>";
						$billinginfo .= "Ph No: ".$billing['phoneno']."<br>";
						$billinginfo .= "</div>";
						echo $billinginfo;
				
			     } else{
					 echo __('no_billing_information');
					 } ?>
			    </td>
			    <td style="line-height:20px;"><?php if(!empty($shipping)){
						$shippinginfo="";
						$shippinginfo .= "<div>";
						$shippinginfo .= $shipping['name']."<br>";
						$shippinginfo .= $shipping['address']."<br>";
						$shippinginfo .= $shipping['town']."<br>";
						$shippinginfo .= $shipping['city']." - ";
						$shippinginfo .= $shipping['zipcode']."<br>";
						$shippinginfo .= "Ph No: ".$shipping['phoneno']."<br>";
						$shippinginfo .= "</div>";
						echo $shippinginfo;
			    } else{
					echo __('no_shipping_information');
			    } ?></td>
			</tr>
		       </tbody>                                        

                </table>
		
		<table border="0"  width="99%" >
		    <thead>
			<tr><td><?php echo __('product_title'); ?></td>
			<td><?php echo __('quantity_label');?></td>
			<td><?php echo __('price_label');?></td>
			<td><?php echo __('sub_total_label');?></td>
			<td><?php echo __('seller_name');?></td>
			<td><?php echo __('order_status'); ?></td>
			</tr>
		    </thead>
		    <tbody>
			<?php
			$discount_amount=$subtotal=$shipping_amount=$taxamount=0;
			   foreach($all_transaction_list as $all_transaction_list):
			    $subtotal +=  $currentprice*$all_transaction_list['quantity'];
			    $shipping_amount += $all_transaction_list['shipping_fee'];
			   
			  
			?>
			<tr>
			    <td style="line-height:20px;"> <?php echo $all_transaction_list['product_name'];?> </td>
			    <td style="line-height:20px;"> <?php echo $all_transaction_list['quantity'];?> </td>
			    <td style="line-height:20px;"> <?php echo $site_currency." ".Commonfunction::numberformat($currentprice);?> </td>
			    <td style="line-height:20px;"> <?php echo $site_currency." ".Commonfunction::numberformat(($currentprice)*$all_transaction_list['quantity']);?> </td>
			  <td style="line-height:20px;"> 
			   <?php echo "Admin";
			   
			  ?></td>
			    <td style="line-height:20px;">
				<?php		
					$color = (($orders['order_status']!="C")||($all_transaction_list['shipping_status']=="P"))?"red":"green";
					 ?>
				 
				 
				<span style="color:<?php echo $color;?>"><?php echo ($orders['order_status']=='P')?__('pending_status'):(($orders['order_status']=='C')?__('completed_status'):__('success_status'));?></span></td>
				
			   
			    
			</tr>
			<?php endforeach; ?>
			
			<tr>
			    <td colspan="4"  style="line-height:20px;">
				
			    </td>
			    <td ><?php echo __('sub_total_label');?>: </td>
			     <td ><?php echo $site_currency." ".Commonfunction::numberformat($subtotal);?> </td>
			</tr>
			<tr>
			    <td colspan="4"></td>
			    <td ><?php echo __('shipping_rate'); ?>: </td>
			     <td ><?php echo $site_currency." ".Commonfunction::numberformat($shipping_amount);?> </td>
			</tr>
			<tr>
			    <td colspan="4"></td>
			    <td ><?php echo __('tax_label'); ?>: </td>
			    <td ><?php
			    echo $site_currency." ".Commonfunction::numberformat($taxamount);?> </td>
			</tr>
			<tr>
			    <td colspan="4"></td>
			    <td ><?php echo __('discount_label');?>: </td>
			    <td ><?php
			    echo $site_currency." ".Commonfunction::numberformat(abs($discount_amount));?> </td>
			</tr>
			<tr>
			    <td colspan="4"></td>
			    <td ><?php echo __('total'); ?>: </td>
			     <td ><?php
			     
			    $total = ($subtotal)+$shipping_amount+$taxamount+$discount_amount;
			     echo $site_currency." ".Commonfunction::numberformat($total);?> </td>
			</tr>
			
		       </tbody>                                        

                </table>
		    </div>
		    
		    
		   <!--Tab3-->
		  
		    <div id="tabs4" class="tabscontent" style="clear: both;display: none;">
			<div style="width:500px; margin: 20px auto;"><?php echo __('change_this_shipping_delivered');?>
			<select name="order_status" onchange="window.location='<?php echo URL_BASE;?>transaction/orderhistory/<?php echo $orders['order_id'];?>?orderstatus='+this.value">			    
			    <option value="P" <?php echo $orders['order_status']=="P" ?"selected=selected":"";?>><?php echo __('pending_status'); ?></option>
			    <option value="S" <?php echo $orders['order_status']=="S" ?"selected=selected":"";?>><?php echo __('success_status');?></option>
			    <option value="C" <?php echo $orders['order_status']=="C" ?"selected=selected":"";?>><?php echo __('completed_status'); ?></option>
			</select>
			
			
			
			</div>
			<?php if($orders['order_status']=="C") {?>
			    <!--Sent mail -->
			<div id="sendmailform">
			    <form method="post"  class="admin_form" name="winners_reply_form" action ="">
				<table border="0" cellpadding="5" cellspacing="0" width="100%">
				     <input type="hidden" name="username"  maxlength="128" value="<?php echo $orders['username'];?>"/>
				       <tr>
					       <td valign="top"><label><?php echo __('mail_receiver'); ?></label></td>
					       <td><input type="text"  style= "border-color: #FFFFFF;" name="email" id="email" readonly="readonly" value="<?php echo $orders['email'];?>"/>
						</td>
				       </tr>
				       <tr>
						<td valign="top"><label><?php echo __('mail_subject'); ?></label><span class="star">*</span></td>
					       <td><input type="text" name="subject" id="subject" maxlength="128" value=""/>
						    <span class="error">
						       <?php echo isset($errors['subject'])?ucfirst($errors['subject']):""; ?>
						    </span>
					       </td>
				       </tr>
				       <tr>
					       <td width="15%" valign="top"><label><?php echo __('mail_content'); ?></label><span class="star">*</span></td>
					       <td>
					       
					       <textarea class="ckeditor" name="message" id="email_content"  ></textarea>
						   <span class="error">
						       <?php echo isset($errors['message'])?ucfirst($errors['message']):""; ?>
						   </span>
						  
					       </td>
				       </tr>
					
					<tr>
					       <td colspan="2" class="star">*<?php echo __('required_label'); ?></td>
				       </tr>  
				       <tr>
	       
					   <td colspan="3" style="padding-left:150px;">
					     <br />
					      
					    <input type="submit" value="<?php echo __('button_send');?>" name="sendmail" title="<?php echo __('button_send');?>" /> 
					     <div class="clr">&nbsp;</div>
					   </td>
	       
				       </tr>
			       </table>
		       </form>
			</div>
			<?php } ?>
			
		    </div> 
		    
		    
		    
		<div>
		<a href="<?php echo URL_BASE;?>transaction/orderhistory" style="padding: 5px;float: right;margin-right: 10px;background: #254A70;border: 1px solid #DDD;font: bold 12px arial;color: white; text-decoration: none;"><?php echo __('back_button'); ?></a>
		</div>

    </div>
    <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
</div>
</div>
<input type="hidden" id="transactionurl" value="<?php echo URL_BASE.$orders['controller_name'].'/transactionlogs'; ?>"/>
<input type="hidden" id="res_order" value="<?php echo $orders['res_order'];?>"/>

<script>

$(document).ready(function(){
    var transactionurl=$("#transactionurl").val();
    var invoice_no=$("#res_order").val();    
             
		$.ajax({
				url:transactionurl,
				type:'get',
				data:"invoicenumber="+invoice_no,
				cache:false,
				contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
				complete:function(data){		
					$("#transactionlog").html(data.responseText);
				}
			});
    
});
$(document).ready(function(){
    
      toggle(7);
    
    if(location.hash=="#orderhistory")
    {
	$("#tabs4").show();
	$(".tabscontent").not("#tabs4").hide();
    }
    $(".tablink").click(function(){
			   var tabs= $(this).attr("rel");
			   $("#"+tabs).show();
			   $(".tabscontent").not("#"+tabs).hide();
    });
    tinyMCE.init({
		mode : "exact",
		elements : "email_content",
		theme : "advanced",
		theme_advanced_resizing : true,
		 plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
		 theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|formatselect,fontselect,fontsizeselect",
       theme_advanced_buttons2 : "bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,anchor,code,|,forecolor,backcolor"

	});
      toggle(7);
      
});</script>

<?php endforeach;?>
