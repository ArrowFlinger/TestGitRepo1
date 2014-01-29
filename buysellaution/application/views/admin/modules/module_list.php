<?php defined('SYSPATH') OR die("No direct access allowed."); 



$table_css="";
if($modules>0)
{  $table_css='class="table_border"';  }


//For Notice Messages
//===================
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
            
                  <div style="float: left;padding-left:45px; width:678px;">
		    <form name="packageinstall" id="packageinstall" method="post" enctype="multipart/form-data">
			 <div class="info">
			      <span style="font-size:14px; font-weigth:bold; line-height: 20px;">Upload a bid package (File upload will be in compressed .zip format).<br/>
			      Make sure the sql pack, js file and zip pack has to be in same module name.</span><br/><br/>
			 <span style="color:green"><b>Need 777 (Full write) Permission for specific folder to update Package.</b><br/>
			 1. modules/<br/>
			 2. public/<br/>
			 3. application/bootstrap.php</span>
			 </div>
			 <div style="background: #ccc; padding:10px; margin: 5px;">
			      <input type="file" name="package"/>
			      <select name="packagetype">
				   <option value="M">Bid Package</option>
				   <option value="O">Other Package</option>
			      </select>
			      <input type="submit" name="upload" value="Add Package" style="float: right;"/>
			 </div>
		    </form>

                  </div>
                 <div class="clr">&nbsp;</div>
                  <table cellspacing="1" cellpadding="5" width="90%" align="center" <?php echo $table_css; ?>>
                  
                  <?php if($modules > 0){ ?>
                            <tr class="rowhead">
                                    <th align="center" width="8%"><?php echo __('sno_label'); ?></th>
                                    <th align="left" width="38%"><?php echo __('module_name'); ?></th>
                                    <th align="left" width="38%"><?php echo __('module_type'); ?></th>
                                    <th align="center" width="20%"><?php echo __('module_status'); ?></th>
                                    
    
                            </tr>    
                            <?php 
                             
                             $sno=0; /* For Serial No */
                               
                             foreach($modules as $module => $path){
                             if (false !== strpos($module,'auction_')) 
  							  {
                             	$auction_module_name = substr($module,8);
                            	$sno++;
                             	$trcolor=($sno%2==0) ? 'oddtr' : 'eventr'; 
                            
                            ?>
                            <tr class="<?php echo $trcolor; ?>">
                                    
                                    <td width="8%" align="center">
                                        <?php echo $sno; ?>
                                    </td>
                                    <td align="left" width="38%">
                                        <?php echo ucfirst($auction_module_name); ?>
                                    </td>
				    <td align="left" width="38%">
					<?php switch($path['pack_type']) {
					   case "M":
						  $s = "Bid Package";
						  break;
					   case "O":
						  $s = "Other Package";
						  break;
					   default:
						  $s = "Bid Package";
						  break;
					}
					echo $s;
					?>
                                        
                                    </td>
                                    <td align="center" width="40%">
                                    	
                                      <?php
				   
                                      if(file_exists($path)){
									  if(!array_key_exists(trim($auction_module_name),$installed)){
									  echo '<a href="'.URL_BASE.'modules/install/'.$auction_module_name.'"> Install</a>' ;
									  
									  }else{
									   echo '<input type="button" id="uninstall" value="Uninstall" onclick=check("'.URL_BASE.'modules/uninstall/'.$installed[trim($auction_module_name)].'")>' ;
									  
                                   				//echo '<a href="'.URL_BASE.'modules/edit/'.$installed[$auction_module_name].'" > Disable</a>' ;
								}
                                   				
                                   	}else { echo "Module Folder doesn't exists. Please rename the folder as module name";}?>
                                    </td>
                                    
                            </tr>
    
                           <?php } }
			   
			   foreach($auction_type as $type):
			   $path = MODPATH.$type['typename'];
			   $sno++;
                             	$trcolor=($sno%2==0) ? 'oddtr' : 'eventr'; 
			      ?>
			      <tr class="<?php echo $trcolor; ?>">
                                    
                                    <td width="8%" align="center">
                                        <?php echo $sno; ?>
                                    </td>
                                    <td align="left" width="38%">
                                        <?php echo ucfirst($type['typename']); ?>
                                    </td>
				    <td align="left" width="38%">
					<?php switch($type['pack_type']) {
					   case "M":
						  $s = "Bid Package";
						  break;
					   case "O":
						  $s = "Other Package";
						  break;
					   default:
						  $s = "Bid Package";
						  break;
					}
					echo $s;
					?>
                                        
                                    </td>
                                    <td align="center" width="40%">
                                    	
                                      <?php
				     
                                      if(file_exists($path)){
									  if($type['status']=="I"){
									  echo '<a href="'.URL_BASE.'modules/install/'.$type['typename'].'"> Install</a>' ;
									  
									  }else{
									   echo '<input type="button" id="uninstall" value="Uninstall" onclick=check("'.URL_BASE.'modules/uninstall/'.$type['typeid'].'")>' ;
									  
                                   				//echo '<a href="'.URL_BASE.'modules/edit/'.$installed[$auction_module_name].'" > Disable</a>' ;
								}
                                   				
                                   	}else { echo "Module Folder doesn't exists. Please rename the folder as module name";}?>
                                    </td>
                                    
                            </tr>
			      <?php
			   endforeach;
								 } 
		 					else { 
							?>
                                <tr>
                                    <td class="nodata"><?php echo __('no_data'); ?></td>
                                </tr>
        					<?php } ?>
                    </table>
                
        </div>
        <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
        <div class="clr">&nbsp;</div>
			   		
        
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

function frmdel_bid(packageid)
{
    var answer = confirm("<?php echo __('delete_alert_bidpackage');?>")
    if (answer){
         window.location="<?php echo URL_BASE;?>adminauction/delete_packages/"+packageid;
    }
    
    return false;  
} 

$('#more_action').change(function() {
	var selected_val= $('#more_action').val();
	if(selected_val){
		if($('input[type="checkbox"]').is(':checked'))
		{
	   	 var ans = confirm("<?php echo __('delete_alert_bidpackage');?>")
	   	 if(ans){
				 document.frmbid.action="<?php echo URL_BASE;?>adminauction/delete_packages/";
				 document.frmbid.submit();
			 }

		}else{
			alert("<?php echo __('delete_alert_bidpackage_select');?>");
			$('#more_action').val('');
		}
	}
	return false;  
});
function check(str)
{
          var id = str.split('uninstall/');
	  $.ajax({
		    url:"<?php echo URL_BASE;?>modules/checkactive",
		    type:"get",
		    data:"id="+id[1],
		    complete:function(data){
				if(data.responseText=="active")
				{
				   var ans = confirm("<?php echo __('delete_alert_bidpackage');?>")
				   if(ans){
					window.location="<?php echo URL_BASE;?>modules/uninstall/"+id[1];
					
				   }
				   else
				   {
					
				   }
			        }
				else
				{
				   window.location="<?php echo URL_BASE;?>modules/uninstall/"+id[1];
				  
				}
								
							},
			error:function(data)
			{
	//		 alert('error');	
			}
		});
}
/*$(document).ready(function () {
     
     $("#uninstall").click(function(){
          
});*/


$(document).ready(function(){
      toggle(6);
});
</script>
