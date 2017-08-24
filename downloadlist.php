<?php

error_reporting(0);

$todayDownload = date('Ymd-His',time());

header("Content-Disposition: attachment; filename=\"XLFIF-REPORT-$todayDownload.xls\"");
header("Content-Type: application/vnd.ms-excel");
session_start();

if (!isset($_SESSION['username']) || $_SESSION['username']==''){
	$_SESSION = [];
	session_destroy();
	header("Location: ./index.php");
	exit();
}

include ('./config.inc.php');
include ('./dbconnect.inc.php');

$q = "
	SELECT 
		datetime_created,
		nama,
		lahir_tempat,
		lahir_tanggal,
		alamat,
		CONCAT('\'',notelp) AS notelp,
		jenis_kelamin,
		email,
		pekerjaan_v,
		statusrumah_v,
		pendidikan_v,
		maritalstatus_v,
		tanggungan,
		object_v,
		dp,
		angsuran,
		top
	FROM v_registrasi 
	ORDER BY datetime_created ASC;
";
$r = mysqli_query($dblink,$q) or die(mysqli_error($dblink));

$dashboardTotal = mysqli_num_rows($r);
$dashboardToday = 0;
$dashboardFollowup = 0;
$dashboardAccept = 0;
$dashboardSubsXLAxis = 0;
$dashboardSubsOthers = 0;

$today = date('Y-m-d',time());

$i=0;
$body = "";
if ($dashboardTotal>0){
	while($d=mysqli_fetch_assoc($r)){
		$i++;
		$trStyle = ($i%2==0)?'background-color: #fffbe7;color: #555;':'background-color: #ffffff;color: #555;';
		
		if (date('Y-m-d',strtotime($d['datetime_create']))==$today){
			$dashboardToday++;
		}
		
		if ($d['followup_status']==2){
			$dashboardFollowup++;
		}
		
		if ($d['approvereject_status']==2){
			$dashboardAccept++;
		}
		
		
		//subs type
		$arrSubsXLAxis = array('0859', '0877', '0878', '0831', '0832', '0838', '0817', '0818', '0819');
		$fourDigit = substr($d['notelp'],0,4);
		if (in_array($fourDigit,$arrSubsXLAxis)){
			$dashboardSubsXLAxis++;
		} else {
			$dashboardSubsOthers++;
		}
		
		
		if ($d['followup_status']==1){
			$actionfu = '-';
			$actionar = '-';
		} else {
			$actionfu = '&#10004; FU DONE';
			if ($d['approvereject_status']==0){
				$actionar = '-';
			} else if ($d['approvereject_status']==1){
				$actionar = '<span class="txtARRed">&#10008; REJECTED</span>';
			} else if ($d['approvereject_status']==2){
				$actionar = '<span class="txtARGreen">&#10004; ACCEPTED</span>';
			}
		}
		
		
		
		
		$body .= "<tr style='".$trStyle."'>";
		$body .= 
				"<td>".$i.
				"</td><td style='text-align:center'>".$d['datetime_created'].
				"</td><td>".$d['nama'].
				"</td><td>".$d['lahir_tempat'].
				"</td><td>".$d['lahir_tanggal'].
				"</td><td>".$d['alamat'].
				"</td><td>".$d['notelp'].
				"</td><td>".$d['jenis_kelamin'].
				"</td><td>".$d['email'].
				"</td><td>".$d['pekerjaan_v'].
				"</td><td>".$d['statusrumah_v'].
				"</td><td>".$d['pendidikan_v'].
				"</td><td>".$d['maritalstatus_v'].
				"</td><td>".$d['tanggungan'].
				"</td><td>".$d['object_v'].
				"</td><td>".$d['dp'].
				"</td><td>".$d['angusuran'].
				"</td><td>".$d['top'].
				"</td><td style='text-align:center'>".$actionfu.
				"</td><td style='text-align:center'>".$actionar.
				"</td>";
		$body .= "</tr>";
		
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<style>
.boxPrint{
	border: 1px solid #E1E1E1;
    border-radius: 4px;
	font-size:14px; 
	text-align:center;
	margin-top:20px;
	min-height:100px;
	padding:10px;
}

.dashboardFont{
	font-size:28px;
	font-weight:bold;
}
</style>
<body style="font-size:12px;">

<!-- Primary Page Layout
------------------------- -->

	<div class="row">
		<center>
			<div class="column" style="margin-top: 3%">
				<div style="position:relative; overflow: show">
					<table style='background-color: #ffe486; font-size:12px; font-family:tahoma' cellpadding='4' cellspacing='1' border='0'>
						<tr>
							<th>No.</th>
							<th style='text-align:center'>Datetime Register</th>
							<th>Nama</th>
							<th>Tempat Lahir</th>
							<th>Tanggal Lahir</th>
							<th>Alamat</th>
							<th>No Telp</th>
							<th>Jenis Kelamin</th>
							<th>Email</th>
							<th>Pekerjaan</th>
							<th>Status Rumah</th>
							<th>Pendidikan</th>
							<th>Status Menikah</th>
							<th>Tanggungan</th>
							<th>Object</th>
							<th>DP</th>
							<th>Angsuran</th>
							<th>TOP</th>
							<th style='text-align:center'>Follow Up</th>
							<th style='text-align:center'>Accept/Reject</th>
						</tr>
						<?php
						if ($dashboardTotal>0){
							echo $body;
						} else {
							?>
							<tr><td colspan="7"><i>-no data-</i></td></tr>
							<?php
						}
						?>
					</table>
				</div>
			</div>
		</center>
	</div>

<!-- End Document
  ------------------------- -->
</body>
</html>
