<?php
error_reporting(0);
header("Content-type: application/json");

$t = isset($_POST['t'])?$_POST['t']:"";
$h = isset($_SERVER['HTTP_X_FORWARDED_FOR'])?$_SERVER['HTTP_X_FORWARDED_FOR']:"";
$uids = isset($_POST['uids'])?$_POST['uids']:"";

if (($t!="" && $t===getenv('TOKEN_KEY')) && ($h!="" && $h===getenv('ACCEPTED_HOST')) && $uids!=""){
	include("./config.inc.php");
	include("./dbconnect.inc.php");
	
	$q = "UPDATE t_registrasi SET emailstatus_uid=1 WHERE uid IN (".$uids.")";
	$r = mysqli_query($dblink, $q) or die (mysql_error($dblink));
	$arrResponse = array(
		"status" => true,
		"msgCode" => "00",
		"msg" => "Success"
	);
} else {
	$arrResponse = array(
		"status" => false,
		"msgCode" => "04",
		"msg" => "Unknown Error",
	);
}

echo json_encode($arrResponse);
?>
