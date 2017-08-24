<?php
error_reporting(0);
session_start();
$_SESSION = [];
session_destroy();
$redir = '<meta http-equiv="refresh" content="5; url=index.php" />';
$msg = '<h6><br/><center>Anda telah logout!<br /><a class="button button-primary" href="index.php" >&laquo; Login Kembali</a></center></h6>';

?>
<html lang="en">
<head>

  <!-- Basic Page Needs
  ------------------------- -->
  <meta charset="utf-8">
  <title>XL m-Ads :: Admin</title>
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Mobile Specific Metas
  ------------------------- -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php echo $redir;?>
  <!-- FONT
  ------------------------- -->
  <!--link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css"-->

  <!-- CSS
  ------------------------- -->
  <link rel="stylesheet" href="normalize.css">
  <link rel="stylesheet" href="skeleton.css">

  <!-- Favicon
  ------------------------- -->
  <link rel="icon" type="image/png" href="favicon.png">

</head>
<body>
<?php echo $msg;?>
<!-- End Document
  ------------------------- -->
</body>
</html>