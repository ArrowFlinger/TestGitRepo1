<?php defined("SYSPATH") or die("No direct script access.");?>
<?php echo Form::open(NULL,array('method'=>'post','enctype' => 'multipart/form-data'));?>
<?php  
	$lng=isset($_POST['lng'])?$_POST['lng']:(isset($users[0]['longitude'])?$users[0]['longitude']:2.33739);
	$country=isset($_POST['country'])?$_POST['country']:(isset($users[0]['country'])?$users[0]['country']:'');
	$address=isset($_POST['address'])?$_POST['address']:(isset($users[0]['address'])?$users[0]['address']:'');
	$lat=isset($_POST['lat'])?$_POST['lat']:(isset($users[0]['latitude'])?$users[0]['latitude']:48.89364);
	$long=isset($_POST['long'])?$_POST['long']:'';
	$map_canvas=isset($_POST['map_canvas'])?$_POST['map_canvas']:'';
?>

		  <input type="hidden" id="lng" name="lng" value="<?php echo $lng; ?>"/>
			<input type="hidden" name="country" id="country" value="<?php echo  $country; ?>">
			<input type="hidden" name="address" id="address" value="<?php echo  $address; ?>">
			<!---End-->
			<!--Map Lat&Long-->
			<input type="hidden" id="lat" name="lat" value="<?php echo $lat; ?>"/>
		    
			<input type="hidden" id="map_canvas" name="map_canvas" value="<?php echo $map_canvas; ?>"/>
		<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=AIzaSyDswVcpgWiYGJpLq-iVmZJCQRt-tY9Wck0"
		  type="text/javascript"></script>

		 <script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript">

	$(document).ready(function () {
			
			load();
			initialize();
		//$("#showmap").hide();
	   
		$(window).load(function(){

			load();
			
			initialize();
			
			
		//	$(".sign_map2").hide();
		});
		/*$(window).unload(function(){
			GUnload();
		});*/
		
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

	</script>
	<!--Faceinvite-->
	<script type="text/javascript">
	//For Delete the users photo
	//=====================
	function frmdel_photo(userid)
	{
		var answer = confirm("<?php echo __('delete_alert_image');?>")
		if (answer){
			window.location="/users/delete_userphoto/"+userid;
		}

		return false;  
	} 
	$(document).ready(function(){
		
		 $("#passwords").click(function(){	
			
			 $("#pass").toggle();
		});

	});
	//code for checking message field maxlength
	//============================
	function limitlength(obj, maxlength){
			//var maxlength=length
			if (obj.value.length>maxlength){
					obj.value=obj.value.substring(0, maxlength);
					// max reach
				   document.getElementById("info_label").innerHTML="<?php echo __('entered_max_text');?>"+maxlength;
			}else{
		$("")
					var charleft = maxlength - obj.value.length;
				   
					document.getElementById("info_label").innerHTML= charleft+"<?php echo __('entered_char_left_text');?>";
			}
	}
	//For Photo View Using Lightbox
	//=============================
	/*    jQuery(function($) {
			$('#gallery a').lightBox();
		}); */
	</script>

	<script type="text/javascript">
	$(document).ready(function () {$("#edit_profile_active").addClass("act_class");});
	</script>
	<div class="my_message_right" id="edit_profile_page">
		<div class="message_common_border">
			<h1 title="<?php echo strtoupper(__('menu_edit_profile'));?>"><?php echo __('menu_edit_profile');?></h1>
			<p>&nbsp;</p>
	</div>
	<div class="message_common">
	<?php
	$lat1 = 48.89364;
	$lang1 = 2.33739;
		foreach ($users as $user)
		{
			$lat1 = $user['latitude']!=""?$user['latitude']:48.89364;
		$lang1 = $user['longitude']!=""?$user['longitude']:2.33739;
				$id=$user['id'];	
				if(count($errors)>0)
				{
				$user['firstname']=$validator['firstname'];
				$user['lastname']=$validator['lastname'];
				$user['aboutme']=$validator['aboutme'];
				$user['country']=$validator['country'];
				}
			?>
				 
	<div class="login_middle_common_profil">
		<div class="user_name_common">
			<p><?php echo __('username_label');?> <span class="red">*</span>:</p>
			<div class="text_feeld">
				<h2><?php echo Form::input('username',$user['username'],array('maxlength'=>'20','class'=>'textbox','readonly'=>'readonly','title' =>__('username_label')));?></h2>
			</div>
		</div>

		<div class="user_name_common">
			<p><?php echo __('email_label');?>:</p>
			<div class="text_feeld">
				<h2><?php echo Form::input('email',$user['email'],array('maxlength'=>'50','class'=>'textbox','readonly'=>'readonly','title' =>__('email_label')));?></h2>
			</div>
		</div>

		<div class="user_name_common">
			<p><?php echo __('firstname_label');?> <span class="red">*</span>:</p>
			<div class="text_feeld">
				<h2><?php echo Form::input('firstname',isset($data['firstname'])?$data['firstname']:$user['firstname'],array('maxlength'=>'20','class'=>'textbox','title' =>__('firstname_label')));?></h2>
			</div><?php if($errors){echo (array_key_exists('firstname',$errors))? $errors['firstname']:"";}?>
		</div>
		<div class="user_name_common">
			<p><?php echo __('lastname_label');?> :</p>
			<div class="text_feeld">
				<h2><?php echo Form::input('lastname',isset($data['lastname'])?$data['lastname']:$user['lastname'],array('maxlength'=>'20','class'=>'textbox','title' =>__('lastname_label')));?></h2>
			</div><?php if($errors){ echo (array_key_exists('lastname',$errors))? $errors['lastname']:"";}?>
		</div>
		
	<div class="user_name_common">
	<p><?php echo __('map_details');?> :</p>
	<div class="text_feeld">
		<div class="map_text">
			<input type="text" maxlength="100" name="address1" id="address1" value="<?php echo isset($data['address1'])?$data['address1']:$user['country']?>"/>
			<div class="but_common_right" style="width:auto;">
				<div class="but_left"></div>
					<div class="but_mid" style="width:auto;">
						<input style="width:auto;" type="button" value="<?php echo __('button_search');?>"  title="<?php echo __('button_search');?>" onclick="showAddress()" />
					</div>
				<div class="but_right"></div>
			</div>
		</div>
	</div>
	</div>
	 <div id="close_map">
	<div class="user_name_common2">
		<div class="text_feeld2">
			<p><span id="close" class="claoser" style="margin: -21px 0 0 324px;" title="<?php echo  __('click_here_to_select_this_location');?>">&nbsp;</span>
			<span id="close" title="<?php echo  __('click_here_to_select_this_location');?>"></span>
				<div id="showmap">
					<a align="center" id="map" style="width: 355px; height: 400px"></a>
				</div></p>
				<div class="colm1_width fl"><p id="selplace"><?php echo  __('click_here_to_select_this_location');?><span class="red"></span>:</p></div>
		</div>
	</div> </div>
	<div class="user_name_common">
		<p><?php echo __('aboutme_label');?> <span class="red">*</span>:</p>
		<div class="text_feeld">
			<h2><?php echo Form::textarea('aboutme',isset($data['aboutme'])?$data['aboutme']:$user['aboutme'],array('onkeyup'=>"return limitlength(this, 256)",'cols'=>'28', 'rows' => '8','title' =>__('aboutme_label')));?></h2>
			<h3><label class="errore_msg fl clr"><span class="red"><?php if($errors){ echo (array_key_exists('aboutme',$errors))? $errors['aboutme']:"";}?></span><div class="info_label" id="info_label" ></div>
			<div class="info_label" id="info_label" ><?php echo __('max_label');?>: 256 </div></label></h3>
		</div>
	</div>

	<div class="user_name_common">
	<p><?php echo __('photo_label');?>:</p>
	<div class="text_feeld">
	 <?php	//code to remove or delete photo link
			$user_image_path=IMGPATH.NO_IMAGE;
			$light_box_class=$delete_link=$atag_start=$atag_end="";
			$image_title=__('no_photo');

			//check if file exists or not
			if(($user['photo']) && (file_exists(DOCROOT.USER_IMGPATH.$user['photo'])))
			{ 
				$user_image_path = URL_BASE.USER_IMGPATH.$user['photo'];
				$image_title=$user['username'];
				$light_box_class="class='lightbox'";
				$delete_title = __('delete'); 
				$delete_link="<a href='javascript:;' onclick='frmdel_photo(".$user['id'].");' class='deleteicon' title='$delete_title' id='photo_delete'>"."</a>"; 
				$atag_start='<a href='.$user_image_path.' title='.$image_title.'>'; 
				$atag_end='</a>';										   
			}
	?> 
	<?php echo $atag_start;?> 
	<img src="<?php echo $user_image_path; ?>" title="<?php echo $image_title; ?>"  alt="no_img" width="<?php echo USER_SMALL_IMAGE_WIDTH;?>" height="<?php echo USER_SMALL_IMAGE_HEIGHT;?>"/></a>
	<?php echo $atag_end; ?>
	<?php echo $delete_link; ?>
	</div><?php  if($errors){echo array_key_exists("photo",$errors)?$errors["photo"]:"";}?>
		<input class="input" name="photo" size="30" type="file" value=""/>
	</div>	
	<div class="no_img">
				<div class="buton_green">
					<div class="profil_butoon">
					<div class="res_left"></div>
					<div class="res_mid"><a title="<?php echo strtoupper(__('button_reset'));?>"><input type="submit" name="submit_user" value="<?php echo strtoupper(__('button_reset'));?>"/></a></div>
					<div class="res_right"></div>
				</div>
				<span></span>				
				<div class="grand_total_btn_cp">
					<div class="save_left"></div>
					<div class="save_mid"><a title="<?php echo strtoupper(__('button_save'));?>"><input type="submit" name="submit_user_profile" value="<?php echo strtoupper(__('button_save'));?>"/></a></div>
					<div class="save_right"></div>
				</div>				
				</div>
	</div>
	<?php echo Form::close(); ?>
	<?php }//End foreach ?>
	</div>
	</div>
	</div>
	</div>
	<script type="text/javascript">
	function load() {
		  if (GBrowserIsCompatible()) {
			var map = new GMap2(document.getElementById("map"));
			map.addControl(new GSmallMapControl());
			map.addControl(new GMapTypeControl());
			var center = new GLatLng(<?php echo $lat1;?>,<?php echo $lang1; ?>);
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
		var latlng = new google.maps.LatLng(<?php echo $lat1;?>,<?php echo $lang1; ?>);
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
				//console.log(results);				
			  /*map.setZoom(11);
			  marker = new google.maps.Marker({
				  position: latlng,
				  map: map
			  });
			  infowindow.setContent(results[1].formatted_address);
			  infowindow.open(map, marker);*/			
			  document.getElementById("country").value=results[1].formatted_address;
			  document.getElementById("address").value=results[0].formatted_address;
			}
		  } else {
			alert("<?php echo __('geocoder_failed');?>" + status);
		  }
		});
	  }
	</script>
	<div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
