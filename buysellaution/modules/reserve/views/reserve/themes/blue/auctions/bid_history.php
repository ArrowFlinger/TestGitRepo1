<ul class="table-bid-history reserve">
        <?php if($count > 0){ ?>
       <?php $j=0; $i=0;foreach($bid_histories as $bid_history):?>
				<?php if($j < 6){ ?>
        <ul>
  <li class="fl" style="border-right: 1px solid #e2e1e1;border-bottom: 1px solid #e2e1e1;word-wrap:break-word;color: #868686;font-weight: bold;list-style: none outside none;padding: 10px 0;text-align: center;width:78px;">
               <?php echo $site_currency." ".number_format($bid_history['price'], 2, '.', '');$j++; ?></li>
    <li class="fl" style="width:80px;border-right: 1px solid #e2e1e1;border-bottom: 1px solid #e2e1e1;word-wrap:break-word;color: #868686;font-weight: bold;list-style: none outside none;padding: 10px 0;text-align: center;"><?php echo $bid_history['bidder_name'];?>
    </li>
    
                <li class="fl" style="width:98px; word-wrap:break-word;border-bottom: 1px solid #e2e1e1;color: #868686;font-weight: bold;list-style: none outside none;padding: 10px 0;text-align: center;"> <?php echo $bid_history['date'];?></li>
		

</ul>
<?php } ?>
			<?php endforeach;?>	
        <?php }  else { ?>
        
        <ul>
            <li class="fl">
            	<p class="no_data"><?php echo __('no_bids_yet');?></p> </li>
        </ul>
        
		<?php }?>
        
</ul>
<script type="text/javascript">
$(function(){
$("ul.table-bid-history ul:last li").css({'border-bottom':'none'});
		   });
</script>
