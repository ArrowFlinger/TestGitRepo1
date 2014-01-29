<?php defined('SYSPATH') OR die("No direct access allowed."); ?>
<div class="header_outer fl clr">
	<div class="header_container">
		<div class="header fl clr">
		
		
        	<div class="header_left fl">
        	
        	<?php

if(($site_settings[0]['maintenance_mode'] != ACTIVE) || (isset($auction_userid) && $user_type == ADMIN)){ ?>
        	
            	<?php if($site_settings[0]['site_logo']==0) { ?>
                    	<h1 class="fl" title="<?php echo $site_name;?>">
                	<a href="<?php echo URL_BASE;?>" title="<?php echo $site_name;?>" class="fl">
                    	<img src="<?php echo IMGPATH.'action-logo.png';?>" alt="<?php echo $site_name;?>" title="<?php echo $site_name;?>" border="0"  class="fl" /> 
                    	 </a>
                </h1><?php } else {?>
                <h1 class="fl" title="<?php echo $site_name;?>">
            	<a href="<?php echo URL_BASE;?>" title="<?php echo $site_name;?>" class="fl">
                    	<img src="<?php echo URL_BASE.LOGO_IMGPATH.$site_settings[0]['site_logo'];?>" alt="<?php echo $site_name;?>" title="<?php echo $site_name;?>" border="0"  class="fl" />
                    	 </a>
                </h1> <?php } ?>
            </div>
            <?php }?>
                 

            <div class="header_right_out fr">
            	<div class="header_right fl clr">
            	   <?php

if(($site_settings[0]['maintenance_mode'] != ACTIVE) || (isset($auction_userid) && $user_type == ADMIN)){ ?>
                	<div class="header_top_menu fr">
                    	<div class="topmenu_left fl"></div>
                        <div class="topmenu_middle fl">
                     
                        
                        	<ul class="fl">
				<?php $static=Commonfunction::get_staticpage_content("header");				
					foreach($static as $sta):?>
				<li class="fl">
                                	<a href="<?php echo URL_BASE;?>cmspage/page/<?php echo $sta['page_url'];?>" title="<?php echo $sta['page_title'];?>" class="fl"><?php echo $sta['page_title'];?></a>
                                </li>   <li class="menu_divider fl">&nbsp;</li>
                                <?php endforeach;?>                            
				<!-- if user-->
				<?php if($auction_userid):?>
						<li class="fl">
                                	<a href="<?php echo URL_BASE;?>users/" title="<?php echo __('menu_users');?>" class="fl"><?php echo __('menu_users');?></a>
                                </li>
				
                                <li class="menu_divider fl">&nbsp;</li>
                                <li class="fl">
                                	<a href="<?php echo URL_BASE;?>users/logout" title="<?php echo __('menu_logout');?>" class="fl"><?php echo __('menu_logout');?></a>
                                </li>		
				<!--if not-->		
				<?php else:?>
                                <li class="fl">
                                	<a href="<?php echo URL_BASE;?>users/login" title="<?php echo __('menu_signin');?>" class="fl"><?php echo __('menu_signin');?></a>
                                </li>				
                                <li class="menu_divider fl">&nbsp;</li>
                                <li class="fl">
                                	<a href="<?php echo URL_BASE;?>users/signup" title="<?php echo __('menu_register');?>" class="fl"><?php echo __('menu_register');?></a>
                                </li>
				<?php endif;?>
                            </ul>
                            <?php }?>
                        </div>
                        <div class="topmenu_left topmenu_right fl"></div>
                    </div>
                         	   <?php

if(($site_settings[0]['maintenance_mode'] != ACTIVE) || (isset($auction_userid) && $user_type == ADMIN)){ ?> 
<?php $fb_settings=Commonfunction::get_facebook_settings();
		if($fb_settings[0]['facebook_login']==YES)
		{?>
		<?php if(!$auction_userid):?>
                    <a href="<?php echo URL_BASE;?>users/facebook" title="Facebook Connect" class="fr f_connect_link">
                    	<img src="<?php echo IMGPATH.'f_connect.png';?>" alt="Facebook Connect" title="Facebook Connect" border="0" class="fl" />
                    </a><?php endif;?>
		<?php } } ?>
                </div>
                <div class="header_right fl clr mt5">
                <div class="header_right_middle fr">
                
                	<?php if($auction_userid){?><?php echo __('welcome_label')." <b>".ucfirst($auction_username); echo"</b>&nbsp;";
					echo __('balance_amount_label').": <b>".$site_currency."</b>"; ?>
					<span class="user_balance" title="<?php echo URL_BASE;?>auctions/check_balance"><?php 
echo $user_current_balance;?></span> <?php echo __('bonus_balance_amount_label').": <b>".$site_currency."</b>"; ?>
					<span class="user_bonus" title="<?php echo URL_BASE;?>auctions/check_bonus"><?php //echo 0;
echo "<b>".$user_current_bonus."</b>";?></span>
					<?php } else {?><span class="user_balance" style="display:none;" title="<?php echo URL_BASE;?>auctions/check_balance"><?php 
echo $user_current_balance;?></span><?php }?>
                </div>
                </div>
                <div class="header_right fl clr">
                    <div class="fr header_lang_content">
                    
                     <?php

