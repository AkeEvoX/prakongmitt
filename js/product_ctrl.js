
function selectProductGroup(cateid,catename)
{
		try{

			$('#listProduct').empty();
			$('#naviitem').empty();
			$('#naviitem').html('<li><a href="#"  onclick=selectProductGroup('+cateid+',"'+catename+'")    >'+catename+'</a></li>');
			//url:'controller/productgroup_ctrl.php?rdm='+new Date().getTime(),
			$.ajax(
			{
				url:'controller/pricelist_ctrl.php?rdm='+new Date().getTime(), 
				type:'GET',
				data:'type=groups&category='+cateid,
				dataType:'json',
				success:function(result){
					
					var generateObject = "";
					var icon = "";
					
					/*
					icon = "<a href='#' onclick=showProductList(this) cateid='"+cateid+"' groupid="+val.id+" groupname='"+val.name+"' >";
						icon += "<div class='col-md-3 iconProd' >";
						icon += "<img src='"+val.icon+"' class='img-responsive'  style='width:100px;'  /><br />";
						icon += val.name;
						icon += "</div></a>";
					*/
					
					if(result.items!="null")
					{
						jQuery.each(JSON.parse(result.items),function(i,val){
							
							icon = "<a href='#' onclick=showProductList(this) cateid='"+cateid+"' groupid="+val.id+" groupname='"+val.name+"' >";
							icon += "<div class='col-md-3 iconProd' >";
							icon += "<img src='"+val.icon+"' class='img-responsive'  style='width:100px;'  /><br />";
							icon += val.name;
							icon += "</div></a>";
							
							generateObject += icon;
						});
					}

					
					$('#listProduct').html(generateObject);

				},
				error:function(xhr, status, error)
				{
					console.log(xhr.responseText);
				}
			});
			
		}
		catch(e)
		{
			console.log(e.description);
		}
}

function selectProductGroup(cate)
{
		try{
			var cateid  = $(cate).attr("cateid");
			var catename = $(cate).attr('catename');
			var source= $(cate).attr('source');
			
			console.log('selectProductGroup src=' + source);
			
			$('#listProduct').empty();
			$('#naviitem').empty();
			$('#naviitem').html('<li><a href="#"  onclick=selectProductGroup('+cate+')   >'+catename+'</a></li>');
			//url:'controller/productgroup_ctrl.php?rdm='+new Date().getTime(),
			$.ajax(
			{
				url:source+'/controller/pricelist_ctrl.php?rdm='+new Date().getTime(), 
				type:'GET',
				data:'type=groups&category='+cateid,
				dataType:'json',
				success:function(result){
					
					var generateObject = "";
					var icon = "";
					
					/*
					icon = "<a href='#' onclick=showProductList(this) cateid='"+cateid+"' groupid="+val.id+" groupname='"+val.name+"' >";
						icon += "<div class='col-md-3 iconProd' >";
						icon += "<img src='"+val.icon+"' class='img-responsive'  style='width:100px;'  /><br />";
						icon += val.name;
						icon += "</div></a>";
					*/
					
					if(result.items!="null")
					{
						jQuery.each(JSON.parse(result.items),function(i,val){
							
							icon = "<a href='#' onclick=showProductList(this) cateid='"+cateid+"' groupid="+val.id+" groupname='"+val.name+"' source='"+source+"' >";
							icon += "<div class='col-md-3 iconProd' >";
							icon += "<img src='"+val.icon+"' class='img-responsive'  style='width:100px;'  /><br />";
							icon += val.name;
							icon += "</div></a>";
							
							generateObject += icon;
						});
					}

					
					$('#listProduct').html(generateObject);

				},
				error:function(xhr, status, error)
				{
					console.log(xhr.responseText);
				}
			});
			
		}
		catch(e)
		{
			console.log(e.description);
		}
}

function showProductList(group)
{
		var cateid = $(group).attr('cateid');
		var groupid = $(group).attr('groupid');				
		var groupname = $(group).attr('groupname');
		var source = $(group).attr('source');
		var currentNavi = $("#naviitem li").eq(0).html();
		
		console.log('showProductList src=' + source);
		
		$('#naviitem').empty();
		$('#naviitem').html("<li>"+currentNavi+ '</li><li>'+groupname+'</li>');

		$.ajax({
			url:source + '/controller/pricelist_ctrl.php?rdm='+new Date().getTime(),
			type:'GET',
			data:'type=products&category='+cateid+'&group='+groupid,
			dataType:"json",
			success:function(result){
				
				var generateObject  = "";
				var itemProd = "";
				jQuery.each(JSON.parse(result.items),function(i,val){

					itemProd =" <a href='#'  onclick=selectProduct(this) proid='"+val.id+"' name='"+val.name+"' price='"+val.price+"'  groupid='"+groupid+"' groupname='"+groupname+"'>";
					itemProd += "<div class='col-md-3 iconProd' >"; 
					itemProd += "<img src='" +val.icon+"' class='img-responsive' style='width:128px;' /><br/>"; /*  icon */
					itemProd +=  val.name+" <br />("+val.price+") "; /*text*/
					itemProd +="</div></a>";
					
					generateObject += itemProd;
				});
			
			  $('#listProduct').html(generateObject);
			},
			error:function(xhr, status, error){
				console.log(xhr.responseText);
			}
			
		});
		
}

function selectProduct(pro)
{
	try
	{
		
		var proid=$(pro).attr("proid");
		var name = $(pro).attr("name");
		var price = $(pro).attr("price");
		var groupid = $(pro).attr("groupid");
		var groupname = $(pro).attr("groupname");
		var proName = pro.name;
		
		
		var total = $('#totalinp').val();

		if(total=="" || total=="0")
		{
			total = 0;
			$('#orderitem').empty();
		}

		
		$('#orderitem').append('<li class="list-group-item list-group-item-info" id="'+proid+'" price="'+price+'" groupid="'+groupid+'" >'+groupname+' > '+name+' ('+price+')<button type="button" class="close" onclick=delProduct(this) proid="'+proid+'" price="'+price+'"  ><span >&times;</span></button></li>').fadeIn('slow');

		total= parseInt(total) + parseInt(price);
		$('#totalinp').val(total);
		$('#netinp').val(total);
		
		//auto scroll bottom
		var orderscroll = $('#orderlist');
		orderscroll.scrollTop(orderscroll.prop('scrollHeight'));
		
	}
	catch(e)
	{
		console.log(e.description);
	}

}

function delProduct(pro)
{
	
	var proid = $(pro).attr("proid");
	var price = $(pro).attr("price");
	var total = $('#totalinp').val();
	var discount = $('#discountinp');
	var net = $('#netinp');

	total = parseInt(total) - parseInt(price);
	
	if(net.val()!="")
	{
		net.val(total);
	}
	
	if(total=="0")
	{
		$('#orderitem').html('<li class="list-group-item list-group-item-warning">กรุณาเลือกสินค้า</li>');
	}
	
	//remote item 
	$('#'+proid).remove();

	$('#totalinp').val(total);
}
