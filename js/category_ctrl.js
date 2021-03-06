
function loadCategory()
{
	$.ajax({
	  url: 'controller/category_ctrl.php',
	  type: 'GET',
	  dataType: "json",
	  data:'type=load', 
	  success: function(data) {
		//called when successful
		
		var generateObject = "";
		
		
		jQuery.each(JSON.parse(data.category), function(i, val) {
				
				generateObject += "<button class='btn btn-primary' onclick=selectCate(this) cateid="+val.id+" cateName='"+val.name+"' ><img src='"+val.icon+"' /><br /><span class='text-center'>"+val.name +"</span></button>";
				
		});
		
		$('#listCategory').html(generateObject);
		
		
	  },
	  error: function(e) {
		//called when there is an error
		console.log(e.message);
	  }
	});
	
}

function loadCategoryRestaurant(source)
{
	//source = controller/category_ctrl.php
	$.ajax({
	  url: source+"/controller/category_ctrl.php",
	  type: 'GET',
	  dataType: "json",
	  data:'type=load', 
	  success: function(data) {
		//called when successful
		
		var generateObject = "";
		
		
		jQuery.each(JSON.parse(data.category), function(i, val) {
				
				generateObject += "<div class='col-sm-3' ><button class='btn btn-primary' onclick=selectCate(this) cateid="+val.id+" cateName='"+val.name+"' source='"+source+"' ><img src='"+val.icon+"' /><br /><span class='text-center'>"+val.name +"</span></button></div>";
				
		});
		
		$('#listCategory').html(generateObject);
		
	  },
	  error: function(jqXHR, exception) {
		//called when there is an error
		console.log("Call Category Error Code " + jqXHR.status + " Desc -> " +jqXHR.responseText);
	  }
	});
	
	
}

function selectCate(cate)
{
	
	try
	{
		/*
		var cateid  = $(cate).attr("cateid");
		var catename = $(cate).attr('catename');

		//load product group  -> product_ctrl.js
		selectProductGroup(cateid,catename);
		*/
		
		selectProductGroup(cate);
		
	}
	catch(e)
	{
		alert(e.description);
	}
	
}

function loadcategoryPage(pageNo)
{
	
	var param = [];
	
	$.ajax({
	  url: 'controller/category_data.php',
	  type: 'GET',
	  dataType: "json",
	  data: 'type=page&index='+pageNO,
	  success: function(data) {
		//called when successful
		
		console.log(data);
		
		
		/*
		var generateObject = "";
		
		
		jQuery.each(JSON.parse(data.category), function(i, val) {
				
				generateObject += "<button class='btn btn-primary iconCate' onclick=selectCate(this) cateid="+val.id+" cateName='"+val.name+"' ><span class='text-center'><img src='"+val.icon+"' />"+val.name +"</span></button>";
				
		});
		
		$('#listCategory').html(generateObject);
		
		
		*/
		
	  },
	  error: function(e) {
		//called when there is an error
		console.log(e.message);
	  }
	});
	
	
}




