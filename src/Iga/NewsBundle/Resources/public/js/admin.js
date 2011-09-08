$(function(){
	$(".addsubcategory").live('click',function(){
		var form = $(this).parent().html();
		$(this).fadeOut('fast',function(){
			
			$(this).parent().find('div').fadeIn('fast',function(){
				$(this).find("input[type=text]").focus();
			});

			var container =  $(this).parent();
			$(this).parent().find('div').find("a").click(function(){
				var href = $(this).attr('url');
				var data = $(this).parent().parent().find('form').serialize();	
				$.ajax({
					url : href,
					type : "POST",
					data : container.find('form').serialize(),
					dataType : 'json',
					success : function(r){
						if(r.success){
							container.html(r.title);
							container.parent().append("<li class='insert'>"+form+"</li>");
						}else{
							alert("La categoria no se pudo insertar: \n" + r);
						}
					}
				});

				return false;
			});
			
		});
		
	});
	
	 $('button.scan').click(function(){
 	
 	var sid = $(this).attr('source');
 	var href = $(this).attr('href');
 	$.ajax({
 		url : href,
 		dataType : 'json',
 		success : function(response){
 			//alert(response);
 			$('#source_'+sid).find('p.count').html(response.count);
 			$('#source_'+sid).find('p.crawled').html(response.crawled.date);
 			if(response.new > 0){
 			alert("added "+response.new+" new items");
 			}else{
 				alert("no items added");
 			}
 		}
 	});
 		
 	
 });
 
 $('#crawlAll').click(function(){
 	var totalSources = 0;
 	var doneSources = 0;
 	$('button.scan').each(function(){
 		totalSources++;
 		 	var sid = $(this).attr('source');
 	var href = $(this).attr('href');
 	$.ajax({
 		url : href,
 		dataType : 'json',
 		success : function(response){
 			doneSources = $('#allsources').find('p.crawled').html();
			$('#allsources').find('p.crawled').html(parseInt(doneSources)+1);

 			//alert(response);
 			$('#source_'+sid).find('p.count').html(response.count);
 			$('#source_'+sid).find('p.crawled').html(response.crawled.date);
 			if(response.new > 0){
 			//alert("added "+response.new+" new items");
 			}else{
 				//alert("no items added");
 			}
 		}, error: function (a,b,c) {
 			alert("There was an error " + a + " " + b + " " + c)
 		}
 	});

 	});
	$('#allsources').find('p.count').html(totalSources);
 });
	
	$(".categoriesdelete").click(function(){
				var container = $(this).parent();
				var href = $(this).attr('href');	
				var cid = $(this).attr('eid');
				$.ajax({
					url : href,
					type : 'POST',
					data : cid,
					dataType : 'json',
					success : function(r){
						if(r.success){
							container.remove();
						}else{
							alert("La categoria no se pudo insertar: \n" + r);
						}
					}
				});		
		return false;
	});
})