<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="action_content_left fl">
<div class="title_temp1 fl clr">
    	<h2 class="fl clr" title="<?php echo __('menu_edit_profile');?>"><?php echo __('menu_edit_profile');?></h2>
</div>
<div class="edit_content fl clr mt20 ml15 pb20">

<?php

$lat = 48.89364;
$lang = 2.33739;
	foreach ($users as $user)
	{$lat = $user['latitude']!=""?$user['latitude']:48.89364;
		$lang = $user['longitude']!=""?$user['longitude']:2.33739;
		$id=$user['id'];	
                if(count($errors)>0)
                {
                $user['firstname']=$validator['firstname'];
                $user['lastname']=$validator['lastname'];
                $user['aboutme']=$validator['aboutme'];
                $user['country']=$validator['country'];
                }
	?>
	<?php echo Form::open(NULL,array('method'=>'post','enctype' => 'multipart/form-data'));?>
    	<div class="row_colm1 fl clr mt20">
			<div class="colm1_width fl"><p><?php echo __('username_label');?><span class="red">*</span> :</p></div>
		<div class="inputbox_out fl">
			<?php echo Form::input('username',$user['username'],array('maxlength'=>'20','class'=>'textbox','readonly'=>'readonly','title' =>__('username_label')));?>
        </div>    
        </div>	
		
       <div class="row_colm1 fl clr mt20">
			<div class="colm1_width fl"><p><?php echo __('email_label');?> :</p></div>
            <div class="colm2_width fl">
            <div class="inputbox_out fl">
                <?php echo Form::input('email',$user['email'],array('maxlength'=>'50','class'=>'textbox','readonly'=>'readonly'));?>
            </div>
        	
            </div>
		</div>
        <div class="row_colm1 fl clr mt20">
			<div class="colm1_width fl"><p><?php echo __('firstname_label');?> <span class="red">*</span>:</p></div>
            <div class="colm2_width fl">
            <div class="inputbox_out fl">
                <?php echo Form::input('firstname',isset($data['firstname'])?$data['firstname']:$user['firstname'],array('maxlength'=>'20','class'=>'textbox','title' =>__('firstname_label')));?>
            </div>
            <label class="errore_msg fl clr"><span class="red"><?php if($errors){echo (array_key_exists('firstname',$errors))? ucfirst($errors['firstname']):"";}?></span></label>
            </div>
        </div>
        <div class="row_colm1 fl clr mt20">
		<div class="colm1_width fl"><p><?php echo __('lastname_label');?> :</p></div>
        <div class="colm1_width fl">
		<div class="inputbox_out fl">
			<?php echo Form::input('lastname',isset($data['lastname'])?$data['lastname']:$user['lastname'],array('maxlength'=>'20','class'=>'textbox','title' =>__('lastname_label')));?>
        </div>
        <label class="errore_msg fl clr"><span class="red"><?php if($errors){ echo (array_key_exists('lastname',$errors))? ucfirst($errors['lastname']):"";}?></span></label>
		</div>
        </div>	
	<!--address & Country lable-->
	 <!--Country-->
        <div class="row_colm1 fl clr mt20">
            <div class="colm1_width fl"><p><?php echo __('map_details');?>:</p></div>
            <div class="colm2_width fl" style="position:relative;">

				<input type="text" size="60" name="address1" id="address1" value="<?php echo isset($data['address1'])?$data['address1']:$user['country']?>"/>
				 
               <div id="showmap" >
					<div>
                    <div class="rupling2" style="width:398px;float:left;">
					<div class="inputbox_out fl" style="width:398px;float:left;">
					<?php /*<div class="oll"><div id="close" style="align:right; color:#999;"> </div></div>*/?>			
                    
					<span class="nodus3 clr fl mt20"><input type="button" value="<?php echo __('search_label');?>" onclick="showAddress()"  /></span>
                </div>
            </div>
		<div>
                    <div class="map3" style="width:400px !important;float:left;">
			<div align="center" id="map" style="width: 400px; height: 400px"><br/></div></div>
			<br>
			<div id="selplace"><input type="button" value="<?php echo __('click_location');?>"></div>
		</div>
        <!--End-->        
        </div>
               </div>
</div>
        </div>
        <!--Map Lat&Long-->
        <input type="hidden" id="lat" name="lat" value=""/>
        <input type="hidden" id="lng" name="lng" value=""/>
        <input type="hidden" name="country" id="country" value="<?php isset($form_values['country'])?$form_values['country']:''; ?>">
        <input type="hidden" name="address" id="address" value="<?php isset($form_values['address'])?$form_values['address']:''; ?>">
        <!---End-->  
        <div class="row_colm1 fl clr mt20">
		<div class="colm1_width fl"><p><?php echo __('aboutme_label');?><span class="red">*</span>:</p></div>
        <div class="colm2_width fl">
		<div class="inputbox_out fl">
			<?php echo Form::textarea('aboutme',isset($data['aboutme'])?$data['aboutme']:$user['aboutme'],array('onkeyup'=>"return limitlength(this, 256)",'style'=>'resize:none;','cols'=>'28', 'rows' => '8','title' =>__('aboutme_label')));?>
        </div>
        <label class="errore_msg fl clr"><span class="red"><?php if($errors){ echo (array_key_exists('aboutme',$errors))? ucfirst($errors['aboutme']):"";}?></span><div class="info_label" id="info_label" ></div>
        <div class="info_label" id="info_label" ><?php echo __('max_label');?>: 256 </div></label>
		</div>
        </div>
        <div class="row_colm1 fl clr mt20">
	<div class="colm1_width fl"><p><?php echo __('photo_label');?> :</p></div>
        <div class="colm2_width fl" >
		<?php
			//code to remove or delete photo link
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
			   	$delete_link="<a href='javascript:;' onclick='frmdel_photo(".$user['id'].");' class='deleteicon'  title='$delete_title' id='photo_delete'></a>"; 
			   	$atag_start='<a class="fl" href='.$user_image_path.' title='.$image_title.'>'; 
			   	$atag_end='</a>';										   
			}
		 ?> 
         <input name="photo" type="file"/>
         <div class="user_image mt10 fl clr" style="width:100px;" id="gallery"><?php echo $atag_start;?>
			<img src="<?php echo $user_image_path; ?>" title="<?php echo $image_title; ?>" class="fl" width="<?php echo USER_SMALL_IMAGE_WIDTH;?>" height="<?php echo USER_SMALL_IMAGE_HEIGHT;?>" >                 
		<?php echo $atag_end; ?>        
		</div>
		<?php echo $delete_link; ?>
		<label class="errore_msg fl clr"><span class="red"><?php  if($errors){echo array_key_exists("photo",$errors)?ucfirst($errors["photo"]):"";}?></span><br/></label>
		</div>
        </div>
        <div class="row_colm1 fl clr">
		<!-- Submit button -->
        <div class="row_colm1 fl clr  mt20">
            <div class="colm1_width fl"><b class="fl">&nbsp;</b></div>
            <div class="colm2_width fl" style="margin-left:240px;">
                <div class="login_submit_btn fl">
                <span class="login_submit_btn_left fl">&nbsp;</span>
                <span class="login_submit_btn_middle fl">
                    <input name="submit_user_profile" type="reset"  value="<?php echo __('button_reset');?>" title="<?php echo __('button_reset');?>"  class="fl"/>
                </span>
                <span class="login_submit_btn_left login_submit_btn_right fl">&nbsp;</span>
                </div>
                <div class="login_submit_btn fl ml20">
                <span class="login_submit_btn_left fl">&nbsp;</span>
                <span class="login_submit_btn_middle fl">
                    <input name="submit_user_profile" type="submit" value="<?php echo __('button_save');?>"  title="<?php echo __('button_save');?>"  class="fl"/>
                </span>
                <span class="login_submit_btn_left login_submit_btn_right fl">&nbsp;</span>
                </div>
            </div>	    
        </div>
        </div>
