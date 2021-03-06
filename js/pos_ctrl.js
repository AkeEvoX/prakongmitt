

$(document).ready(function(){
	resizepage();
	cleardata();
	loadCategory();
});

$(window).resize(function(){
	resizepage();
});
//calcuate on click 
$('#btnCalculate').click(function (){
	
	FncCalculate()
	
});

$('#btnSave').click(function(){
	
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

	var custid = $('#inputCust').data("custid");
	
	if(custid=="")
		custid=0;
	
	var discount =  $('#discountinp').val(); 
	
	if(discount=="")
		discount=0;
	
	dataSave["orderinfo"] = null;
	orderinfo["custid"] = custid;

	//orderinfo["custid"] = $('#inputCust').data("custid");
	orderinfo["discount"] = discount;
	
	orderinfo["total"] = $('#totalinp').val();
	orderinfo["receive"] = $('#receiveinp').val();
	orderinfo["return"] = $('#returninp').val();
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

	//console.log(JSON.stringify(dataSave));
	
	$.ajax({
		url:"controller/order_ctrl.php",
		type:'POST',
		data:JSON.stringify(dataSave),
		contentType: "application/json; charset=utf-8",
		dataType:"json",
		success : function(data){
			
			alert(data.result);
			cleardata();
			
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
			$('#btnSave').click();
		}
	}
	
});

$('#btnCancel').click(function(e){
	if(confirm('ยกเลิกรายการ ? ')){
		cleardata();
	}
});

$('#discountinp').keypress(function(e){
	
	if(e.which==13)
	{
		netcalculate();
	}
	
});

function validateorder()
{
	var result = true;
	var errMsg = "";

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
	
	//net
	
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
	if(height > 300)
	{	
		$('#tabCalc').height(height); 
	}
	
}
