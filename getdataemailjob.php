<?php
error_reporting(0);
header("Content-type: application/json");

$t = isset($_POST['t'])?$_POST['t']:"";
if ($t!="" && $t===getenv('TOKEN_KEY')){
	include("./config.inc.php");
	include("./dbconnect.inc.php");
	
	$q = "SELECT * FROM v_registrasi WHERE emailstatus_uid=0";
	$r = mysqli_query($dblink, $q) or die (mysql_error($dblink));
	$arrItem = array();
	while ($d=mysqli_fetch_assoc($r)){
		$arrItem[] = $d;
	}
	$arrDataRow = array(
		"status" => true,
		"msgCode" => "00",
		"msg" => "Success",
		"total" => count($arrItem),
		"data" => $arrItem
	);
} else {
	$arrDataRow = array(
		"status" => true,
		"msgCode" => "00",
		"msg" => "Success",
		"total" => 0,
		"data" => array(
		)
	);
}
echo json_encode($arrDataRow);
?>
