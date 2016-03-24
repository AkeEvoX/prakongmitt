<?
header('Content-Type: application/json');
session_start();
include ("connect_procedure.php");


//get current profile
$inputJSON = file_get_contents('php://input');
$item= json_decode( $inputJSON, TRUE ); //convert JSON into array

$log = "";

$orderid = $item["orderinfo"]["orderid"];
$tablenum = $item["orderinfo"]["tablenum"];



if($orderid=="")
{
	//insert data order
	$call = $consqli->prepare('call InsertOrder(?,?,?,?,?,?,?,?,?,@result); ') or die('Error Procedure #' . $consqli->errno . ' : ' . $consqli->error);
	$call->bind_param('sssssssds',$empid ,$total,$receive ,$return,$cust,$discount,$status,$net,$tablenum);

	$empid = $_SESSION["profile"]["empid"];
	$total = $item["orderinfo"]["total"];
	$receive = $item["orderinfo"]["receive"];
	$return = $item["orderinfo"]["return"];
	$cust = $item["orderinfo"]["custid"];
	$discount = $item["orderinfo"]["discount"];
	$net = $item["orderinfo"]["net"];
	$status = '1'; // 1=complete , 0=not complete
	$call->execute();

	$call->close();

	$call = $consqli->query("select @result as orderid");
	$row = $call->fetch_assoc();
	$orderid =  $row['orderid']; 
	$call->close();


	$log = "create orderid = " . $orderid;
}
else
{

	//update data order
	$call = $consqli->prepare('call UpdateOrder(?,?,?,?,?,?,?,?,?,?); ') or die('Error Procedure #' . $consqli->errno . ' : ' . $consqli->error);
	$call->bind_param('ssssssssds',$empid,$total,$receive,$change,$cusid,$orderid,$discount,$status,$net,$tablenum);

	$cusid = '';
	$empid = $_SESSION["profile"]["empid"];
	$total = $item["orderinfo"]["total"];
	$receive = $item["orderinfo"]["receive"];
	$change = $item["orderinfo"]["return"];
	$discount = $item["orderinfo"]["discount"];
	$net = $item["orderinfo"]["net"];
	$status='1';

	$call->execute();
	$call->close();

	//clear orderdetail
	$call = $consqli->prepare("delete from orderdetails where orderid=? ");
	$call->bind_param('d',$orderid);
	$call->execute();
	$call->close();


	$log = "update orderid = " . $orderid;
}

foreach ($item["orderdetail"] as $item)
{
	
	$call = $consqli->prepare("call InsertOrderDetail(?,?,?,?) ;");
	$call->bind_param('ssss',$orderid,$proid,$groupid,$price );
	
	$proid = $item["proid"];
	$price = $item["price"];
	$groupid = $item["groupid"];
	
	$call->execute();
	$call->close();

}


//clear overder tablenumbers
if($tablenum!="")
{
	$call = $consqli->prepare('update tablenumbers set orderid=null where numbers=? ') or die('Error Procedure #' . $consqli->errno . ' : ' . $consqli->error);
	$call->bind_param('s',$tablenum);
	$call->execute();
	$call->close();
}

$consqli ->close();


echo json_encode(array("result"=>"Save Success","description"=>$log));
//print_r(json_encode($item));

?>