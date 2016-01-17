<?
//การประกาศตัวแปร
$mysqli_host="127.0.0.1";
$mysqli_user="root"; //super admin  user :root / pass:root
$mysqli_pass="P@ssw0rd";//P@ssw0rd
$mysqli_db="prakongmittdb";
	//ติดต่อเข้าฐานข้อมูล

	
	$consqli = new Mysqli($mysqli_host, $mysqli_user, $mysqli_pass, $mysqli_db) ;
	$consqli->set_charset("utf8");

	// Check connection
	if ($consqli->connect_error) {
		die("Connection failed: " . $consqli->connect_error);
	} 

?>