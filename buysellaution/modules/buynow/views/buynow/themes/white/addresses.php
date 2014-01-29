 <?php defined("SYSPATH") or die("No direct script access."); ?>
<script type="text/javascript" src="<?php echo SCRIPTPATH;?>jquery.js"></script>
<script language="javascript" type="text/javascript"> 
            $(document).ready(function() {
            
            	$("#content-3").slideDown();
            	$("#order_overview").attr('src','<?php echo IMGPATH;?>billing_minus.png');
                $("a.toggle").click(function() {
                    var img = $(this).find("img"); //get a handle of the image tag inside title link
                    var src = $(img).attr("src"); //get the source of the image 

                    //toggle the source of the image to show either plus/minus
                    if (src.endsWith("billing_plus.png"))
                        src = src.replace('billing_plus.png', 'billing_minus.png');
                    else
                        src = src.replace('billing_minus.png', 'billing_plus.png');

                    $(img).attr("src", src);
        
                    //get the title of the anchor tag which corresponds to the id of the content div
                    var content = $(this).attr("title"); 
                    //toggle the display of the content div
                    $(content).slideToggle();
                });
            });

            String.prototype.endsWith = function(str) {
                return this.lastIndexOf(str) == this.length - str.length;  
            }
</script>
<style type="text/css">
            .toggle
            {
                font-size: large;
            }
            .toggle img
            {
                border-style: none;
            }
            .content
            {
                display: none;
                font-size: small;
            }
</style>



<div class="signup_head">
<ul>
<li><a  href="<?php echo URL_BASE; ?>" title="<?php echo __('menu_home')?>"><?php echo __('menu_home')?></a></li>
<li><a href="#"><img src="<?php echo IMGPATH;?>arr_bg.png" width="13" height="11" alt="Arrow" /></a></li>
<li class="active"><a  title="<?php echo $selected_page_title; ?>"><?php echo $selected_page_title; ?></a></li>
</ul>
</div>
<div class="signup-part"><h2 title="<?php echo __('checkout_label');?>"><?php echo __('checkout_label');?></h2></div>
<!-- Edit Billing Address Start -->
<div style="float:left;clear:both;width:100%;">
<div class="message_common_border" style="width:100%;">

