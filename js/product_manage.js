$(document).ready(function(){
		
		//load default page 
		$('#currentPage').val(1);
		loadPage($('#currentPage').val());
});


$('#previousPage').click(function(){
	var page = parseInt($('#currentPage').val()) -1 ;
	
	if(page>0)
	{
		$('#currentPage').val(page);
		console.log(page);
		loadPage(page);
	}
	
});

$('#nextPage').click(function(){
	
	 var page = parseInt($('#currentPage').val()) + 1;
	 var max = $('#showPage').text().split('/')[1];
	 
	if(page<=max){
		$('#currentPage').val(page);
		loadPage(page);
	}
	
});


function loadPage(pageNo)
{
	
	var param = [];
	
	$.ajax({
	  url: 'controller/product_ctrl.php?rdm='+new Date().getTime()  ,
	  type: 'GET',
	  dataType: "json",
	  data: 'type=page&index='+pageNo,
	  success: function(data) {
		//called when successful

		//chack null value
		if(data.items=='null')
			return;
		
		$('#showPage').text(data.page);
		
		
		var table = $('#mgrList');
		
		table.html("");
		
		var header = "<thead><tr>";
		header += "<th >ID</th>";
		header += "<th>NAME</th>";
		header += "<th >Status</th>";
		header += "<th >ICON</th>";
		header += "<th class='col-md-2'><button class='btn btn-success pull-right' type='button' onclick='callInsert()'  id='btnAdd' ><span class='glyphicon glyphicon-plus' ></span>ADD</button></th>";
		header += "</tr>";
		table.append(header)
	
		var newrow ;
		var row ;
			
		jQuery.each(JSON.parse(data.items),function(i,val){
			
				newrow =  $('#mgrList tr:last');
				
				var status = 'InActive'; 

				console.log('active = '+ val.active);
				
				if(val.active=="1")
					status = "Active"
				
				row = "<tr id='"+val.id+"' >";
				row += "<td id='index' class='col-md-2'>"+val.id+"</td>";
				row += "<td id='name' class='col-md-3' >"+val.name+"</td>";
				row += "<td id='active' class='col-md-2' >"+status+"</td>";
				row += "<td id='icon' ><img src='"+val.icon+"'  width='80' class='img-circle' /></td>";
				row += "<td class='col-md-2 text-right'>&nbsp;"; 
				row += "<button class='btn btn-sm btn-warning' onclick='callupdate("+val.id+")'  >Update</button>";
				row += "<button class='btn btn-sm btn-danger' onclick='calldelete("+val.id+");' >Delete</button></td>";
				row += "</tr>";
				
				newrow.after(row);
			
		});
		
	  },
	  error: function(e) {
		
		//called when there is an error
		alert('Error : ' + e.message);
		console.log(e.message);
	  }
	});
	
}

function popup(title,url,event)
{

	$('#modaltitle').html(title);
	var d= new Date();

	$('#modalcontent').load(url + '?rdm='+d.getMilliseconds(),event);
	
	$('#modaldialog').modal('show');
	
}


function callInsert(){
	
	
		popup('เพิ่มราคาสินค้า','dialogs/product.dialog.html',function(response,status,XMLHttpRequest){
			$('#saveitem').val('insert');
	});
	
}

function callsave(){
	
	var dataSave = {};
	
	dataSave["type"] = $('#saveitem').val();
	dataSave["id"] = $('#inputindex').val();
	dataSave["name"] = $('#inputName').val();
	dataSave["icon"] = $('#inputIcon').val();
	dataSave["active"] = $('#inputActive').prop('checked');
	
		$.ajax({
		url:"controller/product_manage.php",
		type:'POST',
		data:JSON.stringify(dataSave),
		contentType: "application/json; charset=utf-8",
		dataType:"json",
		success : function(data){
			
			//alert(data.result);
			$('#modaldialog').modal('hide');
			loadPage($('#currentPage').val());// customize split page
		},
		error:function(xhr, status, error){
			alert('Save Error. => ' + xhr.responseText);
			console.log(xhr.responseText);
		}
	});
	

}
	
function callupdate(obj){
	
	var data = $('#'+obj);
	
	popup('แก้ไขข้อมูลสินค้า','dialogs/product.dialog.html', function(response,status,XMLHttpRequest) {
		
		$('#saveitem').val('update');
		$('#inputindex').val(data.find('#index').text());
		$('#inputName').val(data.find('#name').text());
		$('#inputIcon').val(data.find('#icon img').attr('src'));
		
		var status = false;
		
		if(data.find('#active').text().toLowerCase()=="active")
			status=true;
		
		$('#inputActive').prop('checked',status);

	});
	
}

function calldelete(obj){
	
	var data = $('#'+obj);
	var index = data.find('#index').text();
	var  name = data.find("#name").text();
	
	popup('Confirm Delete','dialogs/delete.dialog.html',function(response,status,XMLHttpRequest) {
		$('#saveitem').val('delete');
		$('#inputindex').val(index);
		$('#inputLabel').html('ต้องการลบกลุ่มสินค้า > ' + name + ' ?');
	});
	
}
