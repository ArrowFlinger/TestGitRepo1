<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:fb="http://ogp.me/ns/fb#">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php echo $meta_description; ?>" />
<meta name="keywords" content="<?php echo $meta_keywords; ?>" /> 
<meta property="og:title" content="" />
<meta property="og:type" content="" />
<meta property="og:url" content="" />
<meta property="og:image" content="" />
<meta property="og:site_name" content="" />
<meta property="fb:admins" content="100000859684178" />
 <meta property="fb:app_id" content="<?php echo FB_APP_ID;?>"/>
<link rel="shortcut icon" href="<?php echo IMGPATH.'favicon.jpg';?>" type="image/x-icon" />
<title><?php echo $title; ?></title>
<script type="text/javascript">
<?php echo $site_settings[0]['site_tracker'];?>
</script>
<script type="text/javascript">
var language=<?php echo $language;?>;
</script>
<?php 
        foreach($styles as $file => $type) 
	{ 
                echo HTML::style($file, array('media' => $type))."\n";
        }
?>
<?php 	foreach($scripts as $file) 
	{ 
		echo HTML::script($file, NULL, TRUE)."\n"; 
	}
?>
</head>

	<body>
		<div class="serverurl" style="display:none;" title="<?php echo url::base();?>auctions/servertime"></div>		<div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
			<?php  
				echo new View(THEME_FOLDER."header");?>
                                        
	                         	<div class="main_container_outer fl clr">
                	<div class="main_container_in">
                    	<div class="main_container fl clr">
			<?php 
                	//show the response message
                	$check_msg = Message::get();
                        if($check_msg){
                         ?>
                                          <div class="span-22a" >
                                            <center>
                                              <div id="messagedisplay" >
			                        <?php echo Message::display();  
			                                        ?>
                                              </div>
                                            </center>
                                          </div>
                                  <?php
                                  }
                                 ?>
	
							<?php echo $content;?>
							<?php echo new View(THEME_FOLDER."user_right");?>
		        		</div>
                   	</div>
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
					});</script> 				

</body>
</html>
