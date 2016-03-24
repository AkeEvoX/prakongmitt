<?
session_start();
header("Content-Type: application/json;  charset=UTF8");
include("connect_restaurant.php");
include("../../../controller/logger.php");


$type = $_GET["type"];
$info = 'null';
switch($type)
{
	case 'tables' :
		
			$stmt = " select * from  getTableResturant ; ";
			$call=$consqli->query($stmt);
			$countItem = $call->num_rows;

			$result = array(); 
			if($countItem!="0" && $countItem != "NULL")
			{
				
				$item = array();
				
				while($row = $call->fetch_assoc())
				{
					
					$num = $row['numbers'];
					$orderid = $row['orderid'];
					$status = $row['status']; // 0=avalible, 1=not avalible ,2 = success
					$item[] = array("number"=>$num,"order"=>$orderid,"status"=>$status);
					
				}
			}

		break;
	case 'order' : 
	
			$oid = $_GET["id"];
			
			$stmt = " select * from getOrderDetails where orderid=".$oid." "; 
			$call=$consqli->query($stmt);
			$countItem = $call->num_rows;
			$result = array();
			
			if($countItem!="0" && $countItem != "NULL")
			{
				
				$item = array();
				
				while($row = $call->fetch_assoc())
				{
					//orderdetailid, prodid,price
					$odid = $row['orderdetailid'];
					$prod = $row["prodid"];
					$price= $row["price"];
					$prodgroupid = $row["prodgroupid"];
					$groupname = $row["prodGroupName"];
					$prodname = $row["prodName"];
					$item[] = array("odid"=>$odid,"prod"=>$prod,"price"=>$price,"prodgroup"=>$prodgroupid,"groupname"=>$groupname,"prodname"=>$prodname);
					
				}
				
			}

			$call->close();

			/* get order information */

			$stmt = "select * from orderinfo where orderid = " . $oid;
			$call=$consqli->query($stmt);
			$row = $call->fetch_assoc();
			//totalPrice,netPrice,receivePrice,returnPrice,discount

			$info = array("total"=>$row["totalPrice"],"net"=>$row["netPrice"],"receive"=>$row["receivePrice"],"change"=>$row["returnPrice"],"discount"=>$row["discount"]);

			$call->close();

		break;
}

$consqli ->close();

$result = array("items"=>json_encode($item),"info"=>json_encode($info));

log_info("get restaurant info> " . print_r($result,true));

echo json_encode($result);

?>