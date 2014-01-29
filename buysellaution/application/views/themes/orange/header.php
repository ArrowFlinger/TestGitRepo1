<?php defined('SYSPATH') OR die("No direct access allowed."); ?>

<div class="header_outer clr">
<div class="header-outer-block fl">
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
                <?php }?>
            </div>
            <div class="header_right_out fr">
            	<div class="header_right fl clr">
                	<div class="header_top_menu fr">
                	
<?php
if(($site_settings[0]['maintenance_mode'] != ACTIVE) || (isset($auction_userid) && $user_type == ADMIN)){ ?>
                    	<div class="topmenu_left fl"></div>
                        <div class="topmenu_middle fl">
                        
                        	<ul class="fl">
				<?php $static=Commonfunction::get_staticpage_content("header");				
					foreach($static as $sta):?>
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
                           
                        </div>
                        <div class="topmenu_left topmenu_right fl"></div>
                         <?php }?> 
                    </div>
                    
<?php
if(($site_settings[0]['maintenance_mode'] != ACTIVE) || (isset($auction_userid) && $user_type == ADMIN)){ ?>
                    <?php if(!$auction_userid):?>
              <div class="connect-block fr">
              <?php $fb_settings=Commonfunction::get_facebook_settings();
                if($fb_settings[0]['facebook_login']==YES)
                {?>
                        <?php if(!$auction_userid):?>
                        <a href="<?php echo URL_BASE;?>users/facebook" title="<?php echo __('fb_connect');?>" class="fl f_connect_link">
                        <img src="<?php echo IMGPATH.'f_connect.png';?>" alt="<?php echo __('fb_connect');?>" title="<?php echo __('fb_connect');?>" border="0" class="fl" />
                        </a><?php endif;?>
                        <?php 
                } ?>
                <?php 
                if($fb_settings[0]['twitter_login']==YES)
                {?>
                         <?php if(!$auction_userid):?>
                        <a href="<?php echo URL_BASE;?>socialnetwork/twitterlogin" alt="<?php echo __('tw_connect');?>" class="f_connect_link fl fbook_login" title="<?php echo __('tw_connect');?>"><img src="<?php echo IMGPATH.'tweet.png';?>"/></a><?php endif;?>
                <?php 
                } ?>        
                </div>
                <?php endif;?>
        	<?php 
			$user_settings=Commonfunction::get_user_settings();
			if(count($user_settings)>0){
					if($user_settings[0]['allow_user_language']==YES){?>
                        <div class="action_select fr">
                      	<form name="lang" id="lang" method="post">
                                <select name="language" id="language" onchange="javascript:form.submit();"  >
                                <?php 
                                foreach($alllang as $language)  
                                { 
                                $a=array_search( $language,$alllang);
                                ?>
                                <option value="<?php echo $a; ?>" <?php echo ($curr_lan == $a)?"selected='selected'":"";?> ><?php echo $language; ?></option>
                                <?php  } ?>
                                </select> 
                         	</form> 
                         	<?php }?>
                        </div>
                       
                        
<?php } }?>
                </div>
                <div class="header_right fl clr mt5">
                <div class="header_right_middle fr">
                
<?php
if(($site_settings[0]['maintenance_mode'] != ACTIVE) || (isset($auction_userid) && $user_type == ADMIN)){ ?>
                	<?php if($auction_userid){?><?php echo __('welcome_label')." <b>".ucfirst($auction_username); echo"</b>&nbsp;";
					echo __('balance_amount_label').": <b>".$site_currency."</b>"; ?>
					<span class="user_balance" title="<?php echo URL_BASE;?>auctions/check_balance"><?php 
echo $user_current_balance;?></span> <?php echo __('bonus_balance_amount_label').": <b>".$site_currency."</b>"; ?>
					<span class="user_bonus" title="<?php echo URL_BASE;?>auctions/check_bonus"><?php 
echo "<b>".$user_current_bonus."</b>";?></span>
					<?php } else {?><span class="user_balance" style="display:none;" title="<?php echo URL_BASE;?>auctions/check_balance"><?php 
echo $user_current_balance;?></span><?php }?>
<?php }?>
                </div>
                </div>
                <div class="header_right fl clr">
                
