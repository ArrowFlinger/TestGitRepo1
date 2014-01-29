<?php defined('SYSPATH') OR die('No direct access allowed.'); 

$total_count=count($user_bonus_friends_list);

		?>

<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
    <div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
    <div class="content_middle">
<h2><?php echo __('bonus_add_friends_list_details');?></h2>
		 <form method="post" enctype="multipart/form-data" class="admin_form" name="frmlog" id="frmlog">
                <table border="0" cellpadding="10" cellspacing="5" width="99%">
                <?php if($total_count > 0){ ?>
                        <tr>
                                <td width="35%" valign="top"><label><?php echo __('id_label'); ?></label></td>
                                <td>
                               
				<?php echo ($user_bonus_friends_list[0]['bonus_id'])?$user_bonus_friends_list[0]['bonus_id']:"-";?>
                                </td>
                        </tr>
                        
                          <tr> 
                          <td width="35%" valign="top"><label><?php echo __('bonus_type'); ?></label></td>
                            	<td>
				<?php echo ($user_bonus_friends_list[0]['bonus_type'])?ucfirst($user_bonus_friends_list[0]['bonus_type']):"-";?>
                             </td>
                        </tr>                                                
                         <tr>
                                <td width="35%" valign="top"><label><?php echo __('username_label'); ?></label></td>
                                <td> 
                        		            
        		   <span style="color:#0B61B1"> 
        		   <?php echo ucfirst($user_bonus_friends_list[0]['username']);?></span>
                                </td>
                        </tr>
                        <tr>
                                <td width="35%" valign="top"><label><?php echo __('bonus_friends_list_label'); ?></label></td>
                                <td> 
                                        <?php 
                                        if($user_bonus_friends_list[0]['friend_ids']>0)
                                        {
                                        $friends=$user_bonus_friends_list[0]['friend_ids'];
                                        
                                        $ids=array_filter(explode(",", $friends));
                                        if(count($ids)>0)
                                                {
                                                $status_ids=array_filter(explode(",",$user_bonus_friends_list[0]['friend_ids']));
                                             
                                                }
                                        else
                                                {
                                                     $status_ids[]="";
                                                }
                                        ?>	            
                                        <span style="color:#000000;">
                                        <?php 
                                        $i=1;
                                        foreach($ids as $id): ?>
                                        <script>
                                        $.getJSON('https://graph.facebook.com/<?php echo $id;?>',function(data){
                                        $('.friends'+'<?php echo $i;?>').html(data.name);
                                        })
                                        </script>
                                      
                                        <img src="https://graph.facebook.com/<?php echo $id;?>/picture" class="fl" title="<?php echo $id;?>" alt=" <?php echo $id;?>" align="center" style="border:1px solid #000000;padding:5px;"/> 
<span style="float:left;" class="friends<?php echo $i;?>" ></span>

                                        <?php 
                                        $i++;
                                        endforeach; ?>
                                        <?php }else echo "---";?>
                                </span>
                                </td>
                        </tr>
                        
                         <tr>
                                <td width="35%" valign="top"><label><?php echo __('bonus_amount'); ?></label></td>
                                <td>
				<?php  echo  $site_currency." ".Commonfunction::numberformat($user_bonus_friends_list[0]['bonus_amount']); ?>
                                </td>
                        </tr>
                        
                        <?php } 

                                // ** normal bonus friends   Listings Ends Here ** //
                                else { 
                                // ** No normal bonus friends  is Found Means ** //
                        ?>
                        <tr>
                                <td class="nodata"><?php echo __('no_data'); ?></td>
                        </tr>
                        <?php }  ?>                                              

                </table>
        </form>
    </div>
    <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
</div>
</div>

