<?php
//error_reporting(0);
header("Content-type: application/json");
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username']==''){
	$_SESSION = [];
	session_destroy();
	header("Location: ./index.php");
	exit();
}

$uid = $_GET['uid'];

include ('./config.inc.php');
include ('./dbconnect.inc.php');

$q = "SELECT * FROM v_registrasi WHERE uid='".mysqli_real_escape_string($dblink,$uid)."'";
$r = mysqli_query($dblink,$q) or die(mysqli_error($dblink));

$d = mysqli_fetch_assoc($r);
$d['datetime_created'] = date("j-F-Y, H:i:s",strtotime($d['datetime_created']));
$d['jenis_kelamin'] = $d['jenis_kelamin']=='L'?'Laki-laki':'Perempuan';
$d['lahir_tanggal'] = date("j-F-Y",strtotime($d['lahir_tanggal']));
$d['dp'] = number_format($d['dp'],0,",",".");
$d['angsuran'] = number_format($d['angsuran'],0,",",".");
//print_r($d);
echo json_encode($d);
?>