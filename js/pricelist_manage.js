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
	  url: 'controller/pricelist_ctrl.php?rdm='+new Date().getTime()  ,
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
		header += "<th>Category</th>";
		header += "<th>Product Group</th>";
		header += "<th>Product</th>";
		header += "<th >Price</th>";
		header += "<th class='col-md-2'><button class='btn btn-success pull-right' type='button' onclick='callInsert()'  id='btnAdd' ><span class='glyphicon glyphicon-plus' ></span>ADD</button></th>";
		header += "</tr>";
		table.append(header);
	
		var newrow ;
		var row ;
			
		jQuery.each(JSON.parse(data.items),function(i,val){
			
				newrow =  $('#mgrList tr:last');
				
				row = "<tr id='"+val.id+"' >";
				row += "<td id='index' class='col-md-2'>"+val.id+"</td>";
				row += "<td id='category' data-id='"+val.cateid+"' class='col-md-2' >"+val.category+"</td>";
				row += "<td id='group' data-id='"+val.groupid+"' class='col-md-2' >"+val.group+"</td>";
				row += "<td id='product' data-id='"+val.prodid+"' >"+val.product+"</td>";
				row += "<td id='price' >"+val.price+"</td>";
				row += "<td class='col-md-3 text-right'>&nbsp;"; 
				row += "<button class='btn btn-sm btn-warning' onclick='callupdate("+val.id+")'  ><span class='glyphicon glyphicon-list-alt' ></span>Update</button>";
				row += "<button class='btn btn-sm btn-danger' onclick='calldelete("+val.id+");' ><span class='glyphicon glyphicon-trash' ></span>Delete</button></td>";
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

function loadCate(id)
{
	var select = $('#cateselect');
	select.html('');  // clear item
	
	$.ajax({
		url:"controller/category_ctrl.php?type=load&rdm=" + new Date().getTime() ,
		type:'GET',
		contentType: "application/json; charset=utf-8",
		dataType:"json",
		success : function(data){
					
			jQuery.each(JSON.parse(data.category),function(i,val){
				var active = "";
				if(id==val.id)
				{
					active = "selected";
				}
		
				select.append("<option value='"+val.id+"' "+active+">"+val.name+"</option>");
				
			});
			
		},
		error:function(xhr, status, error){
			alert('Load category error => ' + xhr.responseText);
			console.log(xhr.responseText);
		}
		
	});
}

function loadGroup(id)
{
	var select = $('#groupselect');

	select.html('');  // clear item
	
	$.ajax({
		url:"controller/productgroup_ctrl.php?type=list&rdm=" + new Date().getTime() ,
		type:'GET',
		contentType: "application/json; charset=utf-8",
		dataType:"json",
		success : function(data){
					
			jQuery.each(JSON.parse(data.items),function(i,val){
				var active = "";
				if(id==val.id)
				{
					active = "selected";
				}
		
				select.append("<option value='"+val.id+"' "+active+">"+val.name+"</option>");
				
			});
			
		},
		error:function(xhr, status, error){
			alert('Load product group error => ' + xhr.responseText);
			console.log(xhr.responseText);
		}
		
	});
}

function loadProduct(id)
{
	
	var select = $('#productselect');

	select.html('');  // clear item
	
	$.ajax({
		url:"controller/product_ctrl.php?type=list&rdm=" + new Date().getTime() ,
		type:'GET',
		contentType: "application/json; charset=utf-8",
		dataType:"json",
		success : function(data){
					
			jQuery.each(JSON.parse(data.items),function(i,val){
				var active = "";
				if(id==val.id)
				{
					active = "selected";
				}
		
				select.append("<option value='"+val.id+"' "+active+">"+val.name+"</option>");
				
			});
			
		},
		error:function(xhr, status, error){
			alert('Load product group error => ' + xhr.responseText);
			console.log(xhr.responseText);
		}
		
	});
	
}

function popup(title,url,event)
{

	$('#modaltitle').html(title);
	
	$('#modalcontent').load(url + '?rdm='+new Date().getTime(),event);
	
	$('#modaldialog').modal('show');
	
}

function callInsert()
{
	
	popup('เพิ่มราคาสินค้า','dialogs/pricelist.dialog.html',function(response,status,XMLHttpRequest){
			$('#saveitem').val('insert');
			loadCate();
			loadGroup();
			loadProduct();
	});

}

function callsave(){
	
	var dataSave = {};
	
	dataSave["type"] = $('#saveitem').val();
	dataSave["id"] = $('#inputindex').val();
	dataSave["category"] = $('#cateselect').val();
	dataSave["group"] = $('#groupselect').val();
	dataSave["product"] = $('#productselect').val();
	dataSave["price"] = $('#pricebox').val();
	
	
		$.ajax({
		url:"controller/pricelist_manage.php",
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
	
	popup('แก้ไขราคาสินค้า','dialogs/pricelist.dialog.html', function(response,status,XMLHttpRequest) {
		
		$('#saveitem').val('update');
		$('#inputindex').val(data.find('#index').text());
		loadCate(data.find('#category').attr('data-id'));
		loadGroup(data.find('#group').attr('data-id'));
		loadProduct(data.find('#product').attr('data-id'));
		$('#pricebox').val(data.find('#price').text());
		
	});
	
}

function calldelete(obj){
	
	var data = $('#'+obj);
	var index = data.find('#index').text();
	var  name = data.find("#product").text();
	
	popup('Confirm Delete','dialogs/delete.dialog.html',function(response,status,XMLHttpRequest) {
		$('#saveitem').val('delete');
		$('#inputindex').val(index);
		$('#inputLabel').html('ต้องการลบกลุ่มสินค้า > ' + name + ' ?');
	});
	
}

