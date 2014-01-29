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
<div class="action_deal_list1  clearfix fl">
<div class="title-left title_temp2">
        <div class="title-right">
        <div class="title-mid">
                <h2 class="fl clr" title="<?php echo __('checkout_label');?>"><?php echo __('checkout_label');?></h2>
                <span class="title-arrow">&nbsp;</span>
        </div>
        </div>
        </div>
            <div class="watch_list_items clr fl">
                <!--Billing information start-->
                
                <div class="billing_information_pink2_outer">
                    <div class="billing_information_pink">
                        <div class="billing_information_lft"></div>
                        <div class="billing_information_mid">
                            <div class="billing_information_mid_inner">
                                <a class="billing_plus toggle"  href="javascript://" title="#content-1" >
                                        <img src="<?php echo IMGPATH;?>billing_plus.png" border="0" /></a>
                                    <h3><?php  echo __('billing_information')?></h3>
                            </div>
                        </div>
                        <div class="billing_information_rft"></div>
                    </div>
                </div>
<div id="content-1" class="content pink_product_box_outer "  style="display: none;margin-top:-15px;background:#fff; border-bottom:1px solid #ddd;padding-bottom:20px;">	
       <div id="pass">
	<?php if(count($db_values)>0){?>
        <!-- Add billing address-->
        <div class="form_tabel">
     
	
       <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><p><?php echo __('name_label');?> <span class="red">*</span>:</p></div>
                <div class="colm2_width fl">
                        <div class="inputbox_out fl">
                        <?php echo Form::input('name', isset($form_values['name'])?$form_values['name']:$db_values[0]['name'],array("id"=>"name","Maxlength"=>"20",'title' =>__('name_label'))) ?>
                        </div>
                <?php 
                if($errors && array_key_exists('name',$errors)){?><label class="errore_msg fl clr"><span class="red"><?php  echo (array_key_exists('name',$errors))? $errors['name']:"";?></span></label><?php }
                ?>
                </div>
        </div>
        <!-- Address line1 -->
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><p><?php echo __('address_line1');?> <span class="red">*</span>:</p></div>
                <div class="colm2_width fl">	
                        <div class="inputbox_out fl">
                        <?php 
	                        $address=explode(" + ",$db_values[0]['address']);
                         echo Form::input('address1', isset($form_values['address1'])?$form_values['address1']:$address[0],array("id"=>"address_line1","Maxlength"=>"50",'title'=>__('address_line1'))) ?>
                        </div>    
                <?php if($errors && array_key_exists('address1',$errors)){?><label class="errore_msg fl clr"><span class="red"><?php  echo (array_key_exists('address1',$errors))? $errors['address1']:"";?></span></label><?php }?>
                </div>
        </div>
        <!-- Address line2 -->
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><p><?php echo __('address_line2');?>:</p></div>
                <div class="colm2_width fl">	
                        <div class="inputbox_out fl">
                        <?php   $address2=(array_key_exists(1,$address))?$address[1]:__('enter_address2');
                        echo Form::input('address2',isset($form_values['address2'])?$form_values['address2']:$address2,array("id"=>"address_line2","Maxlength"=>"50",'title'=>__('address_line2'),'onfocus'=>'label_onfocus("address_line2","'.__('enter_address2').'")','onblur'=>'label_onblur("address_line2","'.__('enter_address2').'")')) ?>
                        </div>    
                <?php if($errors && array_key_exists('address2',$errors)){?> <label class="errore_msg fl clr"><span class="red"><?php  echo (array_key_exists('address2',$errors))? $errors['address2']:"";?></span></label><?php }?>
                </div>
        </div>

        <!--Country-->
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><p><?php echo __('country_label');?> <span class="red">*</span>:</p></div>
                <div class="colm2_width fl">
                        <div class="selectbox_out inputbox_out fl">
	                        <span class="select"><?php $selected= isset($form_values['country'])?$form_values['country']:$db_values[0]['country'];?></span>
                        <?php 
                        echo Form::select('country',Arr::merge(array("-1"=>"Select Country"),$allcountries),$selected,array('class' => 'styled'));?>
                        </div>
                 <?php if($errors && array_key_exists('country',$errors) ){?><label class="errore_msg fl">
                <span class="red"><?php echo (array_key_exists('country',$errors))? $errors['country']:"";?></span>
                </label><?php }?>
                </div>
        </div>

        <!-- City-->
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><p><?php echo __('city_label');?> <span class="red">*</span>:</p></div>
                <div class="colm2_width fl">	
                        <div class="inputbox_out fl">
                        <?php  echo Form::input('city', isset($form_values['city'])?$form_values['city']:$db_values[0]['city'],array("id"=>"city","Maxlength"=>"20",'title'=>__('city_label'))) ?>
                        </div>    
                <?php if($errors && array_key_exists('city',$errors)){?><label class="errore_msg fl clr"><span class="red"><?php  echo (array_key_exists('city',$errors))? $errors['city']:"";?></span></label><?php }?>
                </div>
        </div>

        <!-- Town-->
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><p><?php echo __('town_label');?>:</p></div>
                <div class="colm2_width fl">	
                        <div class="inputbox_out fl">
                        <?php  
                        $town=($db_values[0]['town']!="")?$db_values[0]['town']:__('enter_town');
                        echo Form::input('town',isset($form_values['town'])?$form_values['town']:$town,array("id"=>"town","Maxlength"=>"50",'title'=>__('town'),'onfocus'=>'label_onfocus("town","'.__('enter_town').'")','onblur'=>'label_onblur("town","'.__('enter_town').'")')) ?>
                        </div>    
                <?php if($errors && array_key_exists('town',$errors)){?><label class="errore_msg fl clr"><span class="red"><?php  echo (array_key_exists('town',$errors))? $errors['town']:"";?></span></label><?php }?>
                </div>
        </div>

        <!-- pincode-->
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><p><?php echo __('zipcode_label');?> <span class="red">*</span>:</p></div>
                <div class="colm2_width fl">	
                        <div class="inputbox_out fl">
                        <?php  echo Form::input('zipcode',isset($form_values['zipcode'])?$form_values['zipcode']:$db_values[0]['zipcode'],array("id"=>"zipcode","Maxlength"=>"10",'title'=>__('zipcode_label'))) ?>
                        </div>    
                <?php if($errors && array_key_exists('zipcode',$errors)){?><label class="errore_msg fl clr"><span class="red"><?php  echo (array_key_exists('zipcode',$errors))? $errors['zipcode']:"";?></span></label><?php }?>
                </div>
        </div>
	
        <!-- Phone-->
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><p><?php echo __('phone_label');?>:</p></div>
                <div class="colm2_width fl">	
                        <div class="inputbox_out fl">
                        <?php  
                        $phone=($db_values[0]['phoneno']!="")?$db_values[0]['phoneno']:__('enter_phone');
                        echo Form::input('phone',isset($form_values['phone'])?$form_values['phone']:$phone,array("id"=>"phone","Maxlength"=>"20",'title'=>__('phone_label'),'onfocus'=>'label_onfocus("phone","'.__('enter_phone').'")','onblur'=>'label_onblur("phone","'.__('enter_phone').'")')) ?>
                        </div>    
                <?php if($errors && array_key_exists('phone',$errors)){?> <label class="errore_msg fl clr"><span class="red"><?php  echo (array_key_exists('phone',$errors))? $errors['phone']:"";?></span></label><?php }?>
                <div style="color:#999; float:left"><?php echo __('ex_telephone_label');?></div>
                </div>
          </div>
        </div>
	<?php } else{ ?>
		<div class="add_bill_address fl ml20 french_but" style="margin-top:10px;">
		<span class="add_address_left fl">&nbsp;</span>
		<span class="add_address_middle fl">
			<a href="<?php echo URL_BASE;?>users/myaddresses/billing/add" title="<?php echo __('add_billing_address');?>" class="fl"> <?php echo __('add_billing_address');?></a>
		</span>
		<span class="add_address_left add_address_right fl">&nbsp;</span>
		</div>
	<?php }?>
        </div>	
  
