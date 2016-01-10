<?
include('connect.php');


$type = $_GET["type"];

$Items = array();
$result = array();

if($type=="search") {
	/*
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
	*/
}
else if($type=="detail"){
	
}
else if($type=="summary") {
	
	$page = $_GET["index"];
	$start = $_GET["start"];
	$end = $_GET["end"];
	
	$pagesize=10;
	$max = $pagesize * ($page-1);

	//convert format date
	$tempdate = explode('/',$start);
	$start = $tempdate[2]."-".$tempdate[1]."-".$tempdate[0];
	$tempdate = explode('/',$end);
	$end = $tempdate[2]."-".$tempdate[1]."-".$tempdate[0];


	$sql = " select count(1) as total from orderinfo  ";
	$sql .= " where orderDate between '$start' and '$end' ";

	$data = mysql_query($sql);
	$row = mysql_fetch_array($data);
	$maxpage = ceil( $row["total"] / $pagesize );
	$currentPage =   $page ." / " . $maxpage ;
	

	$sql = " select * ";
	$sql .= " from orderinfo ";
	$sql .= " where orderDate between '$start' and '$end' ";
	$sql .= " limit $max,$pagesize ";

	$data = mysql_query($sql);
	
	if(mysql_num_rows($data)!=0)
	{
		while($row = mysql_fetch_array($data))
		{
			$items[] = array("date"=>$row["orderDate"],"receive"=>$row["receivePrice"],"change"=>$row["returnPrice"],"total"=>$row["totalPrice"]);
		}
	}
	
	
}



$result = array("items" => json_encode($items),"page"=>$currentPage);
echo json_encode($result);
?>