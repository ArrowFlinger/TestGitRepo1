<?php defined('SYSPATH') OR die("No direct access allowed."); ?>
<!-- header start--> 
<link href="<?php echo CSSPATH;?>slider.css" rel="stylesheet" type="text/css" />

<!--select_box_top-->
<link rel="stylesheet" type="text/css" href="<?php echo CSSPATH;?>stylish-select.css" />
<!--<script type="text/javascript" src="<?php echo SCRIPTPATH;?>plugin.js"></script>-->
<script src="<?php echo SCRIPTPATH;?>jquery.stylish-select.js" type="text/javascript"></script>

<script type="text/javascript">

            $(document).ready(function(){
			
		  $('#drop_down_cat').click(function(){
			
			
			if($('#div_category').css('display') == 'none'){ 
			$('#div_category').show(); 
			} else { 
			$('#div_category').hide();
			}
		
                });
		  
		
	
                $('#my-dropdown, #my-dropdown2, #my-dropdown3, #my-dropdown4, #my-dropdown5, #my-dropdown6').sSelect();
		
                //set max height
                $('#my-dropdownCountries').sSelect({ddMaxHeight: '300px'});
		
                //set value on click
                $('#setVal').click(function(){
                    $('#my-dropdown5').getSetSSValue('4');
                });

                //get value on click
                $('#getVal').click(function(){
                    alert('The value is: '+$('#my-dropdown5').getSetSSValue());
                });

                //alert change event
                $('#my-dropdownChange').sSelect().change(function(){alert('changed')});

                
                    return false;
            
            });
        </script>
  <div id="header">
    <div class="header_inner">
      <div class="header_lft">
              <?php
if(($site_settings[0]['maintenance_mode'] != ACTIVE) || (isset($auction_userid) && $user_type == ADMIN)){ ?>
        <p><?php echo __('bidding_type_label');?>  :</p>
        <ul>
          <li style="background:none;"><img src="<?php echo IMGPATH;?>head_top1_bg.png" width="18" height="18" alt="Beginner" /><a title="<?php echo __('beginner_label');?>"><?php echo __('beginner_label');?></a></li>
          <li><img src="<?php echo IMGPATH;?>head_top2_bg.png" width="18" height="18" alt="Penny auction" /><a title="<?php echo __('penny_label');?>"><?php echo __('penny_label');?></a></li>
          <li><img src="<?php echo IMGPATH;?>head_top3_bg.png" width="18" height="18" alt="Peak auction" /><a title="<?php echo __('peak_label');?>"><?php echo __('peak_label');?></a></li>
          <li><img src="<?php echo IMGPATH;?>reserve_icon1.png" width="17" height="17" alt="Reserve auction" /><a  title="Reserve auction">Reserve auction</a></li>
        </ul>
        <?php }?>
      </div>
      <div class="header_rgt">
        <div class="header_right">
         <?php
if(($site_settings[0]['maintenance_mode'] != ACTIVE) || (isset($auction_userid) && $user_type == ADMIN)){ ?>
        <?php 
							$user_settings=Commonfunction::get_user_settings();
							if(count($user_settings)>0)
							{
							if($user_settings[0]['allow_user_language']==YES)
							{?>
							<form name="lang" id="lang" method="post">
          <!--select_box-->
          <div class="selCont" style="margin-bottom:0px;padding-bottom:0px;">
            <select name="language" id="my-dropdown" onchange="javascript:form.submit();">
            <?php 
								foreach($alllang as $language)  
									{
									$a=array_search( $language,$alllang);
									?>
                <option value="<?php echo $a; ?>" <?php echo ($curr_lan == $a)?"selected='selected'":"";?> ><?php echo $language;  ?></option><?php  } ?>
                
            </select>
            </div>
            </form>
            <?php }
          }?>
		<ul>
		<?php if($auction_userid):?>		
			<li><a href="<?php echo URL_BASE;?>users/" title="<?php echo __('menu_users');?>" ><?php echo __('menu_users');?></a></li>
			<li class="active"><a href="<?php echo URL_BASE;?>users/logout" title="<?php echo __('menu_logout');?>"><?php echo __('menu_logout');?></a></li>

		<?php else:?>

			<li><a href="<?php echo URL_BASE;?>users/login" title="<?php echo __('menu_signin');?>"><?php echo __('menu_signin');?></a></li>
			<li class="active"><a href="<?php echo URL_BASE;?>users/signup" title="<?php echo __('menu_register');?>"><?php echo __('menu_register');?></a></li>
		<?php endif;?>		
		</ul>
		<?php }?>
		  </div>
		   </div>
   </div>
 </div>

 
  <div class="header2">
    <div class="header2_lft">
     <?php
