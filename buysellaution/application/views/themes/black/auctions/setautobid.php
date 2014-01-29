<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="content_left_out fl">
<div class="action_content_left fl">
	<div class="title_temp1 fl clr pt10">
    	<h2 class="fl clr pl10" title="<?php echo __('auto_bid_lable');?>"><?php echo __('auto_bid_lable');?></h2>
    </div>
    	
	<div class="watch_list_items fl clr">
		<div id="managetable" class="fl clr">
 <form name="setautobid" action="<?php echo URL_BASE;?>auctions/<?php echo $action; ?>" method="post">
        <div class="row_colm1 fl clr mt20">
		<div class="colm1_width fl"><p><?php echo __('auction_types');?> <span class="red">*</span>:</p></div>
		<div class="colm2_width fl">
		<div class="inputbox_out fl">
		<div class="inputbox_out text_bg fl" style="padding:2px;">	
                    <select name="auctionid"  class=" text_bg select" id="auctionid" onchange="getmake(this.id)" style="height:41px;">	
			<option value=""><?php echo __('select_auction_type');?></option>
				<?php foreach($auction_types_list_autobid as $auctiontype){
					
					//Added by pradeepshyam on mar 4 2013
					$needautobid = true;
					if($auctiontype['settings']!=NULL)
					{
						$unserialize = unserialize($auctiontype['settings']);
						$needautobid = array_key_exists('autobid',$unserialize)?$unserialize['autobid']:true; 
					}
					if($needautobid)
					{
					$selected="";
					if(isset($form_values['auctionid']))
					{
						if($form_values['auctionid']==$auctiontype['typeid'])
						{
							$selected="selected";
						}
					} 
				?>
				<?php 
				
				if($auctiontype['typename']=="beginner")
				{
					if(!$checkuser)
					{
						 
				    }
				    else
				    {
						?>
						<option  value="<?php echo $auctiontype['typeid'];?>" <?php echo $selected;?>> 
					
						<?php echo Ucfirst($auctiontype['typename']);?></option> 
			<?php   }
				}else if($auctiontype['typename']=="buyerseller")

				{ ?> <?php }
				else
				{
					?>
					<option  value="<?php echo $auctiontype['typeid'];?>" <?php echo $selected;?>> 
					
				<?php echo Ucfirst($auctiontype['typename']);?></option> 
				<?php } ?>
				<?php } ?>
				<?php } ?>
			</select>
		</div>

		<?php if($errors && array_key_exists('auction_type',$errors)){?> <label class="errore_msg fl clr"><span class="red"><?php echo (array_key_exists('auction_type',$errors))? $errors['auction_type']: "";?></span></label><?php }?>
		</div>  
	</div>   </div>  
	<div class="row_colm1 fl clr mt20">
		<div class="colm1_width fl"><p><?php echo __('product_name');?> <span class="red">*</span>:</p></div>
			<div class="colm2_width fl">
			<div class="inputbox_out fl">
			<div class="inputbox_out text_bg fl" style="padding:2px;">	
                            <select name="product_name"  class=" text_bg select" id="loadmake" style="height:41px;">	
				<option value=""><?php echo __('select_product_lable');?></option>
<?php

					if(isset($form_values['product_name']))
					{
						
					}
