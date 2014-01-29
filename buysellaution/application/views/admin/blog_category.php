<?php defined('SYSPATH') OR die("No direct access allowed."); 

 //Check the User Login IP's
//=========================
$blogcategory_count=count($blog_categories);

$table_css="";
if($blogcategory_count>0)
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
                    <input type="button" class="button" title="<?php echo __('button_add'); ?>"value="<?php echo __('button_add'); ?>" onclick="location.href='<?php echo URL_BASE;?>blog/add_blog_category'" />
                  </div>
                 <div class="clr">&nbsp;</div>
                  <table cellspacing="1" cellpadding="5" width="90%" align="center" <?php echo $table_css; ?>>
                  
                  <?php if($blogcategory_count > 0){ ?>
                            <tr class="rowhead">
                                    <th align="left" width="5%"><?php echo __('Select'); ?></th> 
                                    <th align="left" width="8%"><?php echo __('sno_label'); ?></th>
                                    <th align="left" width="38%"><?php echo __('category'); ?></th>
                                    <th align="left" width="12%"><?php echo __('status_label');?></th>
                                    <th align="center" width="20%"><?php echo __('created_date');?></th>
                                    <th align="center" width="8%"><?php echo __('button_edit'); ?></th>
                                    <th align="center"><?php echo __('button_delete');?></th>
    
                            </tr>    
                            <?php 
                             
                             $sno=$offset; /* For Serial No */
                             
                             foreach($blog_categories as $blog_category)
                             
                             {
                             
                             $sno++;
                             
                             $trcolor=($sno%2==0) ? 'oddtr' : 'eventr'; 
                            
                            ?>
                            <tr class="<?php echo $trcolor; ?>">
                                    <td align="center">
                                        <input type="checkbox" name="category_chk[]" id="category_chk<?php echo $blog_category['id'];?>" value="<?php echo $blog_category['id'];?>" />
                                    </td>
                                    <td width="8%" align="left">
                                        <?php echo $sno; ?>
                                    </td>
                                    <td align="left" width="38%">
                                        <?php echo ucfirst($blog_category['category_name']); ?>
                                    </td>
                                    <td align="left" width="12%">
                                        <?php echo $blog_category['status']; ?>
                                    </td>
                                    <td align="center" width="20%">
                                        <?php echo $blog_category['created_date']; ?>
                                        
                                    </td>
                                    <td align="center" width="8%">
                                        <?php echo '<a href="'.URL_BASE.'blog/edit_blog_category/'.$blog_category['id'].' " title ="Edit" class="editicon"></a>' ; ?>
                                    </td>                                
                                    <td align="center">
                                        <?php                                                                               
                                        echo '<a  onclick="frmdel_cat('.$blog_category['id'].');" class="deleteicon" title="Delete"></a>'; ?>
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
			 <?php if($blogcategory_count > 0){ ?>
			<div>
			    <div class="select_all">
			        <!--<?php echo __('select_alone');?> --><b><a href="javascript:selectToggle(true, 'frmjob');" title="<?php echo __('all_label');?>"><?php echo __('all_label');?></a></b><span class="pr2 pl2">|</span><b><a href="javascript:selectToggle(false, 'frmjob');" title="<?php echo __('none_label');?>"><?php echo __('none_label');?></a></b>
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

function frmdel_cat(categoryid)
{
    var answer = confirm("<?php echo __('delete_alert_blogcat');?>")
    if (answer){
         window.location="<?php echo URL_BASE;?>blog/blog_delete_category/"+categoryid;
    }
    
    return false;  
} 

$('#more_action').change(function() {
	var selected_val= $('#more_action').val();
	if(selected_val){
		if($('input[type="checkbox"]').is(':checked'))
		{
	   	 var ans = confirm("<?php echo __('delete_alert_blogcat');?>")
	   	 if(ans){
				 document.frmjob.action="<?php echo URL_BASE;?>blog/blog_delete_category/";
				 document.frmjob.submit();
			 }

		}else{
			alert("<?php echo __('delete_alert_blogcat_select');?>");
			$('#more_action').val('');
		}
	}
	return false;  
}); 

$(document).ready(function(){
      toggle(9);
});
</script>
