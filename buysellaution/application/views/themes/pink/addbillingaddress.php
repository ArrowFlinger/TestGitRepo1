<?php defined("SYSPATH") or die("No direct script access."); ?>
<!--- Select box SCRIPT START-->
<script type="text/javascript">

/*
CUSTOM FORM ELEMENTS
Created by Ryan Fait
www.ryanfait.com
The only things you may need to change in this file are the following
variables: checkboxHeight, radioHeight and selectWidth (lines 24, 25, 26)
The numbers you set for checkboxHeight and radioHeight should be one quarter
of the total height of the image want to use for checkboxes and radio
buttons. Both images should contain the four stages of both inputs stacked
on top of each other in this order: unchecked, unchecked-clicked, checked,
checked-clicked.
You may need to adjust your images a bit if there is a slight vertical
movement during the different stages of the button activation.
The value of selectWidth should be the width of your select list image.
Visit http://ryanfait.com/ for more information.
*/

var checkboxHeight = "25";
var radioHeight = "25";
var selectWidth = "250";
/* No need to change anything after this */
document.write('<style type="text/css">input.styled { display: none; } select.styled { position: relative; width: ' + selectWidth + 'px; opacity: 0; filter: alpha(opacity=0); z-index: 5; } .disabled { opacity: 0.5; filter: alpha(opacity=50); }</style>');
var Custom = {
	init: function() {
		var inputs = document.getElementsByTagName("input"), span = Array(), textnode, option, active;
		for(a = 0; a < inputs.length; a++) {
			if((inputs[a].type == "checkbox" || inputs[a].type == "radio") && inputs[a].className == "styled") {
				span[a] = document.createElement("span");
				span[a].className = inputs[a].type;
				if(inputs[a].checked == true) {
					if(inputs[a].type == "checkbox") {
						position = "0 -" + (checkboxHeight*2) + "px";
						span[a].style.backgroundPosition = position;
					} else {
						position = "0 -" + (radioHeight*2) + "px";
						span[a].style.backgroundPosition = position;
					}
				}
				inputs[a].parentNode.insertBefore(span[a], inputs[a]);
				inputs[a].onchange = Custom.clear;
				if(!inputs[a].getAttribute("disabled")) {
					span[a].onmousedown = Custom.pushed;
					span[a].onmouseup = Custom.check;
				} else {
					span[a].className = span[a].className += " disabled";
				}
			}
		}
		inputs = document.getElementsByTagName("select");
		for(a = 0; a < inputs.length; a++) {
			if(inputs[a].className == "styled") {
				option = inputs[a].getElementsByTagName("option");
				active = option[0].childNodes[0].nodeValue;
				textnode = document.createTextNode(active);
				for(b = 0; b < option.length; b++) {
					if(option[b].selected == true) {
						textnode = document.createTextNode(option[b].childNodes[0].nodeValue);
					}
				}
				span[a] = document.createElement("span");
				span[a].className = "select";
				span[a].id = "select" + inputs[a].name;
				span[a].appendChild(textnode);
				inputs[a].parentNode.insertBefore(span[a], inputs[a]);
				if(!inputs[a].getAttribute("disabled")) {
					inputs[a].onchange = Custom.choose;
				} else {
					inputs[a].previousSibling.className = inputs[a].previousSibling.className += " disabled";
				}
			}
		}
		document.onmouseup = Custom.clear;
	},
	pushed: function() {
		element = this.nextSibling;
		if(element.checked == true && element.type == "checkbox") {
			this.style.backgroundPosition = "0 -" + checkboxHeight*3 + "px";
		} else if(element.checked == true && element.type == "radio") {
			this.style.backgroundPosition = "0 -" + radioHeight*3 + "px";
		} else if(element.checked != true && element.type == "checkbox") {
			this.style.backgroundPosition = "0 -" + checkboxHeight + "px";
		} else {
			this.style.backgroundPosition = "0 -" + radioHeight + "px";
		}
	},
	check: function() {
		element = this.nextSibling;
		if(element.checked == true && element.type == "checkbox") {
			this.style.backgroundPosition = "0 0";
			element.checked = false;
		} else {
			if(element.type == "checkbox") {
				this.style.backgroundPosition = "0 -" + checkboxHeight*2 + "px";
			} else {
				this.style.backgroundPosition = "0 -" + radioHeight*2 + "px";
				group = this.nextSibling.name;
				inputs = document.getElementsByTagName("input");
				for(a = 0; a < inputs.length; a++) {
					if(inputs[a].name == group && inputs[a] != this.nextSibling) {
						inputs[a].previousSibling.style.backgroundPosition = "0 0";
					}
				}
			}
			element.checked = true;
		}
	},
	clear: function() {
		inputs = document.getElementsByTagName("input");
		for(var b = 0; b < inputs.length; b++) {
			if(inputs[b].type == "checkbox" && inputs[b].checked == true && inputs[b].className == "styled") {
				inputs[b].previousSibling.style.backgroundPosition = "0 -" + checkboxHeight*2 + "px";
			} else if(inputs[b].type == "checkbox" && inputs[b].className == "styled") {
				inputs[b].previousSibling.style.backgroundPosition = "0 0";
			} else if(inputs[b].type == "radio" && inputs[b].checked == true && inputs[b].className == "styled") {
				inputs[b].previousSibling.style.backgroundPosition = "0 -" + radioHeight*2 + "px";
			} else if(inputs[b].type == "radio" && inputs[b].className == "styled") {
				inputs[b].previousSibling.style.backgroundPosition = "0 0";
			}
		}
	},
	choose: function() {
		option = this.getElementsByTagName("option");
		for(d = 0; d < option.length; d++) {
			if(option[d].selected == true) {
				document.getElementById("select" + this.name).childNodes[0].nodeValue = option[d].childNodes[0].nodeValue;
			}
		}
	}
}
window.onload = Custom.init;
</script>
<div class="action_content_left fl">
       <div class="title-left title_temp1">
        <div class="title-right">
        <div class="title-mid">
    		<h2 class="fl clr pl10" title="<?php echo __('add_billing_address');?>"><?php echo __('add_billing_address');?></h2>
        </div>
        </div>
      </div>
    <div class="action_deal_list  clearfix">
  <div class="edit_content fl clr mt20 ml15 pb20">
	<div id="pass">
        <!-- Add billing address-->
        <div class="form_tabel">
        <?php echo Form::open("",array('name'=>'billing','id'=>'billing')); ?>
	
        <!-- name -->
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><p><?php echo __('name_label');?> <span class="red">*</span>:</p></div>
                <div class="colm2_width fl">
                        <div class="inputbox_out fl">
                        <?php echo Form::input('name', isset($form_values['name'])?$form_values['name']:__('enter_name'),array("id"=>"name","Maxlength"=>"20",'title' =>__('enter_name'),'onfocus'=>'label_onfocus("name","'.__('enter_name').'")','onblur'=>'label_onblur("name","'.__('enter_name').'")')) ?>
                        </div>
                <?php 
                if($errors && array_key_exists('name',$errors)){?><label class="errore_msg fl clr"><span class="red"><?php echo (array_key_exists('name',$errors))? $errors['name']:"";?></span></label><?php }
                ?>
                </div>
        </div>
	
        <!-- Address line1 -->
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><p><?php echo __('address_line1');?> <span class="red">*</span>:</p></div>
                <div class="colm2_width fl">	
                        <div class="inputbox_out fl">
                        <?php  echo Form::input('address1', isset($form_values['address1'])?$form_values['address1']:__('enter_address1'),array("id"=>"address_line1","Maxlength"=>"50",'title'=>__('address_line1'),'onfocus'=>'label_onfocus("address_line1","'.__('enter_address1').'")','onblur'=>'label_onblur("address_line1","'.__('enter_address1').'")')) ?>
                        </div>    
                <?php if($errors && array_key_exists('address1',$errors)){?> <label class="errore_msg fl clr"><span class="red"><?php  echo (array_key_exists('address1',$errors))? $errors['address1']:"";?></span></label><?php }?>
                </div>
        </div>	

        <!-- Address line2 -->
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><p><?php echo __('address_line2');?>:</p></div>
                <div class="colm2_width fl">	
                        <div class="inputbox_out fl">
                        <?php  echo Form::input('address2', isset($form_values['address2'])?$form_values['address2']:__('enter_address2'),array("id"=>"address_line2","Maxlength"=>"50",'title'=>__('address_line2'),'onfocus'=>'label_onfocus("address_line2","'.__('enter_address2').'")','onblur'=>'label_onblur("address_line2","'.__('enter_address2').'")')) ?>
                        </div>    
                <?php if($errors && array_key_exists('address2',$errors)){?><label class="errore_msg fl clr"><span class="red"><?php  echo (array_key_exists('address2',$errors))? $errors['address2']:"";?></span></label><?php }?>
                </div>
        </div>

        <!--Country-->
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><p><?php echo __('country_label');?> <span class="red">*</span>:</p></div>
                <div class="colm2_width fl">
                        <div class="selectbox_out inputbox_out fl">
                        <span class="select"></span>
                        <?php 
                        echo Form::select('country',Arr::merge(array("-1"=>"Select Country"),$allcountries),$form_values['country'],array('class' => 'styled'));?>
                        </div>
                <?php if($errors && array_key_exists('country',$errors)){?><label class="errore_msg fl">
                <span class="red"><?php echo (array_key_exists('country',$errors))? $errors['country']:"";?></span>
                </label><?php }?>
                </div>
        </div>

        <!-- City-->
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><p><?php echo __('city_label');?> <span class="red">*</span>:</p></div>
                <div class="colm2_width fl">	
                        <div class="inputbox_out fl">
                        <?php  echo Form::input('city', isset($form_values['city'])?$form_values['city']:__('enter_city'),array("id"=>"city","Maxlength"=>"20",'title'=>__('city_label'),'onfocus'=>'label_onfocus("city","'.__('enter_city').'")','onblur'=>'label_onblur("city","'.__('enter_city').'")')) ?>
                        </div>    
                <?php if($errors && array_key_exists('city',$errors)){?> <label class="errore_msg fl clr"><span class="red"><?php  echo (array_key_exists('city',$errors))? $errors['city']:"";?></span></label><?php }?>
                </div>
        </div>

        <!-- Town-->
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><p><?php echo __('town_label');?>:</p></div>
                <div class="colm2_width fl">	
                        <div class="inputbox_out fl">
                        <?php  echo Form::input('town', isset($form_values['town'])?$form_values['town']:__('enter_town'),array("id"=>"town","Maxlength"=>"20",'title'=>__('town'),'onfocus'=>'label_onfocus("town","'.__('enter_town').'")','onblur'=>'label_onblur("town","'.__('enter_town').'")')) ?>
                        </div>    
                <?php if($errors && array_key_exists('town',$errors)){?><label class="errore_msg fl clr"><span class="red"><?php  echo (array_key_exists('town',$errors))? $errors['town']:"";?></span></label><?php }?>
                </div>
        </div>

        <!-- pincode-->
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><p><?php echo __('zipcode_label');?> <span class="red">*</span>:</p></div>
                <div class="colm2_width fl">	
                        <div class="inputbox_out fl">
                        <?php  echo Form::input('zipcode', isset($form_values['zipcode'])?$form_values['zipcode']:__('enter_zipcode'),array("id"=>"zipcode","Maxlength"=>"10",'title'=>__('zipcode_label'),'onfocus'=>'label_onfocus("zipcode","'.__('enter_zipcode').'")','onblur'=>'label_onblur("zipcode","'.__('enter_zipcode').'")')) ?>
                        </div>    
                <?php if($errors && array_key_exists('zipcode',$errors)){?><label class="errore_msg fl clr"><span class="red"><?php  echo (array_key_exists('zipcode',$errors))? $errors['zipcode']:"";?></span></label><?php }?>
                </div>
        </div>
	
        <!-- Phone-->
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><p><?php echo __('phone_label');?> <span class="red">*</span>:</p></div>
                <div class="colm2_width fl">	
                        <div class="inputbox_out fl">
                        <?php  echo Form::input('phone', isset($form_values['phone'])?$form_values['phone']:__('enter_phone'),array("id"=>"phone","Maxlength"=>"20",'title'=>__('phone_label'),'onfocus'=>'label_onfocus("phone","'.__('enter_phone').'")','onblur'=>'label_onblur("phone","'.__('enter_phone').'")')) ?>
                        </div>    
                <?php if($errors && array_key_exists('phone',$errors)){?><label class="errore_msg fl clr"><span class="red"><?php  echo (array_key_exists('phone',$errors))? $errors['phone']:"";?></span></label><?php }?>
                <div style="color:#999; float:left;"><?php echo __('ex_telephone_label');?></div>
                </div>
                
        </div>
	
        <!--Submit button-->
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><b class="fl">&nbsp;</b></div>
                <div class="login_submit_btn fl">
                        <span class="login_submit_btn_left fl">&nbsp;</span>
                        <span class="login_submit_btn_middle fl"><?php echo Form::submit('addaddress',__('add'),array('title'=>__('add')));?></span>
                        <span class="login_submit_btn_left login_submit_btn_right fl">&nbsp;</span>
                </div>
        </div>

        <?php echo Form::close() ?>
        </div>
	<!--End of add billing address-->
        <div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
	<!-- End of change password-->
   </div>
</div>
<!--BACK LINK START-->
    <div class="back_link_out fl clr pb20">
        <a href="<?php echo URL_BASE;?>users/myaddresses" title="<?php echo __('back_to_addresses');?>" class="back_link fr"><?php echo __('back_to_addresses');?></a>
    </div>
    <!--BACK LINK END-->
    </div>
    <div class="auction-bl">
    <div class="auction-br">
    <div class="auction-bm">
    </div>
    </div>
    </div>
</div><script type="text/javascript">
$(document).ready(function () {$("#users_menu").addClass("fl active");$("#my_addresses_active").addClass("user_link_active");});
</script>