if(($site_settings[0]['maintenance_mode'] != ACTIVE) || (isset($auction_userid) && $user_type == ADMIN)){ ?>
		<?php if($site_settings[0]['site_logo']==0) { ?>
                    	<h1  title="<?php echo $site_name;?>">
                	<a href="<?php echo URL_BASE;?>" title="<?php echo $site_name;?>" class="fl">
                    	<img src="<?php echo IMGPATH.'action-logo.png';?>" alt="<?php echo $site_name;?>" title="<?php echo $site_name;?>" border="0"  width="221" height="46" /> 
                    	 </a>
                </h1><?php } else {?>
                <h1  title="<?php echo $site_name;?>">
            	<a href="<?php echo URL_BASE;?>" title="<?php echo $site_name;?>" class="fl">
                    	<img src="<?php echo URL_BASE.LOGO_IMGPATH.$site_settings[0]['site_logo'];?>" alt="<?php echo $site_name;?>" title="<?php echo $site_name;?>" border="0" width="221" height="46" />
                    	 </a>
                </h1> <?php } } ?>
	
    </div>
    
    <div class="header2_rgt">
   <?php
if(($site_settings[0]['maintenance_mode'] != ACTIVE) || (isset($auction_userid) && $user_type == ADMIN)){ ?>
  <div class="dash_rgt">
    <ul>
        
        <li>
		<?php if($auction_userid){ ?>
		<label><?php echo __('welcome_label');?> <?php echo ucfirst($auction_username);?>,</label>
                
        </li>
        <li>
            	<p><?php echo __('balance_amount_label')?>:</p>
                
		<span><?php echo $site_currency;?></span><span class="user_balance" title="<?php echo URL_BASE;?>auctions/check_balance">  <?php echo $user_current_balance;?></span>
        </li>
        <li>
                <p> <?php echo __('bonus_balance_amount_label');?>:</p>
		<span title="<?php echo URL_BASE;?>auctions/check_bonus" class="user_bonus"> <span style="padding-top:0px;"><?php echo $site_currency; ?></span> &nbsp; <?php echo "<b>".$user_current_bonus."</b>";?></span>
        </li>
    </li></ul>
    <?php }  
}
?>

   <?php
if(($site_settings[0]['maintenance_mode'] != ACTIVE) || (isset($auction_userid) && $user_type == ADMIN)){ ?>
      <div class="search_total">
        <div class="search_total_lft"> </div>
        <div class="search_total_midd">
          <div class="search_lft">
              <div class="search_icon"></div>
              
              
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
            <input type="text" value="<?php echo $valuess!=''?$valuess:__('search_text');?>" name="search" class="fl" onfocus="if (this.value=='<?php echo __('search_text');?>') this.value='';" onblur="if (this.value=='') this.value='<?php echo __('search_text');?>'" id="search" maxlength="300" />
             </form>
          </div>
          <div class="search_rgt"  >
            <div class="search_button"   >
              <div class="search_button_lft"></div>
              <div class="search_button_mid" style="cursor:pointer;" >
                <p  style="cursor:pointer;" ><a class="fl" onclick="document.user_search.submit();" class="clicksearch"   title="<?php echo strtoupper (__('button_search')); ?>"><?php echo strtoupper (__('button_search')); ?></a></p>
              </div>
              <div class="search_button_rgt"></div>
            </div>
          </div>
       
        </div>
        <div class="search_total_rgt"></div>
      </div>
    </div>
      <?php }?>
  </div>
   
