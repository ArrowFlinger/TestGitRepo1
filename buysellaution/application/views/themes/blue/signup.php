<?php defined("SYSPATH") or die("No direct script access."); ?> 
<!--- Select box SCRIPT START-->
<script type="text/javascript">
$(document).ready(function () {
	$("#signup_menu").addClass("fl active");
	$(window).load(function(){
		load();
		initialize();
		$("#showmap").hide();
	});
	$(window).unload(function(){
		GUnload();
	});
	
	$("#loc").click(function(){
		$("#showmap").toggle(400);
	});
	$("#close").click(function(){
		$("#showmap").toggle(400);
	});	
	$("#selplace").click(function(){
		var lat=$("#lat").val();
		var lng=$("#lng").val();
		if(lat && lng)
		{
			//alert("in");
			codeLatLng();
			$("#showmap").toggle(400);
		}
		else
		{
			alert("<?php echo __('select_a_location');?>");
		}
	});	
});
$(document).ready(function () {$("#signup_menu").addClass("fl active");});
 
</script>

<!--- Select box SCRIPT END-->
<div class="container_inner fl clr">
       <div class="title-left title_temp1">
        <div class="title-right">
        <div class="title-mid">
               <h2 class="fl clr" title="<?php echo __('menu_sign_up');?>"><?php echo __('menu_sign_up');?></h2>
        </div>
        </div>
        </div>
   <div class="deal-left clearfix">
	<div class="action_deal_list clearfix">
