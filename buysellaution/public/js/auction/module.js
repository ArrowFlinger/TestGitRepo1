// JavaScript Document
var auction_types = [],types = [] ;
var baseurl = '';
$(function(){
	$.extend({
		getValues: function(url) {
			var result = null;
			$.ajax({
				url: url,
				type: 'get',
				dataType: 'json',
				async: false,
				success: function(data) {
					var j=0;
					$.each(data, function(k,v){
								
								auction_types[v.typeid] = v.typename;
					});
					result = auction_types;
				}
			});
		   return result;
		}
	});
	types = $.getValues(baseurl+'modules/getAuctiontypes_ajax');
	auction_types= types;
	
});
var NAuction={
	
	clearArray: function (actual){
		var newArray = new Array();
			for(var i = 0; i<actual.length; i++){
			  if (actual[i]){
				newArray.push(actual[i]);
			}
		}
		return newArray;
	},
	Module : function(arr)
	{
		//console.log(auction_types);
		$.ajax({
				url: baseurl+'modules/callback',
				type: 'get',
				dataType: 'json',
				data:arr,
				async: false,
				complete:function(data){
						//alert(data.responseText);
				},
				success: function(data) {
					var module = auction_types[data.module];
					var method = data.action;
					if(data['error'])
					{
						alert(data['error']);
					}
					else { window.location= baseurl+data.view+'/'+module+'/'+method; }
				}
			});
	}
};