?>
			</select>

			</div>
			<?php if($errors && array_key_exists('product_name',$errors)){?> <label class="errore_msg fl clr"><span class="red"><?php echo (array_key_exists('product_name',$errors))? $errors['product_name']:"";?></span></label><?php }?>
			</div>  
	</div>   </div>  
	<div class="row_colm1 fl clr mt20">
		<div class="colm1_width fl"><p><?php echo __('auto_bid_amount_label');?> <span class="red">*</span>:</p></div>
		<div class="colm2_width fl">
		<div class="inputbox_out fl">
		<?php echo Form::input('autobid_amt',isset($values[0]['bid_amount'])?$values[0]['bid_amount']:(isset($form_values['autobid_amt'])?$form_values['autobid_amt']:__('enter_auto_bid_amount')),array('maxlength'=>'20','class'=>'textbox','style'=>'width:350px','id'=>'autobid_amt','onfocus'=>'label_onfocus("autobid_amt","'.__('enter_auto_bid_amount').'")','onblur'=>'label_onblur("autobid_amt","'.__('enter_auto_bid_amount').'")'));?>
		</div>
		<div id="autoerror"></div>
		<?php if($errors && array_key_exists('autobid_amt',$errors)){?> <label class="errore_msg fl clr"><span class="red"><?php echo (array_key_exists('autobid_amt',$errors))? $errors['autobid_amt']: "";?></span></label><?php }?>
		</div>  
		</div>
		<div class="row_colm1 fl clr mt20">
		<div class="colm1_width fl"><p><?php echo __('auto_bid_amount_start_label');?> <span class="red">*</span>:</p></div>
		<div class="colm2_width fl">
		<div class="inputbox_out fl">
		<?php echo Form::input('autobid_start_amount',isset($values[0]['autobid_start_amount'])?$values[0]['autobid_start_amount']:(isset($form_values['autobid_start_amount'])?$form_values['autobid_start_amount']:__('enter_auto_bid_amount_start_product')),array('maxlength'=>'20','style'=>'width:350px','class'=>'textbox','id'=>'autobid_start_amount','onfocus'=>'label_onfocus("autobid_start_amount","'.__('enter_auto_bid_amount_start_product').'")','onblur'=>'label_onblur("autobid_start_amount","'.__('enter_auto_bid_amount_start_product').'")'));?>
	
		</div>
		<div id="autoerror1"></div>
                <span class="fl clr" style="color:#fff;width:100%;"><?php echo __('autobid_lable');?> </span>
		<?php if($errors && array_key_exists('autobid_start_amount',$errors)){?> <label class="errore_msg fl clr">			<span class="red">
	<?php echo (array_key_exists('autobid_start_amount',$errors))? $errors['autobid_start_amount']: "";?>
	</span></label>
	<?php }?>
	<span class="red"><?php //echo ($price_err=='1')?'Autobid start amount less-than product current price':'';?> </span>
		</div>  
	</div>		
				<div class="row_colm1 fl clr mt20">
				<div class="colm1_width fl"><p class="fl">&nbsp;</p></div>
				<div class="login_submit_btn fl">
				<span class="login_submit_btn_left fl">&nbsp;</span>
				<span class="login_submit_btn_middle fl"><?php echo Form::submit('set',($action=="setautobid")?__('set_autobid'):__('edit_autobid'),($action=="setautobid")?array('title' =>__('button_setauto_bid')):array('title' =>__('edit_autobid')));?></span>
				<span class="login_submit_btn_left login_submit_btn_right fl">&nbsp;</span>
				</div>
				</div>
  </form>
                        <?php //print_r($errors);?>
		</div>
		 
		<div class="clear"></div>
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
		<th width="60" colspan="2" align="center"><b><?php echo __('options');?></b></th>

		
		</tr>
		<?php 
                $i=0;
		foreach($select_autobid as $autobid): ?>
		
                <tr>
                        <td align="center" width="90" >
                        <a href="<?php echo URL_BASE;?>auctions/view/<?php echo $autobid['product_url'];?>" class="fl">
                        <?php if(($autobid['product_image'])!="" && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB1.$autobid['product_image']))
                        { 
                        $product_img_path=URL_BASE.PRODUCTS_IMGPATH_THUMB1.$autobid['product_image'];	
                        }
                        else
                        {
                        $product_img_path=IMGPATH.NO_IMAGE;
                        }
                        ?>
                        <img src="<?php echo $product_img_path;?>" width="50" height="50" class="fl" title="<?php echo ucfirst($autobid['product_name']);?>"/>
                        </a>
                        </td>
                        <td align="center" width="180"><p class=" fl" style="width:180px; word-wrap:break-word;"><?php echo ucfirst($autobid['product_name']);?></p></td>		
                        <td align="center" width="90"><p class="fl" style="width:130px; word-wrap:break-word;"><?php echo $autobid['enddate'];?></p></td>
                        <?php /*<td align="center" width="20%"><p class="watch_list_time" style="width:68px;"><?php echo $site_currency." ". $autobid['product_cost'];
                        ?></p></td> */ ?>
                        <td align="center" width="100"><b style="font-weight:normal;width:100px; word-wrap:break-word;"><?php echo $site_currency." ".Commonfunction::numberformat($autobid['bid_amount']); ?></b></td>
                        <td align="center" width="90" colspan="2">
                        <div class="setauto_edit">
						<a class="text_align_center" href="<?php echo URL_BASE;?>auctions/view/<?php echo $autobid['product_url'];?>" title="<?php echo __('view_label');?>" class="view_link fl"><?php echo __('view_label');?> </a>
                     
		
			<?php if($autobid['product_process']!="C") { ?>
                        <a class="text_align_center" href="<?php echo URL_BASE;?>auctions/edit_setautobid/<?php echo $autobid['product_id'];?>" title="<?php echo __('edit_label');?>" class="view_link fl"><?php echo __('edit_label');?></a>
			<?php } else { echo "its closed"; }?></div>
                        </td>
                </tr>
                <?php endforeach; 
                ?>
		
		</table>
		<!--End of autobid list-->
		<?php } ?>
		
	</div>
	</div>

