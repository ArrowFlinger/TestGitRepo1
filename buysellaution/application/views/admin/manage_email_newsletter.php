<?php defined('SYSPATH') OR die("No direct access allowed."); 

//Check the User Login IP's
//=========================
//$productcategory_count=count($product_categories);
$user_loginip_count=count($count_user_login_list);
//print_r($user_loginip_count);exit;
/*$table_css="";
if($productcategory_count>0)
{  $table_css='class="table_border"';  }*/
$table_css="";
   if($user_loginip_count>0)
   {  $table_css='class="table_border"'; }


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
            <form name="frm_email_newsletter" id="frm_email_newsletter" method="post">
                  
                 <div class="clr">&nbsp;</div>
                  <table cellspacing="1" cellpadding="5" width="90%" align="center" <?php echo $table_css; ?>>
                  
                  <?php if($user_loginip_count > 0){ ?>
                            <tr class="rowhead">
                                    <th align="left" width="5%"><?php echo __('Select'); ?></th> 
                                    <th align="center" width="8%"><?php echo __('sno_label'); ?></th>
                                    <th align="left" width="38%"><?php echo __('newsletter_sub_email'); ?></th>
                                    <th align="center" width="20%"><?php echo __('subscriber_IP');?></th>
                                    <th align="left" width="8%"><?php echo __('button_edit'); ?></th>
                                    <th align="center"><?php echo __('button_delete');?></th>
    
                            </tr>    
                            <?php 
                             
                             $sno=$offset; /* For Serial No */
                             
                             foreach($select_newslatter_nonuser as $newslatter_nonuser)
                             
                             {
                             
                             $sno++;
                             
                             $trcolor=($sno%2==0) ? 'oddtr' : 'eventr'; 
                            
                            ?>
                            <tr class="<?php echo $trcolor; ?>">
                                    <td align="center">
                                        <input type="checkbox" name="newsl_chk[]" id="newsl_chk<?php echo $newslatter_nonuser['id'];?>" value="<?php echo $newslatter_nonuser['id'];?>" />
                                    </td>
                                    <td width="8%" align="center">
                                        <?php echo $sno; ?>
                                    </td>
                                    <td align="left" width="38%">
                                        <?php echo $newslatter_nonuser['email'];?>
                                    </td>
                                    <td align="left" width="38%">                                    
                                       <center> <?php echo $newslatter_nonuser['signup_ip']; ?></center>
                                    </td>                                   
                                    
                                    
                                    <td align="center" width="8%">
                                        <?php echo '<a href="'.URL_BASE.'master/edit_email_newsletter/'.$newslatter_nonuser['id'].' " title ="Edit" class="editicon"></a>' ; ?>
                                    </td>                                
                                    <td align="center">
                                        <?php echo '<a  onclick="frmdel_user('.$newslatter_nonuser['id'].');" class="deleteicon" title="Delete"> </a>'; ?>                                   
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
			   		<!--Select All & More Actions Div -->
			 <?php if($user_loginip_count > 0){ ?>
			<div>
			    <div class="select_all">
			        <!--<?php echo __('select_alone');?> --><b><a href="javascript:selectToggle(true, 'frm_email_newsletter');" title="<?php echo __('all_label');?>"><?php echo __('all_label');?></a></b><span class="pr2 pl2">|</span><b><a href="javascript:selectToggle(false, 'frm_email_newsletter');" title="<?php echo __('none_label');?>"><?php echo __('none_label');?></a></b>
			        <span style="padding-left:10px;">
			            <select name="more_action" id="more_action">
			                <option value=""><?php echo __('more_label'); ?></option>
			                <option value="del" ><?php echo __('delete_label'); ?></option>
			            </select>
			         </span>
				</div>
			</div>
			<?php }?>
			<!--Select All & More Actions Div -->        
        <div class="pagination">
          <div><?php echo $pag_data->render(); ?></div>
        </div> 
         <div class="clr">&nbsp;</div> 

  </div>
</div>
<!--My div -->
<script language="javascript" type="text/javascript">
function selectToggle(toggle, form) {
    var myForm = document.forms[form];
    for( var i=0; i < myForm.length; i++ ) { 
        if(toggle) {
            myForm.elements[i].checked = "checked";
        } 
        else
        { myForm.elements[i].checked = ""; }
    }
}


//For Delete the Categories
//=========================

function frmdel_user(id)
{
   var answer = confirm("<?php echo __('delete_alert2');?>")
    if (answer){
        window.location="<?php echo URL_BASE;?>master/delete_newsletter_email/"+id;
    }
    
    return false;  
}


$('#more_action').change(function() { 
	var selected_val= $('#more_action').val();
	if(selected_val){
		if($('input[type="checkbox"]').is(':checked'))
		{
	   		 var ans = confirm("<?php echo __('delete_alert2');?>")
	   		 if(ans){
				 document.frm_email_newsletter.action="<?php echo URL_BASE;?>master/delete_newsletter_list/";
				 document.frm_email_newsletter.submit();
			 }else{
			 	$('#more_action').val('');
			 }
		}else{
			alert("<?php echo __('delete_alert1');?>");
			$('#more_action').val('');
		}
	}
	return false;  
});


$(document).ready(function(){
      toggle(6);
});
</script>

