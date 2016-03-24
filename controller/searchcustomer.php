<?
header("Content-Type: application/json;  charset=UTF8");
include("connect_procedure.php");

$call=$consqli->query("select * from customer  where concat(firstname,',',lastname,',',mobile) like '%".$_GET["fillter"]."%'; ");
$countItem = $call->num_rows;


$result = array();
if($countItem!="0")
{
	
	$item = array();
	
	while($row = $call->fetch_assoc())
	{
		
		$custid = $row["custid"];
		$fullname = $row["firstname"] .' '.$row["lastname"] ;
		$mobile = $row["mobile"] ;
		$item[] = array("id"=>$custid,"name"=>$fullname,"mobile"=>$mobile);
	}
	
}


$result = array("result"=>json_encode($item));

echo json_encode($result);

?>