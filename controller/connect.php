<?
//การประกาศตัวแปร
$m_Host="192.168.1.5";
$m_User="remotedb"; //super admin  user :root / pass:root
$m_Pass="remotedb"; //P@ssw0rd
$m_DB="prakongmittdb";
	//ติดต่อเข้าฐานข้อมูล

	
$connect=mysql_connect($m_Host,$m_User,$m_Pass)or die(mysql_error());
$db=mysql_select_db($m_DB);
 mysql_db_query($m_DB,"SET NAMES UTF8"); //set default encoding UTF-8

if(!$db){echo"Call Database Error: ".mysql_error();};


?>