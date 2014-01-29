<?php defined('SYSPATH') OR die("No direct access allowed."); 


        $sitesettings ="<span class='WebRupee'>".$site_settings[0]['site_paypal_currency']."</span>";
        $srch_from_date = isset($srch['startdate'])?$srch['startdate']:"";
        $srch_to_date = isset($srch['enddate'])?$srch['enddate']:"";
        //for checking whether username options selected or not when form post
        $username_list = isset($srch["userid"]) ? $srch["userid"] :'';
        //For category drop down value set
        $category_val = isset($_POST["product_category"]) ? $_POST["product_category"] :'';
        /* Status Box Checked */

         $status_checked="";
         if((isset($product_data['product_status']) && $product_data['product_status']=="A")  )
         { $status_checked="checked='checked'"; }
         
         //product auction featured checked
         $product_featured_checked="";
         if((isset($product_data['product_featured']) && $product_data['product_featured']=="F") || $action=="add")
         { $product_featured_checked="checked='checked'"; }
         
         //product auction hot checked
         $product_hot_checked="";
         if((isset($product_data['product_featured']) && $product_data['product_featured']=="H") || $action=="add")
         { $product_hot_checked="checked='checked'"; }
         
         //product auction none checked
         $product_none_checked="";
         if((isset($product_data['product_featured']) && $product_data['product_featured']=="N") || $action=="add")
         { $product_none_checked="checked='checked'"; }
         
           //Dedicated Auction product checked
         $dedicated_auction_checked="";
         if((isset($product_data['dedicated_auction']) && $product_data['dedicated_auction']=="E") )
         { $dedicated_auction_checked="checked='checked'"; }

	 //Auto Bid Auction
        
         $auto_auction_checked="";
         if((isset($product_data['autobid']) && $product_data['autobid']=="E") )
         { $auto_auction_checked="checked='checked'"; }
		
	//Buy Now
	
	 $buynow_auction_checked="";
         if((isset($product_data['buynow_status']) && $product_data['buynow_status']=="A") )
         { $buynow_auction_checked="checked='checked'"; }
      
        /* featured Box Checked */

