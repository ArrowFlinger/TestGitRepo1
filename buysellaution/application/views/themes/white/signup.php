<?php defined("SYSPATH") or die("No direct script access.");?>
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
		option = this.getElementsByTagName("option");document.forms['lang'].submit();
		for(d = 0; d < option.length; d++) {
			if(option[d].selected == true) {
				document.getElementById("select" + this.name).childNodes[0].nodeValue = option[d].childNodes[0].nodeValue;
			}
		}
	}
}
window.onload = Custom.init;

</script>


	<div class="signup_head">
		<ul>
			<li><a href="" title="<?php echo __('menu_home')?>"> <?php echo __('menu_home')?></a></li>
			<li><a><img src="<?php echo IMGPATH;?>arr_bg.png" width="13" height="11" alt="Arrow" /></a></li>
			<li class="active"><a href="" title="<?php echo ucfirst(__('menu_register'))?>"><?php echo __('menu_register')?></a></li>
		</ul>
	</div>
	<div class="signup-part"><h2><?php echo __('menu_register')?></h2></div>
	<div class="signup_middle">
		<div class="signup_lft">
			<div class="signup_form">
			<?php echo Form::open(NULL,array('method'=>'post','enctype' => 'multipart/form-data'));?>
				<div class="">
					<div class="log_fields">
						<div class="colm1_width fl"><p><?php echo __('username_label');?> <span class="red">*</span>:</p></div>
						<?php echo Form::input('username',isset($_POST['username'])?$_POST['username']:__('enter_username'),array('maxlength'=>'20','class'=>'textbox','id'=>'username','onfocus'=>'label_onfocus("username","'.__('enter_username').'")','onblur'=>'label_onblur("username","'.__('enter_username').'")'));?>
						</div>
						<label><span class="red"><?php if($errors){echo (array_key_exists('username',$errors))? $errors['username']:"";}?></span></label>
				</div>
				<div class="">
					<div class="log_fields">
						<div class="colm1_width fl"><p><?php echo __('email_label');?> <span class="red">*</span>:</p></div>
						<?php echo Form::input('email',isset($_POST['email'])?$_POST['email']:__('enter_email'),array('maxlength'=>'30','class'=>'textbox','id'=>'email','onfocus'=>'label_onfocus("email","'.__('enter_email').'")','onblur'=>'label_onblur("email","'.__('enter_email').'")'));?>
						</div>
						<label style="width:250px;"><span class="red"><?php if($errors){echo (array_key_exists('email',$errors))? $errors['email']:"";}?></span></label>
				</div>
				<div class="">
					<div class="log_fields">
						<div class="colm1_width fl"><p><?php echo __('password_label');?> <span class="red">*</span>:</p></div>
						<?php echo Form::password('password',isset($_POST['password'])?$_POST['password']:__('enter_password'),array('maxlength'=>'20','class'=>'textbox','id'=>'password','onfocus'=>'label_onfocus("password","'.__('enter_password').'")','onblur'=>'label_onblur("password","'.__('enter_password').'")'));?>
						 </div>
						<label style="width:205px;"><span class="red"><?php if($errors){echo (array_key_exists('password',$errors))? $errors['password']:"";}?></span></label>
				</div>
				<div class="">
					<div class="log_fields">
						<div class="colm1_width fl"><p><?php echo __('retype_password_label');?>  <span class="red">*</span>:</p></div>
						<?php echo Form::password('repassword',isset($_POST['repassword'])?$_POST['repassword']:__('enter_repasswo'),array('maxlength'=>'20','class'=>'textbox','id'=>'repassword','onfocus'=>'label_onfocus("repassword","'.__('enter_repasswo').'")','onblur'=>'label_onblur("repassword","'.__('enter_repasswo').'")'));?>
						</div>
						<span class="red"><?php if($errors){echo (array_key_exists('repassword',$errors))? $errors['repassword']:"";}?></span>
				</div>
				<div class="">
					<div class="log_fields">
						<div class="colm1_width fl"><p><?php echo __('firstname_label');?>  <span class="red">*</span>:</p></div>
						<?php echo Form::input('firstname',isset($_POST['firstname'])?$_POST['firstname']:__('enter_firstname'),array('maxlength'=>'20','class'=>'textbox','id'=>'firstname','onfocus'=>'label_onfocus("firstname","'.__('enter_firstname').'")','onblur'=>'label_onblur("firstname","'.__('enter_firstname').'")'));?>
						</div>
						<span class="red"><?php if($errors){echo (array_key_exists('firstname',$errors))? $errors['firstname']:"";}	?></span>
				</div>
				<div class="" style="float:left;">
					<div class="log_fields">
						<div class="colm1_width fl" style="clear:both;width:100%;"><p><?php echo __('lastname_label');?>:</p></div>
						<?php echo Form::input('lastname',isset($_POST['lastname'])?$_POST['lastname']:__('enter_lastname'),array('maxlength'=>'20','class'=>'textbox','id'=>'lastname','onfocus'=>'label_onfocus("lastname","'.__('enter_lastname').'")','onblur'=>'label_onblur("lastname","'.__('enter_lastname').'")'));?>
						</div>
						<span class="red"><?php if($errors){ echo (array_key_exists('lastname',$errors))? $errors['lastname']:"";}?></span>
				</div>

			  <div class="">
				 <div class="log_fields fl">
					<div class="colm1_width fl"><p><?php echo __('map_details');?>:</p></div>
					 <?php echo Form::input('address1',isset($_POST['address1'])?$_POST['address1']:__('search_places'),array('maxlength'=>'40','class'=>'textbox','id'=>'address1','onfocus'=>'label_onfocus("address1","'.__('search_places').'")','onblur'=>'label_onblur("address1","'.__('search_places').'")'));?>

			<div class="but_common_right">
				<div class="but_left"></div>
				<div class="but_mid">
					<input type="button" value="<?php echo __('button_search');?>"  title="<?php echo __('button_search');?>" onclick="showAddress()" />
				</div>
				<div class="but_right"></div>
			</div>
			</div>
			
			  <div id="close_map">
				<div class="log_fields">
					<div class="colm1_width fl"></div>
					<div id="close" style="margin:-11px 0 0 440px;"class="claoser"></div><br/>
				<div id="showmap">
					<div align="center" id="map" style="width: 431px; height: 400px">
				</div>
		</div>
			</div>
			<div class="colm1_width fl"><p style="background-color:#1C5D9B;cursor:pointer;color:white;" id="selplace"><?php echo  __('click_here_to_select_this_location');?><span class="red"></span>:</p></div>
			</div>
			<?php
				//$lng=isset($_POST['lng'])?$_POST['lng']:2.33739;
				$country=isset($_POST['country'])?$_POST['country']:'';
				$address=isset($_POST['address'])?$_POST['address']:'';

				//$lat=isset($_POST['lat'])?$_POST['lat']:48.89364;
				//$long=isset($_POST['long'])?$_POST['long']:'';
				$map_canvas=isset($_POST['map_canvas'])?$_POST['map_canvas']:'';
			?>

				  <input type="hidden" id="lng" name="lng" value="<?php //echo $lng; ?>"/>
					<input type="hidden" name="country" id="country" value="<?php echo  $country; ?>">
					<input type="hidden" name="address" id="address" value="<?php echo  $address; ?>">
					<!---End-->
					<!--Map Lat&Long-->
					<input type="hidden" id="lat" name="lat" value="<?php //echo $lat; ?>"/>
				   <input type="hidden" id="long" name="long" value="<?php //echo $long; ?>"/>
					<input type="hidden" id="map_canvas" name="map_canvas" value="<?php echo $map_canvas; ?>"/>
						
			</div>
					  <div>     
				
				

				</div>

					<?php 
					if(isset($referrer_name)){?>
					<div class="row_colm1 fl clr mt20">
							<div class="colm1_width fl"><p><?php echo __('referred_label');?> :</p></div>
							<div class="colm2_width fl">
									<div class="inputbox_out fl">
									<?php echo Form::hidden('referred_id',$referrer_userid,array('maxlength'=>'20','class'=>'textbox','id'=>'referrer','readonly'=>'readonly'));?>
									<?php echo Form::input('referred_name',$referrer_name,array('maxlength'=>'20','class'=>'textbox','id'=>'referrer','readonly'=>'readonly'));?>
									</div>

							</div>
					</div>
					<?php } ?>
			<div>
			<div class="sign_box">
				<div>
				 <div class="colm1_width fl"><strong><?php echo __('enter_text_below');?> <span class="red">*</span>:</strong> </div>
				</div>
				<div>
				<?php echo Form::input('captcha',NULL,array('maxlength'=>'5','id'=>'captcha')); ?>
				<?php echo $captcha->render(); ?><p style="color:red;width:100%;float:left;clear:both;"><?php echo ($captcha_val == 0)?__('enter valid captcha')."":"";?></p>
				</div>
			</div> 
			</div>
			<div class="sign_check">
				<div class="check_opt">
			<?php $checked = isset($_POST['newsletter'])?($_POST['newsletter']==1?TRUE:FALSE):FALSE; 
									echo Form::checkbox('newsletter','1',$checked);?>
											<p class="remeber"><?php echo __('newletter_label');?>.</p>
				</div>
				<div class="check_opt">
					<?php $checked= isset($_POST['agree'])?(($_POST['agree']==1)?TRUE:FALSE):FALSE; echo Form::checkbox('agree','1',$checked);?>					
					<p  class="remeber1" ><?php echo __('i_have_read');?><?php echo __('terms_and_condition');?><?php echo __('privacy_policy_i_agree');?><a href="<?php echo url::base();?>cmspage/page/terms-conditions" title="<?php echo __('terms_and_condition');?>"></a></p>
				</div>
				<p style="color:red;width:100%;float:left;clear:both;"><?php if($errors){echo (array_key_exists('agree',$errors))? __('terms_select')."<br/>":"";}?></p>
			</div>
			<div class="sign_button">
				<div class="sign_button_lft"></div>
			<div class="sign_button_midd"><?php echo Form::submit('signup',__('button_signup'),array('title'=>__('button_signup')));?></div>
			<div class="sign_button_rgt"></div>
			</div>

			</div>
		<?php echo Form::close();?>
		</div>
		<div class="sign_rgt">
			<h2><?php echo __('already_a_member');?>?</h2>
			<p><?php echo __('If so you may want to ');?></p>
			<div class="sign_register">
				<div class="signreg_lft"></div>
				<div class="signreg_midd"><a href="<?php echo url::base();?>users/login" title="<?php echo __('menu_signin');?>"><?php echo __('menu_signin')."&raquo;";?></a><?php echo __('now ');?></div>
			<div class="signreg_rgt"></div>

		</div>
		</div>
				   
	</div>
