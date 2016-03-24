<?

include('connect_restaurant.php');
//header('Content-Type: application/json');

$type = $_GET["type"];

//get category from database

if($type=="load")
{
	$category = '';
	$navictrl = 'naviitem';
	$cateItems = array();
	$result = array();

	$query = "select cateid,catename,cateicon from category where active=1 order by catename;";
	
	if($call = $consqli->prepare($query))
	{
		$call->execute();
		$call->bind_result($cateid,$catename,$cateicon);
		
		while($call->fetch())
		{
			$cateItems[] = array("name"=>$catename,"id"=>$cateid,"icon"=>$cateicon);
		}
		
	}
	
	$result= array("category"=> json_encode($cateItems));

	//close connection
	$call->close();
	
	//echo json_encode($result);
}
else if ($type=="page")
{
	
	$result = array();
	$cateItems = array();
	
	$page = $_GET["index"];
	$pagesize = 10 ;
	
	$max = ($pagesize * $page);
	//$min =  $max - $pagesize;
	
	/* sample 
	page =  10 
	min : max - page
	max :  page * no
	*/
	$query = "select * from category limit $max,$pagesize ";
	if($call = $consqli->prepare($query))
	{
		$call->execute();
		$call->bind_result($cateid,$catename,$cateicon,$active);
		while($call->fetch())
		{
			$cateItems[] = array("id"=>$cateid,"name"=>$catename,"icon"=>$cateicon,"active"=>$active);
		}
	}
	
	/*assign item to list */
	$result= array("category"=> json_encode($cateItems));

	$call->close();
	//echo $result;
}

echo json_encode($result);
	

?>