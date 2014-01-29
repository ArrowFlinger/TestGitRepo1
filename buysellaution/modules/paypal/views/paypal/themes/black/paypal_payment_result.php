<div class="content_left_out fl"> 
   <div class="content_left fl mt15">    
      <div class="title-left title_temp1">
         <div class="title-right">
            <div class="title-mid">
               <h4 class="no_data fl clr">Paypal payment Status</h4>
            </div>
         </div>
      </div>
      <div class="deal-left clearfix">
         <div class="action_deal_list clearfix">
            <div class="clear"></div>
            <?php
                        if(isset($response)){
                           //print_r($response);
                           echo "<table>";
                           echo "<tr><td><b>Status : </b></td><td>".$response['response']."</td></tr>";
                           echo "<tr><td><b>Invoice No : </b></td><td>".$response['Invoice No']."</td></tr>";
                           echo "<tr><td><b>Credit card : </b></td><td>".$response['Credit card']."</td></tr>";
                           echo "<tr><td><b>Authorization Code : </b></td><td>".$response['Authorization Code']."</td></tr>";
                          // echo "<tr><td><b>Billing Address : </b></td><td>".$response['Billing Address']."</td></tr>";
                           echo "</table>";
                        }
               ?>
            <div id="fb-root"></div>
            <div class="bidding_type">
               <div class="bidding_type_lft"></div>
               <div class="bidding_type_mid">
                  <div class="bidding_inner">
                     
                  </div>
               </div>
               <div class="bidding_type_rft"></div>
            </div>
         </div>
      </div>
   </div>   
   <div class="auction-bl">
      <div class="auction-br">
         <div class="auction-bm">
         </div>
      </div>
   </div>
</div>
     
     