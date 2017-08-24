<?php
//error_reporting(0);
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username']==''){
	$_SESSION = [];
	session_destroy();
	header("Location: ./index.php");
	exit();
}

$id = $_POST['id'];
$statusid = $_POST['statusid'];

if ($id=='' || ($statusid!=1 && $statusid!=2)){
	exit();
}

include ('./config.inc.php');
include ('./dbconnect.inc.php');

$q = "UPDATE t_registrasi SET followup_status=".mysqli_real_escape_string($dblink,$statusid).",approvereject_status=0 WHERE uid='".$id."'";
$r = mysqli_query($dblink,$q) or die(mysqli_error($dblink));

$q = "SELECT count(followup_status) AS totalFU FROM t_registrasi WHERE followup_status=2 GROUP BY followup_status";
$r = mysqli_query($dblink,$q) or die(mysqli_error($dblink));
$d = mysqli_fetch_assoc($r);

$arrResult = array(
	"status"=> true,
	"msgCode"=> "00",
	"msg"=>"Success",
	"totalFollowUp"=>(int) $d['totalFU']
);
echo json_encode($arrResult);
?>