<?
session_start();
header("Content-Type: application/json;  charset=UTF8");
include("connect_procedure.php");

$usertype = $_SESSION["profile"]["usertype"];
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

$result = array("result"=>json_encode($item));
echo json_encode($result);

/*test github*/

?>