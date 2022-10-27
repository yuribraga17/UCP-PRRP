<?php
  include('func/database.php');
  //Seleciona banco de dados
  
  $login=mysql_escape_string($_POST['user_id']);	//Pegando dados passados por AJAX
  
  //Consulta no banco de dados
  $sql="select * from avisos_ucp where user_id ='".$login."'"; 
  $resultados = mysql_query($sql)or die (mysql_error());
  $res=mysql_fetch_array($resultados); //
	if (@mysql_num_rows($resultados) == 0){
		echo 0;	//Se a consulta não retornar nada é porque as credenciais estão erradas
	}
	
	else{
		echo 1;	//Responde sucesso
		
		exit;	
	}
?>