
$(document).ready(function(){
	resizepage();
	cleardata();
	//loadCategory();
	loadtablenumbers();
	loadCategoryRestaurant('pages/restaurant');
});

$(window).resize(function(){
	resizepage();
});
//calcuate on click 
$('#btnCalculate').click(function (){
	
	FncCalculate()
	
});

$('#btnSave').click(function(){
	//declare attrtibute
	var id = $('#orderid').val();
	var tablenum = $('#tablenum').val();
	
	var dataSave = {};
	var orderinfo = {};
	
	
	var discount =  $('#discountinp').val(); 
	var receive = $('#receiveinp').val();
	var change = $('#returninp').val();
	var net = $('#netinp').val();
	
	if(discount=="")
		discount=0;
	
	if(receive=="")
		receive=0;
	
	if(change=="")
		change=0;
	
	//initial order info for save
	dataSave["orderinfo"] = null;

	orderinfo["orderid"] = $('#orderid').val();
	orderinfo["tablenum"] = $('#tablenum').val();
	orderinfo["discount"] = discount;
	orderinfo["total"] = $('#totalinp').val();
	orderinfo["receive"] = receive;
	orderinfo["return"] = change;
	orderinfo["net"] = net;
	dataSave["orderinfo"] = orderinfo;
	
	dataSave["orderdetail"] = [];
	$('#orderitem li').each(function(idx,order){
		
		var proid = $(order).attr("id");
		var price = $(order).attr("price");
		var groupid = $(order).attr("groupid");
		var item = {};
		item["proid"] = proid;
		item["price"] = price;
		item["groupid"] = groupid;
		
		dataSave["orderdetail"].push(item);
		
	});
	
	console.log('save order => ' + JSON.stringify(dataSave));

	// save order
	$.ajax({
		url:"pages/restaurant/controller/ordersave_ctrl.php?rdm=" + new Date().getTime(),
		type:'POST',
		data:JSON.stringify(dataSave),
		contentType: "application/json; charset=utf-8",
		dataType:"json",
		success : function(data){
			
			alert(data.result);
			cleardata();
			loadtablenumbers();
			
		},
		error:function(xhr, status, error){
			console.log(xhr.responseText);
		}
	});
	
});

$('#btnPay').click(function(){

	console.log('click pay.');
	
	//validate data before save
	if(!validateorder())
	{
		return false;
	}
	
	//re-calculate
	if(!FncCalculate())
	{
		return false;
	}
	
	var dataSave = {};
	var orderinfo = {};
	
	var discount =  $('#discountinp').val(); 
	
	if(discount=="")
		discount=0;

	//console.log('orderid is ' + $('#orderid').val());
	//console.log('tablenum is ' + $('#tablenum').val());
	
	dataSave["orderinfo"] = null;
	orderinfo["orderid"] = $('#orderid').val();
	orderinfo["discount"] = discount;
	orderinfo["total"] = $('#totalinp').val();
	orderinfo["receive"] = $('#receiveinp').val();
	orderinfo["return"] = $('#returninp').val();
	orderinfo["tablenum"] = $('#tablenum').val();
	orderinfo["net"] = $('#netinp').val();
	dataSave["orderinfo"] = orderinfo;
	
	
	dataSave["orderdetail"] = [];
	$('#orderitem li').each(function(idx,order){
		
		var proid = $(order).attr("id");
		var price = $(order).attr("price");
		var groupid = $(order).attr("groupid");
		var item = {};
		item["proid"] = proid;
		item["price"] = price;
		item["groupid"] = groupid;
		
		dataSave["orderdetail"].push(item);
		
	});

	console.log(JSON.stringify(dataSave));
	
	$.ajax({
		url:"pages/restaurant/controller/order_ctrl.php?rdm=" + new Date().getTime(),
		type:'POST',
		data:JSON.stringify(dataSave),
		contentType: "application/json; charset=utf-8",
		dataType:"json",
		success : function(data){
			alert(data.result);
			cleardata();
			loadtablenumbers();
		},
		error:function(xhr, status, error){
			console.log(xhr.responseText);
		}
	});
	
});

$('#receiveinp').keyup(function(e){
	
	var code = (e.keyCode ? e.keyCode : e.which);
	
	this.value = this.value.replace(/[^0-9\.]/g,'');
	
	/*skip enter for reset change*/
	if(code!=13 && $('#returninp').val()!="")
	{
		$('#returninp').val("");
	}
	
});

//calculate with enter on receive input
$('#receiveinp').keypress(function(e){
	if(e.which==13)
	{
		/*first enter for calcuate*/
		if($('#returninp').val()==""){
			FncCalculate();
		}
		else{ /*second enter for save*/
			$('#btnPay').click();
		}
	}
	
});

$('#btnCancel').click(function(e){
	if(confirm('ยกเลิกรายการ ? ')){
		cleardata();
	}
});

$('#discountinp').keyup(function(e){
	
	var code = (e.keyCode ? e.keyCode : e.which);
	
	this.value = this.value.replace(/[^0-9\.]/g,'');
	
});

$('#discountinp').keypress(function(e){
	
	if(e.which==13)
	{
		netcalculate();
	}
	
});