<?php echo Form::close() ?>
	<?php }//End foreach ?>
</div>
</div>
              <div class="user" style="display:none;" ><?php echo $auction_userid;?></div>


<!--Faceinvite-->




<script type="text/javascript" src="<?php echo LIGHTBOX_SCRIPTPATH;?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo LIGHTBOX_CSSPATH;?>" media="screen" />
<script type="text/javascript">

//For Delete the users photo
//=====================
function frmdel_photo(userid)
{
    var answer = confirm("<?php echo __('delete_alert_image');?>")
    if (answer){
        window.location="<?php echo URL_BASE;?>users/delete_userphoto/"+userid;
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

    jQuery(function($) {
        $('#gallery a').lightBox();
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
			alert("<?php echo __('select_a_location');?>");
		}
	});	
});		
</script>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=AIzaSyDswVcpgWiYGJpLq-iVmZJCQRt-tY9Wck0"
      type="text/javascript"></script>

     <script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
function load() {
      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map"));
        map.addControl(new GSmallMapControl());
        map.addControl(new GMapTypeControl());
        var center = new GLatLng(<?php echo $lat;?>,<?php echo $lang;?>);
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
    var latlng = new google.maps.LatLng(<?php echo $lat;?>,<?php echo $lang;?>);
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
<script type="text/javascript">
$(document).ready(function () {$("#users_menu").addClass("fl active");$("#edit_profile_active").addClass("user_link_active");});

</script>