<h1 class="white_title1" title="<?php echo strtoupper(__('billing_information'));?>"> <a class="billing_plus toggle"  href="javascript://" title="#content-1" >
<img src="<?php echo IMGPATH;?>billing_plus.png" border="0" /></a>&nbsp;&nbsp;<?php echo strtoupper(__('billing_information'));?></h1>
<p class="white_title2_bgborder">&nbsp;</p>
</div>
<div id="content-1" class="content pink_product_box_outer "  style="display: none;margin-top:-15px;background:#fff;padding-bottom:20px;">	
<?php if(count($db_values)>0){?>
<div class="message_common" style="width:960px;">

<div class="login_middle_common_profil">
<div class="user_name_common">
<p><?php echo __('name_label');?><span class="red">*</span>  :</p>
<div class="text_feeld">
<h2> <?php echo Form::input('name', isset($form_values['name'])?$form_values['name']:$db_values[0]['name'],array("id"=>"name","Maxlength"=>"20",'title' =>__('name_label'))) ?></h2>
</div>
<label class="errore_msg fl clr"><span class="red"><?php if($errors && array_key_exists('name',$errors)){  echo (array_key_exists('name',$errors))? $errors['name']:""; }?></span></label>
</div>

<div class="user_name_common">
<p><?php echo __('address_line1');?><span class="red">*</span> :</p>
<div class="text_feeld">
<h2> <?php   $address=explode(" + ",$db_values[0]['address']);
           echo Form::input('address1', isset($form_values['address1'])?$form_values['address1']:$address[0],array("id"=>"address_line1","Maxlength"=>"50",'title'=>__('address_line1'))) ?></h2>
</div>
<label class="errore_msg fl clr"><span class="red"><?php  if($errors && array_key_exists('address1',$errors)){ echo (array_key_exists('address1',$errors))? $errors['address1']:""; }?></span></label>
</div>

<div class="user_name_common">
<p><?php echo __('address_line2');?>  :</p>
<div class="text_feeld">
<h2> <?php  $address2=(array_key_exists(1,$address))?$address[1]:__('enter_address2');
                        echo Form::input('address2',isset($form_values['address2'])?$form_values['address2']:$address2,array("id"=>"address_line2","Maxlength"=>"50",'title'=>__('address_line2'))) ?></h2>
</div>
                <label class="errore_msg fl clr"><span class="red"><?php  if($errors && array_key_exists('address2',$errors)){  echo (array_key_exists('address2',$errors))? $errors['address2']:""; }?></span></label>
</div>
<div class="user_name_common">
<p><?php echo __('country_label');?><span class="red">*</span> :</p>
<?php $selected= isset($form_values['country'])?$form_values['country']:$db_values[0]['country'];?>
<div >

 <?php  echo Form::select('country',Arr::merge(array("-1"=>"Select Country"),$allcountries),$selected);?>
</div>
 <label class="errore_msg fl">
                <span class="red">  <?php if($errors && array_key_exists('country',$errors)){?><?php echo (array_key_exists('country',$errors))? $errors['country']:"";?><?php }?></span>
                </label>
</div>


<div class="user_name_common">
<p><?php echo __('city_label');?><span class="red">*</span>  :</p>
<div class="text_feeld">
<h2> <?php  echo Form::input('city', isset($form_values['city'])?$form_values['city']:$db_values[0]['city'],array("id"=>"city","Maxlength"=>"20",'title'=>__('city_label'))) ?></h2>
</div>
               <label class="errore_msg fl clr"><span class="red"> <?php if($errors && array_key_exists('city',$errors)){?><?php  echo (array_key_exists('city',$errors))? $errors['city']:"";?><?php }?></span></label>
</div>


<div class="user_name_common">
<p><?php echo __('town_label');?> :</p>
<div class="text_feeld">
<h2>  <?php  
                        $town=($db_values[0]['town']!="")?$db_values[0]['town']:"";
                        echo Form::input('town',isset($form_values['town'])?$form_values['town']:$town,array("id"=>"town","Maxlength"=>"50",'title'=>__('town'))) ?></h2>
</div>
           <label class="errore_msg fl clr"><span class="red">   <?php if($errors && array_key_exists('town',$errors)){?><?php  echo (array_key_exists('town',$errors))? $errors['town']:"";?><?php }?></span></label>
</div>
<div class="user_name_common">
<p><?php echo __('zipcode_label');?><span class="red">*</span> :</p>
<div class="text_feeld">
<h2>      <?php  echo Form::input('zipcode',isset($form_values['zipcode'])?$form_values['zipcode']:$db_values[0]['zipcode'],array("id"=>"zipcode","Maxlength"=>"10",'title'=>__('zipcode_label'))) ?></h2>
</div>
              <label class="errore_msg fl clr"><span class="red"> <?php if($errors && array_key_exists('zipcode',$errors)){?><?php  echo (array_key_exists('zipcode',$errors))? $errors['zipcode']:"";?><?php }?></span></label>
</div>


<div class="user_name_common">
<p><?php echo __('phone_label');?>  :</p>
<div class="text_feeld">
<h2>   <?php 
                        $phone=($db_values[0]['phoneno']!="")?$db_values[0]['phoneno']:"";
                        echo Form::input('phone',isset($form_values['phone'])?$form_values['phone']:$phone,array("id"=>"phone","Maxlength"=>"20",'title'=>__('phone_label'))) ?></h2>
</div>
                <label class="errore_msg fl clr"><span class="red"><?php if($errors && array_key_exists('phoneno',$errors)){?><?php  echo (array_key_exists('phoneno',$errors))? $errors['phoneno']:"";?><?php }?></span></label>
</div>
 <div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
<div class="user_name_common">



</div>
</div>

</div>


</div>
</div>
<?php } else{ ?>
		
        
        
<div class="message_common" style="width:960px;">
<div class="login_middle_common_profil">
	<div class="grand_total_btn">
			<div class="fl">
		
				<span class="ora_btn_lft">&nbsp;</span>
				<span class="ora_btn_mid"><a href="<?php echo URL_BASE;?>users/myaddresses/billing/add" title="<?php echo strtoupper(__('add_billing_address'));?>" class="fl"><input type="button" style="width:auto;" name="key" value="<?php echo strtoupper(__('add_billing_address'));?>"/></a></span>
				<span class="ora_btn_rgt">&nbsp;</span>
			</div>
			
		
	</div>
	</div>
	
	</div>
	</div>
        
	<?php }?>


