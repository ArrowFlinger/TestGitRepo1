$(document).ready(function(){
    
/*
	$('.toggle2').click(function(){
	
		var imgSrc = document.getElementById('plus_minus').src;
		imgSrc = imgSrc.substr(-12, 12);
		if(imgSrc == "plus_but.png"){
			document.getElementById('plus_minus').src = "/images/minus_but.png"
		}
		else{
			document.getElementById('plus_minus').src = "/images/plus_but.png"
		}	
		$(".toggle_s2").slideToggle("fast");
	});*/
	

	//For Flash Messages
	//==================
		if($('#messagedisplay')){
			$('#messagedisplay').animate({opacity: 1.0}, 6000)
			$('#messagedisplay').fadeOut('fast');
		}
		if($('#error_messagedisplay')){
			$('#error_messagedisplay').animate({opacity: 1.0}, 6000)
			$('#error_messagedisplay').fadeOut('fast');
		}
		
        // Select all
        $("a[href='#select_all']").click( function() {
            $("input[type='checkbox']").attr('checked', true);
            return false;
        });
 
        // Select none
        $("a[href='#select_none']").click( function() {
            $("input[type='checkbox']").attr('checked', false);
            return false;
        });		

	//code for check satisfied or unsatisfied feedback
	//================================================		
	$('.select-satisfy').click(function(){	
		 $('.active').attr('checked','checked');
		 $('.inactive').attr('checked',false);
		 return false;
	});
	
	$('.select-dissatisfy').click(function(){	
		 $('.inactive').attr('checked','checked');
	    $('.active').attr('checked',false);
	    return false;
	});
	
	//code for check flag or unflagged msg
	//=====================================
	$('.select-activated_users').click(function(){	
		 $('.active').attr('checked','checked');
		 $('.inactive').attr('checked',false);
		 return false;
	});
	
	$('.select-inactivated_users').click(function(){	
		 $('.inactive').attr('checked','checked');
	    $('.active').attr('checked',false);
	    return false;
	});
	
	//code for check flag or sender active/inactive
	//=====================================
	$('.select-flagged').click(function(){	
		 $('.active').attr('checked','checked');
		 $('.inactive').attr('checked',false);
		 return false;
	});
	
	$('.select-unflagged').click(function(){	
		 $('.inactive').attr('checked','checked');
	    $('.active').attr('checked',false);
	    return false;
	});
	
	//code for check suspended or unsuspended job
	//========================================
	$('.select-suspended').click(function(){	
		 $('.suspended').attr('checked','checked');
		 $('.unsuspended').attr('checked',false);
		 return false;
	});
	
	$('.select-unsuspended').click(function(){	
		 $('.unsuspended').attr('checked','checked');
	    $('.suspended').attr('checked',false);
	    return false;
	});

	//code for check usr status is active or inactive
	$('.select-activatedusr').click(function(){	
		 $('.activeusr').attr('checked','checked');
		 $('.inactiveusr').attr('checked',false);
		 return false;
	});
	
	$('.select-inactivatedusr').click(function(){	
		 $('.inactiveusr').attr('checked','checked');
	    $('.activeusr').attr('checked',false);
	    return false;
	});
	
	//code for check featured or unfeatured job
	//========================================
	$('.select-featured').click(function(){	
		 $('.featured').attr('checked','checked');
		 $('.unfeatured').attr('checked',false);
		 return false;
	});
	
	$('.select-unfeatured').click(function(){	
		 $('.unfeatured').attr('checked','checked');
	    $('.featured').attr('checked',false);
	    return false;
	});
	
	//code for check active or inactive job
	//=====================================
	$('.select-active').click(function(){	
		 $('.active').attr('checked','checked');
		 $('.inactive').attr('checked',false);
		 return false;
	});
	
	$('.select-inactive').click(function(){	
		 $('.inactive').attr('checked','checked');
	    $('.active').attr('checked',false);
	    return false;
	});
	
	//code for check approved or disapproved jobsuggestion
	//==========================================
	$('.select-approved').click(function(){	
		 $('.approved').attr('checked','checked');
		 $('.disapproved').attr('checked',false);
		 return false;
	});
	
	$('.select-disapproved').click(function(){	
		 $('.disapproved').attr('checked','checked');
	    $('.approved').attr('checked',false);
	    return false;
	});

	 
 });

function closeerr(t)
{
	if(t=="err"){
		$("#error_messagedisplay").hide();
	}
	else{
		$("#messagedisplay").hide();
	}
}
//For First Field Focus
//=====================
function field_focus(field_name)
{
	$("#"+field_name).focus();	
}

//function for select/none checkbox option 
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

	
                
 
//Added by shyam
var auction_typessettings = [];
$(document).ready(function(){ 
    $.extend({
                               
			getAuctionTypesSettings: function(url) {
			var result = null;
			$.ajax({
				url: url,
				type: 'get',
				dataType: 'json',             
				contentType:"application/json; charset=utf-8",
				async: false,
                                complete:function(data)
                                {
                                              
                                   data = jQuery.parseJSON(data.responseText);
                                 
                                   var j=0;					
					$.each(data, function(k,v){
						auction_typessettings[v.typeid] = {name:v.typename,'setting':v.settings};
						j++;
					});
					result = auction_typessettings;
                                }
			});
		   return result;
			}
		});
		auction_typessettings = $.getAuctionTypesSettings(language.baseurl+'modules/getAuctiontypesajaxtoadmin');
               // console.log(auction_typessettings);
//disablefield(auction_typessettings);
setInterval(function(){disablefield(auction_typessettings);},500);
}); 
function disablefield(auction_typessettings)
{
                $.each(auction_typessettings,function(k,v){
                if(typeof v!=='undefined')
                {
                                var ele = v.name;
                                
                                if($("#"+ele).length > 0)
                                {
                                                if($("#"+ele).is(":checked"))
                                                {
                                                                if(v.setting!="")
                                                                {
                                                                                var ks=0;
                                                                                $.each(v.setting,function(k,v){
                                                                                if(!v)
                                                                                {
                                                                                               
                                                                                                if($("#"+k+"-field").length > 0)
                                                                                                {  
                                                                                                                $("#"+k+"-field").hide(); ks++;
                                                                                                                $("#"+k+"-field input[type=checkbox]").attr('checked',false);
                                                                                                                $("#"+k+"-field input[type=text]").val('');
                                                                                                }
                                                                                }
                                                                                else
                                                                                {
                                                                                       if($("#"+k+"-field").length > 0)
                                                                                                {  
                                                                                                                $("#"+k+"-field").show(); 
                                                                                                }         
                                                                                }
                                                                                }); 
                                                                                if(ks==0)
                                                                                {
                                                                                             
                                                                                          $(".modulebase").show();        
                                                                                }
                                                                }
                                                                else
                                                                {
                                                                           $(".modulebase").show();     
                                                                }
                                                       
                                                }
                                                 
                                }
                }
});
}
 
 


