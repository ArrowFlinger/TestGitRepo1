<?php defined('SYSPATH') OR die("No direct access allowed."); 

$blog_data_count=count($comments_data);

$table_css="";
if($blog_data_count>0)
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
            <form name="frmcomm" id="frmcomm" method="post">
                  <div class="clr">&nbsp;</div>
                  <table cellspacing="1" cellpadding="5" width="100%" align="center" <?php echo $table_css; ?>>
                  
                  <?php if($blog_data_count > 0){ ?>
                            <tr class="rowhead">
                               <!-- <th align="left" width="5%"><?php echo __('Select'); ?></th> -->
                                 <th align="left" width="4%"><?php echo __('sno_label'); ?></th> 
                                <th align="left" width="15%"><?php echo __('username_label'); ?></th>
                                <th align="left" width="15%"><?php echo __('user_email'); ?></th>
                                <th align="left" width="15%"><?php echo __('blog_title'); ?></th>
                                <th align="left" width="25%"><?php echo __('comment_description'); ?></th>
                                <th align="center" width="20%"><?php echo __('created_date');?></th>
                                <th align="left" width="10%"><?php echo __('message_status'); ?></th>
                                <th align="center"><?php echo __('button_delete');?></th>
                                
    
                            </tr>    
                            <?php 
                             
                             $sno=$offset; /* For Serial No */                             
                             foreach($comments_data as $commentsdata)                             
                             {                             
                             $sno++;                             
                             $trcolor=($sno%2==0) ? 'oddtr' : 'eventr';                             
                            ?>
                            <tr class="<?php echo $trcolor; ?>">
                                   
                                    <td width="4%" align="left">
                                        <?php echo $sno; ?>
                                    </td>
                                    <td align="left" width="15%">
                                        <?php echo ucfirst(Text::limit_chars($commentsdata['username_blog'],28)); ?>
                                    </td>
                                    <td align="left" width="15%">
                                        <?php echo $commentsdata['useremail']; ?>
                                    </td>
                                    <td align="left" width="15%">
                                        <?php echo ucfirst(Text::limit_chars($commentsdata['blog_title'],28)); ?>
                                    </td>
                                    <?php if($commentsdata['msg_type'] == 'R')
                                        { ?>
                                        <td align="left" width="25%"><a  href="javascript:;" onclick="window.open('<?php echo URL_BASE;?>blog/comment_details/<?php echo $commentsdata['id']; ?>','','width=815,height=333')" style="color:OrangeRed  ">
                                                              <?php echo Text::limit_chars($commentsdata['comment'],28);?></a></td> 
                                        <?php }
                                        else { ?>
                                        <td align="left" width="25%"><a  href="javascript:;" onclick="window.open('<?php echo URL_BASE;?>blog/comment_details/<?php echo $commentsdata['id']; ?>','','width=815,height=333')" style="color:DodgerBlue ">
                                                              <?php echo Text::limit_chars($commentsdata['comment'],28);?></a></td> 
                                        <?php
                                        }
                                        ?>
                                      
                                                                            
                                     <td align="center" width="20%">
                                        <?php echo $commentsdata['created_date_blog']; ?>
                                    </td>
                                     <td width="10%"><?php echo ($commentsdata['msg_type'] == 'R')?__('read'):__('unread'); ?></td>                      
                                    <td align="center">
                                        <?php                                                                               
                                        echo '<a  onclick="frmdel_comment('.$commentsdata['id'].','.$commentsdata['blog_id'].');" class="deleteicon" title="Delete"></a>'; ?>
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
        	   		       
        <div class="pagination">
          <div><?php echo $pag_data->render(); ?></div>
        </div> 
         <div class="clr">&nbsp;</div> 

  </div>
</div>
<!--My div -->
<script language="javascript" type="text/javascript">

//For Delete the Categories
//=========================

function frmdel_comment(comment_id,blog_id)
{
    var answer = confirm("<?php echo __('delete_alert_blog_comment');?>")
    if (answer){
         window.location="<?php echo URL_BASE;?>blog/delete_comment/?commentid="+comment_id+"&blodig="+blog_id;
    }
    
    return false;  
} 

$(document).ready(function(){
      toggle(9);
});
</script>
