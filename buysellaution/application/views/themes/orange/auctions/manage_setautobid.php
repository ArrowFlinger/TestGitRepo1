<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="action_content_left fl">
        <div class="title-left title_temp1">
        <div class="title-right">
        <div class="title-mid">
        <h2 class="fl clr pl10" title="<?php echo __('auto_bid_lable');?>"><?php echo __('auto_bid_lable');?></h2>
        </div>
		
        </div>
        </div>
     <div class="deal-left clearfix">	
     <div class="action_deal_list action_deal_list1 clearfix">
     <div class="auto_bid">
	 <!--set to bid--->
 <form name="setautobid" action="<?php echo URL_BASE;?>auctions/setautobid" method="post">
				 <div class="row_colm1 fl clr mt20">
                        <div class="colm1_width fl"><p><?php echo __('product_name');?> <span class="red">*</span>:</p></div>
                        <div class="colm2_width fl">
                        <div class="inputbox_out fl">
                        <div class="selectbox_out fl">
                        <select name="product_name" id="" onchange="" class="styled">
                                <span id="selectcountry" class="select">
                                        <option value=""><?php echo __('select_product_lable');?></option>
                                        <?php foreach($products as $product){?>
                                        <option  value="<?php echo $product['product_id'];?>" <?php if($form_values['product_name']===$product['product_id']){ echo "selected=selected"; } ?>><?php echo $product['product_name'];?></option> </span>
                                <?php } ?>
                        </select>
                        
                        </div>
                         <?php if($errors && array_key_exists('product_name',$errors)){?> <label class="errore_msg fl clr"><span class="red"><?php echo (array_key_exists('product_name',$errors))? $errors['product_name']: "";?></span></label><?php }?>
                        </div>  
                </div>   </div>  
                <div class="row_colm1 fl clr mt20">
                        <div class="colm1_width fl"><p><?php echo __('auto_bid_amount_label');?> <span class="red">*</span>:</p></div>
                        <div class="colm2_width fl">
                        <div class="inputbox_out fl">
                        <?php echo Form::input('autobid_amt',isset($form_values['autobid_amt'])?$form_values['autobid_amt']:__('enter_auto_bid_amount'),array('maxlength'=>'20','class'=>'textbox','id'=>'autobid_amt','onfocus'=>'label_onfocus("autobid_amt","'.__('enter_auto_bid_amount').'")','onblur'=>'label_onblur("autobid_amt","'.__('enter_auto_bid_amount').'")'));?>
                        
                       
                        </div>
                         <?php if($errors && array_key_exists('autobid_amt',$errors)){?> <label class="errore_msg fl clr"><span class="red"><?php echo (array_key_exists('autobid_amt',$errors))? $errors['autobid_amt']: "";?></span></label><?php }?>
                        </div>  
                </div>
		<div class="row_colm1 fl clr mt20">
            <div class="colm1_width fl"><b class="fl">&nbsp;</b></div>
            <div class="login_submit_btn fl">
            <span class="login_submit_btn_left fl">&nbsp;</span>
            <span class="login_submit_btn_middle fl"><?php echo Form::submit('set',__('set_autobid'),array('title' =>__('set_autobid')));?></span>
            <span class="login_submit_btn_left login_submit_btn_right fl">&nbsp;</span>
            </div>
		</div>
				<!--<select name="product_name" id="product" onchange="">
				<option value="">-- Select Product --</option>
				<?php foreach($products as $product){?>
				<option value="<?php echo $product['product_id'];?>" <?php if($form_values['product_name']===$product['product_id']){ echo "selected=selected"; } ?>><?php echo $product['product_name'];?></option>
				<?php } ?>
				</select>
				<?php	

				echo Form::input('autobid_amt',$form_values['autobid_amt'],array(''=>''));
				echo Form::submit('set','Set Autobid');
				?>-->
                        </form>
      <!---end-->
<?php 
			$count=count($select_autobid);
			if($count>0){?>
		
		<!--List autobid-->
		<table width="670" border="0" align="left" cellpadding="0" cellspacing="0" class="mt10">
		<tr>
		<th width="90" align="center"><b><?php echo __('image');?></b></th>
		<th width="180" align="center"><b><?php echo __('title');?></b></th>
		<th width="90" align="center"><b><?php echo __('end_time');?></b></th>
		<th width="100" align="center"><b><?php echo __('price');?></b></th>
		<th width="90" align="center"><b><?php echo __('auction_paid_price');?></b></th>		
		<th width="60" align="center"><b><?php echo __('options');?></b></th>		
		</tr>
		<?php 			
		$i=0;
		foreach($select_autobid as $autobid):
			
			$bg_none=($i==$count-1)?'bg_none':"";
		?>
		<tr>
		<td align="center" class="<?php echo $bg_none;?>"><a href="<?php echo URL_BASE;?>auctions/view/<?php echo $autobid['product_url'];?>"><?php 
				
				if(($autobid['product_image'])!=""  && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB1.$autobid['product_image']))
	       			{ 
					$product_img_path=URL_BASE.PRODUCTS_IMGPATH_THUMB1.$autobid['product_image'];
				}
				else
				{
					$product_img_path=IMGPATH.NO_IMAGE;
				}
			?><img src="<?php echo $product_img_path;?>" width="50"  height="50" title="<?php echo ucfirst($autobid['product_name']);?>" alt="<?php echo $autobid['product_name'];?>"/></a></td>
		<td align="center" class="<?php echo $bg_none;?>"><p class="won_action_title">
		<?php echo Text::limit_chars(ucfirst($autobid['product_name']),15);?></p></td>

		<td align="center" class="<?php echo $bg_none;?>"><p class="watch_list_time"><?php echo  $autobid['enddate'];?></p></td>
		<td align="center" class="<?php echo $bg_none;?>"><b><?php echo  $site_currency." ".$autobid['product_cost'];?></b></td>
		<td align="center" class="<?php echo $bg_none;?>"><b class="fl won_action_price"><?php echo $site_currency." ".Commonfunction::numberformat($autobid['bid_amt']); ?></b></td>
		<td align="center" class="<?php echo $bg_none;?>"><a href="<?php echo URL_BASE;?>auctions/edit_setautobid/<?php echo $autobid['product_id'];?>" title="<?php echo __('view_label');?>" class="view_link fl"><?php echo __('view_label');?></a></td>
		
					
		</tr>
		<?php $i++; endforeach; ?>
		
		</table>
		<!--End of autobid list-->
		<?php } ?>
</div>
</div>
</div>
        <div class="auction-bl">
        <div class="auction-br">
        <div class="auction-bm">
        </div>
        </div>
        </div>
</div>
<script type="text/javascript">
$(document).ready(function () {$("#users_menu").addClass("fl active");$("#product_autobid_active").addClass("user_link_active");});
</script>
	