?>
<link rel="stylesheet" type="text/css" href="<?php echo ADMINCSSPATH.'ui.datepicker.css';?>" title="alt" />
<style>
.auction_typeslist{float:left; }.auction_typeslist li{ float:left; display:block; width:150px; padding:6px; background:#ccc; margin:4px;}
</style>
<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
    <div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
    <div class="content_middle">
        <form method="post" enctype="multipart/form-data" class="admin_form" name="add-product" id="add-product" action ="<?php echo URL_BASE;?>manageproduct/<?php echo $action;?>">
                <table border="0" cellpadding="5" cellspacing="0">
                        <tr>
                                <td valign="top" ><label><?php echo __('product_title'); ?></label>
                                       <span class="star">*</span>
                                        </td>
                                        <td>
                                        <div class="width400">
                                        <input type="text" name="product_name" onchange="charactercount('product_name')" id="product_name" maxlength="<?php echo $product_settings[0]['max_title_length'];?>"  value="<?php echo isset($product_data['product_name']) &&!array_key_exists('product_name',$errors)? $product_data['product_name']:$validator['product_name']; ?>" onkeyup="return limitlength(this,<?php echo $product_settings[0]['max_title_length'];?>,'info_label')"/>
                                       </div>
                                        <span class="error">
                                        <?php echo isset($errors['product_name'])?ucfirst($errors['product_name']):""; ?>
                                        </span>
                                        <label class="info_label fl ml10" id="info_label" ><?php echo __('info_product_name')?>: <?php echo $product_settings[0]['max_title_length'];?></label>
                                </td>      
                        </tr>
                        <tr>
                                <td valign="top"><label><?php echo __('product_category'); ?></label>
                                        <span class="star">*</span>
                                        </td>                               
                                        <td>
                                        <select name="product_category" id="product_category" >
                                                <option  value="" ><?php echo __('select_category_label');?>
                                                </option> 
                                                <?php		
                                                //code to display product categories drop down
                                                foreach($all_category as $category)
                                                {
                                                if (!isset($product_data)){ 
                                                       $selected_product_category="";	
                                                       $selected_product_category=($category['id']==$category_val) ? " selected='selected' " : ""; 
                                                ?> 
                                                <option value="<?php echo $category['id']; ?>"<?php echo $selected_product_category; ?>>
                                                        <?php echo ucfirst($category['category_name']);?></option>						   		
                                                        <?php  }else{?>
                                                <option  value="<?php echo $category['id']; ?>" <?php echo ($product_data['product_category'] == $category['id'])?"selected='selected'":"";?> ><?php echo ucfirst($category['category_name']);?></option>
                                                <?php  } }?> 						 		   		
                                        </select>						              
                                        <span class="error">
                                                 <?php echo isset($errors['product_category'])? ucfirst($errors['product_category']):""; ?>
                                        </span>
                                        <span class="info_label"><?php echo __('select_category_label');?></span> 
                                </td>
                        </tr> 
                          <!-- **ends here** -->
                          <!-- Code to select user name in drop down- -->
                         <tr style="display:none">
                                <td valign="top"><label><?php echo __('user_label'); ?></label></td>
                                <td>
                                <select name="user_id" id="user_id">
                                                <?php 
                                                //code to display categories drop down

                                                foreach($all_username as $userlist) 
                                                { 
                                                $selected_username="";  	
                                                $selected_username=($userlist['id']==trim($product_data['userid'])) ? " selected='selected' " : ""; 
                                                ?>
                                                <option value="<?php echo $userlist['id']; ?>"  <?php echo $selected_username; ?>>
                                                <?php echo $userlist['username'];?>
                                        </option>
                                <?php }?>
                                </select>
                                </td>
                        </tr>                          
                        <tr>
                                <td valign="top" ><label><?php echo __('product_Tags'); ?></label>
                                        <span class="star">*</span>
                                        </td>
                                        <td>
                                        <div class="width400">
                                        
                                        <input type="text" name="tags" id="tags" maxlength ="100" value="<?php echo isset($product_data['tags']) &&!array_key_exists('tags',$errors)? $product_data['tags']:$validator['tags']; ?>" />
                                        </div>
                                        <span class="error">
                                        <?php echo isset($errors['tags'])?ucfirst($errors['tags']):""; ?>
                                        </span>         
                                       <span class="info_label"><?php echo __('tags_productcost_label');?></span>                 	                                   
                                </td>      
                        </tr>
                       <!-- Code for uploading product Image- -->
		<tr>
        <td valign="top"><label><?php echo __('photo_label'); ?></label><?php if($action=="add"){?><span class="star">*</span><?php }?></td>
        <td>
                                <?php 
                                //code to remove or delete photo link
                                $user_image_path=ADMINIMGPATH.NO_IMAGE;
                                $light_box_class=$delete_link=$atag_start=$atag_end="";
                                $image_title=__('no_photo');

                                //check if file exists or not
                                if(((isset($product_data)) && $product_data['product_image']) && (file_exists(DOCROOT.PRODUCTS_IMGPATH.$product_data['product_image'])))
                                { 
                                        $user_image_path = URL_BASE.PRODUCTS_IMGPATH.$product_data['product_image'];
                                        $image_title=$product_data['product_name'];
                                        $delete_title = __('delete'); 
                                        $light_box_class="class='lightbox'";
                                        $delete_link="<a onclick='frmdel_image(".$product_data['product_id'].");' class='deleteicon' title='$delete_title' id='photo_delete'></a>";
                                        $atag_start='<a href='.$user_image_path.' title='.$image_title.'>'; 
                                        $atag_end='</a>';										   
                                }

                                ?>
                                <?php echo $delete_link; ?>
                                <?php if($action != 'add'):?>
        <span style="margin-right:30px;" id="gallery">
                               <?php echo $atag_start; ?>                                        
        <img src="<?php echo $user_image_path; ?>" title="<?php echo $image_title; ?>" class="fl" width="<?php echo USER_SMALL_IMAGE_WIDTH;?>" height="<?php echo USER_SMALL_IMAGE_HEIGHT;?>" >
        <?php echo $atag_end; ?>
        </span><?php endif;?>

        <div style="width:241px;float:left;">
        <div class="order_button fl clr" style="width:auto;margin:0 0 0 5px;">
       
        <div class="orderr_but_mid fl">
        <input  type="file"  name="product_image" style="height:30px;width:auto; font:bold 12px Arial, Helvetica, sans-serif;color:#333;" /> 
        
        </div>    
        <span class="error">          
       <?php     echo isset($errors['product_image'])?ucfirst($errors['product_image']):""; ?>
        </span> 
       <span style="margin:0 0 0 5px;">
        <p style="width:120px;text-align:left;font-weight:bold;font-size:11px;"><?php echo __('profile_image_content_product');?> </p>
        </span>
        </td>
</tr>
  <!--Multiple Image Uploads Start-->
                        <tr>
                                <td>
                                </td>
                                <td class="quiet">
                                <?php 
                                if ($product_data['product_gallery']=="")
                                { 
                                $no_image_path=ADMINIMGPATH.NO_IMAGE;
                                ?>
                                <img src="<?php echo $no_image_path;?> "style="width:50px;height:50px;padding:3px;border:1px solid #000000" >
                                <?php
                                }
                                else
                                {
                                $allimage=$product_data['product_gallery']; 
                                
                                        $image=explode(",",$allimage);
                                        $i=0; 
                                        foreach( $image as $img){  
                                        $product_keyvalue=$image[$i];?>
                                        <img src="<?php echo URL_BASE.PRODUCTS_IMGPATH_THUMB150x150.'thumb100X100/'.$img;?> " title="<?php echo $img; ?>" style="width:50px;height:50px;padding:3px;border:1px solid #000000" >
                                        <div class="img"  name="<?php echo $img; ?>" > 
                                        <span id="productid" name="<?php echo $product_data['product_id']?>"></span>
                                        <?php
                                        $delete_title = __('delete_more_images'); 
                                        echo '<a  onclick="frmdel_more_image('.$product_data['product_id'].','.$i++.');" class="deleteicon" title='.__('delete').'></a>'; 
                                         }
                                         $i++;
                                         
                                  } ?>
                                  </div>
                                </td>
                        </tr>              
                        <tr>
                                <td class="text_right text_bold" valign="top"><label><?php echo __('more_images');?><span class="star"> </span></label></td>
                                <td>
                                <input type="file" name="product_gallery[]" id="product_gallery[]" onchange="document.getElementById('moreUploadsLink').style.display = 'block';" value="" accept="gif|jpg|png|jpeg" class="required"/>
                                <div id="moreUploads"></div>
                                <div id="moreUploadsLink" style="display:none;"><input type="button" onclick="javascript:addFileInput();"value="More Images"></div>   <span class="error">          
       <?php     echo isset($errors['product_gallery'])?ucfirst($errors['product_gallery']):""; ?>
        </span> 
                                </td>
                        </tr>
                        <tr>
                        	<td>
                        	</td>
                        	<td class="quiet"><?php echo __('multi_image_type');?></td>
                	</tr>
                        <?php if ($product_data['product_gallery']!=0)
                        {?>
                        <tr>
                                <td class="text_right text_bold" valign="top"></td>
                                <td>
                                <?php
                                $delete_title = __('total_more_image_delete'); 
                                         $delete_link="<a onclick='frmdel_more_total_image(".$product_data['product_id'].");' class='deleteicon' title='$delete_title' id='photo_delete'></a>";
                                         echo $delete_link;
                                         ?>
                                         <span><label><?php echo __('total_more_image_delete');?><span class="star"> </span></label></span>
                                </td>
                        </tr>
                        <?php } else {
                        }
                        ?>
 <!--Multiple Image Uploads End-->
                        <tr>
                                <td valign="top" ><label><?php echo __('product_description');?></label>
                                        <span class="star">*</span>
                                        </td>
                                        <td>
                                        <div class="width400">
                                        <textarea name="product_info" id="product_info"  class="resizetextarea" value="" onkeyup="limitlengths(this, <?php echo $product_settings[0]['max_desc_length'];?>,'product_info_label')"><?php echo isset($product_data['product_info']) && !array_key_exists('product_info',$errors)? $product_data['product_info']:$validator['product_info']; ?></textarea>
                                        </div>
                                        <span class="error">
                                        <?php echo isset($errors['product_info'])?ucfirst($errors['product_info']):""; ?>
                                        </span> 
                                        <span class="info_label" id="product_info_label"></span> 
                                   <span class="info_label" id="product_info_label">
                                  
                                   <?php echo __('info_product_name');?>:<?php echo $product_settings[0]['max_desc_length'];?>
                                  </span>                                 	                             
                                </td>      
                        </tr>
                         <!--Dedicated Auction-->
                        <tr id="bonus-field" class="modulebase">
                                <td valign="top">
                                <label><?php echo __('dedicated_auction_label'); ?></label></td>
                                <td>
                                	<input type="checkbox" name="dedicated_auction[]" value="E" <?php echo $dedicated_auction_checked; ?> /> 
                                    <span style="padding-left: 5px;" class="label_error">
                                        <?php echo isset($errors['dedicated_auction'])?ucfirst($errors['dedicated_auction']):""; ?>
                                    </span> 
                                </td>
                        </tr>
                       
                         <tr id="autobid-field"  class="modulebase">
                                <td valign="top">
                                <label><?php echo __('auto_bid_lable'); ?></label></td>
                                <td>
                                	<input type="checkbox" name="autobid[]" value="D" <?php echo $auto_auction_checked; ?> /> 
                                    <span style="padding-left: 5px;" class="label_error">
                                        <?php echo isset($errors['autobid'])?ucfirst($errors['autobid']):""; ?>
                                    </span> 
                                </td>
                        </tr>
                     
                         <tr>
                                <td valign="top">
                                <label><?php echo __('product_tag'); ?></label></td>
                                <td>
                                       	<!--<fieldset style="border:1px solid #999999;width:300px">-->
                                        <ol class="auction_status_list"> 
                                        <li>  
                                                <input id="product_featured" name="product_featured"  
                                                class="radio" type="radio" value="F" <?php echo $product_featured_checked; ?>/>  
                                                <label for="product_featured"><?php echo __('product_featured');?></label>  
                                        </li> 
                                        <li>  
                                                <input id="product_featured" name="product_featured"
                                                class="radio" type="radio" value="H" <?php echo $product_hot_checked; ?>/>  
                                                <label for="product_featured"><?php echo __('product_hot');?></label>  
                                        </li> 
                                         
                                         <li>  
                                                <input id="product_featured" name="product_featured"  
                                                class="radio" type="radio" value="N" <?php echo $product_none_checked; ?> />  
                                                <label for="product_featured"><?php echo __('product_none');?></label>  
                                        </li> 
                                        </ol>  
                                        <!--</fieldset>-->
                                    </span> 
                                </td>
                        </tr>
                           <!--Dedicated Auction End-->				
			<!--Buy Now-->
			<?php 	
//print_r($auction_type);exit;
	$action=explode("/",$action);
			$action1=$action[0];
if($auction_type[0]['pack_type']=="F"){ 
?>

			    <tr id="buynow-field" class="modulebase">
                                <td valign="top">
                                <label><?php echo __('buynow_lable'); ?></label></td>
                                <td>
                                	<input type="checkbox" name="buynow_status[]" value="D" <?php echo $buynow_auction_checked; ?> /> 
                                    <span style="padding-left: 5px;" class="label_error">
                                        <?php echo isset($errors['buynow_status'])?ucfirst($errors['buynow_status']):""; ?>
                                    </span> 
                                </td>
                             </tr>
			    <tr id="shippingfee-field"  class="modulebase">
                                <td valign="top" ><label><?php echo __('shipping_fee'); ?></label>
                                      
                                        </td>
                                        <td>
                                        <div class="width400">
                                        <input type="text" name="shipping_fee" id="shipping_fee"  maxlength ="12" value="<?php echo isset($product_data['shipping_fee']) &&!array_key_exists('shipping_fee',$errors)? $product_data['shipping_fee']:$validator['shipping_fee']; ?>" class="required chkamts text"/><?php echo $sitesettings ;?>
                                        </div>
                                   <?php echo isset($errors['shipping_fee'])?ucfirst($errors['shipping_fee']):""; ?>                                     	   
                                <span class="info_label"><?php echo __('select_shipping_fee');?></span>
                                </td>      
                        </tr>	
			<tr id="shipping_inf">
                                <td valign="top" ><label><?php echo __('shipping_info'); ?></label>
                                      
                                        </td>
                                        <td>
                                        <div class="width400">
                                        <input type="text" name="shipping_info" id="shipping_info"  maxlength ="50" value="<?php if($action1=='edit') { echo isset($product_data['shipping_info']) &&!array_key_exists('shipping_info',$errors)? $product_data['shipping_info']:$validator['shipping_info']; }?>" class="required chkamts text" />
                                        </div>
                                </td>      
                        </tr>			    
					
			<?php	} 
		
			if($action1!="edit")
			{?>
       <!--Auction Types-->
        <tr>
             <td valign="top">
                  <label><?php echo __('auction_types');
				//echo serialize(array('adminjs'=>true,'autobid'=>false,'buynow'=>false,'bonus'=>false,'shippingfee'=>false));
				?></label></td>
            <td>				
                  <ul class="auction_typeslist">
							<?php foreach($auction_type as $types):
							$checked="";
							if($types['pack_type']=="M"){
							if(isset($product_data['auction_type']) &&!array_key_exists('auction_type',$errors)? $product_data['auction_type']:$validator['auction_type']){
							if($validator['auction_type']==$types['typeid']){
							$checked="checked";
							}
							}
							?>
						<li>
							<input type="radio" id="<?php echo $types['typename'];?>" onclick="getelements('<?php echo $types['typename'];?>')" name="auction_type" value="<?php echo $types['typeid'];?>" <?php echo $checked;?>/><?php echo ucfirst($types['typename']);?>
						</li>
						<?php } endforeach;?>
						<span style="padding-left: 5px;" class="error"><?php  echo isset($errors['auction_type'])?ucfirst($errors['auction_type']):""; ?></span> 
				</ul>                                    
             </td>
       </tr>
<?php }?>
                        <!--Auction Types-->
                           <!--Radio Button-->
                            <tr>
                                <td valign="top"><label><?php echo __('status_label'); ?></label></td>
                                <td>
                                <?php if(isset($lastbidder))
                                { 
                                if(($lastbidder==0) and ($status_checked))
                                     { ?>                               
                                	<input type="checkbox" name="product_status[]" value="A" <?php echo $status_checked; ?> /> 
                               <?php } 
                               elseif(($lastbidder!=0) and ($status_checked)) 
                                     { 
                                        echo '<a  onclick="frmdel_inactive_image('.$product_data['product_id'].');"><input type="checkbox" name="product_status[]" id="inactive" value="A" ' ?> <?php echo $status_checked; ?> <?php '</a>';
                                     }  
                                     else 
                                     { ?>	
                                        <input type="checkbox" name="product_status[]" value="A" <?php echo $status_checked; ?> /> 
                               <?php } 
                               } else {?>
                                        <input type="checkbox" name="product_status[]" value="A" <?php echo $status_checked; ?> /> 
                               <?php } ?>
                                	<input type="hidden" name="product_process" value="<?php echo $product_data['product_process'] ; ?>"/>
                                    <span style="padding-left: 5px;" class="label_error">
                                        <?php echo isset($errors['product_status'])?ucfirst($errors['product_status']):""; ?>
                                    </span> 
                                </td>
                        </tr> 
                        <tr>
                        <td colspan="2" class="star">*<?php echo __('required_label'); ?></td>
                        </tr>                                  
                        <tr>
                        <td colspan="3" style="padding-left:110px;"> <br />
                      
                        <input type="button" value="<?php echo __('button_back'); ?>" 
                        onclick="location.href='<?php echo URL_BASE;?>manageproduct/index'" />
                        <input type="reset" value="<?php echo __('button_reset'); ?>" />
                        <input type="submit" value="<?php echo ($action[0] == 'add' )?''.
                        __('button_add').'':''.__('button_update').'';?>"   name="<?php echo ($action[0] == 'add' )?'admin_product_add':'admin_product_edit';?>" />
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

<script type="text/javascript">
function getelements(auction_type)
	{
		if(auction_type == 'clock')
		{
			$("#shippingfee-field").hide();
			$("#shipping_inf").hide();
			var shipfee = document.getElementById('shipping_fee');
			var shipinfo = document.getElementById('shipping_info');
			shipfee.disabled = true;
			shipinfo.disabled = true;
		}else if(auction_type != 'clock')
		{
			$("#shipping_inf").show();	
			$("#shippingfee-field").show();		
		}
	}
	var type="<?php echo $get_act_type[0]['typename'];?>";

window.onload = function() { 
	var chk="<?php echo $chk_action;?>";	
	var type="<?php echo $get_act_type[0]['typename'];?>";	
	if((chk =='edit')&& (type=='clock'))	{

			$("#shippingfee-field").hide();
			$("#shipping_inf").hide();			


			$("#buynow-field").hide();
		}

	}
</script>
