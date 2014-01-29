<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="my_message_right">
	<div class="message_common_border">
		<h1 style="width:170px;" title="<?php echo strtoupper(__('edit_shipping_address'));?>"><?php echo strtoupper(__('edit_shipping_address'));?></h1>
		<p style="width:549px;">&nbsp;</p>
	</div>
	 <?php echo Form::open("",array('name'=>'shipping','id'=>'shipping')); ?>
	<div class="message_common">

		<div class="login_middle_common_profil">
			<div class="user_name_common">
				<p><?php echo __('name_label');?><span class="red">*</span>  :</p>
				<div class="text_feeld">
					<h2>
						<?php echo Form::input('name', isset($form_values['name'])?$form_values['name']:$db_values[0]['name'],array("id"=>"name","Maxlength"=>"20",'title' =>__('name_label'))) ?>
					</h2>
				</div>
				<label class="errore_msg fl clr"><span class="red"><?php if($errors && array_key_exists('name',$errors)){  echo (array_key_exists('name',$errors))? $errors['name']:""; }?></span></label>
			</div>

			<div class="user_name_common">
				<p><?php echo __('address_line1');?><span class="red">*</span> :</p>
				<div class="text_feeld">
					<h2>
						<?php $address=explode(" + ",$db_values[0]['address']);
							   echo Form::input('address1', isset($form_values['address1'])?$form_values['address1']:$address[0],array("id"=>"address_line1","Maxlength"=>"50",'title'=>__('address_line1'))) ?>
					</h2>
				</div>
				<label class="errore_msg fl clr"><span class="red"><?php  if($errors && array_key_exists('address1',$errors)){ echo (array_key_exists('address1',$errors))? $errors['address1']:""; }?></span></label>
			</div>
			<div class="user_name_common">
				<p><?php echo __('address_line2');?>  :</p>
				<div class="text_feeld">
					<h2>
						<?php  $address2=(array_key_exists(1,$address))?$address[1]:__('enter_address2');
											echo Form::input('address2',isset($form_values['address2'])?$form_values['address2']:$address2,array("id"=>"address_line2","Maxlength"=>"50",'title'=>__('address_line2'))) ?>
					</h2>
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
					<h2>
						<?php  echo Form::input('city', isset($form_values['city'])?$form_values['city']:$db_values[0]['city'],array("id"=>"city","Maxlength"=>"20",'title'=>__('city_label'))) ?>
					</h2>
				</div>
				   <label class="errore_msg fl clr"><span class="red"> <?php if($errors && array_key_exists('city',$errors)){?><?php  echo (array_key_exists('city',$errors))? $errors['city']:"";?><?php }?></span></label>
			</div>
			<div class="user_name_common">
				<p><?php echo __('town_label');?> :</p>
				<div class="text_feeld">
					<h2>
						<?php  $town=($db_values[0]['town']!="")?$db_values[0]['town']:"";
							echo Form::input('town',isset($form_values['town'])?$form_values['town']:$town,array("id"=>"town","Maxlength"=>"50",'title'=>__('town'))) ?>
					</h2>
				</div>
				<label class="errore_msg fl clr"><span class="red">   <?php if($errors && array_key_exists('town',$errors)){?><?php  echo (array_key_exists('town',$errors))? $errors['town']:"";?><?php }?></span></label>
			</div>
			<div class="user_name_common">
				<p><?php echo __('zipcode_label');?><span class="red">*</span> :</p>
				<div class="text_feeld">
					<h2>
						<?php  echo Form::input('zipcode',isset($form_values['zipcode'])?$form_values['zipcode']:$db_values[0]['zipcode'],array("id"=>"zipcode","Maxlength"=>"10",'title'=>__('zipcode_label'))) ?>
					</h2>
				</div>
				<label class="errore_msg fl clr"><span class="red"> <?php if($errors && array_key_exists('zipcode',$errors)){?><?php  echo (array_key_exists('zipcode',$errors))? $errors['zipcode']:"";?><?php }?></span></label>
			</div>

			<div class="user_name_common">
				<p><?php echo __('phone_label');?><span class="red">*</span>  :</p>
				<div class="text_feeld">
					<h2><?php $phone=($db_values[0]['phoneno']!="")?$db_values[0]['phoneno']:"";
											echo Form::input('phone',isset($form_values['phone'])?$form_values['phone']:$phone,array("id"=>"phone","Maxlength"=>"20",'title'=>__('phone_label'))) ?>
					</h2>
				</div>
				<label class="errore_msg fl clr"><span class="red"><?php if($errors && array_key_exists('phoneno',$errors)){?><?php  echo (array_key_exists('phoneno',$errors))? $errors['phoneno']:"";?><?php }?></span></label>
			</div>
			 <div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
			<div class="user_name_common">
			<div class=" buton_green">
				<div class="profil_butoon">
				<div class="save_left"></div>
				<div class="save_mid"><a href="<?php echo URL_BASE;?>users/myaddresses" title="<?php echo strtoupper(__('back_button'));?>"><input type="button" value="<?php echo strtoupper(__('back_button'));?>" title="<?php echo strtoupper(__('back_button'));?>"/></a>
			</div>
			<div class="save_right"></div>
			</div>
			<div class="profil_butoon">
			<div class="res_left"></div>
			<div class="res_mid"><a ><input type="submit" name="editaddress" value="<?php echo strtoupper(__('button_update')); ?>"  title="<?php echo strtoupper(__('button_update')); ?>"/></a></div>
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
  <?php echo Form::close(); ?>
 <script type="text/javascript">
$(document).ready(function () {$("#my_addresses_active").addClass("act_class");});
</script>
</script>
