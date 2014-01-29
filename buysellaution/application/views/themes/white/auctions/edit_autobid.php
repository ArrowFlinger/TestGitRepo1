<?php defined("SYSPATH") or die("No direct script access.");?>
<div class="my_message_right" id="edit_autobid_page">
	<div class="message_common_border">
		<h1 class="left_top_title" title="<?php echo strtoupper(__('auto_bid_lable'));?>"><?php echo strtoupper(__('auto_bid_lable'));?></h1>
		<p class="right_border_bg">&nbsp;</p>
	</div>
   <form name="setautobid" action="<?php echo URL_BASE;?>auctions/edit_setautobid/<?php echo $product[0]['product_id']; ?>" method="post">
	<div class="message_common">
		<div class="login_middle_common_profil">
		<div class="user_name_common">
			<p><?php echo __('product_name');?> <span class="red">*</span>  :</p>
			<div class="text_feeld">
				<h2>  <?php  echo Form::input('product_name', isset($form_values['product_name'])?$form_values['product_name']:$autobid_products[0]['product_name'],array("id"=>"product_name",'readonly',"Maxlength"=>"20")); ?></h2>
			</div>
				<label class="errore_msg fl clr"><span class="red"><?php if($errors && array_key_exists('product_name',$errors)){  echo (array_key_exists('product_name',$errors))? $errors['product_name']:""; }?></span></label>
			</div>
		  <input type="hidden" name="product_id" value="<?php if(isset($product[0]['product_id'])){ echo $product[0]['product_id']; } ?>" >
		<div class="user_name_common">
			<p><?php echo __('auto_bid_edit_amount_label');?><span class="red">*</span> :</p>
			<div class="text_feeld">
				<h2><?php  echo Form::input('bid_amount', isset($form_values['bid_amount'])?$form_values['bid_amount']:$autobid_products[0]['bid_amount'],array("id"=>"bid_amount","Maxlength"=>"20")) ?></h2>
			</div>
				<label class="errore_msg fl clr"><span class="red"><?php  if($errors && array_key_exists('bid_amount',$errors)){ echo (array_key_exists('bid_amount',$errors))? $errors['bid_amount']:""; }?></span></label>
			</div>
		 <div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
		<div class="user_name_common">
		<div class=" buton_green">
		
			<div class="profil_butoon">
			<div class="res_left"></div>
			<div class="res_mid"><a ><input type="submit" name="setbid_amount" value="<?php echo strtoupper(__('button_update')); ?>"  title="<?php echo strtoupper(__('button_update')); ?>"/></a></div>
			<div class="res_right"></div>
			</div>

			<div class="profil_butoon">
			<div class="res_left"></div>
			<div class="res_mid"><a ><input type="button" title="<?php echo __('button_back'); ?>" value="<?php echo __('button_back'); ?>" onclick="location.href='<?php echo URL_BASE;?>auctions/setautobid'" /></a></div>
			<div class="res_right"></div>
			</div>

			
		</div>
		</div>
		</div>
	</div>
	</div>
	</div>
</div>
</div>
</form>
<script type="text/javascript">
$(document).ready(function () {$("#autobid_active").addClass("act_class");});
</script>
