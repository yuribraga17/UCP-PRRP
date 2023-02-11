<?php
session_start();

//error_reporting(1);
//ini_set(“display_errors”, 1);

$ambiente = 1; // 1 - Produção / 2 - Teste
if($ambiente == 1){
	$mysqli = new mysqli("135.148.211.180","root","0m7cBK36T4","prrpoficial");
	$url_base = "https://progressive-roleplay.com";
}
else {
	$mysqli = new mysqli("135.148.211.180","root","0m7cBK36T4","prrpoficial");
	$url_base = "https://progressive-roleplay.com";
}

/* check connection */
if ($mysqli->connect_errno) {
    printf("Falha na conexão com o banco de dados: %s\n", $mysqli->connect_error);
	printf("<br>Caso persista, contate um administrador.");
    exit();
}


date_default_timezone_set('America/Sao_Paulo');


//Spawn Config - Registro
$Pos_x = 1719.6923;
$Pos_y = -1948.6207;
$Pos_z = 13.1407;

$Skin_Registro = 124;
	
$footer = "<strong>Copyright</strong> PR:RP &copy; 2018~2023";

//Estilo
$cor_linha_menu = '#36393E';

//======================================
// Checar se o player está logado já
//======================================
if (!isset($_SESSION['usuarioID'])) {
	if(isset($_GET["p"])){
		$page = $_GET["p"];
	}
	if ($page == 'registro'){
		include('paginas/registro.php');
	}
	else{
		include('paginas/login.php');
	}
}
?>