</div>
<!--Shipping information start-->
                <div class="billing_information_pink2_outer" style="margin-top:10px;">
                    <div class="billing_information_pink">
                        <div class="billing_information_lft"></div>
                        <div class="billing_information_mid">
                            <div class="billing_information_mid_inner"> 
                                  <a class="billing_plus toggle"  href="javascript://" title="#content-2" >
                                        <img src="<?php echo IMGPATH;?>billing_plus.png" border="0" /></a>
                                    <h3><?php echo __('shipping_information'); ?></h3>
                            </div>
                        </div>
                        <div class="billing_information_rft"></div>
                    </div>
                </div>
<div id="content-2" class="content pink_product_box_outer" style="display: none;margin-top:-20px;background:#fff; border-bottom:1px solid #ddd;padding-bottom:20px;">
        <div id="pass">
	<?php if(count($db_values_shipping)>0){ ?>
        <!-- Add shipping address-->
        <div class="form_tabel">
        <?php //echo Form::open("",array('name'=>'shipping','id'=>'shipping')); ?>
      <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><p><?php echo __('name_label');?> <span class="red">*</span>:</p></div>
                <div class="colm2_width fl">
                        <div class="inputbox_out fl">
                        <?php echo Form::input('name', isset($form_values['name'])?$form_values['name']:$db_values_shipping[0]['name'],array("id"=>"name","Maxlength"=>"20",'title' =>__('name_label'))) ?>
                        </div>
                <?php 
                if($errors && array_key_exists('name',$errors)){?><label class="errore_msg fl clr"><span class="red"><?php  echo (array_key_exists('name',$errors))? $errors['name']:"";?></span></label><?php }
                ?>
                </div>
        </div>

        <!-- Address line1 -->
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><p><?php echo __('address_line1');?> <span class="red">*</span>:</p></div>
                <div class="colm2_width fl">	
                        <div class="inputbox_out fl">
                        <?php 
                        $address=explode(" + ",$db_values_shipping[0]['address']);
                        echo Form::input('address1', isset($form_values['address1'])?$form_values['address1']:$address[0],array("id"=>"address_line1","Maxlength"=>"50",'title'=>__('address_line1'))) ?>
                        </div>    
                <?php if($errors && array_key_exists('address1',$errors)){?> <label class="errore_msg fl clr"><span class="red"><?php  echo (array_key_exists('address1',$errors))? $errors['address1']:"";?></span></label><?php }?>
                </div>
        </div>

        <!-- Address line2 -->
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><p><?php echo __('address_line2');?>:</p></div>
                <div class="colm2_width fl">	
                        <div class="inputbox_out fl">
                        <?php  $address2=(array_key_exists(1,$address))?$address[1]:__('enter_address2');
                        echo Form::input('address2',isset($form_values['address2'])?$form_values['address2']:$address2,array("id"=>"address_line2","Maxlength"=>"50",'title'=>__('address_line2'),'onfocus'=>'label_onfocus("address_line2","'.__('enter_address2').'")','onblur'=>'label_onblur("address_line2","'.__('enter_address2').'")')) ?>
                        </div>    
                <?php if($errors && array_key_exists('address2',$errors)){?> <label class="errore_msg fl clr"><span class="red"><?php  echo (array_key_exists('address2',$errors))? $errors['address2']:"";?></span></label><?php }?>
                </div>
        </div>

        <!--Country-->
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><p><?php echo __('country_label');?> <span class="red">*</span>:</p></div>
                <div class="colm2_width fl">
                        <div class="selectbox_out inputbox_out fl">
                        <span class="select"><?php $selected= isset($form_values['country'])?$form_values['country']:$db_values_shipping[0]['country'];?></span>
                        <?php 
                        echo Form::select('country',Arr::merge(array("-1"=>"Select Country"),$allcountries),$selected,array('class' => 'styled'));?>
                        </div>
                <?php if($errors && array_key_exists('country',$errors)){?> <label class="errore_msg fl">
                <span class="red"><?php echo (array_key_exists('country',$errors))? $errors['country']:"";?></span>
                </label><?php }?>
                </div>
        </div>

        <!-- City-->
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><p><?php echo __('city_label');?> <span class="red">*</span>:</p></div>
                <div class="colm2_width fl">	
                        <div class="inputbox_out fl">
                        <?php  echo Form::input('city', isset($form_values['city'])?$form_values['city']:$db_values_shipping[0]['city'],array("id"=>"city","Maxlength"=>"20",'title'=>__('city_label'))) ?>
                        </div>    
                <?php if($errors && array_key_exists('city',$errors)){?><label class="errore_msg fl clr"><span class="red"><?php  echo (array_key_exists('city',$errors))? $errors['city']:"";?></span></label><?php }?>
                </div>
        </div>

        <!-- Town-->
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><p><?php echo __('town_label');?>:</p></div>
                <div class="colm2_width fl">	
                        <div class="inputbox_out fl">
                        <?php  
                        $town=($db_values_shipping[0]['town']!="")?$db_values_shipping[0]['town']:__('enter_town');
                        echo Form::input('town',isset($form_values['town'])?$form_values['town']:$town,array("id"=>"town","Maxlength"=>"50",'title'=>__('town'),'onfocus'=>'label_onfocus("town","'.__('enter_town').'")','onblur'=>'label_onblur("town","'.__('enter_town').'")')) ?>
                        </div>    
                <?php if($errors && array_key_exists('town',$errors)){?><label class="errore_msg fl clr"><span class="red"><?php  echo (array_key_exists('town',$errors))? $errors['town']:"";?></span></label><?php }?>
                </div>
        </div>

        <!-- pincode-->
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><p><?php echo __('zipcode_label');?> <span class="red">*</span>:</p></div>
                <div class="colm2_width fl">	
                        <div class="inputbox_out fl">
                        <?php  echo Form::input('zipcode',isset($form_values['zipcode'])?$form_values['zipcode']:$db_values_shipping[0]['zipcode'],array("id"=>"zipcode","Maxlength"=>"10",'title'=>__('zipcode_label'))) ?>
                        </div>    
                <?php if($errors && array_key_exists('zipcode',$errors)){?> <label class="errore_msg fl clr"><span class="red"><?php  echo (array_key_exists('zipcode',$errors))? $errors['zipcode']:"";?></span></label><?php }?>
                </div>
        </div>

        <!-- Phone-->
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><p><?php echo __('phone_label');?>:</p></div>
                <div class="colm2_width fl">	
                        <div class="inputbox_out fl">
                        <?php 
                        $phone=($db_values_shipping[0]['phoneno']!="")?$db_values_shipping[0]['phoneno']:__('enter_phone');
                        echo Form::input('phone',isset($form_values['phone'])?$form_values['phone']:$phone,array("id"=>"phone","Maxlength"=>"20",'title'=>__('phone_label'),'onfocus'=>'label_onfocus("phone","'.__('enter_phone').'")','onblur'=>'label_onblur("phone","'.__('enter_phone').'")')) ?>
                        </div>    
                <?php if($errors && array_key_exists('phone',$errors)){?><label class="errore_msg fl clr"><span class="red"><?php  echo (array_key_exists('phone',$errors))? $errors['phone']:"";?></span></label><?php }?>
                <div style="color:#999; float:left;"><?php echo __('ex_telephone_label');?></div>
                </div>
        </div>
        </div>	
	<?php }else{ ?>
		<div class="add_bill_address french_but fl" style="margin-top:20px;">
		<span class="add_address_left fl">&nbsp;</span>
		<span class="add_address_middle fl">
			<a href="<?php echo URL_BASE.'users/myaddresses/shipping/add';?>" title="<?php echo __('add_shipping_address');?>" class="fl"><?php echo __('add_shipping_address');?></a>
		</span>
		<span class="add_address_left add_address_right fl">&nbsp;</span>
		</div>
	
	<?php }?>

