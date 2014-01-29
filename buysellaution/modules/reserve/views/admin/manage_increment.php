<?php defined('SYSPATH') OR die("No direct access allowed."); 
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
        <div class="content_middle" >
       
                <form method="POST" class="admin_form" action="<?php echo URL_BASE;?>admin/reserve/increment/" >
                        <table class="0" cellpadding="7" cellspacing="0" width="100%">
                        <?php $count = count($increment);
                        	if($count >0) {  ?>
                        	<tr>
                                        <td valign="top"><label><?php echo __('increment_label');?> </label><span class="star">*</span></td>   
                                        <table class="0" cellpadding="7" cellspacing="0" style="margin-left: 100px;">
                                        <tr><td><span class="info_label" style="width:190px;"><?php echo __('price_range_min'); ?></span></td>
                                       <td><span class="info_label" style="width:190px;"><?php echo __('price_range_max'); ?></span></td>
                                        <td><span class="info_label" style="width:190px;"><?php echo __('price_range_increment'); ?></span></td></tr>
                                         <?php foreach($increment as $values )
                        		{ ?>
                                        <tr>
                                        <td><input type="text" name="incrementrange[min][]" style="width:120px;" id="incrementrange[]" class="increment_range"  maxlength="10" value="<?php echo isset($values) &&  (!array_key_exists('minrange',$errors))? trim($values['minrange']):$validator['minrange'];?>">
                                        
                                         <span class="error"><?php echo isset($errors['minrange'])?ucfirst($errors['minrange']):''; ?></span></td>
                                         
                                         
                                         <td><input type="text" style="width:120px;" name="incrementrange[max][]" id="incrementrange[]" class="increment_range"  maxlength="10" value="<?php echo isset($values) &&  (!array_key_exists('maxrange',$errors))? trim($values['maxrange']):$validator['maxrange'];?>">
                                         
                                         <span class="error"><?php echo isset($errors['maxrange'])?ucfirst($errors['maxrange']):''; ?></span></td>
                                          <td><input type="text" style="width:120px;" name="incrementrange[price][]" id="incrementrange[]" class="increment_range"  maxlength="10" value="<?php echo isset($values) &&  (!array_key_exists('price',$errors))? trim($values['price']):$validator['price'];?>">
                                          
                                         <span class="error"><?php echo isset($errors['price'])?ucfirst($errors['price']):''; ?></span></td>
                                </tr>
                                  <?php } ?>
                                  
                                  <tr>
                                	<td><?php //echo __("add_more_increment_label"); ?>
                                	
                                	</td>
                                </tr>
                                                          
                      <tr>
                        	<td colspan="2" class="star">*<?php echo __('required_label'); ?></td>
                        </tr>                        
                                <tr>
                                        <td>&nbsp;</td>
                                        <td>
                                         <input type="reset" name="increment_reset" value="<?php echo __('button_reset');?>" title="<?php echo __('button_reset');?>">
                                        <input type="submit" name="increment_submit" title="<?php echo __('button_update');?>" value="<?php echo __('button_update');?>" >
					                  
                                        </td>
                                </tr>
                                </table>
                                </tr>
                                <?php  } else { ?>
                                <tr>
                                        <td valign="top"><label><?php echo __('increment_label');?> </label><span class="star">*</span></td>   
                                        <td><span class="info_label" style="width:190px;"><?php echo __('price_range_min'); ?></span><input type="text" name="incrementrange[min][]" style="width:120px;" id="incrementrange[]" class="increment_range"  maxlength="10" value="<?php echo isset($site_meta) &&  (!array_key_exists('minrange',$errors))? trim($site_meta[0]['minrange']):$validator['minrange'];?>">
                                        
                                         <span class="error"><?php echo isset($errors['minrange'])?ucfirst($errors['minrange']):''; ?></span></td>
                                         
                                         
                                         <td><span class="info_label" style="width:190px;"><?php echo __('price_range_max'); ?></span><input type="text" style="width:120px;" name="incrementrange[max][]" id="incrementrange[]" class="increment_range"  maxlength="10" value="<?php echo isset($site_meta) &&  (!array_key_exists('maxrange',$errors))? trim($site_meta[0]['maxrange']):$validator['maxrange'];?>">
                                         
                                         <span class="error"><?php echo isset($errors['maxrange'])?ucfirst($errors['maxrange']):''; ?></span></td>
                                         
                                         
                                         <td><span class="info_label" style="width:190px;"><?php echo __('price_range_increment'); ?></span><input type="text" style="width:120px;" name="incrementrange[price][]" id="incrementrange[]" class="increment_range"  maxlength="10" value="<?php echo isset($site_meta) &&  (!array_key_exists('price',$errors))? trim($site_meta[0]['price']):$validator['price'];?>">
                                          
                                         <span class="error"><?php echo isset($errors['price'])?ucfirst($errors['price']):''; ?></span></td>
                                         
                                </tr>
                                
                                <tr>
                                        <td valign="top"><label><?php //echo __('increment_label');?> </label></td>   
                                        <td><input type="text" name="incrementrange[min][]" style="width:120px;" id="incrementrange[]" class="increment_range"  maxlength="10" value="<?php echo isset($site_meta) &&  (!array_key_exists('minrange',$errors))? trim($site_meta[0]['minrange']):$validator['minrange'];?>">
                                        
                                         <span class="error"><?php echo isset($errors['minrange'])?ucfirst($errors['minrange']):''; ?></span></td>
                                         
                                         
                                         <td><input type="text" style="width:120px;" name="incrementrange[max][]" id="incrementrange[]" class="increment_range"  maxlength="10" value="<?php echo isset($site_meta) &&  (!array_key_exists('maxrange',$errors))? trim($site_meta[0]['maxrange']):$validator['maxrange'];?>">
                                         
                                         <span class="error"><?php echo isset($errors['maxrange'])?ucfirst($errors['maxrange']):''; ?></span></td>
                                         
                                         
                                         <td><input type="text" style="width:120px;" name="incrementrange[price][]" id="incrementrange[]" class="increment_range"  maxlength="10" value="<?php echo isset($site_meta) &&  (!array_key_exists('price',$errors))? trim($site_meta[0]['price']):$validator['price'];?>">
                                          
                                         <span class="error"><?php echo isset($errors['price'])?ucfirst($errors['price']):''; ?></span></td>
                                         
                                </tr>
                                
                                <tr>
                                        <td valign="top"><label><?php //echo __('increment_label');?> </label></td>   
                                        <td><input type="text" name="incrementrange[min][]" style="width:120px;" id="incrementrange[]" class="increment_range"  maxlength="10" onchange="document.getElementById('moreUploadsLink').style.display = 'block';" value="<?php echo isset($site_meta) &&  (!array_key_exists('minrange',$errors))? trim($site_meta[0]['minrange']):$validator['minrange'];?>">
                                        
                                         <span class="error"><?php echo isset($errors['minrange'])?ucfirst($errors['minrange']):''; ?></span></td>
                                         
                                         
                                         <td><input type="text" style="width:120px;" name="incrementrange[max][]" id="incrementrange[]" class="increment_range"  maxlength="10" onchange="document.getElementById('moreUploadsLink').style.display = 'block';"  value="<?php echo isset($site_meta) &&  (!array_key_exists('maxrange',$errors))? trim($site_meta[0]['maxrange']):$validator['maxrange'];?>">
                                         
                                         <span class="error"><?php echo isset($errors['maxrange'])?ucfirst($errors['maxrange']):''; ?></span></td>
                                         
                                         
                                         <td><input type="text" style="width:120px;" name="incrementrange[price][]" id="incrementrange[]" class="increment_range"  maxlength="10" onchange="document.getElementById('moreUploadsLink').style.display = 'block';"  value="<?php echo isset($site_meta) &&  (!array_key_exists('price',$errors))? trim($site_meta[0]['price']):$validator['price'];?>">
                                          
                                         <span class="error"><?php echo isset($errors['price'])?ucfirst($errors['price']):''; ?></span></td>
                                         
                                </tr>
                                
                                <tr>
                                        <td valign="top"><label><?php //echo __('increment_label');?> </label></td>   
                                        <td><input type="text" name="incrementrange[min][]" style="width:120px;" id="incrementrange[]" class="increment_range"  maxlength="10" onchange="document.getElementById('moreUploadsLink').style.display = 'block';" value="<?php echo isset($site_meta) &&  (!array_key_exists('minrange',$errors))? trim($site_meta[0]['minrange']):$validator['minrange'];?>">
                                        
                                         <span class="error"><?php echo isset($errors['minrange'])?ucfirst($errors['minrange']):''; ?></span></td>
                                         
                                         
                                         <td><input type="text" style="width:120px;" name="incrementrange[max][]" id="incrementrange[]" class="increment_range"  maxlength="10" onchange="document.getElementById('moreUploadsLink').style.display = 'block';"  value="<?php echo isset($site_meta) &&  (!array_key_exists('maxrange',$errors))? trim($site_meta[0]['maxrange']):$validator['maxrange'];?>">
                                         
                                         <span class="error"><?php echo isset($errors['maxrange'])?ucfirst($errors['maxrange']):''; ?></span></td>
                                         
                                         
                                         <td><input type="text" style="width:120px;" name="incrementrange[price][]" id="incrementrange[]" class="increment_range"  maxlength="10" onchange="document.getElementById('moreUploadsLink').style.display = 'block';"  value="<?php echo isset($site_meta) &&  (!array_key_exists('price',$errors))? trim($site_meta[0]['price']):$validator['price'];?>">
                                          
                                         <span class="error"><?php echo isset($errors['price'])?ucfirst($errors['price']):''; ?></span></td>
                                         
                                </tr>
                                
                                <tr>
                                        <td valign="top"><label><?php //echo __('increment_label');?> </label></td>   
                                        <td><input type="text" name="incrementrange[min][]" style="width:120px;" id="incrementrange[]" class="increment_range"  maxlength="10" onchange="document.getElementById('moreUploadsLink').style.display = 'block';" value="<?php echo isset($site_meta) &&  (!array_key_exists('minrange',$errors))? trim($site_meta[0]['minrange']):$validator['minrange'];?>">
                                        
                                         <span class="error"><?php echo isset($errors['minrange'])?ucfirst($errors['minrange']):''; ?></span></td>
                                         
                                         
                                         <td><input type="text" style="width:120px;" name="incrementrange[max][]" id="incrementrange[]" class="increment_range"  maxlength="10" onchange="document.getElementById('moreUploadsLink').style.display = 'block';"  value="<?php echo isset($site_meta) &&  (!array_key_exists('maxrange',$errors))? trim($site_meta[0]['maxrange']):$validator['maxrange'];?>">
                                         
                                         <span class="error"><?php echo isset($errors['maxrange'])?ucfirst($errors['maxrange']):''; ?></span></td>
                                         
                                         
                                         <td><input type="text" style="width:120px;" name="incrementrange[price][]" id="incrementrange[]" class="increment_range"  maxlength="10" onchange="document.getElementById('moreUploadsLink').style.display = 'block';"  value="<?php echo isset($site_meta) &&  (!array_key_exists('price',$errors))? trim($site_meta[0]['price']):$validator['price'];?>">
                                          
                                         <span class="error"><?php echo isset($errors['price'])?ucfirst($errors['price']):''; ?></span></td>
                                         
                                </tr>
                                
                                <tr>
                                        <td valign="top"><label><?php //echo __('increment_label');?> </label></td>   
                                        <td><input type="text" name="incrementrange[min][]" style="width:120px;" id="incrementrange[]" class="increment_range"  maxlength="10" onchange="document.getElementById('moreUploadsLink').style.display = 'block';" value="<?php echo isset($site_meta) &&  (!array_key_exists('minrange',$errors))? trim($site_meta[0]['minrange']):$validator['minrange'];?>">
                                        
                                         <span class="error"><?php echo isset($errors['minrange'])?ucfirst($errors['minrange']):''; ?></span></td>
                                         
                                         
                                         <td><input type="text" style="width:120px;" name="incrementrange[max][]" id="incrementrange[]" class="increment_range"  maxlength="10" onchange="document.getElementById('moreUploadsLink').style.display = 'block';"  value="<?php echo isset($site_meta) &&  (!array_key_exists('maxrange',$errors))? trim($site_meta[0]['maxrange']):$validator['maxrange'];?>">
                                         
                                         <span class="error"><?php echo isset($errors['maxrange'])?ucfirst($errors['maxrange']):''; ?></span></td>
                                         
                                         
                                         <td><input type="text" style="width:120px;" name="incrementrange[price][]" id="incrementrange[]" class="increment_range"  maxlength="10" onchange="document.getElementById('moreUploadsLink').style.display = 'block';"  value="<?php echo isset($site_meta) &&  (!array_key_exists('price',$errors))? trim($site_meta[0]['price']):$validator['price'];?>">
                                          
                                         <span class="error"><?php echo isset($errors['price'])?ucfirst($errors['price']):''; ?></span></td>
                                         
                                </tr>
                                
                                <tr>
                                        <td valign="top"><label><?php //echo __('increment_label');?> </label></td>   
                                        <td><input type="text" name="incrementrange[min][]" style="width:120px;" id="incrementrange[]" class="increment_range"  maxlength="10" onchange="document.getElementById('moreUploadsLink').style.display = 'block';" value="<?php echo isset($site_meta) &&  (!array_key_exists('minrange',$errors))? trim($site_meta[0]['minrange']):$validator['minrange'];?>">
                                        
                                         <span class="error"><?php echo isset($errors['minrange'])?ucfirst($errors['minrange']):''; ?></span></td>
                                         
                                         
                                         <td><input type="text" style="width:120px;" name="incrementrange[max][]" id="incrementrange[]" class="increment_range"  maxlength="10" onchange="document.getElementById('moreUploadsLink').style.display = 'block';"  value="<?php echo isset($site_meta) &&  (!array_key_exists('maxrange',$errors))? trim($site_meta[0]['maxrange']):$validator['maxrange'];?>">
                                         
                                         <span class="error"><?php echo isset($errors['maxrange'])?ucfirst($errors['maxrange']):''; ?></span></td>
                                         
                                         
                                         <td><input type="text" style="width:120px;" name="incrementrange[price][]" id="incrementrange[]" class="increment_range"  maxlength="10" onchange="document.getElementById('moreUploadsLink').style.display = 'block';"  value="<?php echo isset($site_meta) &&  (!array_key_exists('price',$errors))? trim($site_meta[0]['price']):$validator['price'];?>">
                                          
                                         <span class="error"><?php echo isset($errors['price'])?ucfirst($errors['price']):''; ?></span></td>
                                         
                                </tr>
                                
                                <tr>
                                        <td valign="top"><label><?php //echo __('increment_label');?> </label></td>   
                                        <td><input type="text" name="incrementrange[min][]" style="width:120px;" id="incrementrange[]" class="increment_range"  maxlength="10" onchange="document.getElementById('moreUploadsLink').style.display = 'block';" value="<?php echo isset($site_meta) &&  (!array_key_exists('minrange',$errors))? trim($site_meta[0]['minrange']):$validator['minrange'];?>">
                                        
                                         <span class="error"><?php echo isset($errors['minrange'])?ucfirst($errors['minrange']):''; ?></span></td>
                                         
                                         
                                         <td><input type="text" style="width:120px;" name="incrementrange[max][]" id="incrementrange[]" class="increment_range"  maxlength="10" onchange="document.getElementById('moreUploadsLink').style.display = 'block';"  value="<?php echo isset($site_meta) &&  (!array_key_exists('maxrange',$errors))? trim($site_meta[0]['maxrange']):$validator['maxrange'];?>">
                                         
                                         <span class="error"><?php echo isset($errors['maxrange'])?ucfirst($errors['maxrange']):''; ?></span></td>
                                         
                                         
                                         <td><input type="text" style="width:120px;" name="incrementrange[price][]" id="incrementrange[]" class="increment_range"  maxlength="10" onchange="document.getElementById('moreUploadsLink').style.display = 'block';"  value="<?php echo isset($site_meta) &&  (!array_key_exists('price',$errors))? trim($site_meta[0]['price']):$validator['price'];?>">
                                          
                                         <span class="error"><?php echo isset($errors['price'])?ucfirst($errors['price']):''; ?></span></td>
                                         
                                </tr>
                                
                                <tr>
                                        <td valign="top"><label><?php //echo __('increment_label');?> </label></td>   
                                        <td><input type="text" name="incrementrange[min][]" style="width:120px;" id="incrementrange[]" class="increment_range"  maxlength="10" onchange="document.getElementById('moreUploadsLink').style.display = 'block';" value="<?php echo isset($site_meta) &&  (!array_key_exists('minrange',$errors))? trim($site_meta[0]['minrange']):$validator['minrange'];?>">
                                        
                                         <span class="error"><?php echo isset($errors['minrange'])?ucfirst($errors['minrange']):''; ?></span></td>
                                         
                                         
                                         <td><input type="text" style="width:120px;" name="incrementrange[max][]" id="incrementrange[]" class="increment_range"  maxlength="10" onchange="document.getElementById('moreUploadsLink').style.display = 'block';"  value="<?php echo isset($site_meta) &&  (!array_key_exists('maxrange',$errors))? trim($site_meta[0]['maxrange']):$validator['maxrange'];?>">
                                         
                                         <span class="error"><?php echo isset($errors['maxrange'])?ucfirst($errors['maxrange']):''; ?></span></td>
                                         
                                         
                                         <td><input type="text" style="width:120px;" name="incrementrange[price][]" id="incrementrange[]" class="increment_range"  maxlength="10" onchange="document.getElementById('moreUploadsLink').style.display = 'block';"  value="<?php echo isset($site_meta) &&  (!array_key_exists('price',$errors))? trim($site_meta[0]['price']):$validator['price'];?>">
                                          
                                         <span class="error"><?php echo isset($errors['price'])?ucfirst($errors['price']):''; ?></span></td>
                                         
                                </tr>
                                
                                <tr>
                                        <td valign="top"><label><?php //echo __('increment_label');?> </label></td>   
                                        <td><input type="text" name="incrementrange[min][]" style="width:120px;" id="incrementrange[]" class="increment_range"  maxlength="10" onchange="document.getElementById('moreUploadsLink').style.display = 'block';" value="<?php echo isset($site_meta) &&  (!array_key_exists('minrange',$errors))? trim($site_meta[0]['minrange']):$validator['minrange'];?>">
                                        
                                         <span class="error"><?php echo isset($errors['minrange'])?ucfirst($errors['minrange']):''; ?></span></td>
                                         
                                         
                                         <td><input type="text" style="width:120px;" name="incrementrange[max][]" id="incrementrange[]" class="increment_range"  maxlength="10" onchange="document.getElementById('moreUploadsLink').style.display = 'block';"  value="<?php echo isset($site_meta) &&  (!array_key_exists('maxrange',$errors))? trim($site_meta[0]['maxrange']):$validator['maxrange'];?>">
                                         
                                         <span class="error"><?php echo isset($errors['maxrange'])?ucfirst($errors['maxrange']):''; ?></span></td>
                                         
                                         
                                         <td><input type="text" style="width:120px;" name="incrementrange[price][]" id="incrementrange[]" class="increment_range"  maxlength="10" onchange="document.getElementById('moreUploadsLink').style.display = 'block';"  value="<?php echo isset($site_meta) &&  (!array_key_exists('price',$errors))? trim($site_meta[0]['price']):$validator['price'];?>">
                                          
                                         <span class="error"><?php echo isset($errors['price'])?ucfirst($errors['price']):''; ?></span></td>
                                         
                                </tr>
                                
            
                                <tr>
                                	<td><?php //echo __("add_more_increment_label"); ?>
                                	
                                	</td>
                                </tr>
                                                          
                      <tr>
                        	<td colspan="2" class="star">*<?php echo __('required_label'); ?></td>
                        </tr>                        
                                <tr>
                                        <td>&nbsp;</td>
                                        <td>
                                         <input type="reset" name="increment_reset" value="<?php echo __('button_reset');?>" title="<?php echo __('button_reset');?>">
                                        <input type="submit" name="increment_submit" title="<?php echo __('button_update');?>" value="<?php echo __('button_update');?>" >
					                  
                                        </td>
                                </tr>
                          <?php } ?>       
                                </table>
                           
                </form>
                <br/><br/>
		<div>Price ranges will be calculated as per above entries. It will be sole responsible for the website owner.</div>
              
        </div>
        <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
