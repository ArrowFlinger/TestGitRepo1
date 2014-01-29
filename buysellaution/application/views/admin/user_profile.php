<?php  
 /* Status Box Checked */
//------------------------
$user_type_val = isset($srch["user_type"]) ? $srch["user_type"] :''; 
$status_checked ="";
 if(isset($user_data['status'])	&& $user_data['status']== ACTIVE)
 { $status_checked="checked='checked'"; }
 
 //For based on the user type, field defined
 //=========================================
 $status_field=$back_button=$admin_status_field="";
 if(isset($user_data['usertype']) && $user_data['usertype']!=ADMIN) { 
  
        $status_field="<tr>
        <td><label>".__('status_label')."</label></td>
        <td>
        <input type='checkbox' name='status[]' value='A' ".$status_checked." />";   
        if(isset($errors['status'])) {
        $status_field.="<span style='padding-left: 5px;' class='label_error'>".ucfirst($errors['status'])."</span>";
        } 
        $status_field.="</td>
        </tr> ";
                        
  
}else{
	 $admin_status_field="
	<input type='hidden' name='status[]' value='A' >";
	}
 

	//$read_only=(strlen($user_data['paypal_account'])>0)?"readonly":"";	
 
 ?>
<link type="text/css" href="<?php echo LIGHTBOX_CSSPATH;?>" rel="stylesheet" media="screen" />
<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
    <div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
    <div class="content_middle">
		 <form method="post" enctype="multipart/form-data" class="admin_form" name="frmuser" id="frmuser" action ="<?php echo URL_BASE;?>manageusers/<?php echo $action;?>">
                <table border="0" cellpadding="5" cellspacing="0" width="100%">

                        <tr>
                                <td valign="top" width="20%"><label><?php echo __('fname_label'); ?></label><span class="star">*</span></td>
                                <td>
                                		<input type="text" name="firstname" maxlength="32" id="firstname" value="<?php echo isset($user_data['firstname']) &&!array_key_exists('firstname',$errors)? trim($user_data['firstname']):$validator['firstname']; ?>"/>
                                   <span class="error">
                                        <?php echo isset($errors['firstname'])?ucfirst($errors['firstname']):""; ?>
                                    </span>
                                </td>
                        </tr>
                        <tr>
                                <td valign="top" width="20%"><label><?php echo __('lname_label'); ?></label></td>                               
                                <td>
                                	<input type="text" name="lastname" maxlength="10" value="<?php echo isset($user_data['lastname']) &&!array_key_exists('lastname',$errors)? $user_data['lastname']:$validator['lastname']; ?>" />
                               		<span class="error">
										<?php echo isset($errors['lastname'])?ucfirst($errors['lastname']):""; ?>
									</span>
                                </td>
                        </tr> 
                         <tr>
                                <td valign="top"><label><?php echo __('email_label'); ?></label><span class="star">*</span></td>
                                <td>
                                	 <input type="text" name="email" maxlength="50" value="<?php echo isset($user_data['email']) && !array_key_exists("email",$errors)? trim($user_data['email']):$validator['email']; ?>"/>
                                     <span class="error">
                                        <?php echo isset($emailid_exist)?$emailid_exist:""; echo isset($errors['email'])?ucfirst($errors['email']):""; ?>
                                        <?php echo isset($email_exists)?$email_exists:""; ?>
                                     </span>                          
                                </td>
                        </tr>

                         <tr>
                                <td valign="top"><label><?php echo __('username_label'); ?></label><span class="star">*</span></td>
                                <td>
                                <?php if(isset($user_data['username'])):?>
                                	<input type="text" name="username" style= "border-color: #FFFFFF;" maxlength="30" readonly="readonly" value="<?php echo isset($user_data['username']) && !array_key_exists("username",$errors) ?trim($user_data['username']):$validator['username']; ?>" />
                                	<?php else:?>
                                	<input type="text" name="username" maxlength="30" value="<?php echo isset($user_data['username']) && !array_key_exists("username",$errors) ?$user_data['username']:$validator['username']; ?>" />
                                	<?php endif;?>   
                                   <span class="error">
                                        <?php echo isset($user_exists)?$user_exists:'';echo isset($errors['username'])?ucfirst($errors['username']):""; ?>
                                        <?php echo isset($name_exist)?$name_exist:""; ?>
                                   </span> 
                                </td>
                        </tr>
                        
                        <tr>


                        
                                <td valign="top"><label><?php echo __('address_label'); ?></label></td>
                                <td>
                                        
					<div id="showmap">
					<div>
					<div class="inputbox_out fl">
					<input type="text" size="60" name="address1" id="address1" value="<?php echo isset($user_data['country'])?$user_data['country']: $validator['username'] ?>" >
					</div>
					<input type="button" value="<?php echo __('search_label');?>" onclick="showAddress()" />
					</div>
					<br><br><div id="close" style="align:right;"><?php echo __('close_label');?></div><br>
					<div>
					<div align="center" id="map" style="width: 600px; height: 400px"><br/></div>
					<br>
					<div id="selplace"><input type="button" value="<?php echo __('click_location');?>"></div>
					</div>                        
                                </td>
                        </tr> 
                        <!--Map Lat&Long-->
            <?php
			$country=isset($_POST['country'])?$_POST['country']:(isset($user_data['country'])?$user_data['country']:'');
			$address=isset($_POST['address'])?$_POST['address']:(isset($user_data['address'])?$user_data['address']:'');
             ?>         
			<input type="hidden" id="lat" name="lat" value=""/>
			<input type="hidden" id="lng" name="lng" value=""/>
			<input type="hidden" name="country" id="country" value="<?php echo $country; ?>">
			<input type="hidden" name="address" id="address" value="<?php echo $address; ?>">                  
                         <tr>                     
                      
                        <tr>
                         <td valign="top"><label><?php echo __('photo_label'); ?></label></td>
                      	<td>

				     <?php
						//code to remove or delete photo link
						$user_image_path=ADMINIMGPATH.NO_IMAGE;
						$light_box_class=$delete_link=$atag_start=$atag_end="";
						$image_title=__('no_photo');
						//check if file exists or not
						if(((isset($user_data)) && $user_data['photo']) && (file_exists(DOCROOT.USER_IMGPATH.$user_data['photo'])))
				        {
				           $user_image_path = URL_BASE.USER_IMGPATH.$user_data['photo'];
				           $image_title=$user_data['username'];
						   $light_box_class="class='lightbox'";
						   $delete_title = __('delete');
						   $delete_link="<a onclick='frmdel_photo(".$user_data['id'].");' class='deleteicon' title='$delete_title' id='photo_delete'></a>";
						   $atag_start='<a href='.$user_image_path.' title='.$image_title.'>';
						   $atag_end='</a>';
						 }

						?>

                                        <?php echo $delete_link; ?>
                                        <span style="margin-right:30px;" id="gallery">
										<?php echo $atag_start; ?>                                        
                                        <img src="<?php echo $user_image_path; ?>" title="<?php echo $image_title; ?>" class="fl" width="<?php echo USER_SMALL_IMAGE_WIDTH;?>" height="<?php echo USER_SMALL_IMAGE_HEIGHT;?>" >
										<?php echo $atag_end; ?>
                                        </span>

						    <div style="width:300px;float:left;">
						          <span class="text_bg4 fl" style="margin:0 0 0 5px;">
						               <p class="fl clr" style="width:140px;text-align:center;font-weight:bold;font-size:11px;"><?php echo __('profile_image_content');?></p>
						          </span>
						        <div class="order_button fl clr" style="width:auto;margin:0 0 0 5px;">
						            <!-- <div class="order_but_left fl"></div> -->
						           <div class="orderr_but_mid fl">
						              <input name="photo" type="file" style="height:30px;width:auto; font:bold 12px Arial, Helvetica, sans-serif;color:#333;"/>  
						            </div>

						         </div>
                                  <span class="error" >
                                        <?php echo isset($errors['photo'])?ucfirst($errors['photo']):""; ?>
                                    </span>		
						        </div>
                             </td>

                        </tr>
					

                        
                        <?php echo $status_field; ?>                      
                        <tr>
                        	<td colspan="2" class="star">*<?php echo __('required_label'); ?></td>
                        </tr>                         
                        <tr>
                                <td colspan="3" style="padding-left:110px;">
                                  <br />
                                  	<?php echo $admin_status_field;?>
                           <input type="button" value="<?php echo __('button_back'); ?>" onclick="location.href='<?php echo URL_BASE;?>manageusers/index'" />
                                  	<input type="reset" value="<?php echo __("button_reset"); ?>" title="<?php echo __("button_reset"); ?>" />
								  	<input type="submit" value="<?php echo ($action == 'add' )?''.__("button_add").'':''.__("button_update").'';?>" name="<?php echo ($action == 'add' )?'admin_add':'admin_edit';?>" title="<?php echo ($action == 'add' )?''.__("button_add").'':''.__("button_update").'';?>" />
                                  <div class="clr">&nbsp;</div>
                                </td>
                        </tr> 

                </table>
        </form>
    </div>
    <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
