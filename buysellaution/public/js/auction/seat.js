var seatauction = 0;
if(typeof NAuction!=='undefined'){
NAuction.prototype.seat = function(item)
{
	//console.log(new Date().getSeconds());
	var price=$("#"+item.Product.element+' .price').html();
					
		switch(item.Product.current_status)
		{
		               // alert(item.Product.current_status);					
			case 0:						
				if(item.Product.lastbidder==0)
				{
					a[item.Product.element]['bid'].hide();
					a[item.Product.element]['countdown'].html(language.comingsoon_text);
					a[item.Product.element]['futureday'].html(item.Product.status);
					a[item.Product.element]['comingsoon'].show(1);
												
				}
				else if(item.Product.lastbidder!=0)
				{
					a[item.Product.element]['bidme_link'].hide();
					a[item.Product.element]['countdown'].html(language.resume_text+" "+item.Product.resume_time);	
					a[item.Product.element]['countdown'].css({"font-size":"1.28em"});	
					a[item.Product.element]['futureday'].html(item.Product.status);
				}
				else
				{}
				break;	
			case 1:
				 
				$("#"+item.Product.element+' .buyseatss').html(item.Product.buy_seats); 
				$("#"+item.Product.element+' .user_seat_amount').html(item.Product.user_seat_amount); 
				
				//for show seat balance instant when the user buy seat
				if(item.Product.buy_seats >0) 
				{ 
				        if(item.Product.session_seat_user == item.Product.booked_seat_user_id) 
				        {
				                $("#"+item.Product.element+' .seat_user_bal_show').show(); 
				        }
				        else
				        {
				                $("#"+item.Product.element+' .seat_user_bal_show').hide();
				        }
				} 
				
				//alert($("#"+item.Product.element+' .bid'));
				
				
		                        //alert(item.Product.user_seats_amt);
				/*if(item.Product.user_seats_amt < 0)
				{ 
				        $("#"+item.Product.id).click(function(){
				        
				        $("#"+item.Product.element+' #notice_seat_msg'+item.Product.id).show();
				        $('#notice_seat_msg'+item.Product.id).html("kbkjb");
				        $('#notice_seat_msg'+item.Product.id).fadeOut(5000);
				        });
				}  */   
	                        
				
				
				
				
				//buy seats count greaterthan the seat minimum limit
				if((item.Product.buy_seats >= item.Product.minimun_limit) )
				{
					//buy seats count equal to seat maximum limit
					if(item.Product.buy_seats == item.Product.maximum_limit)
					{
						$("#"+item.Product.element+' .buyseat_button').hide(); 
						
						if(item.Product.auction_started!=0)
						{ 
							Auction.startauction(item.Product.id);
						}
						if(a['status'] == 6)
						{
							$("#"+item.Product.element+' .product_timer').show();
							$("#"+item.Product.element+' .product_bidnow_link').show();
						} 
						$("#"+item.Product.element+' .bidme_link').show(); 
						$("#"+item.Product.element+' .currentprice').show();
						$("#"+item.Product.element+' .new_com').show();
					}
					else //buy seats not reach maximum limit
					{
						$("#"+item.Product.element+' .auction_buyseats').show();
						$("#"+item.Product.element+' .buyseat_button').show();
						if(item.Product.auction_started!=0)
						{ 
							Auction.startauction(item.Product.id);
						}
						if(a['status'] == 6)
						{
							$("#"+item.Product.element+' .product_timer').show();
							$("#"+item.Product.element+' .product_bidnow_link').show();
						} 
						$("#"+item.Product.element+' .bidme_link').show(); 
						$("#"+item.Product.element+' .currentprice').show();
						$("#"+item.Product.element+' .new_com').show();
					
					}
				}
				else //first show , when seat not reach minimum limit
				{
					$("#"+item.Product.element+' .buyseat_button').show();
					$("#"+item.Product.element+' .buyseat_details').show();
					
					$("#"+item.Product.element+' .auction_buyseats').show();
					$("#"+item.Product.element+' .product_timer').hide();
					$("#"+item.Product.element+' .product_bidnow_link').hide();
					if(a['status'] != 6)
					{
						a[item.Product.element]['bidme_link'].hide(); 
						$("#"+item.Product.element+' .currentprice').hide();
						$("#"+item.Product.element+' .new_com').hide();
					}
				}
				
				if(item.settingIncrement.timestamp <= 10 && item.settingIncrement.timestamp > 0)
				{				
					a[item.Product.element]['countdown'].addClass("countdown_red");
				}
				else{
					a[item.Product.element]['countdown'].removeClass("countdown_red");	
				
				}
				if(a['status']==6)
				{
					saveover=item.Product.extras.product_cost - item.Product.price;
					saveover = (saveover < 0)? 0 : saveover;
					saveover = item.Product.currency +" "+saveover;								
					$("#"+item.Product.element+" .saveover").html(saveover);
					pricepaid = item.Product.currency +" "+item.Product.price;
					$("#"+item.Product.element+" .pricepaid").html(pricepaid);
				}
			
				if(set>1){
					if(price!=item.Product.price){
						var auction_elements=$("#"+item.Product.element+" .countdown, #"+item.Product.element+" .currentprice, #"+item.Product.element+" .lastbidder");									
						auction_elements.hide();
						auction_elements.css({'backgroundColor':'#ffe373'});
						auction_elements.fadeIn(400, function () {
							$(this).css({'backgroundColor' : ''});
						
							if($(".productDetail").length){ 
							if(item.Users.lat!=""){
								rendergmap = true;
								(a['status']==6)?Auction.gmap(item.Users.lat,item.Users.lng):""; 
								}
							}
						});
					
					}
				}
				$(".bidder_photo"+item.Product.id).attr("src",item.Product.user_img); 
				//this condtion for show the seats to user
				 
				break;	
			case 2:
				a[item.Product.element]['countdown'].html(language.closed_text);
				a[item.Product.element]['bid'].hide();
				break;		
			case 3:							
				$("#"+item.Product.element+' .bidme_link').hide();
				(a['status']==6)?a[item.Product.element]['product_bidnow_link'].hide():"";
				$("#"+item.Product.element+' .bid').hide();
				$("#"+item.Product.element+' .countdown').html(language.paused);
				break;							
		}					
		
		
		$("#"+item.Product.element+' .currentprice').html(item.Product.current_price);
		$("#"+item.Product.element+' .price').html(item.Product.price);
		(item.Product.lastbidder!=0)?$("#"+item.Product.element+' .lastbidder').html(item.Users.username):$("#"+item.Product.element+' .lastbidder').html(language.no_bids_yet);			
		var dy = item.Product.time_diff['day'];
		var hr = item.Product.time_diff['hr'];
		var mins = item.Product.time_diff['min'];
		var sec = item.Product.time_diff['sec'];
		var d = new Date();
		d.setHours(hr);
		d.setMinutes(mins);
		d.setSeconds(sec);
		mine = d.getTime();
		a['unix_timestamp']=item.Product.unix_timestamp;
		a[item.Product.element]['time_d_day'] = dy;
		a[item.Product.element]['time_d'] = mine;
		a[item.Product.element]['auction_started'] = item.Product.auction_started;
		a[item.Product.element]['checking_time'] = item.Product.checking_time;
		a[item.Product.element]['timestamp_diff']=item.settingIncrement.timestamp;					
		a[item.Product.element]['current_status']=item.Product.current_status;
		a[item.Product.element]['lastbidders']=item.Product.lastbidder;
		a[item.Product.element]['resume_time']=language.resume_text+" "+item.Product.resume_time;

}

NAuction.prototype.startauction =function(pid)
{
	$.ajax({
		url:language.baseurl+'site/seat/startauction',
		type:'post',
		data:'pid='+pid,
		complete:function(data)
		{
			console.log(data.responseText);
			$("#auction_"+pid+' .buyseats_link').hide();
			a['auction_'+pid]['bidme_link'].show(); 
			$("#auction_"+pid+' .currentprice').show();
			$("#auction_"+pid+' .new_com').show();
		},
		success:function(data)
		{
			
		}
		
		})
}


var updateset =true;
NAuction.prototype.timer_seat=function(auctionId,type)
{
	//console.log(a[auctionId]['auction_started']);
	if(a[auctionId]['auction_started']==0){
		tsd = a[auctionId]['timestamp_diff'];
			var condi_remove = function (){
				if(a['status'] != 6) {
						if(aj > closedremovetime)
						{
							(updateset)?Auction.updateAuction(3,auctionId,type):"";
							updateset = false;	
							Auction.getauctionstatus(a['status'],"1");
							a[auctionId].remove();
							aj=0;
						}
						else
						{
							a[auctionId]['countdown'].html(language.closed_text);
							if(tsd < -(parseInt(a[auctionId]['checking_time'])+5)){
								a[auctionId]['bidme_link'].remove();
							}
						}
					}else{
						a[auctionId]['countdown'].html(language.closed_text);
						a[auctionId]['bidme_link'].remove();
						(updateset)?Auction.updateAuction(3,auctionId,type):"";
						updateset = false;
						
						a[auctionId]['product_bidnow_link'].remove();					
					}
			};		
			var countdownset =a[auctionId]['timestamp_diff'];
			//console.log(a[auctionId]['current_status']);
			if(a[auctionId]['current_status']!=0 && a[auctionId]['current_status']!=3)
			{		
					
				if (tsd > 0) {	
					
					var d = new Date();
					d.setTime(a[auctionId]['time_d']);
					end_time_string = Auction.countdown(d, a[auctionId]['time_d_day']);
					a[auctionId]['countdown'].html(end_time_string);
					if (countdownset < 10 && countdownset > 1) {
						a[auctionId]['countdown'].css({'background-color':'#ff0000', 'padding-left':'2px', 'padding-right':'2px'});
					}
					else if (countdownset < 1 && countdownset > -(parseInt(a[auctionId]['checking_time']))) {
						
						a[auctionId]['countdown'].removeAttr('style');
						a[auctionId]['countdown'].html(language.checking+'...');						
					}
					else if (countdownset < -(parseInt(a[auctionId]['checking_time']))) {						
						aj++;
						condi_remove();
					}
					
				} else {
					if (countdownset < 1 && countdownset > -(parseInt(a[auctionId]['checking_time']))) {						
						a[auctionId]['countdown'].removeAttr('style');
						a[auctionId]['countdown'].html(language.checking+'...');						
					}
					else if(countdownset < -(parseInt(a[auctionId]['checking_time'])))
					{
						if(tsd < -(parseInt(a[auctionId]['checking_time'])+5)){
							aj++;
							condi_remove();							
						}
						else
						{
							a[auctionId]['countdown'].html('Closing...');	
						}
					}
				}
			}
			else if(a[auctionId]['current_status']==3)
			{
				console.log('sd');
				a[auctionId]['countdown'].html(language.paused);	
			}
			else
			{
			
				if(a[auctionId]['lastbidders']==0)
				{					
					a[auctionId]['countdown'].html(language.comingsoon_text);		
					
					
					if(countdownset < 2){
							console.log('New Auction Started');							
							(updateset)?Auction.updateAuction(0,auctionId,type):"";
							updateset = false;
							
						
					}								
				}
				else if(a[auctionId]['lastbidders']!=0)
				{					
						
					a[auctionId]['countdown'].html(a[auctionId]['resume_time']);	
					if(countdownset < 2){
						console.log('Auction is resumed');
						(updateset)?Auction.updateAuction(2,auctionId,type):"";
						updateset = false;
						
					}
				}
				else
				{
					if(countdownset == 1){	
						(updateset)?Auction.updateAuction(3,auctionId,type):"";
						updateset = false;					
						
					}
				}
			}
			a[auctionId]['time_d'] = a[auctionId]['time_d'] -1000 ;		
			a[auctionId]['timestamp_diff'] = a[auctionId]['timestamp_diff'] - 1;
	}
}
}

