<?php defined('SYSPATH') or die('No direct script access.');?>     
 <ul> 
<li class="firs_list_blue"><div class="blue_price"><?php echo __('range_label');?></div><div class="blue_bidder"><?php echo __('Bidder_label');?></div> <div class="blue_date"><?php echo __('Date_label');?></div> <div class="blue_type_bid"><?php echo __('Bid_typelabel');?></div>  </li>
		 <?php

		$bid_history_array = array();

		foreach($bid_history_all as $bid_history_allusers):
		
		array_push($bid_history_array,$bid_history_allusers['price']);
                 endforeach;

		$bid_history_unique_array = array_unique($bid_history_array);
		sort($bid_history_unique_array);
     
               
		$bid_history_value_count = array_count_values($bid_history_array);
		
	 if($count > 0){?>
	      
        <?php $i=0;foreach($bid_histories as $bid_history): ?>
                  
        <?php $bg_none=($i==$count-1)?'bg_none':"";?>


        
                    <li class="blue_list_bg1">
                    <div class="blue_price1" id="black_sp_blue_price1" >
		    <?php  echo $site_currency." ".$bid_history['price'];?>
                    </div>
                    <div class="blue_bidder1" id="black_sp_blue_price1" ><?php echo $bid_history['username'];?></div>
                    <div class="blue_date1"><?php echo $bid_history['date'];?></div>
                    <div class="blue_type_bid1"> <span style="color:#FF8810;width:100%;font:normal 11px/15px arial;float:left;text-align:center;" title="highest but not unique">
                     <?php  
		
					if($bid_history_value_count[$bid_history['price']] != 1){ ?>
					<span style=""><?php echo __('not_unique_label'); ?></span>
					<?php } elseif(max($bid_history_unique_array) == $bid_history['price'] ) { ?>

					<span><?php echo __('high_unique_label'); ?> </span>

					<?php	}else{ ?>

					<span> <?php echo __('unique_but_not_highest_label');?></span>	
					<?php } ?>
                    </span></div>
                    </li>
                    <?php  endforeach;?>
        </ul>        			
        <?php }  else { ?>        
        <ul>
            <li class="fl">
            	<p class="no_data"><?php echo __('no_bids_yet');?></p> </li>
        </ul>        
		<?php }?>
