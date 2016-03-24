<?
header("Content-Type: application/json");
session_start();
include("connect_procedure.php");

$inputJson = file_get_contents('php://input');
$item = json_decode($inputJson,true);

//keep profile to session

$return = array("code"=>"","desc"=>"");

$user = $item["user"];
$pass = $item["pass"];

$call = $consqli->query('call login("'.$user.'","'.$pass.'");') or die('Error login #'.$consqli->errno.':'.$consqli->error);
if($call->num_rows != "0")
{
	$row = $call->fetch_assoc();
	$response = $row["result"];
	$empid = $row["empid"];
}



$call->close();
$consqli->next_result();

if($response==1)
{
	
	$call = $consqli->query("call getEmployee('".$empid."');") or die('Error getEmployee #'.$consqli->errno.':'.$consqli->error);
	$row = $call->fetch_assoc();
	
	$_SESSION["profile"] = array("empid"=>$row["empid"],"fullname"=>$row["fullname"],"mobile"=>$row["mobile"],"usertype"=>$row["usertype"],"typename"=>$row["typename"]);
	
	$return["code"] = 1;
	$return["desc"] = "verify success." + $row["fullname"];
}
else
{
	$return["code"] = 0;
	$return["desc"] = "Username หรือ Password ไม่ถูกต้อง !!";
}


$consqli->close();

 
echo  json_encode($return);


?>