</div>
<div id="header_menu">
  <div class="header_menu_inner">
      <?php
if(($site_settings[0]['maintenance_mode'] != ACTIVE) || (isset($auction_userid) && $user_type == ADMIN)){ ?>
		<ul>
			<li id="head_cate">
				    
			<?php   
				    if((preg_match('/auctions\/category/i',Request::detect_uri())  ))
				    
				    {
						$category_name=Request::current()->param('id');
						if($category_name!='')
						{
							   $cname= ucfirst($category_list_white[$category_name]);
						}else
						{
							    $cname=__('ALL_CATEGORIES');
						}
						
				    }else{
						
					 $cname=__('select_category_label');
					 
				    }
			
			
			?>	    
				  
				    
				<a style="cursor:pointer;" style="font-weight:bold;padding:8px 5px;" id="category_list"  title="<?php echo $cname; ?>"><?php echo $cname; ?>
				</a>
				<span style="padding:8px 5px;" >
				<img id="drop_down_cat"  src="<?php echo IMGPATH;?>menu_select.png" align="middle" width="8" height="5" alt="" border="0" title="<?php echo  __('ALL_CATEGORIES'); ?>"/>
				</a>
				
				<div id="div_category" style="display:none;">	
					<ul class="fl">
						
						<li><a style="width:102px;" href="<?php echo URL_BASE;?>auctions/category/" ><?php echo ucfirst(__('ALL_CATEGORIES'));?></a></li>
						
						<?php foreach($category_list_white as $id=>$category_name):?>
							<li><a href="<?php echo URL_BASE;?>auctions/category/<?php echo $id;?>" ><?php echo ucfirst($category_name);?></a></li>
						<?php endforeach;?>
					</ul>
				</div>
			</li>
      
      <li id="home_menu"> <a href="<?php echo URL_BASE;?>" title="<?php echo ucfirst(__('menu_home'));?>"> <?php echo ucfirst(__('menu_home'));?></a></li>
      <li id="live_menu"><a href="<?php echo URL_BASE;?>auctions/live" title="<?php echo ucfirst(__('menu_live_auction'));?>"> <?php echo ucfirst(__('menu_live_auction'));?></a></li>
      <li  id="future_menu"><a href="<?php echo URL_BASE;?>auctions/future" title="<?php echo ucfirst (__('menu_future'));?>"> <?php echo ucfirst (__('menu_future'));?> </a></li>
      <li id="closed_menu"><a href="<?php echo URL_BASE;?>auctions/closed" title="<?php echo ucfirst (__('menu_closed'));?>"> <?php echo ucfirst (__('menu_closed'));?></a></li>
       <li id="buynow_menu"><a href="<?php echo URL_BASE;?>auctions/buynow" title="<?php echo ucfirst(__('menu_buynow_auction'));?>"> <?php echo ucfirst (__('menu_buynow_auction'));?></a></li>          
      <li id="winner_menu"><a href="<?php echo URL_BASE;?>auctions/winners" title="<?php echo ucfirst (__('menu_winners'));?>"> <?php echo ucfirst (__('menu_winners'));?></a></li>
      <li id="news_menu"><a href="<?php echo URL_BASE;?>news/news_details" title="<?php echo ucfirst (__('menu_news'));?>"> <?php echo ucfirst (__('menu_news'));?></a></li>
      <li id="packages_menu"><a href="<?php echo URL_BASE;?>packages/" title="<?php echo ucfirst (__('buy_packages'));?>"> <?php echo ucfirst (__('buy_packages'));?></a></li>
    </ul>
    <?php }?>
  </div>
</div>

</div>



<!--header menu-->
<!--header end-->
