<?php defined("SYSPATH") or die("No direct script access."); ?>
   <div class="banner_right" id="packages_page">
        <div class="banner_top_part"> </div>
        <div class="today_headss">
          <h2 title="<?php echo strtoupper(__('menu_buy_packages'));?>"><?php echo __('menu_buy_packages');?></h2>
          <div class="arrow_ones"></div> </div>
        <div class="feature_totals"><div class="message_common">
         <?php if($count_package_result>0):?>
        <?php  
                $count=$count_package_result;
                $i=0;
                foreach($package_results as $package_result):
                $bg_none=($i==$count-1)?'bg_none':"";
         ?>
          <div class="pack" id="packages_page">
            <h2><?php echo ucfirst($package_result['name']);?></h2>
            <div class="back_top1">
				  <p><?php echo $site_currency;?>.&nbsp;<?php echo Commonfunction::numberformat($package_result['price']);?></p>
				  <div class="button_green">
						<div class="button_green_left"></div>
						<div class="button_green_mid">
						  
						    <?php
		  
		  $param = array( array(array('form[id][]'=>$package_result['package_id'],'form[unitprice][]'=>$package_result['price'],'form[quantity][]' => 1,'form[name][]' => $package_result['name'],'form[type]' =>'package','form[nauction_type]' =>'package')),$site_currency,$i,URL_BASE."process/gateway");  
		    
		    call_user_func_array('Commonfunction::showlinkdata', $param);
		    
		    ?>	
						  
						  
						<!--  <a title="<?php echo ucfirst(__('buy'));?>"href="<?php echo URL_BASE;?>packages/package/<?php echo $package_result['package_id'];?>"><?php echo ucfirst(__('buy'));?></a>--></div>
						<div class="button_green_right"></div>
				  </div>
              <div class="pays">
	       <?php
		  
		  $param = array( array(array('form[id][]'=>$package_result['package_id'],'form[unitprice][]'=>$package_result['price'],'form[quantity][]' => 1,'form[name][]' => $package_result['name'],'form[type]' =>'package','form[nauction_type]' =>'package')),$site_currency,$i,URL_BASE."process/gateway");  
		    
		    call_user_func_array('Commonfunction::showlinkdata', $param);
		    
		    ?>	      </div>
            </div>
          </div>
           <?php $i++; endforeach; ?>
           <div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
	<?php else:?>
	<h4 class="no_data fl clr"><?php echo __("no_packages_at_the_moment");?></h4>
	<?php endif;?>

</div>
	<div class="nauction_pagination">
       <?php if($package_results > 0): ?>
	 <p class="fl"><?php echo $pagination->render(); ?></p>  
	<?php endif; ?>
        </div>
</div></div>
</div>
      

<script type="text/javascript">
$(document).ready(function () {$("#packages_menu").addClass("fl active");});
$(document).ready(function () {$("#menu_purchas_active").addClass("act_class");});
</script>
