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
	<title>Category</title>
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
							<span class="iconTitle" > <img src="images/icons/Folder-32.png" class="img-responsive" />กลุ่มสินค้า</span>
						</div>
							<div class="panel-body table-responsive" >
										<table class='table table-condensed' id='mgrList'> <!-- table-bordered -->
										
										</table>
							</div>
							<div class='panel-footer panel-green' >
								<input type='hidden' id="currentPage" />
								<ul class="pager" style='margin:0px;'>
										<li><a href="#" id="previousPage" >Previous</a></li>
										<li><a href='#'  id="showPage">1 / #</a></li>
										<li><a href="#" id="nextPage" >Next</a></li>
								 </ul>
							</div>
					  </div>
					
				</div>
			</div>
		</div>
		
	  </div>
	  
	  
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
	<script src="js/menus.js" ></script>
	<script src="js/productgroup_manage.js" ></script>
</body>