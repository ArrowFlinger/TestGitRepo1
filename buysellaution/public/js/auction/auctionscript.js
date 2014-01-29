/*
 * Status Values 
 * 1 => All
 * 2 => Closed
 * 3 => Future
 * 4 => Only Live
 * 5 => Hold
 * 6 => Product Detail
 * 7 => Category
 * 8 => Search
 * 
 * 
 * Current Status Values
 * 0 => Future State
 * 1 => Live State
 * 2 => Closed State
*/

var msg=[],
 a=[],
 ln=[],
 autobidinterval=6000,
 processinterval=2000,
 developement = false,
 loopautobids=[],
 item_len=0,
 timer="",
 baseurl= "",
 server_unixtimestamp= "",
 set=0,
 la=true,
 loadservertime =true,
 aj=0,
 rendergmap = true,
 sk=[],
 oldpids=[],
 auctions_list = [],
 auction_types = [],
 prodbidder=[],
 lp=0,
 modulebidurl ="site/",
 sa=0,
 datas="",
 got_data = false,
 hours =0,
 closedremovetime = 15,
 checkboxHeight = "25",
 radioHeight = "25",
 selectWidth = "66";

$(document).ready(function(){		
	  
		item_len=$(".auction_item").length;
		lp=item_len;		
		baseurl=language.baseurl;		
		server_unixtimestamp=language.unix_timestamp;					
		Auction.getDetails();
		//Auction.pennyauction();
		$.extend({
                               
			getAuctionTypes: function(url) { 
			var result = null;
			$.ajax({
				url: url,
				type: 'get',
				dataType: 'json',             
				contentType:"application/json; charset=utf-8",
				async: false,
				success: function(data) {
					var j=0;					
					$.each(data, function(k,v){
						auction_types[v.typeid] = v.typename;
						j++;
					});
					result = auction_types;
				}
			});
		   return result;
			}
		});
		auction_types = $.getAuctionTypes(baseurl+'modules/getAuctiontypes_ajax');
		var o=0;		
		$('.auction_item').each(function(){
			var auctionId    = $(this).attr('id');
			var prd_id = $(this).find('.addwatchlist').attr('rel');	
			var auction_type = $(this).data('auctiontype');

			oldpids[o]=prd_id;
			if(item_len>0){
				if(typeof prd_id != undefined){
				sk[prd_id]=prd_id;}
			a[auctionId] = $('#' + auctionId);
			a[auctionId]['countdown'] = $('#' + auctionId + ' .countdown');
			a[auctionId]['bid'] = $("#"+auctionId+' .bid');
			a[auctionId]['bidme_link'] = $('#' + auctionId + ' .bidme_link');			
			a[auctionId]['product_bidnow_link'] = $('#' + auctionId + ' .product_bidnow_link');
			a[auctionId]['futureday'] = $("#"+auctionId+' .futureday');				
			a[auctionId]['comingsoon'] = $("#"+auctionId+' .comingsoon');
			}
			o++;
		});		
		if($(".user").html())
		{
			$(".bid").live('click',function()
			{					
				var url=$(this).attr("name");
				var id=$(this).attr("id");
				
				var formid=typeof $(this).attr('data-formid')!==undefined ?$(this).data('formid'):"";
				var auction_type = $(this).data('auctiontype');
				var biddingurl =baseurl+modulebidurl+auction_types[auction_type]+"/bid";
				if(!a['auction_'+id]['bid'].hasClass('new_block')){			
					Auction.bid(biddingurl,id,a['auction_'+id]['timestamp_diff'],formid);	
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
	
		$("#category_list").click(function(){
			$("#div_category").toggle();
		});
		$("#div_category").click(function(){
			$("#div_category").hide();
		});
		if($("#category_fetch").length)
		{
			var value=$("#category_fetch").html();
			$("#category_list").val(value);
		}
		
});	

$.fn.compare = function(t) {
	try{
		if(typeof t !== 'undefined'){
		if (this.length != t.length) { return false; }
		var a = this.sort(),
			b = t.sort();
		var s=0;
		for (var i = 0; t[i]; i++) {
			for (k in b[i])
			{
				if(a[i][k].length != b[i][k].length)
				{
					return false;
				}
			}		     
		}		
		return true;
		}
	}
	catch (e)
	{
		Auction.showConsole(e);
	}
};
 
function  NAuction()
{
                
 
	this.bid = function(url,pid,timestamp,formid){
                
		var userid= "";
		var timestamp=timestamp || "";
                var formid=formid || "";
		if(formid!="")
			f = $("#"+formid).length > 0 ? $("#"+formid).serializeArray() : ""; //Siva 
		else
			f = $("#bidform").length > 0 ? $("#bidform").serializeArray() : ""; //Siva 
		
		if(typeof pid === 'object')
		{
                            
			z=0;
			var newbidarr=[];
			$.each(auction_types,function(ak,av){			
				if(typeof av !=='undefined')
				{		
					var newpidarr=[],arr=[];				
					$.each(pid,function(k,v){
						if(ak == v.auction_type) 
						{				
							if(newpidarr.length <=0){
								newpidarr[ak] = new Array();
							}
							arr={'pid':v.pid,'uid':v.uid,'astart':v.astart};
							newpidarr[ak]=newpidarr[ak].concat(arr);
							newbidarr[z]={'url' : v.bidurl,pid:newpidarr}; 
						}					
					});
					z++;
				}
			});
        
			var datas=(timestamp!="")?{'pid':pid,'timestamp':timestamp}:{'pid':pid};
			(typeof pid != 'object')?$(".loader"+pid).show():"";
			$.each(newbidarr ,function(bk,bv){
            
               
					if(typeof bv !=='undefined')
					{
                  
                  //Shyam added on Mar 16
                  var pidarray = new Array();
                  i=0;
                  $.each(bv.pid,function(k,v){
                     if(typeof v!=='undefined')
                     {
                        pidarray[i] = v;
                        i++;
                     }
                  
                  });
                   //End shyam
						$.ajax({
						url:bv.url,
						cache:false,
						type:'get',
						dataType: 'jsonp',
						timeout:5000,
						data:{'pid':pidarray,'timestamp':timestamp},
						contentType:"application/json; charset=utf-8",
						complete:function(data){
							},
						success:function(data){
							
							},
						error:function(jqXHR, textStatus, errorThrown){
							Auction.showConsole(errorThrown);
						}
						});	
					}
				});
				Auction.getauctionstatus(a['status'],"1", a['pid']);
			
		}
		else
		{	
                                
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
                                               
                                                
                                                //venkatraja added for Auction.check_userbalance() and Auction.Check_userbonus() and data.Message!=language.bids_amount_greater_than_zero is added
                                              
							Auction.check_userbalance();
                                                        Auction.check_userbonus();
                                                        
						if(data.Message===null && data.Bid_count > 0)
						{
							//(a['status']==6)?Auction.gmap(data.lat,data.lng):""; //MAP
                                                       
									
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
		
			
	}
	this.showConsole=function(message){
		if(developement)
		{console.log(message);}
	}	
	this.getauctionstatus=function(status,ses,pid,arrayset)
	{				
		
		var bidurl=$(".bid").attr("name");	
		var ses=ses || "";	
		var saveover=0;
		var pricepaid = 0;
		var spids=new Array();
		var npids=new Array();
		var status = a['status'] = status || 5;
		var pid = a['pid'] = pid || "";
		var arrayset = a['arrayset']= arrayset || [];
		var url=$(".auction_item").attr("name") || baseurl+"auctions/process";
		var total_autobidarr_len=0;
		(pid!="")?Auction.bidhistory():"";
		if(typeof a['autobids'] !=='undefined')
		{			
			total_autobidarr_len=Auction.len(a['autobids']);		
			if(total_autobidarr_len>0){
			datas=(a['autobids'] !=='undefined')? { 'autobid': a['autobids'],'status' :status ,'pid' : pid,'arrayset' : arrayset}: "";}		
			else
			{
				datas={'status' :status,'pid' : pid, 'arrayset' : arrayset};
			}	
			
		}else{
			
			datas={'status' :status,'pid' : pid, 'arrayset' : arrayset};
		}
		
		try{
		$.ajax({
			url:url,
			dataType:"jsonp",
			cache:false,
			type: 'get',
			data:datas,
			timeout:10000,
			contentType: "application/json; charset=utf-8",
			
			success:function(data){	
				
				$(".bid").show();	
				var newautobid= $(data['autobids']).compare(a['autobids']);
				if(!newautobid && a['status']!=5 && a['status']!=3)
				{
					Auction.getDetails();
					set=0;
				}
				
				$.each(data['auctions'],function(i,item){
					spids[i]=item.Product.id;
					if (typeof a[item.Product.element] == 'undefined') {
						return;
					}
					
					
					if(typeof auction_types !== 'undefined')
					{
						var fun = "Auction."+auction_types[item.Product.auction_type];
						
						try{
								if(typeof eval(fun) === 'function')
									window['Auction'][auction_types[item.Product.auction_type]](item);
							}
							catch(e)
							{
							Auction.showConsole(e);
							}		
					}
					
				});  
				if(data['auctions'].length > lp)
				{	
					
					var ab=0;
					if(oldpids.length>0){
						for (var d = 0; d < spids.length; d++) {
							
							for(k=0;k<oldpids.length;k++)
							{
								if (spids[d] == oldpids[k]) {
									ab=0;
									break;
								}
								else
								{
									ab=1;
								}
							}
							if(ab==1)
							{
								npids.push(spids[d]);
							}
							
						}	
					}
					else
					{
						npids=spids;
						
					}
					//(a['status']!=6 || a['status']!=8)?Auction.add_blocks(npids):"";
				
					sa=1;
					lp=data.length;
				}
				if (!got_data) {
					setInterval(function(){Auction.timer();}, 1000);
				}		
				
				got_data = true;
				var $timeinterval= (ses=="")?processinterval:5000;
				timer=(ses=="")?setTimeout(function(){Auction.getauctionstatus(status,ses,pid,arrayset);}, $timeinterval):"";
				
				ses="";
				if($(".auction_item").length<= 0 && $(".no_data").length <= 0 && a['status']==4)
				{					
					$(".no_data_show").html('<h4 class="no_data fl clr">'+language.no_live_auction_at_the_moment+'</h4>');
				}				
				},
			error:function(jqXHR, textStatus, errorThrown){
				Auction.showConsole(errorThrown);
				}
			});
		}
		catch(e)
		{
			Auction.showConsole(e);
		}
				set++;
	}
	this.configureURL=function(type)
	{
		var type = type || 0;
		Auction.showConsole(auctions_list);
	}
	this.add_blocks=function(pids){
		$.ajax({
				url:baseurl+"auctions/addBlock",
				type:'get',
				data:{pids:pids},
				cache:false,
				dataType:'json',
				success:function(data){
					if($(".auction_item").length > 0 ){
							$(".auction_item:last").after(data['output']);}
					else { 
							$(".action_deal_list").html(data['output']);
					}				
				},
				error:function(jqXHR, textStatus, errorThrown)
				{Auction.showConsole(errorThrown);}
			});
	}
	this.timer=function(){
		
		$('.auction_item').each(function () {
			var auctionId    = $(this).attr('id');
			var auction_type = $(this).find('.auction_type').attr('data-auctiontype');
			if(typeof  a[auctionId] =='undefined')
			{
				return; 
			}
			if(typeof auction_types !== 'undefined')
			{
				var fun = "Auction.timer_"+auction_types[auction_type];
				try{
                                                
						if(typeof eval(fun) === 'function')
							window['Auction']["timer_"+auction_types[auction_type]](auctionId,auction_type);
					}
					catch(e)
					{
                                                Auction.showConsole(e);
					}		
			}
		});
		
	}
	this.autobidarr=function()
	{		
		return ( typeof a['autobids'] !=='undefined')?a['autobids']:[];		
	}
	this.getDetails=function()
	{
		try{
		$.ajax({
				url:baseurl+'auctions/details',
				type:'post',
				dataType:'json',
				timeout:5000,
				success:function(data)
				{
					a['autobids'] =  data.autobids;
				}
			});
		}
		catch (e)
		{
			Auction.showConsole(e);
		}		
	}
	this.len = function(obj) {
		var L=0;
		$.each(obj, function(i, elem) {
			L++;
		});
		return L;
	}
	this.autobid=function(autobids){
		
		var autobids=autobids;		
		var newarr=new Array();
		var j=0;
		
		$.each(autobids,function(ak,av){
			for(k in av)
			{				
				var shifted=av[k].shift();
				av[k].push(shifted);	
				var pid=k.toString();
				autobids[j][pid.toString()]=av[k];
			}		
			j++;
		});
		 loopautobids = (set>1)?autobids:Auction.autobidarr();
		
		var $this = this;
		var total_len = Auction.len(autobids);
		if(item_len >0 && typeof autobids!='undefined' && total_len > 0){
			var bidsarr=new Array();
			for(i=0;i<total_len;i++)
			{
				
				for (k in autobids[i])
				{				
					
					pid=k.split("_");
					uid = autobids[i][k][0].split("-");
					var biddingurl =baseurl+modulebidurl+auction_types[pid[1]]+"/bid";
					bidsarr[i]={'pid' : pid[0] , 'uid' : uid[0],'bidurl' :biddingurl,'auction_type':pid[1],'astart':uid[1]};
					break;
				}
			}
		
			Auction.bid(baseurl+'auctions/bid/',bidsarr,"");
			set++;
			($this !=='undefined' ) ? setTimeout(function(){Auction.autobid(loopautobids);},autobidinterval):"";
		}
		return;
	}
	this.countdown=function(d, day){
		//hrs = d.getHours();	
		//mins = d.getMinutes();
		//secs = d.getSeconds();
		
			if (d.getHours() < 10)
		{
			hrs=("0" + d.getHours().toString());
		}
		else
		{
			hrs=d.getHours().toString();
		}
		if (d.getMinutes() < 10)
		{
			mins=("0" + d.getMinutes().toString());
		}
		else
		{
			mins=d.getMinutes().toString();
		}
		if (d.getSeconds() < 10)
		{
			secs=("0" + d.getSeconds().toString());
		}
		else
		{
			secs=d.getSeconds().toString();
		}

		var themename=$("#theme_name").val();
	
                if(themename=='white')
                {
		        tm = day+':'+hrs+':'+mins+':'+secs;
		        }else
		{
		
		tm = '<div class="timer"><ul><li><div class="d-timer"><div class="t-timer-lft"></div><div class="t-timer-mid"><span>'+day+'</span></div><div class="t-timer-rft"></div><p class="d_time1">'+'d '+'</p></div></li><li>:</li>'+'<li><div class="d-timer"><div class="t-timer-lft"></div><div class="t-timer-mid"><span>'+hrs+'</span></div>'+'<div class="t-timer-rft"></div><p class="d_time1">'+' hr '+'</p></div></li><li>:</li>'+'<li><div class="d-timer"><div class="t-timer-lft"></div><div class="t-timer-mid"><span>'+mins+'</span></div>'+'<div class="t-timer-rft"></div><p class="d_time1">'+' min '+'</p></div></li><li>:</li>'+'<li><div class="d-timer"><div class="t-timer-lft"></div><div class="t-timer-mid"><span>'+secs+'</span></div><div class="t-timer-rft"></div><p class="d_time1">'+'s'+'</p></div></li></ul></div>';
		
		}
		
		/*if (day <= 0) {
		tm = hrs+' hr '+mins+' min '+secs+' s ';		
			if (hrs <= 0) {
				if (mins <= 0) {
					if (secs <= 0) {
						tm = '1 s';
					} else {
						tm = secs+' s';
					}
				} else {
					if (mins == 1 && secs == 0) {
						tm = '60 s';
					} else {
						tm = mins+' min '+secs+' s ';
					}
				}
			} 
		}*/	
		return tm;
	}
	this.bidhistory=function()
	{
		if($(".bid_history").length>0){
			var url2=$(".bid_history").attr("id");
			$.ajax({
				url:url2,
				type:'get',
				data:"q=history",
				cache:false,
				contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
				complete:function(data){		
					$(".bid_history").html(data.responseText);
				}
			});
		}
	}
	this.updateAuction=function(a,pid,type,array){
		module = auction_types[type];
		array = array || {};
		updateurl = baseurl+"site/"+module+"/updateproduct";
		
			$.ajax({
				url:updateurl,
				type:'get',
				data:{status:a,pid:pid,array:array},
				cache:false,
				complete:function(data)
				{},
				success:function(data){},
				error:function()
				{Auction.showConsole('Update error');}
			});
	}
	this.clearArray= function (actual){
		var newArray = new Array();
			for(var i = 0; i<actual.length; i++){
			  if (actual[i]){
				newArray.push(actual[i]);
			}
		}
		return newArray;
	}
	this.status=function(){
		return a['status'];
	}
	this.servertime=function()
	{	
		var timest= ( typeof server_unixtimestamp !='undefined' && server_unixtimestamp !='') ? server_unixtimestamp* 1000 :a['unix_timestamp']*1000 ;
		var asd = new Date(timest);
		var hour = asd.getHours();
		var meridian="AM";
		if(hour>=12)
		{
			hour=hour-12;
			meridian="PM";
		}	
		if (hour == 0) {
       		hour = 12;
   		}
		var hrs=(hour<10) ? '0'+hour:hour;
		var mins = (asd.getMinutes()<10) ? '0'+asd.getMinutes():asd.getMinutes();
		var secs = (asd.getSeconds()<10)?'0'+asd.getSeconds():asd.getSeconds();
		var time = hrs+':'+mins+':'+secs+' '+meridian;	
		if( typeof a['unix_timestamp'] !='undefined'){
		a['unix_timestamp'] =a['unix_timestamp']+1;
		
		}
		server_unixtimestamp++;		
		var themename=$("#theme_name").val();
		if(themename == "white")
		{		
			$(".server_time_hrs").html(hrs);
			$(".server_time_mins").html(mins);
			$(".server_time_secs").html(secs);			
		}else {		
			$(".server_time").html(time);
		}
		setTimeout(function(){Auction.servertime();},1000);
	}
	this.check_userbalance=function()
	{
		try{
			var user=$(".user").html();
                        
			$.ajax({
					url:baseurl+"auctions/check_balance/"+user,
					type:'get',
					data:"",
					cache:false,
					contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
					complete:function(data){
                                                
						$(".user_balance").html(data.responseText);
					}
				});
		}
		catch(e){}
	}
	this.check_userbonus=function()
	{
		var user=$(".user").html();
		var url=$(".user_bonus").attr("title");
		$.ajax({
				url:baseurl+"auctions/check_bonus/"+user,
				type:'get',
				data:"",
				contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
				complete:function(data){
					var bonusdata=data.responseText;
					if($(".user_bonus b").html()!="")
					{
						$(".user_bonus b").html(bonusdata);
					}
					else
					{$(".user_bonus").html("0");}
				}
			});
	}
       
        //White theme
	var themename=$("#theme_name").val();
	
        if(themename!='white')
        {

	this.gmap = function(lat,lng)
	{		
                if(rendergmap)
                {
                                if(typeof google!=='undefined')
                                {
                                                var myOptions = {
                                                center: new google.maps.LatLng(lat,lng),
                                                zoom: 11,
                                                mapTypeId: google.maps.MapTypeId.ROADMAP
                                                };
                                                var map = new google.maps.Map(document.getElementById("map-canvas"),
                                                myOptions);
                                                var marker = new google.maps.Marker({
                                                position: myOptions.center
                                                });
                                                marker.setMap(map);
                                                pantoDefined=new google.maps.LatLng(lat,lng);
                                                map.panTo(pantoDefined);
                                                rendergmap = false;
                                }
                }
                return true;
  	}
	this.sendRequestViaMultiFriendSelector= function (arr) {
        FB.ui({method: 'apprequests',
          message: arr['invite_text'],
          exclude_ids:arr['exclude_ids']
        },Auction.requestCallback);
        } 
    }
  
    this.requestCallback= function (response) {
		  if(typeof response !=='undefined' && response != null)
		 {
			  $.ajax({
					url:baseurl+'users/invite',
					type:'GET',
					dataType:'json',
					data:{ids:response.to,rid:response.request},
					beforeSend:function(){
						$("#fb_loader").remove();
						$(".action_deal_list").before('<div id="fb_loader" style="text-align:center; font-size:16px;">Loading...</div>');
					},
					complete:function(data){
						//alert(data.responseText);
					},
					success:function(data){							
							location.reload();
							$("#fb_loader").remove();
					}
				});
			}
		 Auction.showConsole(response);
     }
	
};

$(window).load(function(){	
	
	(item_len > 0)?setTimeout(function(){
		
									   var items= Auction.clearArray(sk);
									   var ret=0;									  
									   var total_len = Auction.len(Auction.autobidarr());
										for(i=0;i<total_len;i++)
										{
											for (k in Auction.autobidarr()[i])
											{	
												for(z=0;z<items.length;z++)
												{						
													s=k.split("_");					
													if(items[z]==s[0]){ ret =0; break;}else { ret=1;}
												}
												if(ret==0){ break; }
											}
											if(ret==0){ break; }
										}		
									   (ret==0)?Auction.autobid(Auction.autobidarr()):"";									   
									   
									   } ,2000):"";	
	
	if(loadservertime){
		setTimeout(function(){Auction.servertime();},2000);
	}
});

function confirmDelete(text){
	var agree=confirm(text);
	if (agree){
     		return true;
	 }
	else{
    		return false;
	}
}
function label_onfocus(classname,value)
{
	
	var classes=$("#"+classname);
	if(classes.attr("value")==value)
	{
		classes.val("");
		
	}
}
function label_onblur(classname,value)
{
	
	var classes=$("#"+classname);
	if(classes.attr("value")=="")
	{
		classes.val(value);

		
	}
}


document.write('<style type="text/css">input.styled { display: none; } select.styled { position: relative; width: ' + selectWidth + 'px; opacity: 0; filter: alpha(opacity=0); z-index: 5; } .disabled { opacity: 0.5; filter: alpha(opacity=50); }</style>');

var Custom = {
	init: function() {
		var inputs = document.getElementsByTagName("input"), span = Array(), textnode, option, active;
		for(ma = 0; ma < inputs.length; ma++) {
			if((inputs[ma].type == "checkbox" || inputs[ma].type == "radio") && inputs[ma].className == "styled") {
				span[ma] = document.createElement("span");
				span[ma].className = inputs[ma].type;

				if(inputs[ma].checked == true) {
					if(inputs[ma].type == "checkbox") {
						position = "0 -" + (checkboxHeight*2) + "px";
						span[ma].style.backgroundPosition = position;
					} else {
						position = "0 -" + (radioHeight*2) + "px";
						span[ma].style.backgroundPosition = position;
					}
				}
				inputs[ma].parentNode.insertBefore(span[ma], inputs[ma]);
				inputs[ma].onchange = Custom.clear;
				if(!inputs[ma].getAttribute("disabled")) {
					span[ma].onmousedown = Custom.pushed;
					span[ma].onmouseup = Custom.check;
				} else {
					span[ma].className = span[ma].className += " disabled";
				}
			}
		}
		inputs = document.getElementsByTagName("select");
		for(ma = 0; ma < inputs.length; ma++) {
			if(inputs[ma].className == "styled") {
				option = inputs[ma].getElementsByTagName("option");
				active = option[0].childNodes[0].nodeValue;
				textnode = document.createTextNode(active);
				for(b = 0; b < option.length; b++) {
					if(option[b].selected == true) {
						textnode = document.createTextNode(option[b].childNodes[0].nodeValue);
					}
				}
				span[ma] = document.createElement("span");
				span[ma].className = "select";
				span[ma].id = "select" + inputs[ma].name;
				span[ma].appendChild(textnode);
				inputs[ma].parentNode.insertBefore(span[ma], inputs[ma]);
				if(!inputs[ma].getAttribute("disabled")) {
					inputs[ma].onchange = Custom.choose;
				} else {
					inputs[ma].previousSibling.className = inputs[ma].previousSibling.className += " disabled";
				}
			}
		}
		document.onmouseup = Custom.clear;
	},
	pushed: function() {
		element = this.nextSibling;
		if(element.checked == true && element.type == "checkbox") {
			this.style.backgroundPosition = "0 -" + checkboxHeight*3 + "px";
		} else if(element.checked == true && element.type == "radio") {
			this.style.backgroundPosition = "0 -" + radioHeight*3 + "px";
		} else if(element.checked != true && element.type == "checkbox") {
			this.style.backgroundPosition = "0 -" + checkboxHeight + "px";
		} else {
			this.style.backgroundPosition = "0 -" + radioHeight + "px";
		}
	},
	check: function() {
		element = this.nextSibling;
		if(element.checked == true && element.type == "checkbox") {
			this.style.backgroundPosition = "0 0";
			element.checked = false;
		} else {
			if(element.type == "checkbox") {
				this.style.backgroundPosition = "0 -" + checkboxHeight*2 + "px";
			} else {
				this.style.backgroundPosition = "0 -" + radioHeight*2 + "px";
				group = this.nextSibling.name;
				inputs = document.getElementsByTagName("input");
				for(ma = 0; ma < inputs.length; ma++) {
					if(inputs[ma].name == group && inputs[ma] != this.nextSibling) {
						inputs[ma].previousSibling.style.backgroundPosition = "0 0";
					}
				}
			}
			element.checked = true;
		}
	},
	clear: function() {
		inputs = document.getElementsByTagName("input");

		for(var b = 0; b < inputs.length; b++) {
			if(inputs[b].type == "checkbox" && inputs[b].checked == true && inputs[b].className == "styled") {
				inputs[b].previousSibling.style.backgroundPosition = "0 -" + checkboxHeight*2 + "px";
			} else if(inputs[b].type == "checkbox" && inputs[b].className == "styled") {
				inputs[b].previousSibling.style.backgroundPosition = "0 0";

			} else if(inputs[b].type == "radio" && inputs[b].checked == true && inputs[b].className == "styled") {
				inputs[b].previousSibling.style.backgroundPosition = "0 -" + radioHeight*2 + "px";
			} else if(inputs[b].type == "radio" && inputs[b].className == "styled") {
				inputs[b].previousSibling.style.backgroundPosition = "0 0";
			}
		}
	},
	choose: function() {
		option = this.getElementsByTagName("option");document.forms['lang'].submit();
		for(d = 0; d < option.length; d++) {
			if(option[d].selected == true) {
				document.getElementById("select" + this.name).childNodes[0].nodeValue = option[d].childNodes[0].nodeValue;
			}
		}
	}
}
window.onload = Custom.init;

(function( $ ){
  $.fn.idle = function(options) {

    var defaults = {
      idle: 60000, //idle time in ms
      events: 'mousemove keypress mousedown', //events that will trigger the idle resetter
      onIdle: function(){}, //callback function to be executed after idle time
      onActive: function(){}, //callback function to be executed after back from idleness
      keepTracking: false //if you want to keep tracking user even after the first time, set this to true
    };

    var idle = false;

    var settings = $.extend( {}, defaults, options );

    var resetTimeout = function(id, settings){
      if(idle){
        settings.onActive.call();
        idle = false;
      }
      clearTimeout(id);

      return timeout(settings);
    }

    var timeout = function(settings){
      id = setTimeout(function(){
        idle = true;
        settings.onIdle.call();
        if(settings.keepTracking){
          timeout(settings);
        }
      }, settings.idle);
      return id;
    }

    return this.each(function(){
      id = timeout(settings);
      $(this).bind(settings.events, function(e){
        id = resetTimeout(id, settings);
      });
    }); 

  }; 
})( jQuery );

$(document).idle({
  onIdle: function(){
    window.location = language.baseurl+"auctions/idle";
  },
  onActive:function(){
                window.location = language.baseurl+"auctions/live";    
  },
  idle: 600000
});
var Auction=new NAuction();