<?php
if(($site_settings[0]['maintenance_mode'] != ACTIVE) || (isset($auction_userid) && $user_type == ADMIN)){ ?>
                <div class="fr search-block clearfix">
                
                <?php
                if(isset($_GET['search']))
                {
                         $valuess=ucfirst(Text::limit_chars($_GET['search'],20));
                }	
                else
                {
                        $valuess="";
                }
                ?>
                <form action="<?php echo URL_BASE;?>auctions/search/" id="user_search" name="user_search" method="get">
                        <span class="search_bg fl"><input type="text" value="<?php echo $valuess!=''?$valuess:__('search_text');?>" name="search" class="fl" onfocus="if (this.value=='<?php echo __('search_text');?>') this.value='';" onblur="if (this.value=='') this.value='<?php echo __('search_text');?>'" id="search" maxlength="300" /></span>	
                        <a class="fl" onclick="document.user_search.submit();" class="clicksearch" href="#" title="Search"><img src="<?php echo IMGPATH;?>search_button.png" width="18" height="18" alt="Search" border="0" class="fl" /></a>  
                </form>
                <?php }?>
                </div>
                </div>
            </div>
    	</div>
	</div>
    </div>
   <div class="main_menu fl clr">
   <div class="menu-inner clearfix">
   
<?php
if(($site_settings[0]['maintenance_mode'] != ACTIVE) || (isset($auction_userid) && $user_type == ADMIN)){ ?>
                    <ul class="clearfix">	
                        <li class="fl" id="home_menu" >
                            <a href="<?php echo URL_BASE;?>" title="<?php echo __('menu_home');?>" class="fl">
                                     <?php echo __('menu_home');?>  
                            </a>
                        </li>
                        <li class="sep">&nbsp;</li>
                        <li class="fl" id="live_menu">
                            <a href="<?php echo URL_BASE;?>auctions/live" title="<?php echo __('menu_live_auction');?>" class="fl">
                             <?php echo __('menu_live_auction');?>
                            </a>
                        </li>
                        <li class="sep">&nbsp;</li>
                        <li class="fl"  id="future_menu">
                            <a href="<?php echo URL_BASE;?>auctions/future" title="<?php echo __('menu_future');?>" class="fl">
                             <?php echo __('menu_future');?>
                            </a>
                        </li>
                        <li class="sep">&nbsp;</li>
                        <li class="fl" id="closed_menu">
                            <a href="<?php echo URL_BASE;?>auctions/closed" title="<?php echo __('menu_closed');?>" class="fl">
                                <?php echo __('menu_closed');?>
                            </a>
                        </li>
                         <li class="sep">&nbsp;</li>
                        <li class="fl" id="buynow_menu">
                            <a href="<?php echo URL_BASE;?>auctions/buynow" title="<?php echo __('menu_buynow_auction');?>" class="fl">
                             <?php echo __('menu_buynow_auction');?>
                            </a>
                        </li>
                        <li class="sep">&nbsp;</li>
                        <li class="fl" id="winner_menu">
                            <a href="<?php echo URL_BASE;?>auctions/winners" title="<?php echo __('menu_winners');?>" class="fl">
                            <?php echo __('menu_winners');?>
                            </a>
                        </li>
                        <li class="sep">&nbsp;</li>
                        <li class="fl" id="news_menu">
                        <a href="<?php echo URL_BASE;?>news/news_details" title="<?php echo __('menu_news');?>" class="fl"><?php echo __('menu_news');?></a>
                        </li>
                        <li class="sep">&nbsp;</li>
                        <li class="fl" id="packages_menu">
                            <a href="<?php echo URL_BASE;?>packages/" title="<?php echo __('buy_packages');?>" class="fl">
                               <?php echo __('buy_packages');?>
                            </a>
                    </li>
                </ul>
                <?php }?>
            </div>
            
      </div>
</div>
