<? 
session_start();


if(!isset($_SESSION["profile"]))
{
	echo "<script>alert('please login !!');window.location='login.php';</script>";
	
}
/* hello world's */

?>
<!DOCTYPE html>
<html lang='en'>
<head>
	<title>Prakongmitt</title>
	<meta charset='utf-8'>
	<meta http-equiv='X-UA-Compatible' content='IE=edge'>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<link rel='stylesheet' href='css/bootstrap.min.css' >
	<link rel='stylesheet' href='css/prakongmitt.css' >
	<link rel='stylesheet' href='css/pos.css' >
	<link rel='stylesheet' href='css/pos_mobile.css' >
</head>
<body>
	<!-- navigator bar -->
    <!-- div class="container" -->
      <!-- Static navbar -->
      <nav class="navbar navbar-default"  style="margin-bottom:0px;" >
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Prakongmitt</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
		  <!--show menu -->
            <ul id="menunav" class="nav navbar-nav">
				<li class="active"><a href="#" id="mainmenu">MENU</a></li>
            </ul>
			
            <ul class="nav navbar-nav navbar-right">
			  <li><a href="#"><span class="glyphicon glyphicon-user" ></span> <? echo $_SESSION["profile"]["fullname"]; ?></a></li>
              <li><a href="login.php"><span class="glyphicon glyphicon-off" ></span> Log out</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>
      <!-- Main component for a primary marketing message or call to action -->
      <div class="container-fluid" style="height:100%">
        <div class='row'>
            <div class='col-md-2 nopadding'>
                <div class="panel panel-success"  id="tabCate" >
                <div class="panel-heading" ><span class="iconTitle" > <img src="images/icons/Folder-32.png" class="img-responsive" />ประเภทสินค้า</span></div>
                <div class="panel-body scrollitem" id="listCategory" >
					
                </div>
              </div>
            </div>
            <div class='col-md-5 nopadding'>
               <div class="panel panel-info" id="tabProd">
                <div class="panel-heading"><span class="iconTitle" > <img src="images/icons/Clipboard-32.png" class="img-responsive" />รายการสินค้า</span></div>
                <div class="panel-body" style='padding:0;' >
                  <ol id='naviitem' class="breadcrumb">
                    <li><a href="#">กรุณาเลือกเมนู</a></li>
                  </ol>
                  <div id='listProduct' class='scrollitem' >  
                  </div>
                </div>
            </div>
          </div>
            <div class='col-sm-5 nopadding'> 
			
			              <!-- Order List -->
              <div class="panel panel-warning" style='margin:0px;' id="tabCalc">
                <div class="panel-heading"><span class="iconTitle" > <img src="images/icons/Shopping-Cart-02-32.png" class="img-responsive" />รายการขาย</span></div>
                <div class="panel-body">
						<div class="well well-sm height200 scrollitem" id="orderlist" style="margin-bottom:10px;">
							<ul class="list-group" id='orderitem'>
							</ul>
						</div>
							 <!--Calculator-->
					  <div class="panel panel-danger">
						<div class="panel-heading"><span class="iconTitle" > <img src="images/icons/Bid-02-32.png" class="img-responsive" />ข้อมูลชำระเงิน</span></div>
						<div class="panel-body">
						  <form class="form-horizontal">  
						  <div class="form-group">
							<label for="totalinp" class="col-sm-3 control-label">รวมเงิน</label>
							<div class="col-sm-9">
							  <input type="text" class="form-control" id="totalinp" placeholder="" readonly='readonly'>
							</div>
						  </div>
						    <div class="form-group">
							<label for="discountinp" class="col-sm-3 control-label">ส่วนลด</label>
							<div class="col-sm-9">
							  <input type="text" class="form-control" id="discountinp" placeholder="จำนวนเงินส่วนลด" value="0" >
							</div>
						  </div>
						  <div class="form-group">
							<label for="netinp" class="col-sm-3 control-label">เงินสุทธิ</label>
							<div class="col-sm-9">
							  <input type="text" class="form-control" id="netinp" placeholder="จำนวนเงินส่วนลด" readonly='readonly' >
							</div>
						  </div>
						  <div class="form-group">
							<label for="receiveinp" class="col-sm-3 control-label">รับเงิน</label>
							<div class="col-sm-9">
							  <input type="text" class="form-control" id="receiveinp" placeholder="กรอกจำนวนเงิน">
							</div>
						  </div>
						  <div class="form-group">
							<label for="returninp" class="col-sm-3 control-label">ตั้งทอน</label>
							<div class="col-sm-9">
							  <input type="text" class="form-control" id="returninp" placeholder="" readonly="readonly">
							</div>
						  </div>
						  <div class="form-group">
							<div class="col-sm-offset-3 col-sm-9">
							  <button type="button" id='btnCalculate' class="btn btn-warning"><span class="glyphicon glyphicon-th" aria-hidden="true"></span> คำนวน</button>
							  <button type="button" id='btnSave' class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> บันทึก</button>
							  <button type="button" id='btnCancel' class="btn btn-danger"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> ยกเลิก</button>
							</div>
						  </div>
						</form>  
						</div>
					</div>
				  
                </div>
              </div>
			
          </div> 
        </div>
    </div>  <!--/container -->
	
	
<!--show modal-->
<!-- Modal -->
<div class="modal fade" id="modaldialog" tabindex="-1" role="dialog" aria-labelledby="modaltitle">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modaltitle">Modal title</h4>
      </div>
	  <div id="modalcontent">
		.....
	  </div>
    </div>
  </div>
</div>
	<!--show modal-->

	<script src="js/jquery.min.js"></script>
	<script src='js/bootstrap.js' ></script>
	<script src='js/pos_ctrl.js' ></script>
	<script src='js/category_ctrl.js' ></script>
	<script src='js/product_ctrl.js' ></script>
	<script src="js/searchcustomer.js" ></script>
	<script src="js/menus.js" ></script>
	
</body>
</html>