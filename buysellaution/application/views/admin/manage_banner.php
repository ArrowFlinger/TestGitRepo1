<?php defined('SYSPATH') OR die("No direct access allowed."); 
 
$get_banner_count=count($get_banner);

$table_css="";
if($get_banner_count>0)
{  $table_css='class="table_border"';  }


//For Notice Messages

$sucessful_message=Message::display();

if($sucessful_message) { ?>
    <div id="messagedisplay" class="padding_150">
         <div class="notice_message">
            <?php echo $sucessful_message; ?>
         </div>
    </div>
<?php } ?>
<div class="container_content fl clr">
    <div class="cont_container mt15 mt10">
        <div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
        <div class="content_middle">
            <form name="frmjob" id="frmjob" method="post">
                  <div style="float: right;padding-right:45px;">
                    <input type="button" class="button" title="<?php echo __('button_add'); ?>"value="<?php echo __('button_add'); ?>" onclick="location.href='<?php echo URL_BASE;?>settings/add_banner'" />
                  </div>
                 <div class="clr">&nbsp;</div>
        <table cellspacing="1" cellpadding="5" width="90%" align="center" <?php echo $table_css; ?>>

                <?php if($get_banner_count > 0)
                { ?>
                        <tr class="rowhead">
                        <th align="left" width="8%"><?php echo __('sno_label'); ?></th>
                        <th align="left" width="18%"><?php echo __('banner_title'); ?></th>
                        <th align="left" width="15%"><?php echo __('banner_image'); ?></th>
                        <th align="left" width="5%"><?php echo __('order_label');?></th>
                        <th align="center" width="18%"><?php echo __('banner_status_label');?></th>
                        <th align="center" width="8%"><?php echo __('button_edit'); ?></th>
                        <th align="center" width="8%"><?php echo __('button_delete');?></th>

                        </tr>    
                        <?php 

                        $sno=$offset; /* For Serial No */  

                        foreach($get_banner as $banner)
                        {
                                $sno++;
                                $trcolor=($sno%2==0) ? 'oddtr' : 'eventr'; 
                                $banner_image_path=ADMINIMGPATH.NO_IMAGE;
				$image_title=__('no_photo');
                                //check if file exists or not
                                if(((isset($banner)) && $banner['banner_image']) && (file_exists(DOCROOT.BANNER_IMGPATH.$banner['banner_image'])))
                                { 
                                        $banner_image_path = URL_BASE.BANNER_IMGPATH.$banner['banner_image'];                         
                                        $image_title = $banner['title'];
                                        $atag_end='</a>';										   
                                }	

                                ?>
                                
                               
                                <tr class="<?php echo $trcolor; ?>">

                                <td width="8%" align="center">
                                <?php echo $sno; ?>
                                </td>
                                <td align="center" width="18%">
                                <?php echo ucfirst($banner['title']); ?>
                                </td>
                                <td align="center" width="15%">
                                <img src="<?php echo $banner_image_path; ?>" title="<?php echo $image_title;?>" class="fl ml20" width="<?php echo BANNER_SMALL_IMAGE_WIDTH;?>" height="<?php echo BANNER_SMALL_IMAGE_HEIGHT;?>">
                                </td>
                                <td align="center" width="5%">
                                <?php echo ucfirst($banner['order']); ?>
                                </td>
                                <td align="center" width="18%">
                                <?php echo ($banner['banner_status'] == 'A')? __('active_label'): __('inactive_label'); ?>
                                </td>
                                <td align="center" width="8%">
                                <?php echo '<a href="'.URL_BASE.'settings/edit_banner/'.$banner['banner_id'].' " title ="Edit" class="editicon"></a>' ; ?>
                                </td>                                
                                <td align="center">
                                <?php                                                                               
                                echo '<a  onclick="frmdel_banner('.$banner['banner_id'].');" class="deleteicon" title="Delete"></a>'; ?>
                                </td>
                                </tr>
                        <?php 
                        } 
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
          <div><?php echo $pag_data->render(); ?></div>
        </div> 
         <div class="clr">&nbsp;</div> 

  </div>
</div>
<!--My div -->
<script language="javascript" type="text/javascript">

//For Delete the banner
//=========================

function frmdel_banner(banner_id)
{
        var answer = confirm("<?php echo __('delete_alert_banner');?>")
        if (answer){
                window.location="<?php echo URL_BASE;?>settings/delete_banner/"+banner_id;
        }

        return false;  
} 

function frm_banner(banner_id,sus_status)
{

        switch (sus_status)
        {
                //if resumes means 			
                case 0:
                var answer = confirm("<?php echo __('inactive_alert_banner');?>")	
                break;
                //if hold means 		
                case 1:
                var answer = confirm("<?php echo __('active_alert_banner');?>")
                break;					
        } 


        if (answer){

                window.location="<?php echo URL_BASE;?>settings/active/"+"?id="+banner_id+"&&susstatus="+sus_status;
        }
}

$(document).ready(function(){
      toggle(8);
});
</script>
