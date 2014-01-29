<?php defined('SYSPATH') OR die("No direct access allowed."); 


        $sitesettings ="<span class='WebRupee'>".$site_settings[0]['site_paypal_currency']."</span>";
        $srch_from_date = isset($srch['startdate'])?$srch['startdate']:"";
        $srch_to_date = isset($srch['enddate'])?$srch['enddate']:"";
        //for checking whether username options selected or not when form post
        
         $auto_auction_checked="";
         if((isset($product_data['autobid']) && $product_data['autobid']=="E") /*|| $action=="add"*/)
         { $auto_auction_checked="checked='checked'"; }
      
        /* featured Box Checked */
//print_r($product_data);exit;
?>
<link rel="stylesheet" type="text/css" href="<?php echo ADMINCSSPATH.'ui.datepicker.css';?>" title="alt" />
<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
    <div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
    <div class="content_middle">
        <form method="post" enctype="multipart/form-data" class="admin_form" name="add-product" id="add-product">
                <table border="0" cellpadding="5" cellspacing="0">
                      
                          <!-- **ends here** -->
                  <!-- Code to select user name in drop down- -->
                        
                        <tr>
                                <td valign="top" ><label><?php echo __('product_start_date'); ?></label>
                                        <span class="star">*</span>
                                        </td>
                                        <td>
                                        <div class="width400">
                                        <input type="text" name="startdate" id="startdate"   value="<?php echo isset($validator['startdate']) &&!array_key_exists('startdate',$errors)? $validator['startdate']:$product_data['startdate']; ?>" readonly=" readonly" class="DatePicker" onChange="serveralert()"/>
                                        </div>
                                        <span class="error">
                                        <?php echo isset($errors['startdate'])?ucfirst($errors['startdate']):""; ?>
                                        </span>                                 	                                
                                </td>      
                        </tr>
                        <tr>
                                <td valign="top" ><label><?php echo __('product_end_date'); ?></label>
                                        <span class="star">*</span>
                                        </td>
                                        <td>
                                        <div class="width400">
                                        <input type="text" name="enddate" id="enddate"  value="<?php echo isset($validator['enddate']) &&!array_key_exists('enddate',$errors)? $validator['enddate']:$product_data['enddate']; ?>" readonly=" readonly" class="DatePicker" />
                                        </div>
                                        <span class="error">
                                        <?php echo isset($errors['enddate'])?ucfirst($errors['enddate']):""; ?>
                                        </span>                                 	                                   
                                </td>      
                        </tr>
                         <tr>
                                <td valign="top" ><label><?php echo __('product_cost'); ?></label>
                                        <span class="star">*</span>
                                        </td>
                                        <td>
                                        <div class="width400">
                                        <input type="text" name="product_cost" id="product_cost"  maxlength ="12" value="<?php echo isset($product_data['product_cost']) &&!array_key_exists('product_cost',$errors)? $product_data['product_cost']:$validator['product_cost']; ?>" class="required chkamts text" /><?php echo $sitesettings ;?>
                                        </div>
                                        <span class="error">
                                        <?php echo isset($errors['product_cost'])?ucfirst($errors['product_cost']):""; ?>
                                        </span>                                 	   
                                <span class="info_label"><?php echo __('select_productcost_label');?></span>
                                </td>      
                        </tr>
                         <tr>
                                <td valign="top" ><label><?php echo __('product_current_price'); ?></label>
                                        <span class="star">*</span>
                                        </td>
                                        <td>
                                        <div class="width400">
                                        <?php if($product_data['lastbidder_userid']==0){ ?>
                                        <input type="text" name="current_price" id="current_price"  maxlength ="12" value="<?php echo isset($product_data['current_price']) &&!array_key_exists('current_price',$errors)? $product_data['current_price']:$validator['current_price']; ?>" class="required chkvals text" title="<?php echo __('Enter the current price and must be less product cost'); ?>" /><?php echo $sitesettings ; ?>
                                        <?php
                                        }else{?>
                                        <input type="text" name="current_price" id="current_price"  maxlength ="12" value="<?php echo isset($product_data['current_price']) &&!array_key_exists('current_price',$errors)? $product_data['current_price']:$validator['current_price']; ?>" class="required chkvals text" title="<?php echo __('Enter the current price and must be less product cost'); ?>" readonly/><?php echo $sitesettings ; ?>
                                        <?php }?>
                                        </div>
                                        <span class="error">
                                        <?php echo isset($errors['current_price'])?ucfirst($errors['current_price']):""; ?>
                                        </span>                                 	   
                                  <span class="info_label"><?php echo __('select_current_label');?></span>
                                </td>      
                        </tr>
                         <tr>
                                <td valign="top" ><label><?php echo __('max_count_down'); ?></label>
                                        <span class="star">*</span>
                                        </td>
                                        <td>
                                        <div class="width400">
                                        <input type="text" name="max_countdown" name="max_countdown" id="max_countdown"  maxlength ="6" value="<?php echo isset($product_data['max_countdown']) &&!array_key_exists('max_countdown',$errors)? $product_data['max_countdown']:$validator['max_countdown']; ?>" class="required chkmacd text" /><span style="margin-left:5px"><?php echo __('seconds_label');?></span>
                                        </div>
                                        <span class="error">
                                        <?php echo isset($errors['max_countdown'])?ucfirst($errors['max_countdown']):""; ?>
                                        </span>                                 	   
                                <span class="info_label"><?php echo __('select_maxcount_label');?></span>
                                </td>      
                        </tr>
                        <tr>
                                <td valign="top" ><label><?php echo __('bidding_count_down'); ?></label>
                                        <span class="star">*</span>
                                        </td>
                                        <td>
                                        <div class="width400">
                                        <input type="text" name="bidding_countdown" id="bidding_countdown"  maxlength ="6" value="<?php echo isset($product_data['bidding_countdown']) &&!array_key_exists('bidding_countdown',$errors)? $product_data['bidding_countdown']:$validator['bidding_countdown']; ?>" class="required chkval text" title="<?php echo __('Enter the bidding countdown and must be less max count down'); ?>"/><span style="margin-left:5px"><?php echo __('seconds_label');?></span>

                                        </div>
                                        <span class="error">
                                        <?php echo isset($errors['bidding_countdown'])?ucfirst($errors['bidding_countdown']):""; ?>
                                        </span>                                 	   
                                        <span class="info_label"><?php echo __('select_bidcountdown_label');?></span>
                                </td>      
                        </tr>
                         <tr>
                                <td valign="top" ><label><?php echo __('bidding_amount'); ?></label>
                                        <span class="star">*</span>
                                        </td>
                                        <td>
                                        <div class="width400">
                                        <input type="text" name="bidamount" id="bidamount"  maxlength ="12" value="<?php echo isset($product_data['bidamount']) &&!array_key_exists('bidamount',$errors)? $product_data['bidamount']:$validator['bidamount']; ?>" /><?php echo $sitesettings ; ?>

                                        </div>
                                        <span class="error">
                                        <?php echo isset($errors['bidamount'])?ucfirst($errors['bidamount']):""; ?>
                                        </span>                                 	   
                                         <span class="info_label"><?php echo __('select_bidamount_label');?></span>
                                </td>      
                        </tr>
                        
                        <td colspan="2"><?php echo __('auction_type_label'); ?>: <?php echo __('begginer_auction_label');?></td>
                           
                        <tr>
                        <td colspan="2" class="star">*<?php echo __('required_label'); ?></td>
                        </tr>                                  
                        <tr>
                        <td colspan="3" style="padding-left:110px;"> <br />
                       
                        <input type="reset" value="<?php echo __('button_reset'); ?>" />
                        <input type="submit" value="<?php echo ($action == 'add' )?''.
                        __('start_auction').'':''.__('start_auction').'';?>"  name="<?php echo ($action == 'add' )?'start_auction':'start_auction';?>" />
                        <div class="clr">&nbsp;</div>
                        </td>
                        </tr> 
            </table>
        </form>
    </div>
    <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
