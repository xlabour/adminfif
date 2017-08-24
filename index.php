<?php

error_reporting(0);
session_start();

if (isset($_SESSION['username']) && $_SESSION['username']!=''){
	header("Location: ./admin.php");
	exit();
}

include ('./config.inc.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  ------------------------- -->
  <meta charset="utf-8">
  <title><?php echo $WEB_TITLE;?></title>
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

  </script>
</head>
<body>

<!-- Primary Page Layout
------------------------- -->
<div class="container">
	<div class="row">
		<center>
			<div class="column" style="margin-top: 3%">
				<div style="position:relative; overflow: show">
					<br /><br />
					<h6 style="color:#777; font-weight:bold;">Login:</h6>
					<form action="./login.php" method="post">
						<input type="text" name="username" value="" placeholder="Username" autocomplete="off"  autofocus/><br />
						<input type="password" name="password" value="" placeholder="Password" autocomplete="off" /><br />
						<input type="Submit" name="submit" id="submit" value="Login" class="button button-primary"/>
					</form>
				</div>
			</div>
		</center>
	</div>
</div>

<!-- End Document
  ------------------------- -->
</body>
</html>