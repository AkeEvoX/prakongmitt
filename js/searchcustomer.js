

//show dialog search customer
$('#btnDiagSearchCust').click(function(){
	
	$('#modaltitle').html('ค้นหาข้อมูลลูกค้า');
	
	$('#modalcontent').load('dialogs/searchcustomer.html');
	
	$('#modaldialog').modal('show');
	
});

function SearchCustomer()
{
	
	
	var fillterstring = $('#inputFind').val();
	
	$.ajax({
		
		url:'controller/searchcustomer.php',
		type:'GET',
		contentType:'application/json; charset=utf8',
		dataType:'json',
		data: 'fillter='+fillterstring, 
		success:function(data){
			
			console.log("response result : "+data);
			var generateObject ="";
				
			if(data.result!="null"){
				
				jQuery.each(JSON.parse(data.result),function(i,item){
					
					generateObject += "<button type='button' onclick='SelectCustomer(this);' custid='"+item.id+"' custname='"+item.name+"' mobile='"+item.mobile+"' class='list-group-item list-group-item-info' >"+item.name+" ("+item.mobile+")</button>";
				
				});
				
			}
			else{
				 generateObject = '<a href="#" class="list-group-item list-group-item-danger">ไม่พบข้อมูล</a>';
			}

			$('#customerlist').html(generateObject);
			
		},
		error:function(xhr,status,error){
			console.log(xhr.responseText);
		}
		
	});
	
}

function SelectCustomer(item)
{
	
	var custid = $(item).attr("custid");
	var custname = $(item).attr("custname");
	
	$('#inputCust').data("custid",custid);
	$('#inputCust').val(custname);
	$('#modaldialog').modal('hide');
	
}

function cancelSearch()
{
	$('#inputCust').data("custid","");
	$('#inputCust').val("");
	$('#modaldialog').modal('hide');
}


$(document).on("click","#btnSearchCust",function(e){
	
	SearchCustomer();
	
});

$(document).on("keypress","#inputFind",function(e){
	
	if(e.which==13)
	{
		SearchCustomer();
	}
});


	