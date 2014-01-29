<?php defined('SYSPATH') OR die("No direct access allowed."); 

 //Check the User Login IP's
//=========================
$news_count=count($auction_news);

$table_css="";
if($news_count>0)
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
            <form name="news" id="news" method="post">
                  <!-- Add Button & url link -->
                  <div style="float: right;padding-right:45px;">
                    <input type="button" class="button" title="<?php echo __('button_add'); ?>"value="<?php echo __('button_add'); ?>" onclick="location.href='<?php echo URL_BASE;?>adminnews/add_news'" />
                  </div>
                 <div class="clr">&nbsp;</div>
                  <table cellspacing="1" cellpadding="5" width="90%" align="center" <?php echo $table_css; ?>>
                  
                  <?php if($news_count > 0)
                  { ?>
                            <tr class="rowhead">
                                    <th align="left" width="5%"><?php echo __('Select'); ?></th> 
                                    <th align="left" width="8%"><?php echo __('sno_label'); ?></th>
                                    <th align="left" width="15%"><?php echo __('news_title'); ?></th>
                                    <th align="left" width="38%"><?php echo __('news_description'); ?></th>
                                    <th align="left" width="12%"><?php echo __('status_label');?></th>
                                    <th align="center" width="20%"><?php echo __('created_date');?></th>
                                    <th align="left" width="8%"><?php echo __('button_edit'); ?></th>
                                    <th align="center"><?php echo __('button_delete');?></th>
    
                            </tr>    
                            <?php 
                             
                             $sno=$offset; /* For Serial No */
                             
                             foreach($auction_news as $auction_news)
                             {
                             
                             $sno++;
                             $trcolor=($sno%2==0) ? 'oddtr' : 'eventr'; 
                             ?>
                             <tr class="<?php echo $trcolor; ?>">
                                    <td align="center">
                                        <input type="checkbox" name="news_chk[]" id="news_chk<?php echo $auction_news['news_id'];?>" value="<?php echo $auction_news['news_id'];?>" />
                                    </td>
                                    <td width="8%" align="left">
                                        <?php echo $sno; ?>
                                    </td>
                                    <td align="left" width="15%">
                                        <?php echo ucfirst($auction_news['news_title']); ?>
                                    </td>
                                    
                                     <td align="left" width="38%">
                                     <?php echo Text::limit_chars($auction_news['news_description'],25);?>
                                    </td>
                                    <td align="left" width="12%">
                                        <?php echo $auction_news['status']; ?>
                                    </td>
                                    <td align="center" width="20%">
                                        <?php echo $auction_news['created_date']; ?>
                                    </td>
                                    <td align="center" width="8%">
                                        <?php echo '<a href="'.URL_BASE.'adminnews/edit_news/'.$auction_news['news_id'].' " title ="Edit" class="editicon"></a>' ; ?>
                                    </td>                                
                                    <td align="center">
                                        <?php                                                                               
                                        echo '<a  onclick="frmdel_news('.$auction_news['news_id'].');" class="deleteicon" title="Delete"></a>'; ?>
                                   </td>
                            </tr>
    
                           <?php } 
                        } 
                        else 
                        { 
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
			 <?php if($news_count > 0){ ?>
			<div>
			    <div class="select_all">
			        <b><a href="javascript:selectToggle(true, 'news');" title="<?php echo __('all_label');?>"><?php echo __('all_label');?></a></b><span class="pr2 pl2">|</span><b><a href="javascript:selectToggle(false, 'news');" title="<?php echo __('none_label');?>"><?php echo __('none_label');?></a></b>
			        <span style="padding-left:10px;">
			            <select name="more_action" id="more_action">
			                <option value=""><?php echo __('more_label'); ?></option>
			                <option value="del" ><?php echo __('delete_label'); ?></option>
			            </select>
			         </span>
				</div>
			</div>
			<?php }?>
			<!--Pagination View -->        
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


//For Delete the news
//===================

function frmdel_news(news_id)
{
    var answer = confirm("<?php echo __('delete_alert_news');?>")
    if (answer){
         window.location="<?php echo URL_BASE;?>adminnews/delete_news/"+news_id;
    }
    
    return false;  
} 

$('#more_action').change(function() {
	var selected_val= $('#more_action').val();
	if(selected_val){
		if($('input[type="checkbox"]').is(':checked'))
		{
	   	 var ans = confirm("<?php echo __('delete_alert_news');?>")
	   	 if(ans){
				 document.news.action="<?php echo URL_BASE;?>adminnews/delete_news/";
				 document.news.submit();
			 }

		}else{
			alert("<?php echo __('delete_alert_news_select');?>");
			$('#more_action').val('');
		}
	}
	return false;  
}); 

$(document).ready(function(){
      toggle(6);
});
</script>
