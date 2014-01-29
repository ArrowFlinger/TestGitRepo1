<table cellpadding="0" cellspacing="0" border="0" width="257" class="table-bid-history fl">
  <?php if($count > 0){?>
  <?php $i=0;foreach($bid_histories as $bid_history):?>
  <?php $bg_none=($i==$count-1)?'bg_none':"";?>
  <tr style="float:left;width:258px;border-bottom: 1px solid #e2e1e1;">
    <td style="border-right: 1px solid #e2e1e1;word-wrap:break-word;color: #868686;font-weight: bold;list-style: none outside none;padding: 10px 0;text-align: center;width:65px;"><?php echo $site_currency." ".Commonfunction::numberformat($bid_history['price']);?></td>
    <td align="center" style="border-right: 1px solid #e2e1e1;word-wrap:break-word;color: #868686;font-weight: bold;list-style: none outside none;padding: 10px 0 0px 0px;text-align: center;width:65px;"><?php echo $bid_history['username'];?></p></td>
    <td align="center" style="border-right: 1px solid #e2e1e1;word-wrap:break-word;color: #868686;font-weight: bold;list-style: none outside none;padding: 10px 0;text-align: center;width:60px;"><?php echo $bid_history['date'];?></td>
 <td style="width:60px; word-wrap:break-word;color: #868686;font-weight: bold;list-style: none outside none;padding: 10px 0;text-align: center;width:60px"> <?php echo ($bid_history['bid_type']=='AB')?'Auto Bid':'Single Bid';?></td>		
  </tr>
  <?php endforeach;?>
  <?php }  else { ?>
  <table cellpadding="0" cellspacing="0" border="0" width="284">
    <tr>
      <td><p class="no_data"><?php echo __('no_bids_yet');?></p></td>
    </tr>
  </table>
  <?php }?>
</table>
