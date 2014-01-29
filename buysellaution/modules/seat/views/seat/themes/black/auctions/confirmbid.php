<div class="popup_inner popup_inner2 seat_popup seat" style="text-align: left;">
<div class="popup_content">
      <?php foreach($product_results as $results):?>
      <?php 
				if(($results['product_image'])!="" && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB.$results['product_image']))
	       			{ 
					$product_img_path=URL_BASE.PRODUCTS_IMGPATH_THUMB.$results['product_image'];
				}
				else
				{
					$product_img_path=IMGPATH.NO_IMAGE;
					
				}
			?>
                                    <div class="pop_tl">
                                        <div class="pop_tr">
                                            <div class="pop_tm">
                                                <h2><?php echo __('buying_seats');?>: <?php echo ucfirst($results['product_name']);?></h2>
                                                <a href="javascript:;" title="close" class="re_close popup_close"  onclick="document.getElementById('box').style.display='none';
   document.getElementById('fade').style.display='none'">close</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="popup_content_middle" style="width: auto;">
                                        <div class="clearfix">
                                            <p class="errormessage enough" style="color:red;display:block;">
                                                <?php $balance = str_replace(",","",$user_current_balance);
                                                      if($balance < $results['seat_cost']):?>
                                                      <?php echo __('seatbalance_empty');?>
                                                      <a href="<?php echo URL_BASE;?>packages/"><?php echo __('buy_packages');?></a>
                                                <?php endif;?>
                                            </p>
					  <div class="MessageText" style="margin-bottom:20px; color:#b9b9b9; font:normal 12px/18px arial;">
                                              <?php echo __('you_pay');?>: <b><?php echo $site_currency. $results['seat_cost'];?></b> <?php echo __('for_auction_seat');?>: <b><?php echo ucfirst($results['product_name']);?></b>
					  </div>
                                            <div class="re_image">
                                                <img src="<?php echo $product_img_path;?>">
                                            </div>
                                            <div class="res_conent">
                                                <h3><?php echo ucfirst($results['product_name']);?></h3>
                                                
                                                <div class="content_info clearfix">
                                                    <p class="res_label"><?php echo __('price');?> </p><span>:</span><p><?php echo $site_currency. $results['product_cost'];?></p>
                                                </div>
                                                 <div class="content_info clearfix">
                                                    <p class="res_label"><?php echo __('seat_cost');?> </p><span>:</span><p><?php echo $site_currency. $results['seat_cost'];?></p>
                                                </div>
						 <div class="content_info clearfix">
                                                    <p class="res_label"><?php echo __('seat_enddate');?> </p><span>:</span><p><?php echo  $results['seat_enddate'];?></p>
                                                </div>
                                          
	                               <div class="re_confirm clearfix">
					  <?php if($balance >= $results['seat_cost']):?>
                                           <div href="javascript:;"  class="re_confrim_bid confirm_seat" id="<?php echo $results['product_id'];?>">
                                               <button><?php echo __('confirm_buy');?></button>
                                           </div>
					   <?php endif;?>
                                            <div href="javascript:;"  class="re_cancel_bid cancel_seat"  data-auctiontype="35">
                                               <button><?php echo __('cancel_bid');?></button>
                                           </div>
                                       </div>
	                              </div>
                                        </div>
                                    </div>
                                    <div class="pop_bl">
                                        <div class="pop_br">
                                            <div class="pop_bm">
                                               
                                            </div>
                                        </div>
                                    </div><?php endforeach;?>
                                </div></div>
				<script>
				  
				</script>