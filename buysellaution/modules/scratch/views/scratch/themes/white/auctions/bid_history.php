<?php defined("SYSPATH") or die("No direct script access.");?>
 <link href="<?php echo CSSPATH;?>slider.css" rel="stylesheet" type="text/css" />
 <div class="detail_big_history_content"><p><?php echo count($bid_histories)." ".__('bids_total');?></p>  </div>

       <div class="detail_big_history_current_winning"><h1><?php echo __('current_winning_bidder');?></h1> </div>        
       <div class="winning_list"> 
       <?php if($count > 0){?>
       <ul>
			<?php $j=0; $i=0;foreach($bid_histories as $bid_history):?>
				<?php if($j < 6){ ?>
					<li>
						<div class="winning_list_left">
							<h1><?php echo ucfirst($bid_history['username']);?></h1>
							<p><?php echo $bid_history['date'];?></p>
						</div>
						<div class="winning_list_right">
							<p><?php echo $site_currency." ".number_format($bid_history['price'], 2, '.', '');$j++; ?></p>
						</div>
					</li>
				<?php } ?>
			<?php endforeach;?>
			<div> <a class="detail_winner_down_list" title="Arrow" href="">  </a>  </div>
         </ul>
		<?php }  else { ?>
		<ul>
			<li> <p class="no_data"><?php echo __('no_bids_yet');?></p> </li>
        </ul>
        <?php }?>
    </div>



