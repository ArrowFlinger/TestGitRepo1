 

//scratch
 var scratchcounter ='';//scratch
if(typeof NAuction!=='undefined'){
NAuction.prototype.scratch = function(item)
{
         
	//console.log(auction_types,.getKey("scratch"));
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
							a[item.Product.element]['bidme_link'].show();
							
							if(item.settingIncrement.timestamp <= 10 && item.settingIncrement.timestamp > 0){				
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
                                                                userbidcount = item.Product.user_bid_count;
								
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
											//this.gmap(item.Users.lat,item.Users.lng);
											}
										}
									});
									
								}
							}
							$(".bidder_photo"+item.Product.id).attr("src",item.Product.user_img);								
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
                                        $("#"+item.Product.element+' #bid_count').html(item.bid_history_count);	                                        
		
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
					a[item.Product.element]['checking_time'] = item.Product.checking_time;
					a[item.Product.element]['timestamp_diff']=item.settingIncrement.timestamp;					
					a[item.Product.element]['current_status']=item.Product.current_status;
					a[item.Product.element]['lastbidders']=item.Product.lastbidder;
					a[item.Product.element]['resume_time']=language.resume_text+" "+item.Product.resume_time;

}



NAuction.ScratchBid = function(url,pid,timestamp,formid){

		var userid= "";
		var timestamp=timestamp || "";
                var formid=formid || "";
		if(formid!="")
			f = $("#"+formid).length > 0 ? $("#"+formid).serializeArray() : ""; //Siva 
		else
			f = $("#bidform").length > 0 ? $("#bidform").serializeArray() : ""; //Siva 
		
	           
		var datas=(timestamp!="")?{'pid':pid,'timestamp':timestamp,'formvalues': f}:{'pid':pid,'formvalues': f};
		(typeof pid != 'object')?$(".loader"+pid).show():"";
		
			$.ajax({
				url:url,
				cache:false,
                                type:'get',
				dataType: 'jsonp',
				timeout:5000,
                                data:datas,
				contentType:"application/json; charset=utf-8",
				complete:function(jqXHR, textStatus){},
				success:function(data){
				
						var msg=$(".bid").attr('title');
						var display_msg=$("#notice_msg"+data.id);
						$(".loader"+data.id).hide(); 
							Auction.check_userbalance();
                                                        Auction.check_userbonus();
                                                        
						if(data.Message===null && data.Bid_count > 0)
						{
							
                                                           
                                                         //Mar-06 scratch Siva
                                                         Auction.customscript(GetIndexByValue(auction_types,"scratch"),'buynow',{'pid':pid});
									
							Auction.getauctionstatus(a['status'],"1", a['pid']);
							Auction.bidhistory();
						}							
						else
						{
                                                    
							$(display_msg).show();
							$(display_msg).html(data.Message);
							$(display_msg).fadeOut(5000);
						}
						
				
				},
			error:function(jqXHR, textStatus, errorThrown){
				Auction.showConsole(errorThrown);
			}
			});
	}

//Mar-06 siva scratch use
     NAuction.prototype.customscript=function(auction_type,fname,param){
            if(auction_type !== '')
			{
				var fun = "Auction."+fname+'_'+auction_types[auction_type];
				try{
                                                
						if(typeof eval(fun) === 'function')
							window['Auction'][fname+"_"+auction_types[auction_type]](param);
					}
					catch(e)
					{
                                                Auction.showConsole(e);
					}		
			}    
        }


NAuction.prototype.timer_scratch=function(auctionId,type)
{
		tsd = a[auctionId]['timestamp_diff'];
			var condi_remove = function (){
				if(a['status'] != 6) {
						if(aj > closedremovetime)
						{
							Auction.updateAuction(3,auctionId,type);						
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
						Auction.updateAuction(3,auctionId,type);
						a[auctionId]['product_bidnow_link'].remove();					
					}
			};		
			var countdownset =a[auctionId]['timestamp_diff'];
			
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
							Auction.updateAuction(0,auctionId,type);
							(a['status'] != 6) ? a[auctionId].remove() : "";
						
					}								
				}
				else if(a[auctionId]['lastbidders']!=0)
				{					
						
					a[auctionId]['countdown'].html(a[auctionId]['resume_time']);	
					if(countdownset < 2){
						console.log('Auction is resumed');
						Auction.updateAuction(2,auctionId,type);
						Auction.getauctionstatus(5,"1");
					}
				}
				else
				{
					if(countdownset == 1){						
						Auction.updateAuction(3,auctionId,type);
						condi_remove();
					}
				}
			}
			a[auctionId]['time_d'] = a[auctionId]['time_d'] +1000 ;		
			a[auctionId]['timestamp_diff'] = a[auctionId]['timestamp_diff'] - 1;	
}

