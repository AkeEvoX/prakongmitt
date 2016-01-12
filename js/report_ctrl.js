
$(document).ready(function(){

	 setupDateTime();
	 loadCate();
	 loadGroup();
	 loadProduct();
	 $('#reportoption').css('display','none');
});

$('input[type=radio][name=reporttype]').on('change',function (){
		
		switch($(this).val())
		{
			case 'detail' : 
					$('#reportoption').css('display','inline');
				break;
			
			default : 
					$('#reportoption').css('display','none');
				break;
		}
});

function loadCate()
{
	var select = $('#categorys');
	
	select.html("<option value='' >- - select all- -</option>");  // clear item
	
	$.ajax({
		url:"controller/category_ctrl.php?type=load&rdm=" + new Date().getTime() ,
		type:'GET',
		contentType: "application/json; charset=utf-8",
		dataType:"json",
		success : function(data){
					
			jQuery.each(JSON.parse(data.category),function(i,val){
				
				select.append("<option value='"+val.id+"' >"+val.name+"</option>");
				
			});
			
		},
		error:function(xhr, status, error){
			alert('Load category error => ' + xhr.responseText);
			console.log(xhr.responseText);
		}
		
	});
}


function loadGroup()
{
	var select = $('#groups');

	select.html("<option value='' >- - select all- -</option>");  // clear item
	
	$.ajax({
		url:"controller/productgroup_ctrl.php?type=list&rdm=" + new Date().getTime() ,
		type:'GET',
		contentType: "application/json; charset=utf-8",
		dataType:"json",
		success : function(data){
					
			jQuery.each(JSON.parse(data.items),function(i,val){
				
				select.append("<option value='"+val.id+"' >"+val.name+"</option>");
				
			});
			
		},
		error:function(xhr, status, error){
			alert('Load product group error => ' + xhr.responseText);
			console.log(xhr.responseText);
		}
		
	});
}


function loadProduct()
{
	
	var select = $('#products');

	select.html("<option value='' >- - select all- -</option>");  // clear item
	
	$.ajax({
		url:"controller/product_ctrl.php?type=list&rdm=" + new Date().getTime() ,
		type:'GET',
		contentType: "application/json; charset=utf-8",
		dataType:"json",
		success : function(data){
					
			jQuery.each(JSON.parse(data.items),function(i,val){
				
				select.append("<option value='"+val.id+"' >"+val.name+"</option>");
				
			});
			
		},
		error:function(xhr, status, error){
			alert('Load product group error => ' + xhr.responseText);
			console.log(xhr.responseText);
		}
		
	});
	
}

function setupDateTime(){
	
	var start = $('#startDate');
	var end = $('#endDate');
	
	var  datesetup = {
			locale:'en',
		format:'DD/MM/YYYY'
	};
	
	
	start.datetimepicker(datesetup);
	end.datetimepicker(datesetup);
	
	//setup end date over start date
	start.on('dp.change',function(e){
		end.data('DateTimePicker').minDate(e.date);
		$(this).data('DateTimePicker').hide();
	});
	
	$('#endDate').on('dp.change',function(e){
		start.data('DateTimePicker').maxDate(e.date);
		$(this).data('DateTimePicker').hide();
	});
	
}

function popup(title,url,event)
{
	 //modal-lg
	
	$('#modaldialog').find(".modal-dialog").addClass("modal-lg");

	$('#modaltitle').html(title);
	
	var d= new Date();

	$('#modalcontent').load(url + '?rdm='+d.getMilliseconds(),event);
	
	$('#modaldialog').modal('show');
	
}


$('#btnSearch').click(function(){
	
	var type = $('input[type=radio][name=reporttype]:checked');
	var categorys = $('#categorys');
	var groups = $('#groups');
	var products = $('#products');
	
	switch(type.val())
	{
		case 'summary' :
				callSummeryReport();
			break;
		default : 
				callDetailReport(start.val(),end.val(),categorys.val(),groups.val(),products.val());
			break; 
			
	}
	
});

function callSummeryReport()
{
	
	//pop report
	popup("Report Summery","dialogs/report.summery.html",function(response,status,XMLHttpRequest){
			$('#currentPage').val(1);
			loadsummary($('#currentPage').val());//load default page

	});
	
}

function callDetailReport(start,end,category,group,product)
{
	//pop report 
	popup("Report Detail","dialogs/report.detail.html",function(response,status,XMLHttpRequest){
		var page = 1;
		$('#currentPage').val(page);
		loaddetail(page);
	})
}

function  previouspage()
{
	var page = parseInt($('#currentPage').val()) -1 ;
			
	if(page>0)
	{
		controlpage(page);
	}	

}

function nextpage()
{
	
	var page = parseInt($('#currentPage').val()) + 1;
	var max = $('#showPage').text().split('/')[1];	

	if(page<=max){
		controlpage(page);
	}

}

function controlpage(page)
{
	var type = $('input[type=radio][name=reporttype]:checked');

	switch(type.val())
		{
			case 'summary':

					$('#currentPage').val(page);
					loadsummary(page);

				break;
			default : 

				break;
		}
}

function loadsummary(pageNo)
{
	var list = $('#mgrList');
	list.html("");
	var start = $('#startInp');
	var end = $('#endInp');


	$.ajax({
		url:'controller/report_ctrl.php?rdm='+new Date().getTime(),
		type:'GET',
		dataType:'json',
		data:'type=summary&index='+pageNo+'&start='+start.val()+"&end="+end.val(),
		contentType: "application/json; charset=utf-8",
		success: function(data){


			var header = "<thead><tr>";
			header += "<th >Date</th>";
			header += "<th >Receive</th>";
			header += "<th >Return</th>";
			header += "<th >Total</th>";
			header += "</tr>";

			list.append(header);

			if(data.items=='null'){
				list.append("<tr><td>Data Not Round.</td></tr>");
				return;
			}

			$('#showPage').text(data.page);


			jQuery.each(JSON.parse(data.items),function(i,val){	
				var row = "<tr>";
				row += "<td class='col-md-3' >"+ val.date +"</td>";
				row += "<td class='col-md-3' >"+ val.receive +"</td>";
				row += "<td class='col-md-3' >"+ val.change +"</td>";
				row += "<td class='col-md-3' >"+ val.total +"</td>";
				row += "</tr>";


				list.append(row);
			});

		},
		error:function(xhr,status,error){
			console.log("call loadsummary error => " + xhr.responseText);
		}
	});
	
}

function loaddetail(pageNo){
	var list = $('#mgrList');
	list.html("");
	var start = $('#startInp');
	var end = $('#endInp');
	var categorys = $('#categorys');
	var groups = $('#groups');
	var products = $('#products');
	
	$.ajax({
		url:'',
		dataType:'json',
		data:'',
		contentType:'',
		success:function(data){
			
		},
		error:function(xhr,status,error){
			console.log("call loaddetail error =>" + xhr.responseText);
		}
	});
}
