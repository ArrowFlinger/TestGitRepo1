 <?php defined("SYSPATH") or die("No direct script access."); ?>
 <div class="wrapper_outer" id="process_page">
            <div class="wrapper_inner">
                <div class="wrapper">
                     <div class="auctions_black_authorize_top_bg">
                         
                         <div class="auctions_black_authorize_top_mid">
                             <h2><?php echo  __('payment_label');  ?></h2>
                         </div>                        
                     </div>
                     
		     <?php
		     
		  $type=(isset($postvalues['nauction_type']))?$postvalues['nauction_type']:'';?>
		     
		       <div class="actions_black_autorize_mid_bg">
		    <?php
		    
		    $k=0;
		    
		    if(count($postvalues)>0){
		      
		         $abc=array();
		      
		    foreach($postvalues['id'] as $id){ ?> 
                     
                     
                   
                        
                        
                    
                         <div class="container_tot">
                               <?php if($type!="package"){?>
                    <div class="container_left">
						<?php if(isset($postvalues['image'][$k]) && isset($postvalues['product_url'][$k])){?>
                        	<?php 
				if(($postvalues['image'][$k])!="" && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB.$postvalues['image'][$k]))
	       			{ 
					$product_img_path=URL_BASE.PRODUCTS_IMGPATH_THUMB.$postvalues['image'][$k];
				}
				else
				{
					$product_img_path=IMGPATH.NO_IMAGE;
					
				}
			?>
			
                       <a href="<?php echo url::base();?>auctions/view/<?php echo $postvalues['product_url'][$k];?>">
                            <img width="148" height="100"  src="<?php echo $product_img_path; ?>" title="<?php echo ucfirst($postvalues['name'][$k]); ?>" alt="Auction" />
                        </a>
                    </div>
                     <?php }?>
                     <?php }?>
                    <div class="container_right">
                        <div class="product_name">
                            <strong><?php  echo __('name_label'); ?>:</strong>
                            <p><?php echo ucfirst($postvalues['name'][$k]); ?></p>
                        </div>
                        <div class="amount">
                            <strong><?php echo __('amount_label');?>:</strong>
                            <p><?php echo $site_currency." ".Commonfunction::numberformat($postvalues['unitprice'][$k]); ?></p>
			</div>
			
			
			
			
		      <?php if($type!="package"){?> 
			
			<!-- venkatraja added start-->
			
			   <div class="amount">
                            <strong><?php echo __('quantity_label');?>:</strong>
                            <p><?php
			    
			    $quantity=(isset($postvalues['quantity'][$k]))?$postvalues['quantity'][$k]:'';
			    
			    echo $quantity; ?></p>
                        </div>
			    
			
			<div class="amount">
                            <strong><?php echo __('sub_total_label');?>:</strong>
                            <p><?php
			    $sub_amount=(isset($postvalues['quantity'][$k]) && isset($postvalues['unitprice'][$k]))?$postvalues['quantity'][$k]*$postvalues['unitprice'][$k]:'';
			    $sub_amount_arr[]=$sub_amount;
			    echo $site_currency." ".Commonfunction::numberformat($sub_amount); ?></p>
                        </div>
			 
			    <?php }?>
			
		    </div>
			 </div>
		     
		     
		      <?php
		      
		      if(isset($postvalues['id'][$k]))
		      {
				 $field['form[id][]']=$postvalues['id'][$k];
		      }
		      
		      
		      if(isset($postvalues['unitprice'][$k]))
		      {
				 $field['form[unitprice][]']=$postvalues['unitprice'][$k];
		      
		      }
		      
		      if(isset($postvalues['quantity'][$k]))
		      {
		      
				 $field['form[quantity][]']=$postvalues['quantity'][$k];
		      }
		      
		      if(isset($postvalues['name'][$k]))
		      {
				 $field['form[name][]']=$postvalues['name'][$k];
		      }
		      
		      if(isset($postvalues['type']))
		      {
				 $field['form[type]'] = $postvalues['type'];
		      }
		      
		      
		      if(isset($postvalues['nauction_type']))
		      {
				 $field['form[nauction_type]'] = $type;
		      }
		      
		      if(isset($postvalues['shipping_cost']))
		      {
				 $field['form[shipping_cost]'] = $postvalues['shipping_cost'];
		      }
		      
				  $arr[]=$field;
		      
				  $k++;
		      }
		      
		      }

			  ?>
			
                        
                        
                    
                         <div class="container_tot">
				 <?php if($type!="package"){?><div class="container_left"></div><?php }?>
				 <!--div class="container_left"></div-->
				    <div class="container_right"  style="margin-top:0px;">
					    
					    
			
				<?php    if(array_key_exists('shipping_cost',$postvalues)){?>
				<div class="amount">
                            <strong><?php echo __('shipping_fee');?>:</strong>
                            <p><?php
			    
			 
			    
			    echo $site_currency." ".Commonfunction::numberformat($postvalues['shipping_cost']); ?></p>
                        </div>
			
			<?php }?>
			 
			
			<?php
			      if(array_key_exists('shipping_cost',$postvalues))
			      { ?>
			
				<div class="amount">
                            <strong><?php echo __('Total Amount');?>:</strong>
                            <p>
				<?php 
			    echo $site_currency." ".Commonfunction::numberformat(array_sum($sub_amount_arr)+$postvalues['shipping_cost']);?>
			     </p>
                        </div>
			<?php	
				 }
			    
			    ?>
					
                        
                        <div class="payment_option">
                            <strong><?php echo __('payment_option');?>:</strong>
                            <div class="choose_option">
                                <div class="input_box_left"></div>
                                <div class="input_box_mid">
                                    <div class="choose_option_select bg_none">
                                        <select class="select" title="<?php echo __('choose_your_option'); ?>" id="gateway_code">
                                            
                                             <option value=""><?php echo __('choose_your_option'); ?></option>
                                            
                                            <?php 
                                        foreach($payment_gateway as $key){
						
					     if(Commonfunction::check_gateway_plugin($key['paygate_code'])==1){
                                         ?>   
                                            <option value="<?php echo $key['paygate_code'];  ?>"><?php echo $key['payment_gatway'];  ?></option>
                                          <?php
					  
					     }       
					  }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="input_box_right"></div>
                            </div>
                            
                            
                              <?php
			     
                                if(count($payment_gateway)>0){
                              
                                        foreach($payment_gateway as $key){
						  
					if(isset($key['customfunction']) && $key['customfunction']!="")
					{
						$cfunction = unserialize($key['customfunction']);
						$fnname = $cfunction['name'];
				$param = array($arr,$currency_code,1,$key['paygate_code']);		 
						
						$checkfname =  explode("::",$cfunction['name']);
										if(method_exists($checkfname[0],$checkfname[1]))
										{
										//	print_r($param);exit;
											call_user_func_array($fnname, $param);
										}
					}
					else{
                                        $paythrough=strtolower($key['payment_gatway']);//exit;
                                        echo "<br/><a href=".URL_BASE."".$paythrough."/".$paythrough."_payment/".$package_result['package_id']." title=''>". __($paythrough.'_label')."</a>";
					}
					 
                                        }
				}
                                        ?>
                                
                            
                          
                            
                            <div class="paynow_button">
                                <a>
                                    <span class="paynow_but_left"></span>
                                    <span class="paynow_but_mid" title="<?php echo __('pay_now');?>" onclick='payment_gateway_pass()'><?php echo __('pay_now');?></span>
                                    <span class="paynow_but_right"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                         </div>
                     </div>
                   
                </div>
            </div>
        </div>

<script type="text/javascript">

    function payment_gateway_pass()
        {

	    var paypalsubmit=$("#gateway_code").val();
	   
	     if(paypalsubmit!=''){
		
		  $("#"+paypalsubmit).submit();
		  
	     }else{
		 
		 alert("<?php echo  __('please_choose_any_one_gateway');?>");
		 
	     }
            
        }

	$(document).ready(function(){	

		if (!$.browser.opera) {
    
			// select element styling
			$('select.select').each(function(){
				var title = $(this).attr('title');
				if( $('option:selected', this).val() != ''  ) title = $('option:selected',this).text();
				$(this)
					.css({'z-index':10,'opacity':0,'-khtml-appearance':'none'})
					.after('<span class="select">' + title + '</span>')
					.change(function(){
						val = $('option:selected',this).text();
						$(this).next().text(val);
						})
			});

		};
		
	});
</script>
 
 
