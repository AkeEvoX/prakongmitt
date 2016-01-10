<?
include('connect.php');
//header('Content-Type: application/json');

$type = $_GET["type"];

//get category from database

if($type=="load")
{
	$category = '';
	$navictrl = 'naviitem';
	$cateItems = array();
	$result = array();

	$sql = "select * from category where active=1 order by catename; ";
	$data = mysql_query($sql);

	if(mysql_num_rows($data)!=0)
	{
		while($row = mysql_fetch_array($data))
		{
			$cateItems[] = array("name"=>$row["cateName"],"id"=>$row["cateid"],"icon"=>$row["cateIcon"]);	
		}
	}

	$result= array("category"=> json_encode($cateItems));

	//echo $result;
	echo json_encode($result);
}
else if ($type=="page")
{
	
	$result = array();
	$cateItems = array();
	
	$page = $_GET["index"];
	$pagesize = 10 ;
	
	$max = ($pagesize * $page) ;
	//$min =  $max - $pagesize;
	
	/* sample 
	page =  10 
	min : max - page
	max :  page * no
	*/
	
	$sql = "select * from category limit $max,$pagesize";
	$data = mysql_query($sql);
	
	if(mysql_num_rows($data)!=0)
	{
			while($row = mysql_fetch_array($data))
		{
			$cateItems[] = array("name"=>$row["cateName"],"id"=>$row["cateid"],"icon"=>$row["cateIcon"],"active"=>ord($row["active"]));
		}
	}
	
	/*assign item to list */
	$result= array("category"=> json_encode($cateItems));

	//echo $result;
	echo json_encode($result);
	
}

?>