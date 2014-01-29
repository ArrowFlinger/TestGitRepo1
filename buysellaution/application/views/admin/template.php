<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	    <meta name="description" content="<?php echo $meta_settings[0]['meta_description'];?>" />
	        <meta name="keywords" content="<?php  echo $meta_settings[0]['meta_keywords'];?>" />
                   <?php echo $welcomestyle; ?>
      
             <?php foreach($welcomescript as $file) { echo HTML::script($file, NULL, TRUE); }?>
        <title><?php echo $page_title;?></title>
<link rel="shortcut icon" href="<?php echo URL_BASE;?>public/admin/images/favicon.jpg" type="image/x-icon" />
<script type="text/javascript">
var language=<?php echo $language;?>;
</script>
</head>
<body>
<div class="container_outer fl clr">
  <?php  echo new View("admin/header"); ?>
    <div class="con_out fl clr">
       <div class="con_in"> 
           <div class="con_bdy fl">
               <?php  if($controller != 'admin' && $action != 'login'): ?>
		      <?php  echo new View("admin/admin_menu"); ?>
		           <div class="cont_rgt fl">
    		                  <div class="container_rgt_head fl clr">
    					<h1><?php echo $page_title; ?></h1>
      		                             </div>
                                                 <div class="bread_crumb">
                                                       <!-- common config  home link -->
				                          <?php $link = HOME;
						   $atag_start='<a href='.URL_BASE.''.$link.' title='.$link.'>'; 
			        	       $atag_end='</a>';?>	
                                           <?php echo $atag_start. __('home_breadcrumb').$atag_end;?>
	                            <span class="fwn"><img src="<?php echo URL_BASE;?>public/admin/images/list_arrow_medium.png" width="14px" height="14px" _class="mt5"/></span>
	                            <?php if(isset($selected_controller_title)) { ?>
	                            <div style="float: left;"><?php echo $selected_controller_title; ?></div>
	                            <span class="fwn"><img src="<?php echo URL_BASE;?>public/admin/images/list_arrow_medium.png" width="14px" height="14px" _class="mt5"/></span>
	                            <?php } ?>
                            <div style="float: left;"><?php echo $selected_page_title; ?></div>
                      </div>
<div class="container_content fl clr">
        <?php endif; 
				//For Notice Messages
				$sucessful_message=Message::display();
                                if($sucessful_message) { ?>
					<div id="messagedisplay" class="padding_150">
						 <div class="notice_message">
							<?php echo $sucessful_message; ?>
						 </div>
					</div>
				<?php } ?>    				   
                             <?php echo $content;?>
    		        </div>
                  </div>
              </div>               
          </div>
      </div>  
   <?php  echo new View("admin/footer"); ?>   
</div> 
</body>
</html>
