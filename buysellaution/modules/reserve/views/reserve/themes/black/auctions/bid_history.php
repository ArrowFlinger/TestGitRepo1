<?php 
	//echo $user_id;

if($count > 0){?>

<?php $j=0; $i=0;foreach($bid_histories as $bid_history):?>
				<?php if($j < 6){ ?>
		<table cellpadding="0" cellspacing="0" border="0" width="316">
                    	
		<tr>
                            <td width="80" align="center"><?php echo $site_currency." ".number_format($bid_history['price'], 2, '.', '');$j++; ?></td>
                            <td width="105" align="center"><?php echo $bid_history['bidder_name']; ?></td>
                            <td width="82" align="center"><?php echo $bid_history['date'];?></td>
				
                        </tr></table> <?php } ?>
			<?php endforeach;?>		
		<?php }  else { ?><p class="no_data fl" style="margin:0 0 0 10px;"><?php echo __('no_bids_yet');?></p><?php }?>
