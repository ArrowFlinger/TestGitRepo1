        // JavaScript Document
var scripts = document.getElementsByTagName("script"),
SrcPath = scripts[1].src;

SrcPath = SrcPath.replace("/js/script.js", "");

 $(document).ready(function(){
        $(window).load(function () {
               $(':input:visible:enabled:first').focus();
         })
});

$(document).ready(function () {
	if($('#messagedisplay')){
		$('#messagedisplay').animate({opacity: 1.0}, 8000)
		$('#messagedisplay').fadeOut('slow');
	}
	if($('#error_messagedisplay')){
		$('#error_messagedisplay').animate({opacity: 1.0}, 8000)
		$('#error_messagedisplay').fadeOut('slow');
	}
	
	  $('.scr_month').hide(); 
     $('.scr_year').hide();
     $('.user_month').hide(); 
     $('.user_year').hide();
     
     
     
     /* $(".image").rotate({
           bind:
             {
                mouseover : function() {
                        $(this).rotate({animateTo:360})
                },
                mouseout : function() {
                        $(this).rotate({animateTo:0})
                }
             }
           
        }); */
        
       
});


 $(document).ready(function(){
        $('.toggle').click(function(){
		$(".toggle_s").slideToggle("fast");
	});
	$('.toggle1').click(function(){
		$(".toggle_s1").slideToggle("fast");
	});
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
	});
	$('.toggle3').click(function(){
		$(".toggle_s3").slideToggle("fast");
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


function blockunblockCity(country,city,type)
{
	if(country && city){
		window.location.href = SrcPath+"/admin/"+type+"-city/"+country+"/"+city+".html"
	}
	return;
}

function deleteCity(country,city)
{
	if(country && city && confirm('Are you sure  want to delete?')){
		window.location.href = SrcPath+"/admin/delete-city/"+country+"/"+city+".html"
	}
	return;
}


function blockunblockCategory(id,catUrl,type)
{
	if(id && catUrl){
		window.location.href = SrcPath+"/admin/"+type+"-category/"+id+"/"+catUrl+".html"
	}
	return;
}

function deleteCategory(id,catUrl)
{
	if(id && catUrl && confirm('Are you sure want to delete?')){
		window.location.href = SrcPath+"/admin/delete-category/"+id+"/"+catUrl+".html"
	}
	return;
}

function changelogoimage(name)
{
	var theme =  document.getElementById('themeselectName').value; 
	document.getElementById('themeImgID').src = SrcPath+"/themes/"+theme+"/images/"+name+".png";
}

function blockunblockUser(id,code,type)
{
	if(id && type){
		window.location.href = SrcPath+"/admin/"+type+"-user/"+code+"/"+id+".html"
	}
	return;
}

function deleteUser(id,code)
{
	if(id && confirm('Are you sure  want to delete?')){
		window.location.href = SrcPath+"/admin/delete-user/"+id+"/"+code+".html"
	}
	return;
}

function blockunblockaffiliate(id,code,type)
{
	if(id && type){
		window.location.href = SrcPath+"/admin/"+type+"-affiliate/"+code+"/"+id+".html"
	}
	return;
}

function deleteaffiliate(id,code)
{
	if(id && confirm('Are you sure  want to delete?')){
		window.location.href = SrcPath+"/admin/delete-affiliate/"+id+"/"+code+".html"
	}
	return;
}


function blockunblockcitylink(id,code,type)
{
	if(id && type){
		window.location.href = SrcPath+"/admin/"+type+"-citylinks/"+code+"/"+id+".html"
	}
	return;
}

function deletecitylink(id,code)
{
	if(id && code && confirm('Are you sure  want to delete?')){
		window.location.href = SrcPath+"/admin/delete-citylinks/"+id+"/"+code+".html"
	}
	return;
}

function blockunblockdeal(id,code,type)
{
	if(id && type && code){
		window.location.href = SrcPath+"/admin/"+type+"-deal/"+code+"/"+id+".html"
	}
	return;
}

function blockunblockauction(id,code,type)
{
	if(id && type && code){
		window.location.href = SrcPath+"/admin/"+type+"-auction/"+code+"/"+id+".html"
	}
	return;
}

function blockunblockmdeal(id,code,type)
{
	if(id && type && code){
		window.location.href = SrcPath+"/merchant/"+type+"-deal/"+code+"/"+id+".html"
	}
	return;
}




function deletedeal(id,code)
{
	if(id && code && confirm('Are you sure  want to delete?')){
		window.location.href = SrcPath+"/admin/delete-deal/"+id+"/"+code+".html"
	}
	return;
}

function blockunblocksubscriber(id,type)
{ 

	if(id && type){

		window.location.href = SrcPath+"/admin/"+type+"-subscriber/"+id+".html"
	}
	return;

}

function deletesubscriber(id)
{

	if(id && confirm('Are you sure want to delete?')){


		window.location.href = SrcPath+"/admin/delete-subscriber/"+id+".html"
	}
	return;
}

function blockunblockFaq(id,type)
{	
	if(id){
		window.location.href = SrcPath+"/faq/"+type+"-faq/"+id;
	}
	return;
}
function deleteFaq(id)
{	
	if(id && confirm('Are you sure want to delete?')){
		window.location.href = SrcPath+"/faq/delete-faq/"+id;

	}
	return;
}

function blockunblockBlog(id,code,type)
{	
	if(id && type && code){
		window.location.href = SrcPath+"/blog/"+type+"-blog/"+code+"/"+id+".html"
	}
	return;
}

function deleteBlog(id,code)
{	
	if(id && code && confirm('Are you sure want to delete?')){
		window.location.href = SrcPath+"/blog/delete-blog/"+id+"/"+code+".html"

	}
	return;
}

function blockunblockCMS(id,code,type)
{	
	if(id && type && code){
		window.location.href = SrcPath+"/cms/"+type+"-cms/"+code+"/"+id+".html"
	}
	return;
}

function deleteCMS(id,code)
{	
	if(id && code && confirm('Are you sure want to delete?')){
		window.location.href = SrcPath+"/cms/delete-cms/"+id+"/"+code+".html"

	}
	return;
}


function deleteContact(id)
{
    if(id && confirm('Are you sure want to delete?')){
		window.location.href = SrcPath+"/admin/delete/"+id+".html"
	}
	return;

}
  


function checkboxcheckAll(form_name,check_all,isO){
	var trk=0;
	var frm = eval('document.'+form_name);
	var check_frm = eval('document.'+form_name+'.'+check_all);

	for (var i=0;i<frm.elements.length;i++){
		var e=frm.elements[i];
		if ((e.name != check_all) && (e.type=='checkbox')){
			if (isO != 1){
				trk++;
				if(e.disabled!=true)
					e.checked=check_frm.checked;
			}
		}
	}
};
function deselectCheckBox(form_name,checkboxelement){
	var frm = eval('document.'+form_name);
	var check_frm = eval('document.'+form_name+'.'+checkboxelement);
	if(check_frm.checked){
		check_frm.checked=false;
	}
};

function enquireystatus(code,id){
    if(code && id){ 
        var url = SrcPath+'/admin/contact-status/'+code+'/'+id+'.html';
    } 
    $.post(url,function(check){ 
        document.getElementById('option'+id).innerHTML = check;
    
    }); 
}
function blockunblockAds(id,type)
{	
	if(id){
		window.location.href = SrcPath+"/admin/"+type+"-ads/"+id;
	}
	return;
}
function deleteAds(id)
{	
	if(id && confirm('Are you sure want to delete?')){
		window.location.href = SrcPath+"/admin/delete-ads/"+id;

	}
	return;
}

function city_change(country){ 
if(country == ''){ var country = -1;  }
	if(country){var url = SrcPath+'/admin_users/CityS/'+country; }
	//$.post(url,function(check){ $("#CitySD").html(check); /*document.getElementById('CitySD').innerHTML = check; */});
	$.ajax(
	{
		type:'POST',
		url:url,
		cache:false,
		async:true,
		global:false,
		dataType:"html",
		success:function(check)
		{
		   $("#CitySD").html(check);
		},
		error:function()
		{
			alert('No city has been added under this country.');
		}
	});
}


function city_change_merchant(country){ 
if(country == ''){ var country = -1;  }

	if(country){var url = SrcPath+'/admin_merchant/CityS/'+country; }
	//$.post(url,function(check){ $("#CitySD").html(check); /*document.getElementById('CitySD').innerHTML = check; */});
	$.ajax(
	{
		type:'POST',
		url:url,
		cache:false,
		async:true,
		global:false,
		dataType:"html",
		success:function(check)
		{
		   $("#CitySD").html(check);
		},
		error:function()
		{
			alert('No city has been added under this country.');
		}
	});
}

function city_change_merchant_shop(country){ 
if(country == ''){ var country = -1;  }

	if(country){var url = SrcPath+'/merchant/CitySS/'+country; }
	//$.post(url,function(check){ $("#CitySD").html(check); /*document.getElementById('CitySD').innerHTML = check; */});
	$.ajax(
	{
		type:'POST',
		url:url,
		cache:false,
		async:true,
		global:false,
		dataType:"html",
		success:function(check)
		{
		   $("#CitySD").html(check);
		},
		error:function()
		{
			alert('No city has been added under this country.');
		}
	});
}

function blockunblockmerchant(id,code,type)
{
	if(id && type){
		window.location.href = SrcPath+"/admin/"+type+"-merchant/"+code+"/"+id+".html"
	}
	return;
}

function deletemerchant(id,code)
{
	if(id && confirm('Are you sure  want to delete?')){
		window.location.href = SrcPath+"/admin/delete-merchant/"+id+"/"+code+".html"
	}
	return;
}

function blockunblockmerchantshop(id,mid,type)
{
	if(id && type){
		window.location.href = SrcPath+"/admin/"+type+"-merchant-shop/"+id+"/"+mid+".html"
	}
	return;
}




function blockunblockshop(id,type)
{
	if(id && type){
		window.location.href = SrcPath+"/merchant/"+type+"-shop/"+id+".html"
	}
	return;
}

function deletemerchantshop(id,mid)
{
	if(id && confirm('Are you sure  want to delete?')){
		window.location.href = SrcPath+"/admin/delete-merchant-shop/"+id+"/"+mid+".html"
	}
	return;
}

/* shop select */

function shop_change(users){ 

if(users == ''){ var users = -1;  }
	if(users){var url = SrcPath+'/admin_deals/shop/'+users; }
	//$.post(url,function(check){ $("#CitySD").html(check); /*document.getElementById('CitySD').innerHTML = check; */});
	$.ajax(
	{
		type:'POST',
		url:url,
		cache:false,
		async:true,
		global:false,

		dataType:"html",
		success:function(check)
		{
		   $("#shop").html(check);
		},
		error:function()
		{
			alert('No city has been added under this country.');
		}
	});
}

// User commants 

function blockunblockUsercomments(id,type)
{
	if(id && type){
		window.location.href = SrcPath+"/admin/"+type+"-user-comments/"+id+".html"
	}
	return;
}

// fund delete 
function deletefund(id,amount)
{
	if(id && amount && confirm('Are you sure  want to delete?')){
		window.location.href = SrcPath+"/merchant/delete-fund-request/"+id+"/"+amount;
	}
	return;
}

/** UPDATE FUND REQUEST STATUS**/

function updatefundrequest_status(requestid, userid, type)
{
        if(type==4){
        if(requestid && userid && type==4){
		window.location.href = SrcPath+"/admin/message-fund-request-status/"+requestid+"/"+userid+".html";
	}
	return;
        
        } else {
	if(requestid && userid && type){
		window.location.href = SrcPath+"/admin/update-fund-request-status/"+requestid+"/"+userid+"/"+type+".html";
	}
	return;
	
	}

}

/** PRODUCTS**/
function blockunblockproduct(id,code,type)
{
	if(id && type && code){
		window.location.href = SrcPath+"/admin/"+type+"-products/"+code+"/"+id+".html"
	}
	return;
}

/** MARCHANT PRODUCTS**/
function blockunblockmproduct(id,code,type)
{

	if(id && type && code){
		window.location.href = SrcPath+"/merchant/"+type+"-products/"+code+"/"+id+".html"

	}

	return;
}

/** Merchant Close Deals **/

function close_deal(id,code,type)
{
	if(id && type && code){
		window.location.href =SrcPath+"/merchant/"+type+"-deals/"+code+"/"+id+".html"
	}
	return;
}


/** Admin Close Deals **/

function admin_close_deal(id,code,type)
{
	if(id && type && code){
		window.location.href =SrcPath+"/admin/"+type+"-deals/"+code+"/"+id+".html"
	}
	return;
}


/** Blog Functions **/
	

function blockunblockBlog(id,code,type,redirect)
{
	if(id && code){
		window.location.href = SrcPath+"/admin/"+type+"-blog/"+id+"/"+code+"/"+redirect+".html"
	}
	return;
}

function deleteBlog(id,code,redirect)
{	
	if(id && code && confirm('Are you sure you want to delete?')){
		window.location.href = SrcPath+"/admin/delete-blog/"+id+"/"+code+"/"+redirect+".html"

	}
	return;
}

	/** Email Scbscriber**/
function blockunblocksubscriber(id,type)
{ 

	if(id && type){
		
		window.location.href = SrcPath+"/admin/"+type+"-subscribe/"+id+".html"
	}
	return;

}

function deletesubscriber(id)
{

	if(id && confirm('Are you sure want to delete?')){


		window.location.href = SrcPath+"/admin/delete-subscribe/"+id+".html"
	}
	return;
}

	/** Contacts manage**/

function deletesubcontact(id)
{

	if(id && confirm('Are you sure want to delete?')){


		window.location.href = SrcPath+"/admin/delete-contacts/"+id+".html"
	}
	return;
}


function publishBlog(id,code,type,redirect)
{
	if(id && code){
		window.location.href = SrcPath+"/admin/"+type+"-blog/"+id+"/"+code+"/"+redirect+".html"
	}
	return;
}

	/** Blog Comment Functions **/

function blockunblockComments(id,blog,type)
{
	if(id){
		window.location.href = SrcPath+"/admin/"+type+"-comments/"+id+"/"+blog+".html"
	}
	return;
}
function approvedisapproveComment(id,blog,type)
{
	if(id){
		window.location.href = SrcPath+"/admin/"+type+"-comments/"+id+"/"+blog+".html"
	}
	return;
}
function deleteComments(id,blog)
{
	if(id && confirm('Are you sure you want to delete?')){
		window.location.href = SrcPath+"/admin/delete-comments/"+id+"/"+blog+".html"
	}
	return;
}
/** DELETE USER COMMENTS **/
function deleteUserComments(id)
{	
	if(id && confirm('Are you sure you want to delete?')){
		window.location.href = SrcPath+"/admin/delete-user-comments/"+id+"/"+".html"
	}
	return;
}

function forceclose_deal(id,key)
{

	if(id && confirm('Are you sure you want to close the deal?')){

		window.location.href = SrcPath+"/admin/force-close/"+id+"/"+key+".html";
	}
	return;
}


function Transaction_date() {
                $('.scr_date').show();
                $('.scr_month').hide();
                $('.scr_year').hide();
                $("#transactiondate").addClass("selected");
       		    $("#transactionmonth").removeClass("selected");
       		    $("#transactionyear").removeClass("selected");
        }
        
        function Transaction_month() {
                $('.scr_month').show();
                $('.scr_date').hide();
                $('.scr_year').hide();
                
           		$("#transactionmonth").addClass("selected");
           		$("#transactiondate").removeClass("selected");
           		$("#transactionyear").removeClass("selected");
                
        }
        
        function Transaction_year() {
                $('.scr_year').show();
                $('.scr_date').hide();
                $('.scr_month').hide();
                
           		$("#transactionyear").addClass("selected");
           		$("#transactiondate").removeClass("selected");
           		$("#transactionmonth").removeClass("selected");
                
        }
        
        function User_date() {
                $('.user_date').show();
                $('.user_month').hide();
                $('.user_year').hide();
                $("#userdate").addClass("selected");
       		    $("#usermonth").removeClass("selected");
       		    $("#useryear").removeClass("selected");
        }
        
        function User_month() {
                $('.user_month').show();
                $('.user_date').hide();
                $('.user_year').hide();
                
           		$("#usermonth").addClass("selected");
           		$("#userdate").removeClass("selected");
           		$("#useryear").removeClass("selected");
                
        }
        
        function User_year() {
                $('.user_year').show();
                $('.user_date').hide();
                $('.user_month').hide();
                
           		$("#useryear").addClass("selected");
           		$("#userdate").removeClass("selected");
           		$("#usermonth").removeClass("selected");
                
        }
	/* select graphs */        
	
	/*function showstuff(select_container_days){
  document.getElementById(container_days_line).style.visibility="visible";
  
}
 
function hidestuff(select_container_months){
   document.getElementById(container_month_line).style.visibility="visible";
}
	
	function hidestuff(select_container_years){
   document.getElementById(container_year_line).style.visibility="visible";
}
	*/
	
	
	
	
	
	
	
	
	
	
	
	
        

	/* select Email To Send Newsletter */

function user_change(users,type){ 
	if(users && type==1){var url = SrcPath+'/admin_deals/user_select/'+users; }
		
	if(users && type==2){var url = SrcPath+'/admin_products/user_select/'+users; }

	$.ajax(
	{
		type:'POST',
		url:url,
		cache:false,
		async:true,
		global:false,

		dataType:"html",
		success:function(check)
		{
		   $("#email").html(check);
		},
		error:function()
		{
			alert('No Email Under the Option.');
		}
	});
}

