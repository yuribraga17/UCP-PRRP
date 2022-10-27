<?php
  error_reporting(0);
  ini_set(“display_errors”, 0 );
include('database.php');


$id = strip_tags($_POST['id']);
$idd = $mysqli->real_escape_string($id);
echo $idd;
$mysqli->query("UPDATE ucp_notific SET visto = '1' WHERE id='".$idd."'");
?>