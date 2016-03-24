$('#mainmenu').click(function(){
	
	//set size menu dialog
	$('#modaldialog').find(".modal-dialog").removeClass("modal-lg");
	
	loadcontentdialog("เมนูหลัก","dialogs/mainmenu.html?rnd="+ new Date().getTime());
	
	loadmenu();
	/*
	$.getScript("js/mainmenu.js",function(){
			loadmenu();
	});
	*/
});

$('#reportmenu').click(function(){
	
	loadcontentdialog("รายงาน","dialogs/reportmenu.html?rnd="+ new Date().getTime());
	
});

function loadcontentdialog(title,page)
{
	
	$('#modaltitle').html(title);
	$('#modalcontent').load(page);
	$('#modaldialog').modal('show');
	
}


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
