<?php
	error_reporting(0);
	ini_set(“display_errors”, 0 );
  	include('database.php');					//Seleciona banco de dados
  
  	$login = $mysqli->real_escape_string($_POST['charname']);	//Pegando dados passados por AJAX
  
	$base1 = 0;
	$base2 = 0;

	if ($result = $mysqli->query("SELECT Username FROM accounts WHERE Username='".$login."' LIMIT 1")) {
    	$base1 = $result->num_rows;
    	$result->close();
	}
	if ($result = $mysqli->query("SELECT Charname FROM ucp_aplic WHERE Charname='".$login."' LIMIT 1")) {
    	$base2 = $result->num_rows;
    	$result->close();
	}

	if ($base1 == 0 && $base2 == 0)
		echo 0; // O nome não está em uso
	else
		echo 1; // Já existe um personagem com este nome
	
?>