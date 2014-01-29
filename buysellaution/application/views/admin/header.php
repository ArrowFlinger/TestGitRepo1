<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<div class="head_out fl clr">
  <div class="head_in">
    <div class="header fl clr">  
	<div class="logo fl mt25 ml50">
	<?php 
	
	$logo_image_path=IMGPATH.DEFAULT_LOGO_IMAGE;
if(((isset($site_settings)) && $site_settings[0]['site_logo']) && (file_exists(DOCROOT.LOGO_IMGPATH.$site_settings[0]['site_logo']))){
	$logo_image_path = URL_BASE.LOGO_IMGPATH.$site_settings[0]['site_logo'];}?>
	<a href="<?php echo URL_BASE;?>" target = "_blank"><img src="<?php echo $logo_image_path; ?>" width="<?php echo LOGO_SMALL_IMAGE_WIDTH;?>" height="<?php echo LOGO_SMALL_IMAGE_HEIGHT;?>"  border="0" title="<?php echo $site_settings[0]['site_name'];?>" /></a>
	</div>
     <div class="fr head_rgt">
     <div class="fr clr">
			<?php  if($controller != 'admin' && $action != 'login'): ?>
		      <p class="fl"> <?php echo __("welcome_label") ; ?></p><p class="fl"> <?php echo strtolower($username).' | '; ?>  </p>
              <p class="fl"><a href = "<?php echo URL_BASE;?>manageusers/myinfo/<?php echo $admin_session_id; ?>" class='fl'><?php echo __("menu_myinfo").' | '; ?></a></p>
              <p class="fl"><a href = "<?php echo URL_BASE;?>manageusers/change_password/" class='fl'><?php echo __("menu_change_password").' | '; ?></a></p>
			    
			     <a href ="<?php echo URL_BASE;?>admin/logout" class='fl' ><?php echo __('logout_label') ?></a>
			     </p>
		    <?php endif; ?>		
            </div>
		<div style="float:right;clear:both;" class="mt10">
			<form name="lang" id="lang" method="post">
				<select name="admin_language" id="language" style="width:100px;" onchange="javascript:form.submit();">
				<?php 
					foreach($alllang as $language){ 
						 $a=array_search( $language,$alllang); ?> 
						 <option value="<?php echo $a; ?>" <?php echo ($curr_lan == $a)?"selected='selected'":"";?> >
						 <?php echo $language; ?></option>							
				<?php } ?> 						
				</select>
			</form>
		 </div>
      </div>			
    </div>
  </div>
</div>
