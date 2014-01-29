<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="action_content_left fl">
        <div class="title-left title_temp1">
        <div class="title-right">
        <div class="title-mid">
        <h2 class="fl clr pl10" title="<?php echo __('auto_bid_lable');?>"><?php echo __('auto_bid_lable');?></h2>
        </div>
		
        </div>
        </div>
  <?php foreach($autobid_products as $product){ ?>
     <div class="deal-left clearfix">	
     <div class="action_deal_list action_deal_list1 clearfix">
     <div class="auto_bid ml10">
	 <!--set to bid--->
<form name="setautobid" action="<?php echo URL_BASE;?>auctions/edit_setautobid/<?php echo $product['product_id']; ?>" method="post">
                                                 
                
                <div class="row_colm1 fl clr mt20">
                        <div class="colm1_width fl"><p><?php echo __('product_name');?> <span class="red">*</span>:</p></div>
                        <div class="colm2_width fl">
                        <div class="inputbox_out fl">
                        <?php  echo Form::input('product_name', isset($form_values['product_name'])?$form_values['product_name']:$product['product_name'],array("id"=>"product_name",'readonly',"Maxlength"=>"20")); ?>
                        </div>
                        <?php if($errors && array_key_exists('product_name',$errors)){?><label class="errore_msg fl clr"><span class="red"><?php  echo (array_key_exists('product_name',$errors))? ucfirst($errors['product_name']):"";?></span></label><?php }?>
                         
                        </div>  
                </div>
                 
                <input type="hidden" name="product_id" value="<?php if(isset($product['product_id'])){ echo $product['product_id']; } ?>" >
                <div class="row_colm1 fl clr mt20">
                        <div class="colm1_width fl"><p><?php echo __('auto_bid_amount_label');?> <span class="red">*</span>:</p></div>
                        <div class="colm2_width fl">
                        <div class="inputbox_out fl">
                        <?php  echo Form::input('bid_amount', isset($form_values['bid_amount'])?$form_values['bid_amount']:$product['bid_amount'],array("id"=>"bid_amount","Maxlength"=>"20")) ?>
                        </div>
                         <?php if($errors && array_key_exists('bid_amount',$errors)){?> <label class="errore_msg fl clr"><span class="red"><?php  echo (array_key_exists('bid_amount',$errors))? ucfirst($errors['bid_amount']):"";?></span></label><?php }?>
                                               
                        </div>  
                </div>
                <?php } ?>
		<div class="row_colm1 fl clr mt20">
            <div class="colm1_width fl"><b class="fl">&nbsp;</b></div>
            <div class="login_submit_btn fl">
            <span class="login_submit_btn_left fl">&nbsp;</span>
            <span class="login_submit_btn_middle fl"><?php echo Form::submit('setbid_amount',__('button_update'),array('title' =>__('button_update')));?></span>
            <span class="login_submit_btn_left login_submit_btn_right fl">&nbsp;</span>
            </div>

			
            <div class="login_submit_btn fl ml10">
            <span class="login_submit_btn_left fl">&nbsp;</span>
            <span class="login_submit_btn_middle fl"><input type="button" title="<?php echo __('button_back'); ?>" value="<?php echo __('button_back'); ?>" onclick="location.href='<?php echo URL_BASE;?>auctions/setautobid'" /></span>
            <span class="login_submit_btn_left login_submit_btn_right fl">&nbsp;</span>
            </div>
            
		</div>
                        
                        </form>
      <!---end-->

</div>
</div>
</div>
        <div class="auction-bl" style="width:660px;">
        <div class="auction-br">
        <div class="auction-bm">
        </div>
        </div>
        </div>
</div>
<script type="text/javascript">
$(document).ready(function () {$("#users_menu").addClass("fl active");$("#product_autobid_active").addClass("user_link_active");});
</script>	
