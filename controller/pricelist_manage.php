<?
header('Content-Type: application/json');
session_start();
include ("connect_procedure.php");

//get current profile
$inputJSON = file_get_contents('php://input');
$item= json_decode( $inputJSON, TRUE ); //convert JSON into array

	$typesave = $item["type"];
	$id = $item["id"];
	$category = $item["category"];
	$group = $item["group"];
	$product = $item["product"];
	$price = $item["price"];

	$result = "Fails";
	
	if($typesave == "insert")
	{
		
		try{	
			$call = $consqli->prepare("call insertPricelist(?,?,?,?) ;");
			$call->bind_param('iiii',$category,$group,$product,$price);
			$call->execute();
			$result  = "Success";
		}
		catch(Exception $e)
		{
			die("Insert Fails.");
		}
		
	}
	else if($typesave=="update"){
		
			$call = $consqli->prepare("call updatePricelist(?,?,?,?,?) ; ");
			$call->bind_param('iiiii',$id,$category,$group,$product,$price);
			$call->execute();
			$result  = "Success";
		
	}
	else if($typesave=="delete")
	{
		
			$call = $consqli->prepare("call deletePricelist(?) ;");
			$call->bind_param('i',$id);
			$call->execute();
			$result  = "Success";

	}

	$call->close();
	$consqli ->close();
	
echo json_encode(array("result"=> $typesave." ".$result ));
//print_r(json_encode($item));

?>