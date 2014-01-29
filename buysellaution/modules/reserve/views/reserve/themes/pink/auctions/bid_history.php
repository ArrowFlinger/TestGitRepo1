<table cellpadding="0" cellspacing="0" border="0" width="257" class="table-bid-history reserve fl">
  <?php if($count > 0){?>
   <?php $j=0; $i=0;foreach($bid_histories as $bid_history):?>
				<?php if($j < 6){ ?>
  <tr style="float:left;width:258px;border-bottom: 1px solid #e2e1e1;">
    <td style="border-right: 1px solid #e2e1e1;word-wrap:break-word;color: #868686;font-weight: bold;list-style: none outside none;padding: 10px;text-align: center;width:65px;"><?php echo $site_currency." ".number_format($bid_history['price'], 2, '.', '');$j++; ?></td>
    <td align="center" style="border-right: 1px solid #e2e1e1;word-wrap:break-word;color: #868686;font-weight: bold;list-style: none outside none;padding: 10px;text-align: center;width:65px;"><?php echo $bid_history['bidder_name'];?></p></td>
    <td align="center" style="border-right:none;word-wrap:break-word;color: #868686;font-weight: bold;list-style: none outside none;padding: 10px;text-align: center;width:65px;"><?php echo $bid_history['date'];?></td>
 	
  </tr>
  <?php } ?>
			<?php endforeach;?>	
  <?php }  else { ?>
  <table cellpadding="0" cellspacing="0" border="0" width="284">
    <tr>
      <td><p class="no_data"><?php echo __('no_bids_yet');?></p></td>
    </tr>
  </table>
  <?php }?>
</table>
