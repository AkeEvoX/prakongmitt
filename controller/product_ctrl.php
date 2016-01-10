<?
include('connect.php');


$type = $_GET["type"];

$Items = array();
$result = array();

if($type=="load") {
	
	$groupid = $_GET["groupid"];	
	$sql = "select t1.*,t2.prodName,t2.prodIcon from productlist t1 left join product t2 on t1.prodid=t2.prodid where prodgroupid=".$groupid." ";
	$data = mysql_query($sql);
	if(mysql_num_rows($data)!=0)
	{
		while($row = mysql_fetch_array($data))
		{
			$items[] = array("name"=>$row["prodName"],"id"=>$row["prodid"],"icon"=>$row["prodIcon"],"price"=>$row["price"],"groupid"=>$row["prodgroupid"]);
		}
	}
	
}
else if($type=="list"){
	
	
	$sql = "select * from product order by prodname;";
	$data = mysql_query($sql);
	if(mysql_num_rows($data)!=0)
	{
		while($row = mysql_fetch_array($data))
		{
			$items[] = array("name"=>$row["prodName"],"id"=>$row["prodid"],"icon"=>$row["prodIcon"],"price"=>$row["price"],"groupid"=>$row["prodgroupid"]);
		}
	}
}
else if($type=="page") {
	
	$page = $_GET["index"];
	$pagesize=10;
	
	$max = $pagesize * ($page-1);


	$sql = " select count(1) as total from product order by prodid desc  ";
	$data = mysql_query($sql);
	$row = mysql_fetch_array($data);
	$maxpage = ceil( $row["total"] / $pagesize );
	$currentPage =   $page ." / " . $maxpage ;
	
	
	$sql = " select prodid,prodName,prodIcon,(active+0) as status from product limit $max,$pagesize";
	$data = mysql_query($sql);
	
	if(mysql_num_rows($data)!=0)
	{
		while($row = mysql_fetch_array($data))
		{
			$items[] = array("name"=>$row["prodName"],"id"=>$row["prodid"],"icon"=>$row["prodIcon"],"active"=>$row["status"]);
		}
	}
	
	
}



$result = array("items" => json_encode($items),"page"=>$currentPage);
echo json_encode($result);
?>