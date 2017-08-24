<?php

error_reporting(0);

session_start();

if (!isset($_SESSION['username']) || $_SESSION['username']==''){
	$_SESSION = [];
	session_destroy();
	header("Location: ./index.php");
	exit();
}

include ('./config.inc.php');
include ('./dbconnect.inc.php');

$q = "SELECT * FROM t_registrasi ORDER BY datetime_created DESC;";
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
			$actionfu = '<button class="button" onclick="javascript:statusfu(this,\''.$d['uid'].'\',2);">FOLLOW UP</button>';
			$actionar = '-';
		} else {
			$actionfu = '<button class="button btnFUGreen" onclick="javascript:statusfu(this,\''.$d['uid'].'\',1);">&#10004; FU DONE</button>';
			if ($d['approvereject_status']==0){
				$actionar = '<button  class="button btnSmallAR btnARGreen" onclick="javascript:statusRejectOrAccept(this,\''.$d['uid'].'\',2);">&#10004; ACCEPT</button><br /><button  class="button btnSmallAR btnARRed" onclick="javascript:statusRejectOrAccept(this,\''.$d['uid'].'\',1);">&#10008; REJECT</button><br />';
			} else if ($d['approvereject_status']==1){
				$actionar = '<span class="txtARRed">&#10008; REJECTED</span>';
			} else if ($d['approvereject_status']==2){
				$actionar = '<span class="txtARGreen">&#10004; ACCEPTED</span>';
			}
		}
		
		
		
		
		$body .= "<tr style='".$trStyle."'>";
		$body .= "<td>".$i."</td><td style='text-align:center'>".$d['datetime_created']."</td><td>".$d['nama']."</td><td>".$d['notelp']."</td><td>".$d['alamat']."</td><td style='text-align:center'>".$actionfu."</td><td id=\"columnActionAR_".$d['uid']."\" style='text-align:center'>".$actionar."</td>";
		$body .= "</tr>";
		
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  ------------------------- -->
  <meta charset="utf-8">
  <title>XL FIF | Admin</title>
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Mobile Specific Metas
  ------------------------- -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- FONT
  ------------------------- -->
  <!--link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css"-->

  <!-- CSS
  ------------------------- -->
  <link rel="stylesheet" href="normalize.css">
  <link rel="stylesheet" href="skeleton.css">

  <!-- Favicon
  ------------------------- -->
  <link rel="shortcut icon" type="image//vnd.microsoft.icon" href="favicon.ico">
  <script src="jquery.js"></script>
  <script language="javascript">
		checkFollowUp = function(){
			if ($('#dashboardTotal').html()!=$('#dashboardFollowup').html()){
				//ada perbedaaan 
				$('#dashboardTotal').parent().css('background-color','#ffcece');
				$('#dashboardFollowup').parent().css('background-color','#ffcece');
			} else {
				$('#dashboardTotal').parent().css('background-color','#ffffff');
				$('#dashboardFollowup').parent().css('background-color','#ffffff');
			}
		}
		
		statusfu = function(_this, _id, _statusid){
			$.ajax({
				url:'./statusfu.php',
				type:'post',
				dataType:'json',
				data:'&id='+ _id+ '&statusid=' + _statusid,
				success:function(json){
					if (json.status){
						$(_this).removeClass();
						if (_statusid==2){
							$(_this).html('&#10004; FU DONE');
							$(_this).addClass('button btnFUGreen');
							$(_this).attr('onclick','javascript:statusfu(this,\''+ _id +'\',1);');
							$('#columnActionAR_' + _id).html('<button class="button btnSmallAR btnARGreen" onclick="javascript:statusRejectOrAccept(this,\''+ _id +'\',2);">&#10004; ACCEPT</button><br /><button  class="button btnSmallAR btnARRed" onclick="javascript:statusRejectOrAccept(this,\''+ _id +'\',1);">&#10008; REJECT</button><br />');
						} else {
							$(_this).html('FOLLOW UP');
							$(_this).addClass('button');
							$(_this).attr('onclick','javascript:statusfu(this,\''+ _id +'\',2);');
							$('#columnActionAR_' + _id).html('-');
						}
						$('#dashboardFollowup').html(json.totalFollowUp);
						checkFollowUp();
					} else {
						alert('[ERROR] Something went wrong!');
					}
				}
			});
		}
		
		
		statusRejectOrAccept = function(_this, _id, _statusid){
			$.ajax({
				url:'./statusar.php',
				type:'post',
				dataType:'json',
				data:'&id='+ _id+ '&statusid=' + _statusid,
				success:function(json){
					if (json.status){
						$(_this).removeClass();
						if (_statusid==2){
							$(_this).parent().html('<span class="txtARGreen">&#10004; ACCEPTED</span>');
						} else {
							$(_this).parent().html('<span class="txtARRed">&#10008; REJECTED</span>');
						}
						$('#dashboardAccept').html(json.totalAccept);
					} else {
						alert('[ERROR] Something went wrong!');
					}
				}
			});
		}
		
		$(document).ready(function(){
			checkFollowUp();
		});
  </script>
</head>
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
<div class="container">
	<div class="row">
		<div class="value-props row">
			<div class="boxPrint four columns value-prop">
				Total:
				<div class="dashboardFont" id="dashboardTotal"><?php echo $dashboardTotal;?></div>
			</div>
			<div class="boxPrint four columns value-prop">
				Followed up:
				<div class="dashboardFont" id="dashboardFollowup"><?php echo $dashboardFollowup;?></div>
			</div>
			<div class="boxPrint four columns value-prop">
				Accepted:
				<div class="dashboardFont" id="dashboardAccept"><?php echo $dashboardAccept;?></div>
			</div>
			<div class="boxPrint four columns value-prop">
				New Today:
				<div class="dashboardFont" id="dashboardToday"><?php echo $dashboardToday;?></div>
			</div>
			<div class="boxPrint four columns value-prop">
				Subs Type:
				<div class="dashboardFont" id="dashboardSubsXLAxis">XL/Axis:<?php echo $dashboardSubsXLAxis;?></div>
				<div class="dashboardFont" id="dashboardSubsOthers">Others:<?php echo $dashboardSubsOthers;?></div>
			</div>
		</div>
	</div>
	<div class="row">
		<center>
			<div class="column" style="margin-top: 3%">
				<div style="position:relative; overflow: show">
					<br /><br />
					<h6 style="color:#777; font-weight:bold;">
						Welcome <?php echo $_SESSION['username'];?> (<a href="./logout.php">Logout</a>),<br />
						Download List Data as XLS <a href="./downloadlist.php">Download List</a>
					</h6>
					<table style='background-color: #ffe486; font-size:12px; font-family:tahoma' cellpadding='4' cellspacing='1' border='0'>
						<tr><th>No.</th><th style='text-align:center'>Datetime (Descending)</th><th>Name</th><th>Phone</th><th>Address</th><th style='text-align:center'>Follow Up</th><th style='text-align:center'>Accept/Reject</th></tr>
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
</div>

<!-- End Document
  ------------------------- -->
</body>
</html>