if(($site_settings[0]['maintenance_mode'] != ACTIVE) || (isset($auction_userid) && $user_type == ADMIN)){ ?> 
                    
                         <div class="lang_select fr">
                            <!--Category fetch-->
			    <?php echo Form::input('category',__('pls_select_any_category'),array('id'=>'category_list','readonly'=>'readonly'));?>
                            <div id="div_category" style="display:none;">	
                                <ul class="fl">
				
                                    <?php foreach($category_list as $category):?>
                                    <li><a href="<?php echo URL_BASE;?>auctions/category/<?php echo $category['id'];?>" ><?php echo $category['category_name'];?></a></li>
                                    <?php endforeach;?>
                                </ul>
                            </div>
                            <!--End of category fetch-->
                            
                            
                        </div>
                        
                        
                        
                        
                        
			<?php 
			$user_settings=Commonfunction::get_user_settings();
			if(count($user_settings)>0){
					if($user_settings[0]['allow_user_language']==YES){?>
                        <div class="action_select fr mr20">
                        	<form name="lang" id="lang" method="post">
                                <select name="language" id="language" onchange="javascript:form.submit();">
                                <?php 
                                foreach($alllang as $language)  
                                { 
                                $a=array_search( $language,$alllang);
                                //$a=key($alllang);
                                ?>
                                <option value="<?php echo $a; ?>" <?php echo ($curr_lan == $a)?"selected='selected'":"";?> ><?php echo $language; ?></option>
                                <?php  } ?>
                                </select> 
                         	</form>
                        </div>
<?php } }?>
           
              <?php }?>
                       
                    </div>
                </div>

                <div class="main_menu fl clr">
                <?php

if(($site_settings[0]['maintenance_mode'] != ACTIVE) || (isset($auction_userid) && $user_type == ADMIN)){ ?>
                    <ul class="fr">	
                        <li class="fl" id="home_menu" >
                            <a href="<?php echo URL_BASE;?>" title="<?php echo __('menu_home');?>" class="fl">
                                <span class="menu_left fl">&nbsp;</span>
                                <span class="menu_middle fl"><?php echo __('menu_home');?></span>
                                <span class="menu_left menu_right fl">&nbsp;</span>
                            </a>
                        </li>
                        <li class="fl" id="live_menu">
                            <a href="<?php echo URL_BASE;?>auctions/live" title="<?php echo __('menu_live_auction');?>" class="fl">
                                <span class="menu_left fl">&nbsp;</span>
                                <span class="menu_middle fl"><?php echo __('menu_live_auction');?></span>
                                <span class="menu_left menu_right fl">&nbsp;</span>

                            </a>
                        </li>
                        <li class="fl"  id="future_menu">
                            <a href="<?php echo URL_BASE;?>auctions/future" title="<?php echo __('menu_future');?>" class="fl">
                                <span class="menu_left fl">&nbsp;</span>
                                <span class="menu_middle fl"><?php echo __('menu_future');?></span>
                                <span class="menu_left menu_right fl">&nbsp;</span>
                            </a>
                        </li>
                        <li class="fl" id="closed_menu">
                            <a href="<?php echo URL_BASE;?>auctions/closed" title="<?php echo __('menu_closed');?>" class="fl">
                                <span class="menu_left fl">&nbsp;</span>
                                <span class="menu_middle fl"><?php echo __('menu_closed');?></span>
                                <span class="menu_left menu_right fl">&nbsp;</span>
                            </a>
                        </li>
                        <li class="fl" id="buynow_menu">
                            <a href="<?php echo URL_BASE;?>auctions/buynow" title="<?php echo __('menu_buynow_auction');?>" class="fl">
                                <span class="menu_left fl">&nbsp;</span>
                                <span class="menu_middle fl"><?php echo __('menu_buynow_auction');?></span>
                                <span class="menu_left menu_right fl">&nbsp;</span>

                            </a>
                        </li>
                        <li class="fl" id="winner_menu">
                            <a href="<?php echo URL_BASE;?>auctions/winners" title="<?php echo __('menu_winners');?>" class="fl">
                                <span class="menu_left fl">&nbsp;</span>
                                <span class="menu_middle fl"><?php echo __('menu_winners');?></span>
                                <span class="menu_left menu_right fl">&nbsp;</span>
                            </a>
                        </li>
                        
                        <!--<li class="fl" id="news_menu">
                            <a href="<?php echo URL_BASE;?>news/news_details" title="<?php echo __('menu_news');?>" class="fl">
                                <span class="menu_left fl">&nbsp;</span>
                                <span class="menu_middle fl"><?php echo __('menu_news');?></span>
                                <span class="menu_left menu_right fl">&nbsp;</span>
                            </a>
                        </li>
                        <li class="fl"  id="blog_menu">
                            <a href="<?php echo URL_BASE;?>userblog/blog_details" title="<?php echo __('blog');?>" class="fl">
                                <span class="menu_left fl">&nbsp;</span>
                                <span class="menu_middle fl"><?php echo __('blog');?></span>
                                <span class="menu_left menu_right fl">&nbsp;</span>                            
                            </a>
                        </li>-->
                       
                        <li class="fl" id="packages_menu">
                            <a href="<?php echo URL_BASE;?>packages/" title="<?php echo __('buy_packages');?>" class="fl">
                                <span class="menu_left fl">&nbsp;</span>
                                <span class="menu_middle fl"><?php echo __('buy_packages');?></span>
                                <span class="menu_left menu_right fl">&nbsp;</span> 
                            </a>
                        </li>
                    </ul>
                    <?php }?>
            	</div>
       
            </div>
    	</div>
	</div>
</div>
