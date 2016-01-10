<?
include('connect.php');
//header('Content-Type: application/json');

$type = $_GET["type"];
$items = array();
$result = array();

if($type=="load"){
//get category from database
	$cateid = $_GET["cateid"];
	$navictrl = 'listProduct';
	

	$sql = "select * from productgroups where cateid=".$cateid." order by prodGroupName; ";
	$data = mysql_query($sql);

	if(mysql_num_rows($data)!=0)
	{
		while($row = mysql_fetch_array($data))
		{
			$items[] = array("name"=>$row["prodGroupName"],"id"=>$row["prodGroupid"],"icon"=>$row["prodGroupIcon"]);
		}
	}

}
else if($type=="list")
{

	$sql = "select * from productgroups order by prodGroupName; ";
	$data = mysql_query($sql);

	if(mysql_num_rows($data)!=0)
	{
		while($row = mysql_fetch_array($data))
		{
			$items[] = array("name"=>$row["prodGroupName"],"id"=>$row["prodGroupid"],"icon"=>$row["prodGroupIcon"]);
		}
	}
	
}
else if($type=="page")
{
	
	$page = $_GET["index"];
	$pagesize=10;
	
	$max = $pagesize * ($page - 1);

	$sql = " select count(1) as total from productgroups order by prodGroupid desc  ";
	$data = mysql_query($sql);
	$row = mysql_fetch_array($data);
	$maxpage = ceil( $row["total"] / $pagesize );
	$currentPage =   $page ." / " . $maxpage ;

		//$sql = "select * from productgroups limit $max,$pagesize";
	$sql = "select prodGroupid,prodGroupName,prodGroupIcon,(active+0) as active from productgroups limit $max ,$pagesize ";
	
	$data = mysql_query($sql);
	/*prodGroupid,prodGroupName,cateid,prodGroupIcon,active*/
	if(mysql_num_rows($data)!=0)
	{
			while($row = mysql_fetch_array($data))
		{
			$items[] = array("name"=>$row["prodGroupName"],"id"=>$row["prodGroupid"],"icon"=>$row["prodGroupIcon"],"active"=>$row["active"]);
		}
	}
	
}

$result= array("items"=> json_encode($items),"page"=>$currentPage);

echo json_encode($result);

?>