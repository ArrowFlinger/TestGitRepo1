<?php defined('SYSPATH') OR die("No direct access allowed."); 
//All Bid History Count

$all_bidhistory_count=count($all_bidhistory);
$table_css="";
if($all_bidhistory_count>0)
{  $table_css='class="table_border"';  }
?>
<div class="container_content fl clr">
    <div class="cont_container mt15 mt10">
        <div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
        <div class="content_middle">
            <form>
                 <div class="clr">&nbsp;</div>
                  <table cellspacing="1" cellpadding="5" width="90%" align="center" <?php echo $table_css; ?>>
                  
                  <?php if($all_bidhistory_count > 0){ ?>
                            <tr class="rowhead">
                                   
                                    <th align="left" width="8%"><?php echo __('sno_label'); ?></th>
                                    <th align="left" width="20%"><?php echo __('username_label'); ?></th>
                                    <th align="left" width="28%"><?php echo __('product_name');?></th>
                                    <th align="left" width="15%"><?php echo __('total_bids');?></th>
                                    <th align="left" width="20%"><?php echo __('bid_price');?></th>
                                    <th align="center" width="20%"><?php echo __('last_bid_date');?></th>
                                    <!--<th align="left" width="25%"><?php echo __('product_status');?></th>-->
                            </tr>    
                            <?php 
                             
                             $sno= $Offset; /* For Serial No */
                             
                             foreach($all_bidhistory as $bidhistory)                             
                             {                             
                            	 $sno++;                             
                            	 $trcolor=($sno%2==0) ? 'oddtr' : 'eventr';                             
                            ?>
                            <tr class="<?php echo $trcolor; ?>">
                                    <td width="8%" align="center">
                                        <?php echo $sno; ?>
                                    </td>
                                    <td align="left" width="20%">
                                        <?php echo ucfirst($bidhistory['username']); ?>
                                    </td>
                                    <td align="left" width="28%">
                                        <?php 
                                        $product=$bidhistory['product_name'];
                                        echo  ucfirst(Text::limit_chars($product,20));?>
                                    </td>
		
		                   <td align="center" width="15%">
                                       <?php echo  $bidhistory['count('.BID_HISTORIES.'.product_id)'];?>
                                       
                                    </td>
                                     <td align="left" width="20%">
                                       
                                       <?php echo  $site_currency." ".Commonfunction::numberformat($bidhistory['max('.BID_HISTORIES.'.price)']);?>
                                    </td>
                                    <td align="center" width="20%">
                                        <?php echo $bidhistory['date']; ?>
                                    </td>          
					
                            </tr>
                           <?php } 
                                        } 
                                        else { 
                                        ?>
                                <tr>
                                    <td class="nodata"><?php echo __('no_data'); ?></td>
                                </tr>
        			<?php } ?>
                    </table>
                </form>
        </div>
        <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
        <div class="clr">&nbsp;</div>
        <div class="pagination">
          <div>
                <?php if(($action != 'search') && $all_bidhistory_count > 0): ?>
                <p><?php echo $pag_data->render(); ?></p>  
                <?php endif; ?> 
        </div>
        </div> 
         <div class="clr">&nbsp;</div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
      toggle(3);
});
</script>