<div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
	<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=AIzaSyDswVcpgWiYGJpLq-iVmZJCQRt-tY9Wck0"
      type="text/javascript"></script>

     <script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
$(document).ready(function () {
	load();
		
		initialize();
		
	//	$("#showmap").hide();

	$(window).load(function(){
		load();
		
		initialize();
		
		//$("#showmap").hide();
	});
	$(window).unload(function(){
		GUnload();
	});
	
	$("#loc").click(function(){
		$("#showmap").toggle(400);
	});
	$("#close").click(function(){
	   
		$("#close_map").toggle(400);
	});	
	$("#selplace").click(function(){
		var lat=$("#lat").val();
		var lng=$("#lng").val(); 
		if(lat && lng)
		{
			//alert("in");
			codeLatLng();
			$("#close_map").toggle(400);
		}
		else
		{
			alert("<?php echo __('select_a_location');?>");
		}
	});	
}); 
function load() {
      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map"));
        map.addControl(new GSmallMapControl());
        map.addControl(new GMapTypeControl());
        var center = new GLatLng(48.89364,2.33739);
        map.setCenter(center, 15);
        geocoder1 = new GClientGeocoder();
        var marker = new GMarker(center, {draggable: true});  
        map.addOverlay(marker);
       /* document.getElementById("lat").value = center.lat().toFixed(5);
        document.getElementById("lng").value = center.lng().toFixed(5);*/

	GEvent.addListener(marker, "dragend", function() {
	var point = marker.getPoint();
	map.panTo(point);
	document.getElementById("lat").value = point.lat().toFixed(5);
	document.getElementById("lng").value = point.lng().toFixed(5);
        });

	GEvent.addListener(map, "moveend", function() {
	map.clearOverlays();
	var center = map.getCenter();
	var marker = new GMarker(center, {draggable: true});
	map.addOverlay(marker);
	/*	  document.getElementById("lat").value = center.lat().toFixed(5);
	document.getElementById("lng").value = center.lng().toFixed(5);*/


	GEvent.addListener(marker, "dragend", function() {
	var point =marker.getPoint();
	map.panTo(point);
	document.getElementById("lat").value = point.lat().toFixed(5);
	document.getElementById("lng").value = point.lng().toFixed(5);

        });
 
        });

      }
    }