</div>
</div>
 <?php
 $lat = 48.89364;
 $lang = 2.33739;
	$lat = $user_data['latitude']!=""?$user_data['latitude']:48.89364;
	$lang = $user_data['longitude']!=""?$user_data['longitude']:2.33739;
 ?>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=AIzaSyDswVcpgWiYGJpLq-iVmZJCQRt-tY9Wck0" type="text/javascript">
</script>
     <script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
function load() {
      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map"));
        map.addControl(new GSmallMapControl());
        map.addControl(new GMapTypeControl());
        var center = new GLatLng(<?php echo $lat;?>,<?php echo $lang; ?>);
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
	alert(address + " not found");
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
  //  alert(latlng);
    geocoder.geocode({'latLng': latlng}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) { 
        if (results[1]) {   
			//console.log(results);
			//alert(results.responseText); 
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
        alert("Geocoder failed due to: " + status);
      }
    });
  }
</script>
<script type="text/javascript" src="<?php echo LIGHTBOX_SCRIPTPATH;?>"></script>
<script type="text/javascript">
//code for checking message field maxlength
//============================
function limitlength(obj, maxlength){
        //var maxlength=length
        if (obj.value.length>maxlength){
                obj.value=obj.value.substring(0, maxlength);
                // max reach
                //$("span.info_label").html("<?php echo __('ddfdsfdsf');?>");
                document.getElementById("info_label").innerHTML="<?php echo __('entered_max_text');?>"+maxlength;
        }else{
                var charleft = maxlength - obj.value.length;
                //alert(charleft);
                //inner html
                document.getElementById("info_label").innerHTML= charleft+"<?php echo __('entered_char_left_text');?>";
        }
}

//For Delete the users photo
//=====================
function frmdel_photo(userid)
{
    var answer = confirm("<?php echo __('delete_alert_image');?>")
    if (answer){
        window.location="<?php echo URL_BASE;?>/manageusers/delete_userphoto/"+userid;
    }

    return false;
}

$(document).ready(function(){

	//For Field Focus
	//===============
	field_focus('firstname');

    //For Photo View Using Lightbox
    //=============================
    jQuery(function($) {
        $('#gallery a').lightBox();
    });
});

$(document).ready(function(){
      toggle(2);
});
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
			alert("Select a location");
		}
	});	
});
</script>