<!-- Edit Billing Address end -->


<!-- Edit Shipping Address start -->

<div style="float:left;clear:both;width:100%;">
<div class="message_common_border" style="width:100%;">

<h1 class="white_title1" title="<?php echo strtoupper(__('shipping_information'));?>"> <a class="billing_plus toggle"  href="javascript://" title="#content-2" >
                                   <img src="<?php echo IMGPATH;?>billing_plus.png" border="0" /></a>&nbsp;&nbsp;<?php echo strtoupper(__('shipping_information'));?></h1>
<p class="white_title2_bgborder">&nbsp;</p>
</div>
<div id="content-2" class="content pink_product_box_outer" style="display: none;background:#fff;padding-bottom:20px;">
<?php if(count($db_values_shipping)>0){ ?>
 
<div class="message_common" style="width:960px;">

<div class="login_middle_common_profil">
<div class="user_name_common">
<p><?php echo __('name_label');?><span class="red">*</span>  :</p>
<div class="text_feeld">
<h2> <?php echo Form::input('name', isset($form_values['name'])?$form_values['name']:$db_values[0]['name'],array("id"=>"name","Maxlength"=>"20",'title' =>__('name_label'))) ?></h2>
</div>
<label class="errore_msg fl clr"><span class="red"><?php if($errors && array_key_exists('name',$errors)){  echo (array_key_exists('name',$errors))? $errors['name']:""; }?></span></label>
</div>

<div class="user_name_common">
<p><?php echo __('address_line1');?><span class="red">*</span> :</p>
<div class="text_feeld">
<h2> <?php   $address=explode(" + ",$db_values[0]['address']);
           echo Form::input('address1', isset($form_values['address1'])?$form_values['address1']:$address[0],array("id"=>"address_line1","Maxlength"=>"50",'title'=>__('address_line1'))) ?></h2>
</div>
<label class="errore_msg fl clr"><span class="red"><?php  if($errors && array_key_exists('address1',$errors)){ echo (array_key_exists('address1',$errors))? $errors['address1']:""; }?></span></label>
</div>

<div class="user_name_common">
<p><?php echo __('address_line2');?>  :</p>
<div class="text_feeld">
<h2> <?php  $address2=(array_key_exists(1,$address))?$address[1]:__('enter_address2');
                        echo Form::input('address2',isset($form_values['address2'])?$form_values['address2']:$address2,array("id"=>"address_line2","Maxlength"=>"50",'title'=>__('address_line2'))) ?></h2>
</div>
                <label class="errore_msg fl clr"><span class="red"><?php  if($errors && array_key_exists('address2',$errors)){  echo (array_key_exists('address2',$errors))? $errors['address2']:""; }?></span></label>
</div>
<div class="user_name_common">
<p><?php echo __('country_label');?><span class="red">*</span> :</p>
<?php $selected= isset($form_values['country'])?$form_values['country']:$db_values[0]['country'];?>
<div >

 <?php  echo Form::select('country',Arr::merge(array("-1"=>"Select Country"),$allcountries),$selected);?>
</div>
 <label class="errore_msg fl">
                <span class="red">  <?php if($errors && array_key_exists('country',$errors)){?><?php echo (array_key_exists('country',$errors))? $errors['country']:"";?><?php }?></span>
                </label>
</div>


<div class="user_name_common">
<p><?php echo __('city_label');?><span class="red">*</span>  :</p>
<div class="text_feeld">
<h2> <?php  echo Form::input('city', isset($form_values['city'])?$form_values['city']:$db_values[0]['city'],array("id"=>"city","Maxlength"=>"20",'title'=>__('city_label'))) ?></h2>
</div>
               <label class="errore_msg fl clr"><span class="red"> <?php if($errors && array_key_exists('city',$errors)){?><?php  echo (array_key_exists('city',$errors))? $errors['city']:"";?><?php }?></span></label>
</div>


<div class="user_name_common">
<p><?php echo __('town_label');?> :</p>
<div class="text_feeld">
<h2>  <?php  
                        $town=($db_values[0]['town']!="")?$db_values[0]['town']:"";
                        echo Form::input('town',isset($form_values['town'])?$form_values['town']:$town,array("id"=>"town","Maxlength"=>"50",'title'=>__('town'))) ?></h2>
</div>
           <label class="errore_msg fl clr"><span class="red">   <?php if($errors && array_key_exists('town',$errors)){?><?php  echo (array_key_exists('town',$errors))? $errors['town']:"";?><?php }?></span></label>
</div>
<div class="user_name_common">
<p><?php echo __('zipcode_label');?><span class="red">*</span> :</p>
<div class="text_feeld">
<h2>      <?php  echo Form::input('zipcode',isset($form_values['zipcode'])?$form_values['zipcode']:$db_values[0]['zipcode'],array("id"=>"zipcode","Maxlength"=>"10",'title'=>__('zipcode_label'))) ?></h2>
</div>
              <label class="errore_msg fl clr"><span class="red"> <?php if($errors && array_key_exists('zipcode',$errors)){?><?php  echo (array_key_exists('zipcode',$errors))? $errors['zipcode']:"";?><?php }?></span></label>
</div>


<div class="user_name_common">
<p><?php echo __('phone_label');?>  :</p>
<div class="text_feeld">
<h2>   <?php 
                        $phone=($db_values[0]['phoneno']!="")?$db_values[0]['phoneno']:"";
                        echo Form::input('phone',isset($form_values['phone'])?$form_values['phone']:$phone,array("id"=>"phone","Maxlength"=>"20",'title'=>__('phone_label'))) ?></h2>
</div>
                <label class="errore_msg fl clr"><span class="red"><?php if($errors && array_key_exists('phoneno',$errors)){?><?php  echo (array_key_exists('phoneno',$errors))? $errors['phoneno']:"";?><?php }?></span></label>
</div>
 <div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
<div class="user_name_common">





</div>
</div>
</div>

</div>


</div>
	<?php }else{ ?>
	<div class="message_common" style="width:960px;">

<div class="login_middle_common_profil">
	<div class="grand_total_btn">
			<div class="fl">
		
				<span class="ora_btn_lft">&nbsp;</span>
				<span class="ora_btn_mid"><a href="<?php echo URL_BASE.'users/myaddresses/shipping/add';?>" title="<?php echo strtoupper(__('add_shipping_address'));?>" class="fl"><input type="button" style="width:auto;" name="key" value="<?php echo strtoupper(__('add_shipping_address'));?>"/></a></span>
				<span class="ora_btn_rgt">&nbsp;</span>
			</div>
			
		
	</div>
	</div>
	
	</div>
	</div>
	<?php }?>