<div class="login_form fl clr mt20 ml10">
<div class="signup_form_left fl">
	<?php echo Form::open(NULL,array('method'=>'post','enctype' => 'multipart/form-data'));?>
		
        <!--username-->
        <div class="row_colm1 fl clr">
                <div class="colm1_width fl"><p><?php echo __('username_label');?> <span class="red">*</span>:</p></div>
                <div class="colm2_width fl">
                        <div class="inputbox_out fl">
                        <?php echo Form::input('username',isset($form_values['username'])?$form_values['username']:__('enter_username'),array('maxlength'=>'20','class'=>'textbox','id'=>'username','onfocus'=>'label_onfocus("username","'.__('enter_username').'")','onblur'=>'label_onblur("username","'.__('enter_username').'")'));?>
                        </div>
                <label class="signup_errore_msg fl"><span class="red"><?php if($errors){echo (array_key_exists('username',$errors))? ucfirst($errors['username']):"";}?></span></label>
                </div>
        </div>
        <!--email-->
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><p><?php echo __('email_label');?> <span class="red">*</span>:</p></div>
                        <div class="colm2_width fl"><div class="inputbox_out fl">
                        <?php echo Form::input('email',isset($form_values['email'])?$form_values['email']:__('enter_email'),array('maxlength'=>'30','class'=>'textbox','id'=>'email','onfocus'=>'label_onfocus("email","'.__('enter_email').'")','onblur'=>'label_onblur("email","'.__('enter_email').'")'));?>
                        </div>
                <label class="signup_errore_msg fl"><span class="red"><?php if($errors){echo (array_key_exists('email',$errors))? ucfirst($errors['email']):"";}?></span></label>
                </div>
        </div>
        <!--password-->
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><p><?php echo __('password_label');?> <span class="red">*</span>:</p></div>
                <div class="colm2_width fl">
                        <div class="inputbox_out fl">
                        <?php echo Form::password('password',isset($form_values['password'])?$form_values['password']:__('enter_password'),array('maxlength'=>'20','class'=>'textbox','id'=>'password','onfocus'=>'label_onfocus("password","'.__('enter_password').'")','onblur'=>'label_onblur("password","'.__('enter_password').'")'));?>
                        </div>
                <label class="signup_errore_msg fl"><span class="red"><?php if($errors){echo (array_key_exists('password',$errors))? ucfirst($errors['password']):"";}?></span></label>
                </div>
        </div>
        <!--Retype password-->
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><p><?php echo __('retype_password_label');?> <span class="red">*</span>:</p></div>
                <div class="colm2_width fl">
                        <div class="inputbox_out fl">
                        <?php echo Form::password('repassword',isset($form_values['repassword'])?$form_values['repassword']:__('enter_repasswo'),array('maxlength'=>'20','class'=>'textbox','id'=>'repassword','onfocus'=>'label_onfocus("repassword","'.__('enter_repasswo').'")','onblur'=>'label_onblur("repassword","'.__('enter_repasswo').'")'));
                        ?>
                        </div>
                <label class="signup_errore_msg fl">
                <span class="red"><?php if($errors){echo (array_key_exists('repassword',$errors))? ucfirst($errors['repassword']):"";}?></span>
                </label>
                </div>
        </div>
        <!--Firstname-->
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><p><?php echo __('firstname_label');?> <span class="red">*</span>:</p></div>
                <div class="colm2_width fl">
                        <div class="inputbox_out fl">
                        <?php echo Form::input('firstname',isset($form_values['firstname'])?$form_values['firstname']:__('enter_firstname'),array('maxlength'=>'20','class'=>'textbox','id'=>'firstname','onfocus'=>'label_onfocus("firstname","'.__('enter_firstname').'")','onblur'=>'label_onblur("firstname","'.__('enter_firstname').'")'));?>
                        </div>
                <label class="signup_errore_msg fl">
                <span class="red"><?php if($errors){echo (array_key_exists('firstname',$errors))? ucfirst($errors['firstname']):"";}	?></span>
                </label>  
                </div>  
        </div>
        <!--Lastname-->
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><p><?php echo __('lastname_label');?> :</p></div>
                <div class="colm2_width fl">
                        <div class="inputbox_out fl">
                        <?php echo Form::input('lastname',isset($form_values['lastname'])?$form_values['lastname']:__('enter_lastname'),array('maxlength'=>'20','class'=>'textbox','id'=>'lastname','onfocus'=>'label_onfocus("lastname","'.__('enter_lastname').'")','onblur'=>'label_onblur("lastname","'.__('enter_lastname').'")'));?>
                        </div>
                <label class="signup_errore_msg fl">
                <span class="red"><?php if($errors){ echo (array_key_exists('lastname',$errors))? ucfirst($errors['lastname']):"";}?></span>
                </label>    
                </div>
        </div>
		
       
        
        <!--Start Address-->
<div class="row_colm1 fl clr mt20">
    <div class="colm1_width fl"><p><?php echo __('map_details');?></p></div>
     <div class="colm2_width fl">
       
		<div>
		<br>
		<div class="inputbox_out fl">
		<?php echo Form::input('address1',isset($_POST['address1'])?$_POST['address1']:__('search_places'),array('maxlength'=>'40','class'=>'textbox','id'=>'address1','onfocus'=>'label_onfocus("address1","'.__('search_places').'")','onblur'=>'label_onblur("address1","'.__('search_places').'")'));?>
		</div>		
		</div>	   
        <div id="showmap">
		<input type="button" value="<?php echo __('search_label');?>" onclick="showAddress()" />		
		<div>
			<div align="center" id="map" style="width: 600px; height: 400px"><br/></div>
			<br>
			<div id="selplace"><input type="button" value="<?php echo __('click_location');?>"></div>
		</div>
        <!--End-->
        
        </div>
     </div>
