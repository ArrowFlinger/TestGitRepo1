<?php  
foreach($productsresult as $winner_result):?>
        <div class="winners_detail_list fl clr reserve">
        <div class="winners-top"></div>
          <div class="winners-middle clearfix">
            <!--Winner Image STAT-->
            <div class="winners_detail_left fl">
            <?php 
                    if(($winner_result['photo'])!="" && file_exists(DOCROOT.USER_IMGPATH.$winner_result['photo']))
                    { 
                        $user_img_path=URL_BASE.USER_IMGPATH.$winner_result['photo'];
                    }
                    else
                    {
                        $user_img_path=IMGPATH.NO_IMAGE;
                    }
                ?>
                <img src="<?php echo $user_img_path;?>" alt="<?php echo ucfirst($winner_result['username']);?>" title="<?php echo ucfirst($winner_result['username']);?>"/>
            </div>
            <!--Winner END-->
            <!-- WInner Name AND Winner Detail START-->
            <div class="winners_detail_middle fl ml10">
                <!--Winner Name-->
                <p class="fl clr"><?php echo ucfirst($winner_result['username']);?></p>
                <!--Winner Location-->
                <span class="fl clr mt5"><?php echo __("ended_on_label").": ".$auction->date_to_string($winner_result['enddate']);?>
                </span>
    <span class="fl clr mt5"><?php echo $winner_result['country'];
       // $country=($winner_result['country']!="")?$winner_result['country']:"IN";
       // echo __("from_label")." ".$allcountries[$country];?></span>
            </div>
            <!-- WInner Name AND Winner Detail START-->
            <div class="winners_action_detail fl ml10"> 
            <div class="ribbon"></div>          	
            <div class="winners_action_detail_right fl">
                <table width="200" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                                <th colspan="2" align="center"><p style="word-wrap:break-word; width:190px;"><?php echo ucfirst($winner_result['product_name']);?></p></th>
                        </tr>
                        <tr>
                                <td align="left" valign="top" width="80"><label><?php echo __('retail_price_label')?> :</label></td>
                                <td align="left" valign="top"><p><?php echo $site_currency;?> <?php echo $winner_result['product_cost'];?></p></td>
                        </tr>
                        <tr>
                                <td align="left" valign="top" width="84"><label><?php echo __('auction_price_label')?> :</label></td>
                                <td align="left" valign="top"><p><?php echo $site_currency;?> <?php echo Commonfunction::numberformat($winner_result['current_price']);?></p></td>
                        </tr>
                        <tr>
                                <td align="left" valign="top" width="80"><label><?php echo __('savings_label')?> :</label></td>
                                <td align="left" valign="top"><p><?php echo (round(((1-($winner_result['current_price']/$winner_result['product_cost']))*100),2))>0 ? round(((1-($winner_result['current_price']/$winner_result['product_cost']))*100),2): 0;?>%</p></td>
                        </tr>
                </table>
            </div>
            <div class="action_image fl">
                <?php 
                    
                    if(($winner_result['product_image'])!="" && file_exists(DOCROOT.PRODUCTS_IMGPATH.$winner_result['product_image']))
                        { 
                        $product_img_path=URL_BASE.PRODUCTS_IMGPATH.$winner_result['product_image'];
                    }
                    else
                    {
                        $product_img_path=IMGPATH.NO_IMAGE;
                    }
                ?>
                        <img src="<?php echo $product_img_path;?>" width="100" height="100" alt="<?php echo ucfirst($winner_result['product_name']);?>" title="<?php echo ucfirst($winner_result['product_name']);?>"/>
            </div>
        </div>
        </div>
        <div class="winners-bottom"></div>
        </div>
<?php endforeach;?>            
