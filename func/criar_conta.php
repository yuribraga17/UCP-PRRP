<?php 
    include('database.php');					//Seleciona banco de dados
  
  
  	function get_ip() {
		//Just get the headers if we can or else use the SERVER global
		if ( function_exists( 'apache_request_headers' ) ) {
			$headers = apache_request_headers();
		} else {
			$headers = $_SERVER;
		}
		//Get the forwarded IP if it exists
		if ( array_key_exists( 'X-Forwarded-For', $headers ) && filter_var( $headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) {
			$the_ip = $headers['X-Forwarded-For'];
		} elseif ( array_key_exists( 'HTTP_X_FORWARDED_FOR', $headers ) && filter_var( $headers['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 )
		) {
			$the_ip = $headers['HTTP_X_FORWARDED_FOR'];
		} else {
			
			$the_ip = filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 );
		}
		return $the_ip;
	}
	@$charname2=mysql_escape_string($_POST['charname']);
  	if(empty($charname2))
	{
		$login=mysql_escape_string($_POST['login']);	//Pegando dados passados por AJAX
		$senha=mysql_escape_string($_POST['senha']);
		$email=mysql_escape_string($_POST['email']);
		$hashedPassword = strtoupper(hash( 'whirlpool',$senha));  
		$date1 = date('m/d/Y h:i:s a', time());
		//Consulta no banco de dados 
		$date = new DateTime();
		$timestamp = $date->getTimestamp();
		$http_client_ip = get_ip();
		
		$sql1="INSERT INTO ucp_users (uNome,uSenha,uRegisterDate,uIP,uEmail) VALUES ('".$login."','".$hashedPassword."','".$date1."','".$http_client_ip."','".$email."')"; 
		mysql_query($sql1)or die (mysql_error());
		
		if($sql1) echo mysql_insert_id();
		else echo "0";
	}
	else
	{
		@$rp=mysql_escape_string($_POST['rp']);
		@$mg=mysql_escape_string($_POST['mg']);
		@$kill=mysql_escape_string($_POST['kill']);
		@$fear=mysql_escape_string($_POST['fear']);
		@$ioc=mysql_escape_string($_POST['ioc']);
		@$own=mysql_escape_string($_POST['own']);
		
		@$login=mysql_escape_string($_POST['login']);
		@$charname=mysql_escape_string($_POST['charname']);	//Pegando dados passados por AJAX
		@$genero=mysql_escape_string($_POST['genero']);
		@$nascdate=mysql_escape_string($_POST['Age']);
		@$localnasc=mysql_escape_string($_POST['localnasc']);
		@$histper=mysql_escape_string($_POST['histpers']);
		
  		if(!empty($rp))
		{
			$sql_app="INSERT INTO ucp_aplic (OwnId,def-rol, avaliado) VALUES ('$own','$rp','0')";
  			mysql_query($sql_app)or die (mysql_error());
			if($sql_app) echo "1";
			else echo"0";
		}
		if(!empty($mg))
		{
			$sql_app2="UPDATE ucp_aplic SET def-mg='$mg', def-matar='$kill' WHERE OwnId = '$own'"; 
  			mysql_query($sql_app2)or die (mysql_error());
			if($sql_app2) echo "1";
			else echo"0";
		}
		if(empty($fear))
		{
			$sql_app3="UPDATE ucp_aplic SET def-fear='$fear', def-ioc='$ioc', histpers='$histper' WHERE OwnId = '$own'"; 
  			mysql_query($sql_app3)or die (mysql_error());
			if($sql_app3) echo "1";
			else echo"0";
		}
		if(empty($histpers))
		{
			$sql2="INSERT INTO accounts_ucp (Username,Charname,Skin,Gender,Age,Origin) VALUES ('$login','$charname','29','$genero','$nascdate','$localnasc')"; 
			mysql_query($sql2)or die (mysql_error());
			if($sql2) echo "1";	
			else echo "2";
		}
		
	}
?>