function showAddress() {
	var address=document.getElementById("address1").value;
	var map = new GMap2(document.getElementById("map"));
	map.addControl(new GSmallMapControl());
	map.addControl(new GMapTypeControl());
	if (geocoder1) {
	geocoder1.getLatLng(
	address,	
	function(point) {
	if (!point) {
	alert(address + "<?php echo __('map_not_found');?>");
	} else {
				
	document.getElementById("lat").value = point.lat().toFixed(5);
	document.getElementById("lng").value = point.lng().toFixed(5);
	map.clearOverlays()
	map.setCenter(point, 14);
	var marker = new GMarker(point, {draggable: true});  
	map.addOverlay(marker);

	GEvent.addListener(marker, "dragend", function() {
	var pt = marker.getPoint();
	map.panTo(pt);

	document.getElementById("lat").value = pt.lat().toFixed(5);
	document.getElementById("lng").value = pt.lng().toFixed(5);
        });

	GEvent.addListener(map, "moveend", function() {
	map.clearOverlays();
	var center = map.getCenter();
	var marker = new GMarker(center, {draggable: true});
	map.addOverlay(marker);
	GEvent.addListener(marker, "dragend", function() {
	var pt = marker.getPoint();
	map.panTo(pt);
	document.getElementById("lat").value = pt.lat().toFixed(5);
	document.getElementById("lng").value = pt.lng().toFixed(5);
	
        }); 
        });

            }
          }
        );
      }
    }	
    
    var geocoder;
  var map;
  var infowindow = new google.maps.InfoWindow();
  var marker;
  function initialize() {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(40.730885,-73.997383);
    var mapOptions = {
      zoom: 8,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
  }
  function codeLatLng() {
	 // alert("latlng");
    var input = document.getElementById("lat").value+','+document.getElementById("lng").value;
    var latlngStr = input.split(",",2);
    var lat = parseFloat(latlngStr[0]);
    var lng = parseFloat(latlngStr[1]);
    var latlng = new google.maps.LatLng(lat, lng);
  //  alert(latlng);
    geocoder.geocode({'latLng': latlng}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        if (results[1]) {
			console.log(results);
          /*map.setZoom(11);
          marker = new google.maps.Marker({
              position: latlng,
              map: map
          });
          infowindow.setContent(results[1].formatted_address);
          infowindow.open(map, marker);*/
         // alert("hi");
          document.getElementById("country").value=results[1].formatted_address;
          document.getElementById("address").value=results[0].formatted_address;
        }
      } else {
        alert("<?php echo __('geocoder_failed');?>" + status);
      }
    });
  }
</script>
