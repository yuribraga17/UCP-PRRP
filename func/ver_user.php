<?php
  	include('database.php');					//Seleciona banco de dados
  
  	$login = $mysqli->real_escape_string($_POST['login']);	//Pegando dados passados por AJAX
  
  	//Consulta no banco de dados 
	if ($result = $mysqli->query("SELECT uNome FROM ucp_users WHERE uNome='".$login."' LIMIT 1")) {
    	if($result->num_rows == 0)
			echo 0;	// Se retornar zero, é por que está errado.
		else
			echo 1;// Se retornar 1, é por que logou-se.
		
    	$result->close();
	}
?>