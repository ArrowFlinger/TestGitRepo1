<?php defined("SYSPATH") or die("No direct script access.");?>
<script type="text/javascript">
$(document).ready(function(){		
		 Auction.getauctionstatus(8,"","",{'search':'<?php echo $value;?>'});
});
</script>

<div class="banner_rgt">
	<div class="today_headss">
		<h2 title="<?php echo strtoupper(__('search_auctions'));?>"><?php echo strtoupper(__('search_auctions'));?></h2>
		<span class="arrow_one_fet"> &nbsp;</span>
	</div>
	<div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
    <div class="feature_total">
	<?php 
		$count=true;	  
		$content=$block="";
		if(count($auction_types) > 0){
					foreach($auction_types as $typeid => $typename){
								if(isset($products[$typeid])){
									$block = $typename::product_block($products[$typeid],8,array('search'=>$value));	
									$content.=$block;
									echo $block;							
								}
					}
				}
				if(trim($content)=="") { $count = false;}				
		?>
		<div class="user" style="display:none;" ><?php echo $user;?></div>
		<div class="clear"></div>		
		<?php if(!$count){?>
		<div class="banner_rgt">
			<div class="message_common">
				<h4 class="">
				<?php echo __("no_search_auction_found",array(":param" =>"<span style='font-size:18px;'>".$value."</span>" ));?>
				</h4> 
			</div>
		</div>
		<?php }?>	
	
</div>
</div>
</div>
</div>
</div>
</div>