<!--Edit Billing address end-->



<!-- Edit Shipping Address start -->


<div>
<div class="message_common_border" style="width:100%;">

<h1 class="white_title1" title="<?php echo strtoupper(__('order_review')); ?>"> <a class="billing_plus toggle"  href="javascript://" title="#content-3" >
                                   <img src="<?php echo IMGPATH;?>billing_plus.png" border="0" id="order_overview" /></a>&nbsp;&nbsp;<?php echo strtoupper(__('order_review')); ?></h1>
<p class="white_title2_bgborder">&nbsp;</p>
</div>
<div id="content-3" class="content pink_product_box_outer" style="display: none;background:#fff;padding-bottom:0px;">
 <!--add to cart-->
	
	<div class="cart_main" id="white_addresses_page">
		<div class="cart_main_inner">
			<div class="cart_tit_bg">
				
				<h2 class="cart_prod" style="color:#FFF;font:14px/14px arial;"><?php echo __('product_name');?></h2>
				<h2 class="cart_amt" style="color:#FFF;font:14px/14px arial;"><?php echo __('product_cost_label');?></h2>
				<h2 class="cart_quality" style="color:#FFF;font:14px/14px arial;float:left;text-align:center;"><?php echo __('quantity_label');?></h2>
				<h2 class="cart_delete" style="color:#FFF;font:14px/14px arial;text-align:center;"><?php echo __('sub_total_label');?></h2>
				<div class="clear"></div>
			</div>
			 <?php
			 $i=0;
			 $sfee=0;
			 foreach($transactions as $trans):
				$amt[]=$trans['total_amt'];
				$tamount[]=$trans['amount'];
				$subamount=array_sum($tamount);
				$shippingfee=($trans['shipping_fee']!='')?$trans['shipping_fee']:0;
				$sfee+=$shippingfee;
			       
			?>
			<div class="cart_tit_bg_wo">
			
				<div class="cart_prod_bor">
					<h3><?php echo ucfirst($trans['product_name']);?></h3>
				
				</div>
				<div class="cart_amt_bor"><?php echo $site_currency." ".Commonfunction::numberformat($trans['product_cost']);?></div>
				<div class="cart_quality_bor">
					<div class="inner">
	<span style="width:100%;text-align:center;float:left;"><?php echo $trans['quantity'];?></span>
					</div>
				</div>
				<div align="center" class="cart_delete_bor">
				 <?php
			    
			    $subamt=$trans['quantity']*$trans['product_cost'];
			     
			    
			    echo $site_currency." ".Commonfunction::numberformat($subamt);
			    $subamtarr[]=$subamt;
			    ?>
				
				</div>
				<div class="clear"></div>
			</div>
	<?php
			 $totalamount=array_sum($amt);
			$arr[]=array('form[id][]'=>$trans['productid'],
						     'form[image][]'=>$trans['product_image'],
						     'form[product_url][]'=>$trans['product_url'],
						     'form[unitprice][]'=>$trans['product_cost'],
						     'form[quantity][]' => $trans['quantity'],
						     'form[name][]' => $trans['product_name'],
						     'form[shipping_cost]' => $sfee,
						     'form[type]' =>'product');
			 
			$i++;
			endforeach;
			 $param = array( array($arr),
				 $site_currency,1,URL_BASE."process/gateway");  
			
			?>
						
		</div>
		<div class="clear"></div>
		<!--<div class="grand_total" style="width:100%;">
			<span class="grand_total_wleft"><?php echo __('price_label');?> :</span>
			<span class="amt grand_total_wright"><?php echo $site_currency." ".Commonfunction::numberformat($totalamount);?></span>
		</div>-->
		<div class="clear"></div>
			<div class="grand_total" style="width:100%">
			<span class="grand_total_wleft"><?php echo __('shipping_handing'); ?> :</span>
			<span class="amt grand_total_wright"><?php echo $site_currency." ".Commonfunction::numberformat($sfee);?></span>
		</div>
		
		<div class="clear"></div>
			<div class="grand_total" style="width:100%;">
			<span class="grand_total_wleft"><?php echo __('grand_total'); ?> :</span>
			<span class="amt grand_total_wright"><?php
			
			echo $site_currency." ".Commonfunction::numberformat(array_sum($subamtarr)+$sfee);?></span>
		</div>
             </div>
