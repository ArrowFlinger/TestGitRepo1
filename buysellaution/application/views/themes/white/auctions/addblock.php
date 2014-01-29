<?php defined("SYSPATH") or die("No direct script access.");?>
<script type="text/javascript">

$(document).ready(function(){	
		var o=0;
		$('.auction_item').each(function(){
			var auctionId    = $(this).attr('id');
			$("#"+auctionId+" .bid").addClass('new_block');
			var prd_id = $(this).find('.addwatchlist').attr('rel');
			oldpids[o]=prd_id;				
			a[auctionId] = $('#' + auctionId);
			a[auctionId]['countdown'] = $('#' + auctionId + ' .countdown');
			a[auctionId]['bid'] = $("#"+auctionId+' .bid');
			a[auctionId]['bidme_link'] = $('#' + auctionId + ' .bidme_link');
			a[auctionId]['futureday'] = $("#"+auctionId+' .futureday');				
			a[auctionId]['comingsoon'] = $("#"+auctionId+' .comingsoon');
			
			o++;
			
		});
		if($(".user").html())
		{
			$(".bid").click(function()
			{		
			
			var url=$(this).attr("name");
			var id=$(this).attr("id");
			var auction_type = $(this).data('auctiontype');			
			var biddingurl =baseurl+modulebidurl+auction_types[auction_type]+"/bid";
			if($(this).hasClass('new_block')){	
				Auction.bid(biddingurl,id);	
			}
			});
		}
		if(!$(".user").html())
		{
			$(".bid").mouseover(function(){
				$(this).html(language.login_labels);
				$(this).click(function(){
					window.location=$(this).attr("rel");
				});
			});
			$(".bid").mouseout(function(){
				$(this).html(language.bid_me_label);
			});
		}
		$(".addwatchlist").click(function(){
			var pid=$(this).attr('rel');
			var url=$(this).attr('name');
			
			$(".loader"+pid).show();
			var display_msg=$("#notice_msg"+pid);
			if($(".user").html())
			{
				$.ajax({
					url:url,
					type:'GET',
					data:'pid='+pid,
					contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
					complete:function(data){
						$(".loader"+pid).hide();
							
						var msg=data.responseText;	
						if(msg==1)
						{
							$(display_msg).show();
							$(display_msg).html(language.added_in_your_watchlist);
							$(display_msg).fadeOut(5000);
						}
						else
						{
							$(display_msg).show();
							$(display_msg).css({"color":"#F00"});
							$(display_msg).html(language.already_in_your_watchlist);
							$(display_msg).fadeOut(5000);
						}
					}
					});
			}
			else
			{
				$(".loader"+pid).hide();
				$(display_msg).show();
				$(display_msg).html(language.login_access);
				$(display_msg).fadeOut(5000);
			}
		return false;		
		});			
		// Auction.getauctionstatus(a['status']);
});//Document ready ends
</script>
<?php 
   //echo Kohana_Beginner::product_block(6,4);exit;
    $count=true;	
   
$content=$block="";
    if(count($auction_types) > 0){
					foreach($auction_types as $typeid => $typename){
								if(isset($result[$typeid])){
									$block = $typename::product_block($result[$typeid],4);	
									$content.=$block;
									echo $block;							
								}
					}
				}
				if(trim($content)=="") { $count = false;}
				
		?>    	

