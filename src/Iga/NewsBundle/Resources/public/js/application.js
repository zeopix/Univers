$(function(){
  //search button
  $('#search-submit, #bd form input[type=submit]').button();


 
 	//bad practice - trick to do auto-height animated
 	
 	
	$(".body.hidden").each(function(){
		var myheight = $(this).css("height");
		$(this).css({ 'height' : '9px', 'overflow' : 'hidden' , 'margin-bottom' : '8px'}).attr('theight',myheight);
	});

	$(".item").hover(function(){
		var height = $(this).find('.body').attr('theight');
		var iid = $(this).attr('iid');
		var body = $(this).find('.body');
		//$(this).find('.body').delay(1000).queue(function() {
			//alert(iid+"in "+height);
			//console.log("what's up?")
    		//$(".item[iid="+iid+"]").find('.body').animate({'height' : height});
		//});
		
		$(body).delay().animate({'height' : height});

	},function(){
		$(this).find('.body').animate({ 'height' : '9px' });
	});
	
	$(".item .title a").click(function(){

		var href = $(this).attr('href');
		var url = $(this).attr('url');
 		$.ajax({
 			url : url,
 			dataType : 'json',
 			success : function(response){
 					if(!response.success){
 						alert("error counting click");
 					}
 					window.location.href=href;
 				},
 				error : function(a,b,c){
 					window.location.href=href;		
 				}
 		});
 		
 		//

		return false;
	});
  //set focus to first input
  $("#home form:not(.filter) :input[type=text]:visible:enabled:first, #bd form:not(.filter) :input[type=text]:visible:enabled:first").focus();
});