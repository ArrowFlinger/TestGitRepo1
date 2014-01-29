<?php defined("SYSPATH") or die("No direct script access."); ?>
<script type="text/javascript">
$(document).ready(function(){		
		 Auction.getauctionstatus(8,"","",{'search':'<?php echo $category;?>'});
});
</script>
<div class="content_left_out fl">
<div class="content_left fl">
        <div class="title-left title_temp1">
        <div class="title-right">
        <div class="title-mid"> 
        <h2 class="fl" title="<?php echo __('category_selected');?>"><?php echo __("category_selected");?>: <?php echo $category;?></h2>
        <div class="lang_select fr">
             <!--Category fetch-->
	    <?php echo Form::input('category',__('pls_select_any_category'),array('id'=>'category_list','readonly'=>'readonly'));?>
            <div id="div_category" style="display:none;">
                <ul class="fl">
                    <?php foreach($category_list as $categorys):?>
                    <li><a href="<?php echo URL_BASE;?>auctions/category/<?php echo $categorys['id'];?>" ><?php echo $categorys['category_name'];?></a></li>
                    <?php endforeach;?>
                </ul>
            </div>
            <!--End of category fetch-->
        </div>
        </div>
        </div>
        </div>
<div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
   <div class="deal-left clearfix">
		
		  <div class="action_deal_list  clearfix">
   <?php
		      
		if(count($products)>0){      
		foreach($products as $product)
		{
		if(array_key_exists($product['auction_type'], $auction_types)){
		$typename = $auction_types[$product['auction_type']];
		$block = $typename::product_block($product['product_id'],7,array('category_id'=>$category_id));	
		//$content.=$block;
		echo $block;
		}
		}
		}
		?>    	
	
	<!--Additional for javascript-->
        <div class="user" style="display:none;" ><?php echo $user;?></div>
        <div class="clear"></div>
       <?php if(count($products)<=0){?>
		<h4  class="no_data fl clr"><?php echo __("no_auctions_found_in_this_category");?></h4>
	<?php }?>
    <div class="pagination commm">
	<?php if(count($products)>0){?>
	 <p><?php echo $pagination->render(); ?></p> 
		<?php } ?>
	
    </div>
</div>
<?php echo $include_facebook;?>
<?php 
	                // To return user data
	               
	                $url=URL_BASE."auctions/fblike";
	                $message=__('flike_alert_msg');
                ?>
                <script type="text/javascript">
                function insert_fbuser()
                {
	                $.ajax({
		                type:'GET',
		                url:'<?php echo $url;?>',
		                data:'',
		                complete:function(data){
			                var msg=data.responseText;
			                if(msg==1)
			                {
				                alert("<?php echo __('flike_alert_msg');?>");
			                }
			                else if(msg==11)
			                {
				                alert("<?php echo __('flike_alert_msg2');?>");
			                }		
		                }
	                });
                }
                $(document).ready(function(){
		FB.Event.subscribe('edge.create',
			function(response) {
			insert_fbuser();
			//alert('You liked the URL: ' + response);
			});
		});
                </script>
	</div>
	<div id="category_fetch" style="display:none;"><?php echo $category;?></div>
    <div class="auction-bl">
    <div class="auction-br">
    <div class="auction-bm">
    </div>
    </div>
    </div>
</div>
</div>
