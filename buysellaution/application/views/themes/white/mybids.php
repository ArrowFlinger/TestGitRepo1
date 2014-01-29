<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="my_message_right" id="mybids_page">
	<div class="message_common_border">
		<h1 title="<?php echo strtoupper(__('my_bids'));?>"><?php echo __('my_bids');?></h1>
		<p>&nbsp;</p>
	</div>
	<?php if($count_bidhistory>0):?>
	<div class="message_common">
	<div class="forms_common">
		<div class="title_cont_watchilist">
                    <div class="title_cont_new_watch" >
                    <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0"  class="table-top">
                      
                        <thead>
                            <tr>
                    <th width="100" align="center"><b><?php echo __('image');?></b></th>
                    <th width="100" align="center"><b><?php echo __('title');?></b></th>
                     <th width="100" align="center"><b><?php echo __('end_time');?></b></th>
                     <th width="100" align="center"><b><?php echo __('total_bids');?></b></th>
                     <th width="100" align="center"><b><?php echo __('status_label');?></b></th>
                    </tr>
                        </thead>
                   
		
		 <?php foreach($bidhistories as $bidhistory):?>
            <tr>
		
                
		<td width="100" align="center">
               
		<a href="<?php echo URL_BASE;?>auctions/view/<?php echo $bidhistory['product_url'];?>" title="<?php echo ucfirst($bidhistory['product_name']);?>">
			<?php if(($bidhistory['product_image'])!="" && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB.$bidhistory['product_image']))
			{ 
				$product_img_path=URL_BASE.PRODUCTS_IMGPATH_THUMB.$bidhistory['product_image'];	
			}
			else
			{
				$product_img_path=IMGPATH.NO_IMAGE;
			}
			?>
		 <img  src="<?php echo $product_img_path;?>" width="65" height="65" title="<?php echo ucfirst($bidhistory['product_name']);?>"/>
		
               
		
                </td>
                <td width="100" align="center">
		
			<a title="<?php echo ucfirst($bidhistory['product_name']);?>"  href="<?php echo URL_BASE;?>auctions/view/<?php echo $bidhistory['product_url'];?>"> <?php echo strlen($bidhistory['product_name'])>19?ucfirst(Text::limit_chars($bidhistory['product_name'],15))."...":ucfirst($bidhistory['product_name']);?></a>
		
                </td>
                  <td width="100" align="center">
		
			<h2 style="width:122px;"><?php echo $bidhistory['enddate'];?></h2>
		
                  </td>
                    <td width="100" align="center">
		
			<h2><?php echo  $bidhistory['count('.BID_HISTORIES.'.product_id)'];?></h2>
		
                    </td>
		<!--<div class="messages_new_watch" style="width:76px;">
			<h2 style="width:60px;"><?php echo  $site_currency." ".Commonfunction::numberformat($bidhistory['max('.BID_HISTORIES.'.price)']);?></h2>
		</div>-->
                <td width="100" align="center">
		
	  <?php echo $bidhistory['in_auction']!=2?"<a  href='".URL_BASE."auctions/view/".$bidhistory['product_url']."' class='delet_link' title='".__('live_text')."'>".__('live_text')."</a>":"<h2>".__('closed_text')."</h2>";?>
		
                </td>
		
        </tr>
        
                   
	  <?php endforeach;?>
                    </table></div>	</div>
            
	</div>
	 <div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
	</div>
		
	<?php else:?>
	<div class="message_common">
		<h4  style="float:none;"><?php echo __("no_bids_detail_at_the_moment");?></h4>
		</div>
	<?php endif;?>
	<?php if($count_bidhistory>0):?>
	<div class="nauction_paginations">
			<p><?php echo $pagination->render(); ?></p>
			</div>
		  <?php endif;?>  
	</div>
	</div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function () {$("#my_bids_active").addClass("act_class");});
</script>