</div>
        <!--Map Lat&Long-->
        <input type="hidden" id="lat" name="lat" value=""/>
        <input type="hidden" id="lng" name="lng" value=""/>
        <input type="hidden" name="country" id="country" value="<?php isset($form_values['country'])?$form_values['country']:''; ?>">
        <input type="hidden" name="address" id="address" value="<?php isset($form_values['address'])?$form_values['address']:''; ?>">
        <!---End-->
        <!--Map Lat&Long-->
        <input type="hidden" id="lat" name="lat" value=""/>
        <input type="hidden" id="long" name="long" value=""/>
        <!---End-->
        <!--Referred by-->
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
        <div style="display:none;">
        <!--Gender-->
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><p><?php echo __('gender_label');?></p></div>
                <div class="colm2_width fl">
                        <div class="inputbox_out fl">
                        <?php echo Form::select('gender',array("M"=>"Male","F"=>"Female"));?>
                        </div>
                </div>
        </div>
  </div>
        <!--end of hide-->
        <!--Captcha-->
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><b class="fl">&nbsp;</b></div>
                <div class="colm2_width fl">
                        <div class="inputbox_out captchabox_out fl">
                        <?php echo Form::input('captcha',NULL,array('maxlength'=>'5','id'=>'captcha')); ?>
                        </div>
                <?php echo $captcha->render(); ?>
                <label class="signup_errore_msg fl">
                <span class="red"><?php echo ($captcha_val == 0)?__('enter valid captcha')."":"";?></span>
                </label>
                </div>
        </div>

        <!--Newsletter-->
        <div class="row_colm1 fl clr mt15">
                <div class="colm1_width fl"><b class="fl">&nbsp;</b></div>
                <div class="colm2_width fl">
                        <div class="remember_me fl">
                        <?php $checked= ($form_values['newsletter']==1)?TRUE:FALSE; 
                        echo Form::checkbox('newsletter','1',$checked);?>
                        <span class="fl"><?php echo __('newletter_label');?>.</span>
                        </div>
                </div>		
        </div>
        <!--I agree-->
        <div class="row_colm1 fl clr mt15">
                <div class="colm1_width fl"><b class="fl">&nbsp;</b></div>
                <div class="colm2_width fl">

                        <div class="remember_me fl">
                        <?php $checked= ($form_values['agree']==1)?TRUE:FALSE; echo Form::checkbox('agree','1',$checked);?>
                        <span class="fl"><?php echo __('i_have_read');?><a href="<?php echo url::base();?>cmspage/page/terms-conditions" title="<?php echo __('terms_and_condition');?>"><?php echo __('terms_and_condition');?></a><?php echo __('privacy_policy_i_agree');?>.</span>
                        </div>
                <label class="signup_errore_msg fl">
                <span class="red"><?php if($errors){echo (array_key_exists('agree',$errors))? __('terms_select')."<br/>":"";}?></span>
                </label>
                </div>
        </div>
        <!--Submit button-->
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><b class="fl">&nbsp;</b></div>
                <div class="login_submit_btn fl">
                <span class="login_submit_btn_left fl">&nbsp;</span>
                <span class="login_submit_btn_middle fl"><?php echo Form::submit('signup',__('button_signup'),array('title'=>__('button_signup')));?></span>
                <span class="login_submit_btn_left login_submit_btn_right fl">&nbsp;</span>
                </div>
        </div>
		
	<?php echo Form::close();?>
        </div>    
        <div class="login_form_right fr mt75">
               
                <div class="already-middle clearfix">
                        <div class="signup_link fl clr mt20">
                        <h4 class="clr"><?php echo __('already_a_member');?>?</h4>
                        <p class="clr" style="font-weight:bold; text-align:center;"> <?php echo __('If so you may want to ');?> <a href="<?php echo url::base();?>users/login" title="<?php echo __('menu_signin');?>"><?php echo __('menu_signin')."&raquo;";?></a><?php echo __('now ');?></p>
                        </div>
                </div>
      
        <div class="signup-bottom"></div>
        </div>
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
<div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=AIzaSyDswVcpgWiYGJpLq-iVmZJCQRt-tY9Wck0"
      type="text/javascript"></script>

     <script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
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
	/*document.getElementById("lat").value = center.lat().toFixed(5);
	document.getElementById("lng").value = center.lng().toFixed(5);*/
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
    //alert(latlng);
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
