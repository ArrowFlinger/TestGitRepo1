<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="my_message_right" id="setautobid_page">
	<div class="message_common_border">
		<h1 style="width:64px;" title="<?php echo strtoupper(__('auto_bid_lable'));?>"><?php echo strtoupper(__('auto_bid_lable'));?></h1>
		<p style="width:652px;">&nbsp;</p>
	</div>
	<form name="setautobid" action="<?php echo URL_BASE;?>auctions/<?php echo $action; ?>" method="post">
	<div class="message_common">
		<span class="red">
			<?php //print_r($usererror); ?>
			<?php if(isset($usererror)){ echo $usererror['isbeginner'];} ?>
		</span>
<div class="login_middle_common_profil" style="padding-left:0px;">
<div class="user_name_common">
<p><?php echo __('auction_types');?> <span class="red">*</span> :</p>
<div class="text_feeld">
	<h2><select name="auctionid"  class=" text_bg select" id="auctionid" onchange="getmake(this.id)">	
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
				}
				else
				{
					?>
					<option  value="<?php echo $auctiontype['typeid'];?>" <?php echo $selected;?>> 
					
				<?php echo Ucfirst($auctiontype['typename']);?></option> 
				<?php } ?>
				<?php } ?>
				<?php } ?>
			</select>
	</h2>
	</div>
	<label class="errore_msg fl clr"><span class="red"><?php if($errors && array_key_exists('name',$errors)){  echo (array_key_exists('name',$errors))? $errors['name']:""; }?></span></label>
	</div>
	<div class="user_name_common">
	<p><?php echo __('product_name');?> <span class="red">*</span>:</p>
	<div class="text_feeld">
		<h2>
		<select name="product_name"  class=" text_bg select" id="loadmake">	
			<option value=""><?php echo __('select_product_lable');?></option>
			<?php if(isset($form_values['product_name']))
			{

			}
			?>
		</select>
		</h2>
	</div>
	<label class="errore_msg fl clr"><span class="red"><?php  if($errors && array_key_exists('product_name',$errors)){ echo (array_key_exists('product_name',$errors))? $errors['product_name']:""; }?></span></label>
</div>

	<div class="user_name_common">
	<p><?php echo __('auto_bid_amount_label');?> <span class="red">*</span>  :</p>
	<div class="text_feeld">
		<h2><?php echo Form::input('autobid_amt',isset($values[0]['bid_amount'])?$values[0]['bid_amount']:(isset($form_values['autobid_amt'])?$form_values['autobid_amt']:__('enter_auto_bid_amount')),array('maxlength'=>'20','class'=>'textbox','id'=>'autobid_amt','onfocus'=>'label_onfocus("autobid_amt","'.__('enter_auto_bid_amount').'")','onblur'=>'label_onblur("autobid_amt","'.__('enter_auto_bid_amount').'")'));?></h2>
	</div>
	<div id="autoerror"></div>
		<label class="errore_msg fl clr"><span class="red"><?php  if($errors && array_key_exists('bid_amount',$errors)){  echo (array_key_exists('bid_amount',$errors))? $errors['bid_amount']:""; }?></span></label>
	</div>

	<div class="user_name_common">
		<p><?php echo __('auto_bid_amount_start_label');?> <span class="red">*</span> :</p>
		<div class="text_feeld">
			<h2> 	<?php echo Form::input('autobid_start_amount',isset($values[0]['autobid_start_amount'])?$values[0]['autobid_start_amount']:(isset($form_values['autobid_start_amount'])?$form_values['autobid_start_amount']:__('enter_auto_bid_amount_start_product')),array('maxlength'=>'20','class'=>'textbox','id'=>'autobid_start_amount','onfocus'=>'label_onfocus("autobid_start_amount","'.__('enter_auto_bid_amount_start_product').'")','onblur'=>'label_onblur("autobid_start_amount","'.__('enter_auto_bid_amount_start_product').'")'));?>
		</h2>
	</div>
<div id="autoerror1"></div>
	<span><?php echo __('autobid_lable');?> </span>
	<label class="errore_msg fl clr"><span class="red"> <?php if($errors && array_key_exists('autobid_start_amount',$errors)){?><?php  echo (array_key_exists('autobid_start_amount',$errors))? $errors['autobid_start_amount']:"";?><?php }?></span></label>
	<span class="red"><?php echo ($price_err=='1')?'Autobid start amount less-than product current price':'';?> </span>
</div>

