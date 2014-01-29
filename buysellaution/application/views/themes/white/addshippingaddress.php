<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="my_message_right">
	<div class="message_common_border">
		<h1 style="width:168px;" title="<?php echo strtoupper(__('add_shipping_address'));?>"><?php echo strtoupper(__('add_shipping_address'));?></h1>
		<p style="width:551px;">&nbsp;</p>
	</div>
	 <?php echo Form::open("",array('name'=>'shipping','id'=>'shipping')); ?>
	<div class="message_common">
		<div class="login_middle_common_profil">
			<div class="user_name_common">
				<p><?php echo __('name_label');?><span class="red">*</span>  :</p>
				<div class="text_feeld">
					<h2>
						<?php echo Form::input('name', isset($_POST['name'])?$_POST['name']:__('enter_name'),array("id"=>"name","Maxlength"=>"20",'title' =>__('enter_name'),'onfocus'=>'label_onfocus("name","'.__('enter_name').'")','onblur'=>'label_onblur("name","'.__('enter_name').'")')) ?>
					</h2>
				</div>
				<label class="errore_msg fl clr"><span class="red"><?php if($errors && array_key_exists('name',$errors)){  echo (array_key_exists('name',$errors))? $errors['name']:""; }?></span></label>
			</div>

			<div class="user_name_common">
				<p><?php echo __('address_line1');?><span class="red">*</span> :</p>
				<div class="text_feeld">
					<h2>
						<?php  echo Form::input('address1', isset($_POST['address1'])?$_POST['address1']:__('enter_address1'),array("id"=>"address_line1","Maxlength"=>"50",'title'=>__('address_line1'),'onfocus'=>'label_onfocus("address_line1","'.__('enter_address1').'")','onblur'=>'label_onblur("address_line1","'.__('enter_address1').'")')) ?>
					</h2>
				</div>
				<label class="errore_msg fl clr"><span class="red"><?php  if($errors && array_key_exists('address1',$errors)){ echo (array_key_exists('address1',$errors))? $errors['address1']:""; }?></span></label>
			</div>

			<div class="user_name_common">
				<p><?php echo __('address_line2');?>  :</p>
				<div class="text_feeld">
					<h2>
						<?php  echo Form::input('address2', isset($_POST['address2'])?$_POST['address2']:__('enter_address2'),array("id"=>"address_line2","Maxlength"=>"50",'title'=>__('address_line2'),'onfocus'=>'label_onfocus("address_line2","'.__('enter_address2').'")','onblur'=>'label_onblur("address_line2","'.__('enter_address2').'")')) ?>
					</h2>
				</div>
				<label class="errore_msg fl clr"><span class="red"><?php  if($errors && array_key_exists('address2',$errors)){  echo (array_key_exists('address2',$errors))? $errors['address2']:""; }?></span></label>
			</div>
			<div class="user_name_common">
				<p><?php echo __('country_label');?><span class="red">*</span> :</p>
				<div >
					 <?php	echo Form::select('country',Arr::merge(array("-1"=>"Select Country"),$allcountries),isset($_POST['country'])?$_POST['country']:-1);?>
				</div>
				 <label class="errore_msg fl">
								<span class="red">  <?php if($errors && array_key_exists('country',$errors)){?><?php echo (array_key_exists('country',$errors))? $errors['country']:"";?><?php }?></span>
				 </label>
			</div>


			<div class="user_name_common">
				<p><?php echo __('city_label');?><span class="red">*</span>  :</p>
				<div class="text_feeld">
					<h2>
						<?php  echo Form::input('city', isset($_POST['city'])?$_POST['city']:__('enter_city'),array("id"=>"city","Maxlength"=>"20",'title'=>__('city_label'),'onfocus'=>'label_onfocus("city","'.__('enter_city').'")','onblur'=>'label_onblur("city","'.__('enter_city').'")')) ?>
					</h2>
				</div>
							   <label class="errore_msg fl clr"><span class="red"> <?php if($errors && array_key_exists('city',$errors)){?><?php  echo (array_key_exists('city',$errors))? $errors['city']:"";?><?php }?></span></label>
			</div>


			<div class="user_name_common">
				<p><?php echo __('town_label');?> :</p>
				<div class="text_feeld">
					<h2>
						<?php  echo Form::input('town', isset($_POST['town'])?$_POST['town']:__('enter_town'),array("id"=>"town","Maxlength"=>	"20",'title'=>__('town'),'onfocus'=>'label_onfocus("town","'.__('enter_town').'")','onblur'=>'label_onblur("town","'.__('enter_town').'")')) ?>
					</h2>
				</div>
						   <label class="errore_msg fl clr"><span class="red">   <?php if($errors && array_key_exists('town',$errors)){?><?php  echo (array_key_exists('town',$errors))? $errors['town']:"";?><?php }?></span></label>
			</div>
			<div class="user_name_common">
				<p><?php echo __('zipcode_label');?><span class="red">*</span> :</p>
				<div class="text_feeld">
					<h2>
						<?php  echo Form::input('zipcode', isset($_POST['zipcode'])?$_POST['zipcode']:__('enter_zipcode'),array("id"=>"zipcode","Maxlength"=>"10",'title'=>__('zipcode_label'),'onfocus'=>'label_onfocus("zipcode","'.__('enter_zipcode').'")','onblur'=>'label_onblur("zipcode","'.__('enter_zipcode').'")')) ?>
					</h2>
				</div>
				<label class="errore_msg fl clr"><span class="red"> <?php if($errors && array_key_exists('zipcode',$errors)){?><?php  echo (array_key_exists('zipcode',$errors))? $errors['zipcode']:"";?><?php }?></span></label>
						
			</div>
			<div class="user_name_common">
				<p><?php echo __('phone_label');?> <span class="red">*</span>:</p>
				<div class="text_feeld">
					<h2>
						<?php  echo Form::input('phone', isset($_POST['phone'])?$_POST['phone']:__('enter_phone'),array("id"=>"phone","Maxlength"=>"20",'title'=>__('phone_label'),'onfocus'=>'label_onfocus("phone","'.__('enter_phone').'")','onblur'=>'label_onblur("phone","'.__('enter_phone').'")')) ?>
					</h2>
				</div>
				<label class="errore_msg fl clr"><span class="red"><?php if($errors && array_key_exists('phone',$errors)){?><?php  echo (array_key_exists('phone',$errors))? $errors['phone']:"";?><?php }?></span></label>
				<div style="color:#999; float:left"><?php echo __('ex_telephone_label');?></div>
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
				<div class="res_mid"><a ><input type="submit" name="addaddress" value="<?php echo strtoupper(__('add')); ?>"  title="<?php echo strtoupper(__('add')); ?>"/></a></div>
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