</div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
    $("#startdate").datetimepicker( {
        beforeShow: customRangeStart,
        minDate: 0,
        maxDate: 365,
        showButtonPanel: true,        
        buttonImageOnly: true,
	showSecond: true,
	timeFormat: 'hh:mm:ss',
	dateFormat: 'yy-mm-dd',
	stepHour: 1,
	stepMinute: 1,
	stepSecond: 1
	} );

    $("#enddate").datetimepicker( {
        beforeShow: customRange,
        minDate: 0,
        firstDay: 1, 
        changeFirstDay: false,
        showButtonPanel: true,       
        buttonImageOnly: true,        
        showSecond: true,
        timeFormat: 'hh:mm:ss',
        dateFormat: 'yy-mm-dd',
        stepHour: 1,
        stepMinute: 1,
        stepSecond: 1
	} );
  });
  
        function customRange(input) 
        { 
                return {
                minDate: (input.id == "enddate" ? $("#startdate").datepicker("getDate") : null)
                }; 
        }
        function customRangeStart(input) 
        { 
                return {
                minDate:  new Date()
                }; 
        }

//code for checking message field maxlength
function limitlength(obj, maxlength)
{
        //var maxlength=length
        if (obj.value.length>maxlength){
                obj.value=obj.value.substring(0, maxlength);
                // max reach
                document.getElementById("info_label").innerHTML="<?php echo __('entered_max_text');?>"+maxlength;
        }else{
                var charleft = maxlength - obj.value.length;
                //inner html
                document.getElementById("info_label").innerHTML= charleft+"<?php echo __('entered_char_left_text');?>";
        }     
} 