<?php $productvalue="";
if(isset($form_values['product_name'])){
$productvalue=$form_values['product_name'];
}
?>
</div>
<script type="text/javascript">
function getmake(id)
{
	var value=$("#"+id).val();
	if(value!="")
	{
		$("#loadmake").show();
		$("#loadmake").html("Loading...");
		$.ajax({
			url:"<?php echo URL_BASE;?>auctions/auctiontypes",
			type:"get",
			data:"parent_id="+value,
			complete:function(data){
				$("#loadmake").html(data.responseText);
			}
			/*error:function(data)
			{
			 alert('error');	
			}*/
		});
	}
	else
	{
		$("#loadmake").show();
	}
}

$(document).ready(function () {
	$("#autobid_active").addClass("fl active");$("#autobid_active").addClass("user_link_active");
	var value=$("#auctionid").val();
	//alert(value);
	if(value!="")
	{
		$("#loadmake").show();
		$("#loadmake").html("Loading...");
		$.ajax({
			url:"<?php echo URL_BASE;?>auctions/auctiontypes",
			type:"get",
			data:"parent_id="+value+"&post=<?php echo $productvalue;?>",
			complete:function(data){
				$("#loadmake").html(data.responseText);
			}
			/*error:function(data)
			{
			 alert('error');	
			}*/
		});
	}
	else
	{
		$("#loadmake").show();
	}


	$("#autobid_amt").focusout(function() {
  		var autobid_amt =$("#autobid_amt").val();
		var product_id=$("#loadmake").val();
		$.ajax({
			url:"<?php echo URL_BASE;?>auctions/auctiontypes",
			type:"get",
			data:"autobid_amt="+autobid_amt+"&product_id="+product_id,
			complete:function(data){
				$("#autoerror").html("");
				if(data.responseText!="Allow")
				{
					$("#autoerror").html("<font color=red><?php echo __('enter_greater_balance');?></font>");
                                        $("#autoerror").fadeOut(5000);
				}
				
				
			}
			/*error:function(data)
			{
			 alert('error');	
			}*/
		});
	});
	$("#autobid_start_amount").focusout(function() {
  		var autobid_start =$("#autobid_start_amount").val();
		var product_id=$("#loadmake").val();
		$.ajax({
			url:"<?php echo URL_BASE;?>auctions/auctiontypes",
			type:"get",
			data:"autobid_start="+autobid_start+"&product_id="+product_id,
			cache:false,
			complete:function(data){
				$("#autoerror1").html("");
				if(data.responseText!="Allow")
				{
					$("#autoerror1").html("<font color=red><?php echo __('enter_current_price');?></font>");
                                         $("#autoerror1").fadeOut(5000);
				}
				
				
			}
			/*error:function(data)
			{
			 alert('error');	
			}*/
		});
	});
});
</script>
<!--Table-->