//Scratch buynow seconds 
NAuction.prototype.scratchbuynow=function(pid){
                a['scratchcount']=a['scratchcount']-1;
                $(".scratchbuycountdown p span.showcountdown").text(a['scratchcount']);
                if (a['scratchcount'] <= 0)
                {
                        $(".scratchbuycountdown").hide();
                        clearInterval(scratchcounter);
                        $.ajax({
                        url:baseurl+'site/scratch/timetobuy_update/',
                        type:'get',
                        data:"pid="+pid,
                        cache:false,
                        contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
                        complete:function(data){		
                       
                         a['scratchcount']=data.responseText;
                         alert('Time is over!');
                        }
                        });
                        $('.buynowok').show();
                        $('#ecommersebuynow').show();
                        //For white theme only-March-30
                        $('#show_pric').hide();
                        
                        //counter ended, do something here
                        return;
                }
               
        }
        
 //Dynamic seconds
 NAuction.prototype.buynow_scratch=function(param){
                $('.buynowok').hide();
                $('.example1').hide();
                //scratch
                
                scratchcounter=setInterval (function(){
                Auction.scratchbuynow(param['pid']);
                },1000);
                $(".scratchbuycountdown").show();//end scratch

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
	        		
	$(".popup_close, .cancel_scratch").live('click',function(){
		$('#fade, #box').fadeOut();
	       })
	      
                 $(".scratchbid").live('click',function()
			{					
				var url=$(this).attr("name");
				var id=$(this).attr("id");
				
				var formid=typeof $(this).attr('data-formid')!==undefined ?$(this).data('formid'):"";
				var auction_type = $(this).data('auctiontype');
				var biddingurl =baseurl+modulebidurl+auction_types[auction_type]+"/bid";
				if(!a['auction_'+id]['bid'].hasClass('new_block')){			
					NAuction.ScratchBid(biddingurl,id,a['auction_'+id]['timestamp_diff'],formid);	
				}
			});               


             
	       
	       $(".bidding_inner ul li:last").after('<li><a href="#" title="'+language.auction_scratch_label+'" class="scratch_icon1">'+language.auction_scratch_label+'</a></li>');
	       
	       //User panel menu
	       $(".user_panel_list ul li:nth-child(9),.dash_lsd ul li:nth-child(9)").after('<li class="fl clr "><a href="'+language.baseurl+'site/scratch/scratchlist" title="'+checkdefined(language.auction_scratch_won)+'"  id="scratchactive">'+checkdefined(language.auction_scratch_won)+'</a></li>');
	       
	       //login check when bidding
        if(!$(".user").html())
        {
            $("#dialog_link").mouseover(function(){
                $(this).html(language.login_labels);
                $(this).click(function(){
                    window.location=$(this).attr("rel");
                });
            });
            $("#dialog_link").mouseout(function(){
                $(this).html(language.bid_me_label);
            });
        }
        //end
	
        // Dialog	
			
        
        $("#yourbidding").keyup(function(){
            $(this).val()!=""?$(this).css({'border-color':'#ccc'}):"";});
        if($(".user").html())
        {
            $('#dialog_link').click(function(){
                if($('#yourbidding').val()!="")
                {
	
                  var pid = $(this).attr('data-pid');					
			var popupid = $(this).attr('data-rel').length>0?$(this).attr('data-rel'):$(this).attr('rel'); 
			$('#' + popupid).fadeIn();  
			
$('body').append('<div id="fade"></div>');
			$('#fade').css({'filter' : 'alpha(opacity=80)'}).fadeIn(); 
			var popuptopmargin = ($('#' + popupid).height() + 10) / 2;
			var popupleftmargin = ($('#' + popupid).width() + 10) / 2;
			     
			$('#' + popupid).css({
			'position':'fixed' 
});
                    $('#sample').text($('#yourbidding').val());
                }else
                { 
                    $("#yourbidding").css({'border':'1px solid red'});
                }
                return false;
		
            });
        }
	
});

function GetIndexByValue(arrayName, value)
{ 
        var keyName = "";
        var index = -1;
                for (var key in arrayName) { 
                        if(arrayName[key]==value)
                        {
                                index = key;
                                return index;
                        }
         
                } 
  
}