<div class="user_name_common">
	<div class=" buton_green">
		<div class="profil_butoon" style="width:auto;">
		<div class="res_left"></div>
		<div class="res_mid" style="width:auto;"><a style="width:auto;" ><?php echo Form::submit('set',($action=="setautobid")?strtoupper(__('set_autobid')):strtoupper(__('edit_autobid')),($action=="setautobid")?array('title' =>strtoupper(__('button_setauto_bid'))):array('title' =>strtoupper(__('edit_autobid'))));?></a></div>
		<div class="res_right"></div>
		</div>
</form>	
<!-- table start -->
</div></div>
<?php $count=count($select_autobid);
			if($count>0):?>	
	<div class="forms_common">
		<div class="title_cont_watchilist">
                           <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0"  class="table-top">
                            <thead>
                            <tr>
                                <th width="100" align="center"><b><?php echo __('image');?></b></th>
                                  <th width="100" align="center"><b><?php echo __('title');?></b></th>
                                     <th width="100" align="center"><b><?php echo __('end_time');?></b></th>
                                        <th width="100" align="center"><b><?php echo __('auction_paid_price');?></b></th>
                                             <th width="100" align="center"><b><?php echo __('options');?></b></th>
                            </tr>
                        </thead>
	
			

<?php foreach($select_autobid as $autobid): ?>
	<tr>
		<td width="100" align="center">
		<h3><a href="<?php echo URL_BASE;?>auctions/view/<?php echo $autobid['product_url'];?>" title="<?php echo ucfirst($autobid['product_name']);?>">
		<?php if(($autobid['product_image'])!="" && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB1.$autobid['product_image']))
							{ 
							$product_img_path=URL_BASE.PRODUCTS_IMGPATH_THUMB1.$autobid['product_image'];	
							}
							else
							{
							$product_img_path=IMGPATH.NO_IMAGE;
							}
							?>
		<img src="<?php echo $product_img_path;?>"  width="50" height="50" title="<?php echo ucfirst($autobid['product_name']);?>"/></a></h3>
	</td>
	<td width="100" align="center">
		<h3><?php echo ucfirst($autobid['product_name']);?></h3>
	</td>
	<td width="100" align="center">
		<h2><?php echo $autobid['enddate'];?></h2>
	</td>
	<td width="100" align="center">
		<h2><?php echo $site_currency." ".Commonfunction::numberformat($autobid['bid_amount']); ?></h2>
	</td>
	<td width="100" align="center">
	   <a href="<?php echo URL_BASE;?>auctions/view/<?php echo $autobid['product_url'];?>" title="<?php echo __('view_label');?>"><?php echo __('view_label');?></a>
	</td>
	<td width="100" align="center">
	<?php if($autobid['product_process']!="C")
	{?>
	<a href="<?php echo URL_BASE;?>auctions/edit_setautobid/<?php echo $autobid['product_id'];?>" title="<?php echo __('edit_label');?>"><?php echo __('edit_label');?></a>
	<?php }
	else { echo "<h2 style='width:95px;padding:0px;text-align:center;line-height:35px;height:102px;margin:0px;' class='messages_new_watch'>".__("its closed")."</h2>"; }?>
</td>

 <?php endforeach;?>
</tr>
                           </table>

 <div class="user" style="display:none;" ><?php echo $auction_userid;?></div>	
<?php else:?>
	<h4 class="no_data clr" style="float:none;"><?php echo __("no_bids_detail_at_the_moment");?></h4>
<?php endif;?>

</div>
</div>
</div>

</div>

</div>
</div>
</div>
</div>
<?php $productvalue="";
if(isset($form_values['product_name'])){
$productvalue=$form_values['product_name'];
}
?>
  
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
			},
			error:function(data)
			{
			 alert('error');	
			}
		});
	}
	else
	{
		$("#loadmake").hide();
	}
}

$(document).ready(function () {

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
			},
			error:function(data)
			{
			 //alert('error');	
			}
		});
	}
	else
	{
		$("#loadmake").hide();
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
					$("#autoerror").html("<font color=red>Entered amount should not be greater than your balance</font>");
                                        $("#autoerror").fadeOut(5000);
				}
				
				
			},
			error:function(data)
			{
			// alert('error');	
			}
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
					$("#autoerror1").html("<font color=red>Entered start amount should be greater than product current price</font>");
                                        $("#autoerror1").fadeOut(5000);
				}
				
				
			},
			error:function(data)
			{
			 //alert('error');	
			}
		});
	});
});
</script>
<script type="text/javascript">
$(document).ready(function () {$("#autobid_active").addClass("act_class");});
</script>
