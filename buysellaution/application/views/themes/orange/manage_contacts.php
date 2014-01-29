<?php defined("SYSPATH") or die("No direct script access."); 
$sub_val = isset($srch["contact_subjectid"]) ? $srch["contact_subjectid"] :''; ?>
<!--- Select box SCRIPT START-->
<script type="text/javascript">
$(document).ready(function () {$("#signup_menu").addClass("fl active");});

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
<!--- Select box SCRIPT END-->
<div class="container_inner fl clr">
       <div class="title-left title_temp1">
        <div class="title-right">
        <div class="title-mid">
             	<h2 class="fl clr" title="<?php echo __('contact_title');?>"><?php echo __('contact_title');?></h2>
        </div>
        </div>
        </div>
       <div class="deal-left clearfix">
	<div class="action_deal_list clearfix">
<div class="login_form fl clr mt20 ml10">
<div class="fl edit_content">
	<?php echo Form::open(NULL,array('method'=>'post','enctype' => 'multipart/form-data'));?>
	<!--subject dropdown-->
	 	<div class="row_colm1 fl clr mt20">
            <div class="colm1_width fl"><p><?php echo __('subject_label');?> <span class="red">*</span>:</p></div>
            <div class="colm2_width fl">
            <div class="selectbox_out inputbox_out fl">
			<span class="select"></span>
                        <select name="contact_subjectid" id="contact_subjectid" class="styled">  
                                <?php 
                                echo "outside";
                                //Code to display  all subject   
                                //===========================
                                foreach($subject as $sub) 
                                { 
                                $selected_sub=""; 	
                                $selected_sub=($sub['id']==$sub_val) ? " selected='selected' " : ""; ?>

                                <option value="<?php echo $sub['id']; ?>" <?php echo $selected_sub;?> > 
                                <?php echo $sub['subject'];?>
                                </option>

                                <?php }?>                           
                        </select>
            </div>
		 	<label class="signup_errore_msg fl">
                <span class="red"><?php if($errors){echo (array_key_exists('subject',$errors))? ucfirst($errors['subject']):"";}?></span>
            </label>
            </div>
        </div>
		<!--firstname-->
        <div class="row_colm1 fl clr mt20">
			<div class="colm1_width fl"><p><?php echo __('username_label');?> <span class="red">*</span>:</p></div>
            <div class="colm2_width fl">
            <div class="inputbox_out fl">
              <?php if(isset($auction_userid)):?>
                    		<?php echo Form::input('name', $auction_username,array("id"=>"name","Maxlength"=>"30","readonly"=>"readonly","style"=>"height:19px;")) ?>
                    <?php endif;?>               
                
               	  <?php if(!isset($auction_userid)):?><?php echo Form::input('name', $validator['name'],array("id"=>"name","Maxlength"=>"30")) ?>
                      <?php endif;?>
            </div>
            <label class="signup_errore_msg fl">
                <span class="red"><?php echo isset($errors["name"])?ucfirst($errors["name"]):"";?></span>
            </label>  
            </div>  
		</div>
		<!--email-->
        <div class="row_colm1 fl clr mt20">
			<div class="colm1_width fl"><p><?php echo __('email_label');?><span class="red">*</span>:</p></div>
            <div class="colm2_width fl">
            <div class="inputbox_out fl">
              <?php if(isset($auction_userid)):?>
                    		<?php echo Form::input('email',isset($auction_userid)?$auction_email:$validator['email'],array("id"=>"email","Maxlength"=>"50","readonly"=>"readonly","style"=>"height:19px;")) ?>
                    <?php endif;?>               
                
               	  <?php if(!isset($auction_userid)):?><?php echo Form::input('email',isset($auction_userid)?$auction_email:$validator['email'],array("id"=>"email","Maxlength"=>"50")) ?>
                      <?php endif;?>
            </div>
            <label class="signup_errore_msg fl">
                <span class="red"><?php echo isset($errors["email"])?ucfirst($errors["email"]):"";?></span>
            </label>  
            </div>  
		</div>
		<!--Telephone-->
        <div class="row_colm1 fl clr mt20">
        	<div class="colm1_width fl"><p><?php echo __('telephone_label');?> :</p></div>
			<div class="colm2_width fl">
            <div class="inputbox_out fl">
                <?php echo Form::input('telephone', $validator['telephone'],array("id"=>"telephone","Maxlength"=>"15")) ?>
            </div>
            
            <label class="signup_errore_msg fl">
                <span class="red"><?php echo isset($errors["telephone"])?ucfirst($errors["telephone"]):"";?></span><br>
                 <span class="info_label"><?php echo __('ex_telephone_label');?></span>
            </label>    
            </div>
            </div>
		<!--Message-->
		 <div class="row_colm1 fl clr mt20">
        	<div class="colm1_width fl"><p><?php echo __('message_label');?> <span class="red">*</span>:</p></div>
			<div class="colm2_width fl">
                <div class="inputbox_out textarea_out fl">
                   <?php echo Form::textarea('message',trim($validator['message']),array("id"=>"message","maxlength"=>"255",'style'=>'resize:none;',"onkeyup"=>"return limitlength(this, 255);")) ?>
                </div>
                <label class="signup_errore_msg fl">
                    <span class="red"><?php echo isset($errors['message'])?ucfirst($errors["message"]):"";?></span>
                    <span class="info_label" id="info_label"></span><br>
                    <span class="info_label" id="info_label"><?php echo __('max_label');?>:255</span> 
                </label>   
                </div>
		</div>
			
		<!--Submit button-->
		<div class="row_colm1 fl clr  mt20">
            <div class="colm1_width fl"><b class="fl">&nbsp;</b></div>
            <div class="colm2_width fl">
                <div class="login_submit_btn fl">
                <span class="login_submit_btn_left login_submit_btn_left1 fl">&nbsp;</span>
                <span class="login_submit_btn_middle login_submit_btn_middle1 fl">
                    <input name="submit_user_profile" type="reset" value="<?php echo __('button_reset');?>" class="fl"/>
                </span>
                <span class="login_submit_btn_left login_submit_btn_right fl login_submit_btn_left1 login_submit_btn_right1">&nbsp;</span>
                </div>
                <div class="login_submit_btn fl ml20">
                <span class="login_submit_btn_left fl">&nbsp;</span>
                <span class="login_submit_btn_middle fl">
                    <input name="contact_submit" type="submit" value="<?php echo __('button_send');?>" class="fl"/>
                </span>
                <span class="login_submit_btn_left login_submit_btn_right fl">&nbsp;</span>
                </div>
            </div>	    
        </div>
</div>        
	<?php echo Form::close();?>
</div>    
</div>
</div>
 <div class="auction-bl">
        <div class="auction-br">
        <div class="auction-bm">
        </div>
        </div>
        </div>
</div> 
</div>
<div class="user" style="display:none;" ><?php echo $auction_userid;?></div>

<!--sign up-->
<script language="javascript" type="text/javascript">
	function limitlength(obj, maxlength){
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

$(document).ready(function(){
	//For Field Focus
	//===============
	field_focus('name');
}); 
		//code for select box other option
		$('#contact_subjectid').change(function() {
		  if($(this).find('option:selected').val() == "7"){
		    $("#subject").show();
		  }else{
		    $("#subject").hide();
		  }
		});
</script> 
