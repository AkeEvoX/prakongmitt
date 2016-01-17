$(document).ready(function(){
		
		//load default page 
		loadcategoryPage($('#currentpage').val());

});


function loadcategoryPage(pageNo)
{
	
	var param = [];
	
	$.ajax({
	  url: 'controller/category_ctrl.php',
	  type: 'GET',
	  dataType: "json",
	  data: 'type=page&index='+pageNo,
	  success: function(data) {
		//called when successful
		
		var table = $('#cateList');
		
		table.html("");
		
		var header = "<thead><tr>";
		header += "<th >ID</th>";
		header += "<th>NAME</th>";
		header += "<th >Status</th>";
		header += "<th >ICON</th>";
		header += "<th class='col-md-2'><button class='btn btn-success pull-right' type='button' onclick='callInsert()' >ADD</button></th>";
		header += "</tr>";
		table.append(header)
	
		var newrow ;
		var row ;
			
		jQuery.each(JSON.parse(data.category),function(i,val){
			
				newrow =  $('#cateList tr:last');
				
				var status = 'InActive'; 
				
				if(val.active=="1")
					status = "Active"
				
				row = "<tr id='"+val.id+"' >";
				row += "<td id='index' class='col-md-2'>"+val.id+"</td>";
				row += "<td id='name' >"+val.name+"</td>";
				row += "<td id='active' class='col-md-2' >"+status+"</td>";
				row += "<td id='icon' class='col-md-2' ><img src='"+val.icon+"' class='img-circle' /> </td>";
				row += "<td class='col-md-2 text-right'>"; 
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
	
	//$('#modalcontent').load('dialogs/category.dialog.html?index='+d.getMilliseconds(),event);
	$('#modalcontent').load(url + '?random='+d.getMilliseconds(),event);
	
	$('#modaldialog').modal('show');
	
}


function callInsert()
{
	
		popup('เพิ่มข้อมูลประเภทสินค้า','dialogs/category.dialog.html',function(response,status,XMLHttpRequest){
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
		url:"controller/category_manage.php",
		type:'POST',
		data:JSON.stringify(dataSave),
		contentType: "application/json; charset=utf-8",
		dataType:"json",
		success : function(data){
			
			//alert(data.result);
			$('#modaldialog').modal('hide');
			loadcategoryPage(0);// customize split page
		},
		error:function(xhr, status, error){
			alert('Save Error. => ' + xhr.responseText);
			console.log(xhr.responseText);
		}
	});
	

}
	
function callupdate(obj){
	
	var data = $('#'+obj);
	
	popup('แก้ไขข้อมูลประเภทสินค้า','dialogs/category.dialog.html', function(response,status,XMLHttpRequest) {
		
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
		$('#inputLabel').html('ต้องการลบประเภทสินค้า > ' + name + ' ?');
	});
	
}
