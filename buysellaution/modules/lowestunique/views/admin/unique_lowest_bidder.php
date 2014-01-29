<?php defined('SYSPATH') OR die("No direct access allowed."); 
$total_winner =count($winner_auctions);
?>
<div class="container_content fl clr">
        <div class="cont_container mt15 mt10">
                <div class="content_top">
                     <div class="top_left"></div> 
                           <div class="top_center"></div>
                                 <div class="top_rgt"></div>
                                       </div>
                    <div class="content_middle">     
                <div class="clr">&nbsp;</div>
        <?php if($total_winner > 0){ ?>
<div class= "overflow-block">
<?php }?>
<?php $table_css='class="table_border"';?> 
<table cellspacing="1" cellpadding="10" width="100%" align="center" <?php echo $table_css; ?>>

<?php if($total_winner > 0){ ?>
                <tr class="rowhead">
                        <th align="left" width="3%"><?php echo __('sno_label'); ?></th>
                               <th align="center" width="3%"><?php echo __('action_label'); ?></th>
                               <th align="left" width="10%"><?php echo __('username_label'); ?></th>
                                    <th align="left" width="10%"><?php echo __('email_label'); ?></th>
                                          <th align="left" width="5%"><?php echo __('productname_label'); ?></th>
                                          <th align="left" width="45%"><?php echo __('productprice_label')."(".$site_currency.")"; ?></th>
                                   <th align="left" width="45%"><?php echo __('price_paid_user')."(".$site_currency.")"; ?></th>
                               <th align="left" width="15%"><?php echo __('saving_label'); ?></th> 
				    <th align="left" width="15%"><?php echo __('lowest_unique_bid_price_label')."(".$site_currency.")"; ?></th>     
                        <th align="left" width="25%"><?php echo __('wondate_label'); ?></th>  
                        <th align="left" width="5%"><?php echo __('status_lable'); ?></th>                    
	        </tr>
	        
                <?php
                        $sno=$offset; /* For Serial No */
                        foreach($winner_auctions as $auctions) { 
                        //S.No Increment		
                        $sno++;      
                        //For Odd / Even Rows        
                        $trcolor=($sno%2==0) ? 'oddtr' : 'eventr';  		 
                 ?>     
                <tr class="<?php echo $trcolor; ?>">
			<td><?php echo $sno; ?></td>
			   <td><?php echo '<a  onclick="frmrply_winner('.$auctions['id'].','.$auctions['product_id'].');" class="replyicon" title='.__('reply_lable').'></a>'; ?></td>
                                <td><?php echo ucfirst($auctions['username']); ?></td>
                                          <td><?php echo $auctions['email']; ?></td>
                                          
			                        <td width="15%" ><?php echo wordwrap(ucfirst($auctions['product_name']),25,'<br />',1); ?></td>
			                        <td width="45%" >
			                        <?php 
			                         echo  $site_currency." ".Commonfunction::numberformat($auctions['product_cost']);?>
			                       </td>
                                                <td width="45%">
                                                <?php $user_spents=$adminauction->winner_user_amount_spent($auctions['product_id'],$auctions['lastbidder_userid']);
                                            
                                                $amount1=0;
                                                foreach($user_spents as $user_spent)
                                                {
                                                $amount1 += $user_spent['price'];
                                                }
                                            
                                                echo   $site_currency." ".Commonfunction::numberformat($auctions['current_price']);
                                             
                                                ?>
                                                </td>              
			     <td>
			    
			      <?php echo (round(((1-($auctions['current_price']/$auctions['product_cost']))*100),2))>0 ? round(((1-($auctions['current_price']/$auctions['product_cost']))*100),2): 0;?>%</td>
			<td width="25%"><?php echo $site_currency." ".Commonfunction::numberformat($auctions['lowest_unique_price']); ?></td>
                      <td width="25%"><?php echo $auctions['enddate']; ?></td>
                       <td>
                   <?php echo ($auctions['reply_status'] == 'I')? __('pending_replay'): __('reply'); ?>
                </td>
		</tr>
		<?php 
		}
         } 
	//For No Records
else{ ?>
       	<tr >
        	<td align="center" class="nodata"><?php echo __('no_lowest_unique_won_product_found'); ?></td>
        </tr>
		<?php } ?>
</table>
<?php if($total_winner > 0){ ?>
</div>
<?php }?>
</form>
</div>
<div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
        <div class="clr">&nbsp;</div>
               <div class="pagination">
		         <p><?php echo $pag_data->render(); ?></p> 
            </div>
      <div class="clr">&nbsp;</div>
</div>
<script type="text/javascript" language="javascript">
        //For replying winner user 
	//========================
	function frmrply_winner(req_id,pid)
	{

	   window.location="<?php echo URL_BASE;?>adminauction/winners_reply/?userid="+req_id+"&pid="+pid;
		//return false;  
	} 

$(document).ready(function(){
      toggle(3);
});
</script>
