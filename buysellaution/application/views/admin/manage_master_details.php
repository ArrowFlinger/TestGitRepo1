<?php defined('SYSPATH') OR die("No direct access allowed.");

echo Html::script(URL_BASE.'public/tiny_mce/tiny_mce.js');
?>


<div class="container_content fl clr">
  <div class="cont_container mt15 mt10">
    <div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
     <div class="content_middle">
		<form method="post" class="admin_form" name="frmemailtemplate" id="frmemailtemplate"  >
		
		            <div id="ddtabs1" class="glowingtabs">
		               <ul>
				<?php foreach($all_email_data as $data):?>
		               <li>
                                    <a onclick="show_email_template('<?php echo $data['id'];?>');"  href="#Welcome" rel="gc1">
                                        <span title="<?php echo $data['template_name'];?>"><?php echo $data['template_name'];?></span>
                                    </a>
                               </li>
			       <?php endforeach; ?>
		                
		               </ul>
		             </div> 	
		             <div id="email_template_form_div">&nbsp;</div>
		
		 </form>
	    </div>
	    <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
	  </div>
</div>

<script type="text/javascript" src="<?php echo SCRIPTPATH; ?>ddtabmenu.js"></script>
<!-- Dependencies -->
<script type="text/javascript" src="<?php echo SCRIPTPATH; ?>yahoo-min.js"></script>
<!-- Source file -->
<script type="text/javascript" src="<?php echo SCRIPTPATH; ?>json-min.js"></script>

<script type="text/javascript" language="javascript">
  
</script>
<script type="text/javascript" language="javascript">
 
                $(document).ready(function(){
                   
                    show_email_template('<?php echo $template_id;?>');
			
                });
		
		//  When user clicks on tab, this code will be executed
		function show_email_template(template_id) {
		 //alert(template_id);
				
                     //array for getting validation data
					 
					
		       	 //start the ajax
		        $.ajax({
		     	    //this is the php file that processes the data and submit email template
		            url: "<?php echo URL_BASE;?>master/show_template_details/",
		             
		            //GET method is used
		            type: "POST",
		            //data:  {myJson:  data},
		            
		 				data: "template_id="+template_id,
		             
		            //Do not cache the page
		            cache: false,
		             
		            //success
		            success: function (html) {
		              
                        //Loading Indicator
				        //=================
				        $("#email_template_form_div").html('<img src="<?php echo URL_BASE;?>/public/admin/images/loader.gif "> <?php echo __('ajax_loading_caption'); ?>');
							//build form for all tabs
						$("#email_template_form_div").html(html);
                     
		            },
		            //failure
		            error: function () {   
							$("#email_template_form_div").html("<?php echo __('ajax_url_load_error');?>");
		             
		            }
		                
		        });
		        //  At the end, we add return false so that the click on the link is not executed
		        //return false;
		    }
	</script>

