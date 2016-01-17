<?
include('connect.php');


$type = $_GET["type"];

$Items = array();
$result = array();

if($type=="load")
{
	
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
else if($type=="groups"){
	
	$category = $_GET["category"];	
	

	$sql = " select t1.cateid,t1.prodgroupid,t2.prodGroupName,t2.prodGroupIcon  ";
	$sql .= " from productlist t1 left join productgroups t2 on t1.prodgroupid=t2.prodgroupid ";
	$sql .= " where t1.cateid=".$category ;
	$sql .= " group by t1.cateid,t1.prodgroupid; ";

	$data = mysql_query($sql);
	if(mysql_num_rows($data)!=0)
	{
		while($row = mysql_fetch_array($data))
		{
			$items[] = array("name"=>$row["prodGroupName"],"id"=>$row["prodgroupid"],"icon"=>$row["prodGroupIcon"]);
		}
	}
}
else if($type=='products')
{
	$category = $_GET["category"];	
	$group = $_GET["group"];
	
	$sql = " select t1.*,t2.prodName,t2.prodIcon ";
	$sql .= " from productlist t1 left join product t2 on t1.prodid=t2.prodid ";
	$sql .= " where t1.cateid=".$category ;
	$sql .= " and t1.prodgroupid=".$group ;
	
	$data = mysql_query($sql);
	if(mysql_num_rows($data)!=0)
	{
		while($row = mysql_fetch_array($data))
		{
			$items[] = array("name"=>$row["prodName"],"id"=>$row["prodid"],"icon"=>$row["prodIcon"],"price"=>$row["price"]);
		}
	}
}
else if($type=="page") {
	
	$page = $_GET["index"];
	$pagesize=10;
	
	$max = ($pagesize * ($page-1));
	
	$sql = " select count(1) as total from productlist order by prodlistid desc  ";
	$data = mysql_query($sql);
	$row = mysql_fetch_array($data);
	$maxpage = ceil( $row["total"] / $pagesize );
	$currentPage =   $page ." / " . $maxpage ;
	
	
	$sql = " select t1.*,t2.prodgroupname,t3.catename,t4.prodName from productlist t1 ";
	$sql .= " left join productgroups t2 on t1.prodgroupid = t2.prodGroupid ";
	$sql .= " left join category t3 on t1.cateid = t3.cateid " ;
	$sql .= " left join product t4 on t1.prodid = t4.prodid order by prodlistid desc  limit $max , $pagesize; "; 
	
	$data = mysql_query($sql);
	
	if(mysql_num_rows($data)!=0)
	{
		while($row = mysql_fetch_array($data))
		{
			//prodlistid,prodgroupid,prodid,price,progroupname,catename
			$items[] = array("id"=>$row["prodListid"]
							,"cateid"=>$row["cateid"] 
							,"groupid"=>$row["prodgroupid"] 
							,"prodid"=>$row["prodid"] 
							,"category"=>$row["catename"]
							,"group"=>$row["prodgroupname"]
							,"product"=>$row["prodName"]
							,"price"=> $row["price"]);
		}
		
	}
	
}


$result = array("items" => json_encode($items),"page"=>$currentPage);
echo json_encode($result);
?>