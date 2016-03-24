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
	  <div class="container">
		<div class="row" style="margin-top:5px;">
			<div class="col-md-12">
				<div class="well well-sm">
					<img class="img-responsive" style="width:100%;" src="images/show_case.jpg" />
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">				
			<div class="jumbotron">
			  <h2>Welcome Prakongmitt POS</h2>
				<small>
				Taking good care of your car definitely makes the difference between being a proud owner of a good looking, long lasting, reliable automobile, as opposed to being a resentful owner to a rusty, faded-paint jalopy that fell apart or broke down long before it was destined to.
			  </small>
			  <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a></p>
			</div>
			</div>
			<div class="col-md-6">
				<div class="well">
				<h2>TIPS</h2>
				<small>
				How could one take care of a car? Here are some basic tips every car owner should know.<br/>
Tip 1. First of all, car care is about checking and changing oil regularly. Regular oil and filter changes will make an engine last longer, while neglecting oil-level checks or timely oil changes will destroy it faster.
This goes for both the engine oil and transmission oil.
<br/>
Tip 2. The next step is to flush the cooling system and change coolant annually.
This will prevent corrosion and deposits from building up inside the cooling system and will keep it in a good shape.
<br/>
Be a proud car owner! With diligent care, your car will serve you long.
</small>
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
</body>