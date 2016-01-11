
function loadmenu()
{
	console.log('menu list.');
	$.ajax({
		url:'controller/menus.php?rdm='+ new Date().getTime(),
		type:'GET',
		dataType:'JSON',
		contentType: "application/json; charset=utf-8",
		success:function(data){
			
				var menu = $('#menulist');
				
						
				jQuery.each(JSON.parse(data.result),function(i,val){
						
						menu.append("<a href='"+val.url+"' alt='"+val.desc+"'  ><div class='col-sm-3 iconMenu' ><img src='"+val.icon+"' class='img-responsive' style='width:68px;height:68px;'  /><br /><small >"+val.name+"</small></div></a>");
					
				});
				
		},
		error:function(xhr,status,error){
				alert(xhr.responseText);
		}
	});
	
}

