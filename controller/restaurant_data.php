<?
session_start();
header("Content-Type: application/json;  charset=UTF8");
include("connect_procedure.php");


$type = $_GET["type"];

switch($type)
{
	case 'tables' :
		
			$stmt = " call getTableNumbers();";
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
	
		/*
			$stmt = " call getmenus('".$usertype."');";
			$call=$consqli->query($stmt);
			$countItem = $call->num_rows;
			$result = array();
			
			if($countItem!="0" && $countItem != "NULL")
			{
				
				$item = array();
				
				while($row = $call->fetch_assoc())
				{
					$name = $row['menu_name'];
					$desc = $row["menu_desc"];
					$url = $row["menu_url"];
					$icon = $row["menu_icon"];
					$item[] = array("name"=>$name,"desc"=>$desc,"url"=>$url ,"icon"=>$icon);
				}
				
			}
			
		*/
		
		break;
}

$result = array("items"=>json_encode($item));
echo json_encode($result);

?>