<!--add to cart-->
</div>
</div>
 <div class="message_common" style="width:965px;">

<div class="login_middle_common_profil" style="width:95%;">
<div class="grand_total_btn">
 <p><?php echo __('forgot_an_label');?></p>
			<div class="fl">
			
				<div class="fl">
				<span class="ora_btn_lft">&nbsp;</span>
				<span class="ora_btn_mid"><a href="<?php echo URL_BASE;?>site/buynow/cart_list" title="<?php echo __('edit_cart_label');?>"><input type="button" style="width:auto;" name="key" value="<?php echo __('edit_cart_label');?>"/></a></span>
				<span class="ora_btn_rgt">&nbsp;</span>
			</div>
			</div>
		
			<div class="fl" style="margin-left:10px;">
				<span class="blue_btn_lft">&nbsp;</span>
				
				<span class="blue_btn_mid">
					<?php
				//echo $bonus_amount;exit;
				if($useramount >= (array_sum($subamtarr)+$sfee)){ ?>
				<a href="<?php echo URL_BASE;?>site/buynow/buynow_offline/<?php echo $trans['product_id'];?>" title="<?php echo __('pay_label');?>" name="key" title="<?php echo __('pay_label');?>"/><?php echo __('pay_label');?></a>
				
				<?php	}else{
				    call_user_func_array('Commonfunction::showlinkmultipledata', $param);
				    ?>
	<?php /*		<a href="<?php echo URL_BASE;?>site/buynow/buynow_auction/<?php echo $trans['userid'];?>" title="<?php echo __('pay_label');?>"><input type="button" name="key" value="<?php echo __('pay_label');?>"  title="<?php echo __('pay_label');?>"/></a>
	      */ ?>	
				<?php 	} ?>
				
				</span>
				<span class="blue_btn_rgt">&nbsp;</span>
			</div>
			
		</div>
</div>
</div>
</div>
</div>
<!--Edit Billing address end-->