function checkdefined(value)
{
	if(typeof value!=='undefined')
	{
		return value;
	}
	return '';
}

//For admin menu
$(function(){

               $(".toggleul_8 li:last").after('<li>\
                    <div class="menu_lft1"></div>\
                    <a href="'+checkdefined(language.baseurl)+'admin/seat/seat_settings" class="menu_rgt1" title="'+checkdefined(language.auction_seat_settings)+'">\
                        <span class="pl15">'+checkdefined(language.auction_seat_settings)+'</span>\
                    </a>\
               </li>');
	       $(".bidding_inner ul li:last").after('<li><a title="'+language.seat_auction_label+'" class="seat_icon1">'+language.seat_auction_label+'</a></li>');
	       $(".popup_close, .cancel_seat").live('click',function(){
		$('#fade, #seatpopup').remove();
	       })
	       $(".buy_seat").click(function(){
		if($(".user").html()){
			$('body').append('<div id="fade"></div><div class="popupbox2" id="seatpopup" style="text-align:center">  </div>');
			var pid = $(this).attr('data-pid');					
			var popupid = $(this).attr('data-rel').length>0?$(this).attr('data-rel'):$(this).attr('rel'); 
			$('#' + popupid).fadeIn();  
			$('#fade').css({'filter' : 'alpha(opacity=80)'}).fadeIn(); 
			var popuptopmargin = ($('#' + popupid).height() + 10) / 2;
			var popupleftmargin = ($('#' + popupid).width() + 10) / 2;
			$('#' + popupid).css({
				'position':'fixed' 
			});
			$.ajax({
				url:language.baseurl+'site/seat/confirmseat',
				type:'post',
				dataType:'json',
				data:'pid='+pid,
				cache:false, 
				beforeSend:function()
				{
					$("#seatpopup").html($(".loader"+pid).html());				
				},
				complete:function(data)
				{
					//console.log(data.responseText);
				},
				success:function(data)
				{
			
				//$(".loader"+pid).remove();
					$("#seatpopup").html(data.popup);
				}
			});
		}
		else
		{
			window.location = $(".buy_seat").attr('rel');
		}
		
		});
	         
				    $(".confirm_seat").live('click',function(){
					  var pid = $(this).attr('id');
						  $.ajax({
						  url:language.baseurl+"site/seat",
						  type:"post",
						  dataType:"json",
						  data:"productid="+pid,
						  beforeSend:function()
						  {
						  $(".loader_process").remove();
							$(".re_confirm").after('<div class="loader_process">'+$(".loader"+pid).html()+' Processing...</div>');
							},
						  complete:function(res){
							$(".loader"+pid).hide();
						  //console.log(res.responseText);  
						  }, 
						  success:function(respo){
							$(".loader_process").remove();
							if(respo.error)
							{
							  $('.errormessage').html(respo.error); 
							}else
							{
									Auction.check_userbalance();
								$(".popup_close").click();
							}
							
						  } 
				  
						  });
					 });
});