</div>

</div>
<script type="text/javascript" language="javascript">

//code for checking message field maxlength
//============================

 jQuery(function($) {
    	$(".increment_range").ForceNumericOnly(true);
    });
//validation for text box amount enter
	jQuery.fn.ForceNumericOnly =
	function(digitonly)
	{
	    var dot = digitonly || false; 
	    return this.each(function()
	    {
	
		$(this).keydown(function(e)

		{ 
		    
		    var key = e.charCode || e.keyCode || 0;
		    // allow backspace, tab, delete, arrows, numbers and keypad numbers ONLY
		    if(!dot)
		    {
			return (
			    key == 8 || 
			    key == 9 ||
			    key == 46 ||
			    key == 36 || key == 35 ||
			    (key >= 37 && key <= 40) ||
			    (key >= 48 && key <= 57) ||
			    (key >= 96 && key <= 105));
		    }
		    else
		    {
			//Need deciaml point
			return (
			    key == 8 ||
			    key == 190 ||
			    key == 110 ||
			    key == 9 ||
			    key == 46 ||
			    key == 36 || key == 35 ||
			    (key >= 37 && key <= 40) ||
			    (key >= 48 && key <= 57) ||
			    (key >= 96 && key <= 105));
		    }
		});
	    });
	};
    

$(document).ready(function(){

	//For Field Focus
	//===============
	field_focus('meta_keywords');

}); 



$(document).ready(function(){
      toggle(3);
});
</script>
