<?php defined('SYSPATH') OR die("No direct access allowed."); 
?>
<style>
.content_middle ul{}
.content_middle ul li a{ text-decoration:none;display:block; padding:20px; text-align:center; font-size:18px; margin:8px; border:1px solid #ccc; cursor:pointer;}
.content_middle ul li a:hover{ background:#033; color:#fff;}
</style>
<div class="container_content fl clr">
    <div class="cont_container mt15 mt10">
        <div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
        <div class="content_middle">
            <ul>
            	<?php foreach($auction_type as $auction):?>
            	<li> <a href="javascript:;" onclick="NAuction.Module({'module':'<?php echo $auction['typeid'];?>','action':'add','view':'admin'})"><?php echo ucfirst($auction['typename']);?> </li></a>
                <?php endforeach;?>
            </ul>
        </div>
        <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
        <div class="clr">&nbsp;</div>
			   		
        
         <div class="clr">&nbsp;</div> 

  </div>
</div>
<script type="text/javascript">

$(document).ready(function(){
      toggle(6);
});
</script>
