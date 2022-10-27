<?php
  	error_reporting(0);
  	ini_set(“display_errors”, 0 );
	include('database.php');					//Seleciona banco de dados
  
	$email = $mysqli->real_escape_string($_POST['email']);	//Pegando dados passados por AJAX
  
	if ($result = $mysqli->query("SELECT uEmail FROM ucp_users WHERE uEmail='".$email."' LIMIT 1")) {
    	if($result->num_rows == 0)
			echo 0; // Email não está sendo utilizado.
		else
			echo 1; // Email está sendo utilizado
    	$result->close();
	}
?>