<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml"  xmlns:fb="http://ogp.me/ns/fb#" itemscope itemtype="http://schema.org/Product">
<head>
<title><?php echo $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php echo $meta_description; ?>" />
<meta name="keywords" content="<?php echo $meta_keywords; ?>" />
<meta property="og:title" content="<?php echo isset($fb_title)?$fb_title:__('site_title');?>" />
<meta property="og:type" content="website" />
<meta property="og:url" content="<?php echo isset($fb_url)?$fb_url:'';?>" />
<meta property="og:image" content="<?php echo isset($fb_image)?$fb_image:'';?>" />
<meta property="og:description" content="<?php echo isset($fb_desc)?$fb_desc:'';?>" />
<meta property="fb:app_id" content="<?php echo FB_APP_ID;?>"/>
<!-- Google Plus -->
<meta itemprop="name" content="<?php echo isset($fb_title)?$fb_title:'';?>">
<meta itemprop="description" content="<?php echo isset($fb_desc)?$fb_desc:'';?>">
<meta itemprop="image" content="<?php echo isset($fb_image)?$fb_image:'';?>">
<link rel="shortcut icon" href="<?php echo IMGPATH.'favicon.jpg';?>" type="image/x-icon" />	
<?php 	foreach($styles as $file => $type) { 
		echo HTML::style($file, array('media' => $type))."\n";
	}
?>
<?php foreach($scripts as $file) { echo HTML::script($file, NULL, TRUE)."\n"; }?>

	
<script type="text/javascript">
<?php echo $site_settings[0]['site_tracker'];?>
</script>

<script type="text/javascript">
var language=<?php echo $language;?>;
</script>
</head>
<body>
<input type="hidden" id="theme_name" value="<?php echo THEME; ?>"/>
<div class="serverurl" style="display:none;" title="<?php echo url::base();?>auctions/servertime"><?php echo date(SERVER_TIME_FORMAT,time());?></div>
<div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
	<?php  echo new View(THEME_FOLDER."header"); ?>
	

	
		<div class="main_container_outer fl clr">
		<div class="main_container_in">
		<div class="main_container fl clr">
		
		
		<?php 	//show the response message
			$check_msg = Message::get(); 
			if($check_msg){
			?>
		<div class="span-22a" >
		<center>
		<div id="messagedisplay" >
		<?php echo Message::display(); 
		if(isset($_SESSION['session_response_msg'])) 
		{
			$session_response_msg=Session::instance()->get("session_response_msg"); 
                        echo $session_response_msg;
			
		} 
		?>
		</div>
		</center>
		</div>
		<?php	} ?>
		<?php echo $content;?>

		</div>
	
<?php echo new View(THEME_FOLDER."footer");?>
<script type="text/javascript">
	jQuery(document).ready(function () 
	{
		if(jQuery('#messagedisplay'))
		{
		jQuery('#messagedisplay').animate({opacity: 1.0}, 5000);
		jQuery('#messagedisplay').fadeOut('slow');
		}
		//error message
		if(jQuery('#error_messagedisplay'))
		{
		jQuery('#error_messagedisplay').animate({opacity: 1.0}, 5000);
		jQuery('#error_messagedisplay').fadeOut('slow');
		}
	});
</script>
</body>
</html>