function frmdel_inactive_image(productid)
{
    var answer = confirm("<?php echo __('are_you_sure_inactive_last_bidder_winner');?>")
    if (answer){
        window.location="<?php echo URL_BASE;?>manageproduct/inactive_product/"+productid;
    }
        if($("#inactive").attr("checked")==true)
        {
                $("#inactive").attr('checked',true);
                //alert("Checked");
        }
        else
        {
                $("#inactive").attr('checked',true);
                //alert("Unchecked");
        }
    return false;  
} 

function limitlengths(obj, maxlength)
{
        //var maxlength=length
        if (obj.value.length>maxlength){
                obj.value=obj.value.substring(0, maxlength);
                // max reach
                document.getElementById("product_info_label").innerHTML="<?php echo __('entered_max_text');?>"+maxlength;
        }else{
                var charleft = maxlength - obj.value.length;
                //inner html
                document.getElementById("product_info_label").innerHTML= charleft+"<?php echo __('entered_char_left_text');?>";
        }     
} 
function charactercount(id)
	{		
		var value=$("#"+id).val();		
		 var count=value.split(' ');	
		 $.each(count,function(ak,av){			
			if(av.length > 35)
			{
				alert("Do not enter character more than 35 continuously");
				$("#"+id).val('');
				$("#"+id).focus();
				return false;
			}
			else{ return true;}
		});
	}
$(document).ready(function(){

	//For Field Focus
	//===============
	field_focus('product_name');
});
//For Delete the product image
//=====================
function frmdel_image(productid)
{

    var answer = confirm("<?php echo __('delete_alert_job_image');?>")
    if (answer){
        window.location="<?php echo URL_BASE;?>manageproduct/delete_productimage/"+productid;
    }

    return false;  
} 

//multiple image delete
function frmdel_more_image(product_id,image_id)
{
    var answer = confirm("<?php echo __('delete_alert_more_image');?>")
    if (answer){
        window.location="<?php echo URL_BASE;?>manageproduct/delete_more_productimage/?priductid="+product_id+"&imageid="+image_id;
    }

    return false;  
} 

//multiple image delete
function frmdel_more_total_image(productid)
{

    var answer = confirm("<?php echo __('totle_more_image_delete');?>")
    if (answer){
        window.location="<?php echo URL_BASE;?>manageproduct/delete_more_totle_productimage/"+productid;
    }

    return false;  
} 

//morefile Add
    var upload_number = 1;
    function addFileInput() {
         var d = document.createElement("div");
         var file = document.createElement("input");
         file.setAttribute("type", "file");
         file.setAttribute("name", "product_gallery[]");
         d.appendChild(file);
         document.getElementById("moreUploads").appendChild(d);
         upload_number++;
   
    }
//Default Bid history page load

function deleteimg(id){
var image_name=$("#imagedelete"+id).attr('name');
//alert(image_name);return false;
var url ='  <?php echo URL_BASE.'manageproduct/delete_more_productimage';?>';
var pid=$("#imagedelete").attr('name');
//alert(url);
$.ajax({

        url:url,
        type:'post',
        data:"image_name="+image_name+'&pid='+pid,
        complete:function(data){
        alert(data.responseText);			
        }
});
}

$(document).ready(function(){
      toggle(3);
});

 </script>
