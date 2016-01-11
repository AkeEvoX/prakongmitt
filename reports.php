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
	<link rel='stylesheet' href='css/bootstrap-datetimepicker.css' >
	<title>Reports</title>
</head>
<body>
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
	  
	  <div class="container-fluid">
		<div class="row" style="margin-top:5px;">
			<div class="col-md-12">
				<div class="well well-sm">
					
					 <div class="panel panel-success"  id="tabMgr" >
						<div class="panel-heading" >
							<span class="iconTitle" > <img src="images/icons/Folder-32.png" class="img-responsive" />รายงาน</span>
						</div>
							<div class="panel-body" >
									<div class='row'>
										<div class='col-md-4'>
											<div class='form-group'>
													<div class='input-group'>
														<span class='input-group-addon'>
															<input type='radio' name='reporttype' value='summary' aria-label='Show Summary report' checked />
														</span>
														<input type='text' class='form-control' value='Summary Report' readonly />
													</div>
												</div>
										</div>
									</div>
									<div class='row'>
										<div class='col-md-4'>
											<div class='form-group'>
													<div class='input-group'>
														<span class='input-group-addon'>
															<input type='radio' name='reporttype' value='detail' aria-label='Show detail report' />
														</span>
														<input type='text' class='form-control' value='Detail Report' readonly />
													</div>
												</div>
										</div>
									</div>
									<div class='row' >
											<div class='col-md-4'>
												<div class='form-group'>
												<div class='input-group date' id='startDate'>
													<span class='input-group-addon' >START</span>
													<input type='text' id='startInp' class='form-control' aria-label='start date'/ >
													<span class='input-group-addon'><span class="glyphicon glyphicon-calendar"></span></span>
												</div>
												</div>
											</div>
											<div class='col-md-4'>
													<div class='form-group'>
													<div class='input-group date' id='endDate'>
														<span class='input-group-addon'>END</span>
														<input type='text' id='endInp' class='form-control' aria-label='end date'/ >
														<span class='input-group-addon'><span class="glyphicon glyphicon-calendar"></span></span>
													</div>
													</div>
											</div>
									</div>
									<div id='reportoption' >
										<div class='row'>
										<div class='col-md-4'>
											<div class='form-group'>
											<div class='input-group'>
												<span class='input-group-addon'>Category</span>
												<select id='categorys' class='form-control' >
													<option>wash</option>
												</select>
											</div>
											</div>
										</div>
									</div>
										<div class='row'>
										<div class='col-md-4'>
											<div class='form-group'>
												<div class='input-group'>
													<span class='input-group-addon'>Group</span>
													<select id='groups' class='form-control' >
														<option>car wash</option>
													</select>
												</div>
											</div>
										</div>
									</div>
										<div class='row'>
										<div class='col-md-4'>
												<div class='form-group'>
													<div class='input-group'>
														<span class='input-group-addon'>Product</span>
														<select id='products' class='form-control' >
															<option>motor cyle</option>
														</select>
													</div>
												</div>
											</div>
									</div>
									</div>
								</div>
							<div class='panel-footer panel-green' >
								<button class='btn btn-success' id='btnSearch'>Search</button>
							</div>
					  </div>
					
				</div>
			</div>
		</div>
		
	  </div>
	  
	  
<!--show modal-->
<!-- Modal -->
<div class="modal fade " id="modaldialog" tabindex="-1" role="dialog" aria-labelledby="modaltitle">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modaltitle">Modal title</h4>
      </div>
	  <div id="modalcontent">
		loading .....
	  </div>
    </div>
  </div>
</div>
	<!--show modal-->
	  
	<script src="js/jquery.min.js"></script>
	<script src='js/bootstrap.js' ></script>
	<script src="js/menus.js" ></script>
	<script src="js/moment.js"></script>
	<script src="js/bootstrap-datetimepicker.js" ></script>
	<script src="js/report_ctrl.js" ></script>
</body>