
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
				
				generateObject += "<button class='btn btn-primary iconCate' onclick=selectCate(this) cateid="+val.id+" cateName='"+val.name+"' ><span class='text-center'><img src='"+val.icon+"' />"+val.name +"</span></button>";
				
		});
		
		$('#listCategory').html(generateObject);
		
		
	  },
	  error: function(e) {
		//called when there is an error
		console.log(e.message);
	  }
	});
	
	
}

function selectCate(cate)
{
	
	try
	{
		var cateid  = $(cate).attr("cateid");
		var catename = $(cate).attr('catename');

		//load product group  -> product_ctrl.js
		selectProductGroup(cateid,catename);
		
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