</div> 
      </div> 
<div class="billing_information_pink2_outer" style="margin-top:10px;">
                    <div class="billing_information_pink2">
                        <div class="billing_information_lft2"></div>
                        <div class="billing_information_mid2">
                            <div class="billing_information_mid_inner2">
                                 <a class="billing_plus toggle" href="javascript://" title="#content-3" >
                                        <img src="<?php echo IMGPATH;?>billing_plus.png" border="0" id="order_overview" /></a>
                                    <h3><?php echo __('order_review'); ?></h3>
                            </div>
                        </div>
                        <div class="billing_information_rft2"></div>
                    </div>

                    <div class="billing_information_bottom_bor"> </div>
                </div>
         <div id="content-3" class="content pink_product_box_outer" style="display: none;display: none; background: #fff; margin-top:-13px;width:926px;">
                    <table class="pink_product_box fl clr"  cellpadding="0" cellspacing="0" style="width:926px !important; border:none; ">
			
                        <tr>
                            <th width="350" align="left" style="border-top:1px solid #F0F0F0;border-bottom:1px solid #F0F0F0;"><b style="margin-left:30px;"><?php echo __('product_name');?></b></th>
                            <th width="150" align="center" style="border-top:1px solid #F0F0F0;border-bottom:1px solid #F0F0F0;"><b><?php echo __('product_cost_label');?></b></th>
                            <th width="150" style="border-top:1px solid #F0F0F0;border-bottom:1px solid #F0F0F0;" align="center"><b><?php echo __('quantity_label');?></b></th>
                            <th width="150" style="border-top:1px solid #F0F0F0;border-bottom:1px solid #F0F0F0;" align="center"><b><?php echo __('sub_total_label');?></b></th>
                        </tr>
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
                        <tr>
                            <td width="350" align="left" style="border-top:1px solid #F0F0F0;border-bottom:1px solid #F0F0F0;"><p style="margin-left:30px;width:199px;"><?php echo ucfirst($trans['product_name']);?></p></td>
                            <td width="150" align="center" style="border-top:1px solid #F0F0F0;border-bottom:1px solid #F0F0F0;"><p style="width:200px;"><?php echo $site_currency." ".Commonfunction::numberformat($trans['product_cost']);?></p></td>
                            <td width="150" align="center" style="border-top:1px solid #F0F0F0;border-bottom:1px solid #F0F0F0;"><p><?php echo $trans['quantity'];?></p></td>
                            <td width="150" align="left" style="border-top:1px solid #F0F0F0;border-bottom:1px solid #F0F0F0;"><span>
			    <?php
			    
			    $subamt=$trans['quantity']*$trans['product_cost'];
			     
			    echo $site_currency." ".Commonfunction::numberformat($subamt);
			    $subamtarr[]=$subamt;
			    ?>
			    
			    </span></td>
                        </tr>                        
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
                    </table>
                  
                    <!--price_details2-->
                    <div class="fr right_price_details">
                        <div class="right_price1" style="width:740px;padding-right:20px;">
                            <p><?php echo __('shipping_handing'); ?></p>
                        </div>
                        <div class="right_price2" style="width:150px;text-align:left;"><b><?php echo $site_currency." ".Commonfunction::numberformat($sfee);?>  </b></div>
                    </div> 
                    <!--Total_price-->
                    <div class="fr right_price_details2">
                        <div class="right_price12" style="width:740px;"> <b><?php echo __('grand_total'); ?></b> </div>
                        <div class="right_price22" style="width:150px;text-align:left;"><b><?php
			
			echo $site_currency." ".Commonfunction::numberformat(array_sum($subamtarr)+$sfee);?> </b></div>
                    </div>
                </div>

                <div class="action_deal_list_btm">
                    <div class="action_deal_list_btm_lft">
                        <p><?php echo __('forgot_an_label');?> <a href="<?php echo URL_BASE;?>site/buynow/addtocart_list" title="<?php echo __('edit_cart_label');?>"><?php echo __('edit_cart_label');?></a></p>
                    </div>
                    <div class="action_deal_list_btm_rft">
                        <div class="place_order_lft"></div>
                        <div class="place_order_mid">
			<?php
			
				if($useramount >= (array_sum($subamtarr)+$sfee)){ ?>

				<a href="<?php echo URL_BASE;?>site/buynow/buynow_offline/<?php echo $trans['product_id'];?>" title="<?php echo __('pay_label');?>"><?php echo __('pay_label');?></a>
				<?php	}else{ call_user_func_array('Commonfunction::showlinkmultipledata', $param); ?>
<?php 			/*	<a href="<?php echo URL_BASE;?>site/buynow/buynow_auction/<?php echo $trans['userid'];?>" title="<?php echo __('pay_label');?>"><?php echo __('pay_label');?></a>
*/  ?>
				<?php } ?>
			 </div>
                        <div class="place_order_rft"></div>
                    </div>
                </div>
            </div>
        </div>
 
<div class="auction-bl fl clr" style="width:100%;">
    <div class="auction-br">
    <div class="auction-bm">
    </div>
    </div>
    </div>
<script type="text/javascript">
$(document).ready(function () {$("#users_menu").addClass("fl active");$("#addtocart_list_active").addClass("user_link_active");});
</script>
