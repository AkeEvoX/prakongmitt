<? 
session_start();


if(!isset($_SESSION["profile"]))
{
	echo "<script>alert('please login !!');window.location='login.php';</script>";
	
}

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
      <div class="container-fluid">
        <div class='row'>
            <div class='col-sm-2 nopadding'>
                <div class="panel panel-default">
                <div class="panel-heading">ประเภทสินค้า</div>
                <div class="panel-body scrollitem" id="listCategory">
                </div>
              </div>
            </div>
            <div class='col-sm-5 nopadding'>
               <div class="panel panel-default">
                <div class="panel-heading">รายการสินค้า</div>
                <div class="panel-body" >
                  <ol id='naviitem' class="breadcrumb">
                    <li><a href="#">กรุณาเลือกเมนู</a></li>
                  </ol>
                  <div id='listProduct' class='scrollitem height500' >  
                  </div>
                </div>
            </div>
          </div>
            <div class='col-sm-5 nopadding'> 
              <!-- Order List -->
              <div class="panel panel-default" style='margin:0px;'>
                <div class="panel-heading">รายการสั่งซื้อ</div>
                <div class="panel-body scrollitem" style='height:300px'>
                  <ul class="list-group" id='orderitem'>
					
                  </ul>
                </div>
              </div>
              <!--Calculator-->
              <div class="panel panel-default">
                <div class="panel-heading">ข้อมูลชำระเงิน</div>
                <div class="panel-body">
                  <form class="form-horizontal">
				  <div class="form-group">
				  
                    <label for="inputCust" class="col-sm-3 control-label">ข้อมูลลูกค้า</label>
                    <div class="col-sm-9">
							<div class="input-group">
							  <input type="text" class="form-control" id="inputCust" data-custid="" placeholder="เลือกค้นหาลูกค้า" readonly='readonly'>
							  <span class="input-group-btn">
								<button class="btn btn-default"  id="btnDiagSearchCust" type="button"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> ค้นหา</button>
							  </span>
							</div><!-- /input-group -->
                    </div>
                  </div>
				  
                  <div class="form-group">
                    <label for="totalinp" class="col-sm-3 control-label">รวมเงิน</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="totalinp" placeholder="" readonly='readonly'>
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
	<script src='js/prakongmitt_ctrl.js' ></script>
	<script src='js/category_ctrl.js' ></script>
	<script src='js/product_ctrl.js' ></script>
	<script src="js/searchcustomer.js" ></script>
	<script src="js/menus.js" ></script>
</body>
</html>