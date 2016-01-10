<?
header('Content-Type: application/json');
session_start();
include ("connect_procedure.php");

//get current profile
$inputJSON = file_get_contents('php://input');
$item= json_decode( $inputJSON, TRUE ); //convert JSON into array

	$typesave = $item["type"];
	$id = $item["id"];
	$name = $item["name"];
	$icon = $item["icon"];

	$status  = 0;
	$result = "Fails";
	
	
	if($item["active"]=="true"){
		$status=1;
	}
	
	if($typesave == "insert")
	{
		
		try{	
			$call = $consqli->prepare("call insertProductgroup(?,?,?) ;");
			$call->bind_param('ssi',$name,$icon,$status);
			$call->execute();
			$result  = "Success";
		}
		catch(Exception $e)
		{
			die("Insert Fails.");
		}
		
	}
	else if($typesave=="update"){
		
			$call = $consqli->prepare("call updateProductgroup(?,?,?,?) ; ");
			$call->bind_param('sssi',$id,$name,$icon,$status);
			$call->execute();
			$result  = "Success";
		
	}
	else if($typesave=="delete")
	{
		
			$call = $consqli->prepare("call deleteProductgroup(?) ;");
			$call->bind_param('s',$id);
			$call->execute();
			$result  = "Success";

	}

	$call->close();
	$consqli ->close();
	
echo json_encode(array("result"=> $typesave." ".$result ));
//print_r(json_encode($item));

?>