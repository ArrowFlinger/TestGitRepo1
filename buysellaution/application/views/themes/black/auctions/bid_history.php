<?php 
	//echo $user_id;

if($count > 0){?>

<?php $i=0;foreach($bid_histories as $bid_history):?>
		<?php $bg_none=($i==$count-1)?'bg_none':"";?>
		<table cellpadding="0" cellspacing="0" border="0" width="316">
                    	
		<tr>
                            <td width="80" align="center"><?php echo $site_currency." ".Commonfunction::numberformat($bid_history['price']);?></td>
                            <td width="105" align="center"><?php echo $bid_history['username'];?></td>
                            <td width="82" align="center"><?php echo $bid_history['date'];?></td>
				<td width="82" align="center"><?php echo ($bid_history['bid_type']=='AB')?'Auto Bid':'Single Bid';?></td>
                        </tr></table><?php endforeach;?>		
		<?php }  else { ?><p class="no_data fl" style="margin:0 0 0 10px;"><?php echo __('no_bids_yet');?></p><?php }?>