function loadtablenumbers() {

	//loading data

	
	$.ajax({
		url:'pages/restaurant/controller/restaurant_data.php?rdm='+ new Date().getTime(),
		data:'type=tables',
		datatype:'json',
		type:'GET',
		contentType: "application/json; charset=utf-8",
		success: function(data){
			//listTablenumber
			
			var table = $('#listTablenumber');
			table.html("");
			var generateObject = "";
			
			if(data.items=='null'){
					generateObject = "cannot load data.";
			}
			
			jQuery.each(JSON.parse(data.items),function(i,val){	
			
				var status = 'success';
				
				if(val.status=='1') //not availible
					status = "danger";
			
				//generateObject+= "<button class='btn btn-"+status+" col-md-6'  onclick='showorder("+val.order+","+val.number+")'  ><img src='images/icons/restaurant_icon_32.png' /><br/><b>"+val.number+"</b></button>";
				table.append("<button class='btn btn-"+status+" col-md-6'  onclick='showorder("+val.order+","+val.number+")'  ><img src='images/icons/restaurant_icon_32.png' /><br/><b>"+val.number+"</b></button>");
			});
			
			//table.html(generateObject);
			
		},
		error : function(xhr,status,error) {
			alert("load restaurant table error : "+error.message);
		} 
		
	});
	
}

function showorder(id,tablenum)
{
		console.log("orderid = " + id);

		$('#orderid').val(id);
		$('#tablenum').val(tablenum);

	$.ajax({
		url:'pages/restaurant/controller/restaurant_data.php?rdm=' + new Date().getTime(),
		data:'type=order&id='+id,
		dataType:'json',
		contentType: "application/json; charset=utf-8",
		success:function(data){
			
		console.log(data.items);
		
		$('#totalinp').val(0);
		$('#netinp').val(0);
		$('#orderitem').empty();
		if(data.items=="null") 
		{
			$('#orderitem').html('<li class="list-group-item list-group-item-warning">กรุณาเลือกสินค้า</li>');
			return;
		}
		
		
		//var totalitem = 0 ;
		//var total = 0 ;
		jQuery.each(JSON.parse(data.items),function(i,val){	
		
			$('#orderitem').append('<li class="list-group-item list-group-item-info" id="'
				+val.prod+'" price="'
				+val.price+'" groupid="'
				+val.prodgroup+'" >'
				+val.groupname+' > '
				+val.prodname+' ('+val.price+')<button type="button" class="close" onclick=delProduct(this) proid="'+val.prod+'" price="'+val.price+'"  ><span >&times;</span></button></li>').fadeIn('slow');
				
				//totalitem++;
				//total = parseInt(total) + parseInt(val.price);	
		});

		console.log(data.info);
		
		if(data.info!="null")
		{
			var info = JSON.parse(data.info);
			$('#totalinp').val(info.total);
			$('#discountinp').val(info.discount);
			$('#netinp').val(info.net);
			$('#returninp').val(info.change);
			$('#reciveinp').val(info.receive);
				
		}
	
		
			
		},
		error:function(xhr,status,error){
			alert(error);
		}
		
	});
	
}

function validateorder()
{
	var result = true;
	var errMsg = "";
	
	//validate custid
	/*if($('#inputCust').data("custid")=="")
	{
		errMsg += "- กรุณาเลือกข้อมูลลูกค่า\n";
	}*/
	//valide total
	if($('#totalinp').val()=="")
	{
		errMsg += "- กรุณาเลือกรายการสินค้า\n";
	}
	//validate receive
	if($('#receiveinp').val()=="")
	{
		errMsg += "- กรุณากรอกช่องรับเงิน\n";
	}
	//valide return
	if($('#returninp').val()=="")
	{
		errMsg += "- กรุณาคลิกคำนวน\n";
	}
	
	
	if(errMsg!="")
	{
		alert(errMsg);
		result = false;
	}

	return result;
}

function netcalculate()
{
	var total = parseInt($('#totalinp').val());
	var discount = parseInt($('#discountinp').val());
	var net = $('#netinp');
	net.val(total - discount);
}

function FncCalculate()
{
	//var total = parseInt($('#totalinp').val());
	//var discount = parseInt($('#discountinp').val());
	var net  = parseInt($('#netinp').val());
	var receive = parseInt($('#receiveinp').val());
	var returnMoney = parseInt($('#returninp').val());
	
	if(receive < net)
	{
		alert('- ช่องรับเงินต้องมากกว่า ช่องรวมเงิน.');
		return false;
	}
	
	returnMoney = receive - net;
	$('#returninp').val(returnMoney);
	
	return true;
}

function cleardata()
{
		//clear navigate
		$('#naviitem').html("<li><a href='#'>กรุณาเลือกเมนู</a></li>");
		//clear customer
		//$('#inputCust').val('');
		//$('#inputCust').data("custid","");
		//clear product
		$('#listProduct').empty();
		
		
		//clear order
		$('#orderitem').html('<li class="list-group-item list-group-item-warning">กรุณาเลือกสินค้า</li>');
		//$('#orderitem').empty();
		//clear calcuate
		$('#totalinp').val(0);
		$('#discountinp').val(0);
		$('#netinp').val(0);
		$('#receiveinp').val('');
		$('#returninp').val(0);
}

function resizepage()
{	


	var height = $(window).height();
	var width = $(window).width();
	var hCate = 0;
	var hProd = 0;
	
	if(width < 950)
	{
			height = 300;
	}
	else
	{
		height = height  - (height  * 0.08 );
	}
	console.log('window height is ' + height  + ' width is ' + width);
	
	$('#tabCate').height(height);
	$('#tabProd').height(height);
	$('#tabCate .scrollitem').height(height-50);
	if(height > 300)
	{	
		$('#tabCalc').height(height); 
	}
	
}
