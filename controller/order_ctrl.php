<?
header('Content-Type: application/json');
session_start();
include ("connect_procedure.php");


//get current profile
$inputJSON = file_get_contents('php://input');
$item= json_decode( $inputJSON, TRUE ); //convert JSON into array

$call = $consqli->prepare('call InsertOrder(?,?,?,?,?,@result); ') or die('Error Procedure #' . $consqli->errno . ' : ' . $consqli->error);
$call->bind_param('sssss',$empid ,$total,$receive ,$return,$cust);

	$empid = $_SESSION["profile"]["empid"];
	$total = $item["orderinfo"]["total"];
	$receive = $item["orderinfo"]["receive"];
	$return = $item["orderinfo"]["return"];
	$cust = $item["orderinfo"]["custid"];
	$call->execute();

$call = $consqli->query("select @result as orderid");
$row = $call->fetch_assoc();
$orderid =  $row['orderid']; 

/*while($row = $call->fetch_assoc())
{
	echo $row['orderid'];
}*/



foreach ($item["orderdetail"] as $item)
{
	
	$call = $consqli->prepare("call InsertOrderDetail(?,?,?,?) ;");
	$call->bind_param('ssss',$orderid,$proid,$groupid,$price );
	
	$proid = $item["proid"];
	$price = $item["price"];
	$groupid = $item["groupid"];
	
	$call->execute();
	
}

$call->close();
$consqli ->close();


echo json_encode(array("result"=>"Save Success"));
//print_r(json_encode($item));

?>