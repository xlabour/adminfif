<?php
$dblink = mysqli_connect($DB_HOST, $DB_USERNAME, $DB_PASSWORD) or die('Could not connect: ' . mysqli_error($dblink));
mysqli_select_db($dblink, $DB_NAME) or die(mysqli_error($dblink));
?>
