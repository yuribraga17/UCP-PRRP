<?php
	error_reporting(0);
  	ini_set(“display_errors”, 0 );

  	include('database.php');					//Seleciona banco de dados

  	$login = $mysqli->real_escape_string($_POST['login']);	//Pegando dados passados por AJAX
  	$senha = $mysqli->real_escape_string($_POST['senha']);
	$hashedPassword = strtoupper(hash( 'whirlpool',$senha)); 

  	//Consulta no banco de dados 
	$result = $mysqli->query("SELECT uID,uNome,uSenha FROM ucp_users WHERE uNome='".$login."' AND uSenha='".$hashedPassword."' LIMIT 1");
	$count = $result->num_rows;
	
	if($count == 1){
		$row = $result->fetch_array();

		if($hashedPassword == $row['uSenha'])
		{
			session_start();


			$_SESSION['usuarioID'] = $row['uID'];
			$_SESSION['nomeUsuario'] = $row['uNome'];
			echo 1;
		}
		else 
			echo 0;
	}
	else
		echo 0;
		
	$mysqli->close();
?>