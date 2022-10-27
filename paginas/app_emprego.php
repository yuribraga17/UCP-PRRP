<?php
session_start(); 	//A seção deve ser iniciada em todas as páginas
if (!isset($_SESSION['usuarioID'])) 
{		//Verifica se há seções
	session_destroy();						//Destroi a seção por segurança
	header("Location: login.php"); exit;	//Redireciona o visitante para login
}

include('func/database.php');

$query_check_acc = "SELECT * FROM accounts WHERE id='".$_SESSION['usuarioID']."' LIMIT 1";
$result_check_acc = mysql_query($query_check_acc)or die (mysql_error());
$row_check=mysql_fetch_array($result_check_acc);

if($row_check['admin'] >= 0){ 
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>UCP | Progressive Roleplay</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">



</head>

<body>

    <div id="wrapper">

     <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element"> <span>
                            
                             </span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs">
                            <img src="http://localhost/ucp/img/logo-90.png" height="72" width="152">
                             </span> </span> </a>
                           
                        </div>
                    </li>
                    <?php include('menu.php'); ?>
                </ul>

            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <span class="m-r-sm text-muted welcome-message">Olá <?=$_SESSION['nomeUsuario'];?>, bem vindo ao User Control Panel.</span>
                </li>
                <?php include('func/notifics.php'); ?>


                <li>
                    <a href="deslogar.php">
                        <i class="fa fa-sign-out"></i> Deslogar
                    </a>
                </li>
            </ul>

        </nav>
        </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Minhas aplicações de Emprego</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.php">Home</a>
                        </li>
                        <li>
                        Minhas aplicações
                        </li>
                        <li>
                            <strong>Empregos</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content  animated fadeInRight">
            <div class="row">
                <div class="col-sm-12">
                    <div class="ibox">
                        <div class="ibox-content">
                        
                        <?php
                        $charname = $_SESSION['nomeUsuario'];
                        $quant_pers = "SELECT * FROM characters WHERE Username='$charname' AND status = '1'";
			$result_quant_pers = mysql_query($quant_pers)or die (mysql_error());
			if(mysql_num_rows($result_quant_pers) > 0)
			{
			
				if($_GET['acao'] == 'novaapp')
				{
					?>
					<form id="form" name="form" action="app_emprego.php?acao=sendapp" class="wizard-big" method="post">
					<h1>Aplicando-se para um emprego</h1>
	                                <fieldset>
	                                	<div class="row">
	                                    	<div class="col-lg-8">
	                                    		<h2>Informações Gerais</h2>
	                                    		
	                                    		
	                                            <div class="form-group">
	                                                <label>Selecione o Personagem</label>
	                                                <select class="form-control m-b" name="personagem" id="personagem">
	                                                	<?php
	                                                	while($reshapp=mysql_fetch_array($result_quant_pers))
	                                                	{
	                                                		$charid = $reshapp["ID"];
	                                                		$charName = $reshapp["Charname"];
	                                                		?>
	                                                		<option value="<?=$charid;?>"><?=$charName;?></option>
	                                                		<?php
	                                                	}
	                                                	?>
	                                                </select>
	                                            </div>
	                                            <div class="form-group">
	                                                <label>Selecione o emprego</label>
	                                                <select class="form-control m-b" name="emprego" id="emprego">
	                                                	<option value="30">Fabricante de Armas (Min: 100hrs jogadas)</option>
	                                                </select>
	                                            </div>
	                                            <div style="border-bottom:3px solid #E5E5E5; margin-bottom:12px;"></div>
	                                            <div class="col-lg-12" style="float:right;">
							<div class="ibox">
		                    				<button type="submit" class="btn btn-primary block full-width m-b">Prosseguir >></button>					
							</div>
						    </div>
	                                        
	                                
	                                </fieldset>
	                                
	                                </form>
	                                <?php
				}
				else if($_GET['acao'] == 'sendapp')
				{
					$personagem = mysql_escape_string($_POST['personagem']);
					$emprego = mysql_escape_string($_POST['emprego']);
					//=================================================
					$pers_load = "SELECT * FROM characters WHERE ID='$personagem' AND status = '1' LIMIT 1";
					$result_pers_load = mysql_query($pers_load)or die (mysql_error());
					$res_pers_load=mysql_fetch_array($result_pers_load);
					//=================================================
					switch($emprego)
					{
						case 30: $emprego_n = "Fabricante de Armas";
					}
					?>
					<form id="form" name="form" action="app_emprego.php?acao=finalize" class="wizard-big" method="post">
					<h1>Aplicando-se para um emprego</h1>
	                                <fieldset>
	                                	<div class="row">
	                                    	<div class="col-lg-8">
	                                    		<h2>Informações Gerais</h2>
	                                    		
	                                    		
	                                            <div class="form-group">
	                                                <label>Personagem Selecionado</label>
	                                                <input class="form-control m-b" value="<?=$res_pers_load['Charname'];?>" disabled>
	                                            </div>
	                                            <div class="form-group">
	                                                <label>Emprego selecionado</label>
	                                                <input class="form-control m-b" value="<?=$emprego_n;?>" disabled>
	                                            </div>
	                                            <div style="border-bottom:3px solid #E5E5E5; margin-bottom:12px;"></div>
	                                            <?php
	                                            //====== [ Fabricante de Armas ] ======
	                                            if($emprego == 30)
	                                            {
	                                            	?>
	                                            	<div class="form-group">
	                                                	<label>Por que você acredita ter capacidade para ser um Fabricante/Vendedor de Armas? *</label>
	                                                	<textarea id="quest1" name="quest1" class="form-control required"></textarea>
	                                            	</div>
	                                            	FORMULÁRIO EM CONSTRUÇÃO.
	                                            	<?php
	                                            }
	                                            ?>
	                                            <div style="border-bottom:3px solid #E5E5E5; margin-bottom:12px;"></div>
	                                            <div class="col-lg-12" style="float:right;">
							<div class="ibox">
		                    				<button type="submit" class="btn btn-primary block full-width m-b">Prosseguir >></button>					
							</div>
						    </div>
	                                        
	                                
	                                </fieldset>
	                                
	                                </form>
	                                <?php
				}
				else
				{
				?>
				
				<div class="col-lg-3" style="float:right;">
				<div class="ibox">
	                    		<a href="app_emprego.php?acao=novaapp"><button type="submit" class="btn btn-primary block full-width m-b">Enviar uma nova Aplicação</button></a>
										
				</div>
				</div>
				<h1>EM CONSTRUÇÃO.</h1>
                        	<h2>Aplicações de Empregos</h2>
                            	<p>
                                	Confira o seu histórico e status de aplicações de empregos.
                            	</p>
                            
                            	<div class="table-responsive">
                                	<table class="table table-striped table-hover">
                                            <tbody>
                                                <tr style="text-align:center;">
                                                    <td><b>Nome do Personagem</b></td>
                                                    <td><b>Emprego</b></td>
                                                    <td><b>Status</b></td>
                                                    <td><b>Vizualizar APP</b></td>
                                                </tr>
                                            	<?php
                                                $query_searchapp = "SELECT * FROM ucp_app_wep WHERE accOwn='$charname'";
                                                $result_serapp = mysql_query($query_searchapp)or die (mysql_error());
                                                while($reshapp=mysql_fetch_array($result_serapp))
                                                {
                                                	$charID = $reshapp['OwnId'];
                                                	$checar_se_pers_existe ="SELECT * FROM `characters` WHERE `ID` = '$charID' AND status != '3'"; 
				  			$resultados_p = mysql_query($checar_se_pers_existe)or die (mysql_error());
					  		$resh_char=mysql_fetch_array($resh_char);
						?>
						
                                                <tr style="text-align:center;">
                                                
                                                    <td><?=str_replace("_"," ", $resh_char['Charname']);?></td>
                                                    <td>
                                                    	<?php 
                                                    	switch($reshapp['jobid'])
                                                    	{
                                                    		case 30: echo "Fabricante de Armas"; break;
                                                    		case 40: echo "Fabricante de Drogas"; break;
                                                    	}
                                                    	
                                                    ?></td>
                                                    <td>
                                                    <?php 
                                                    	switch($reshapp['avaliado'])
                                                    	{
                                                    		case 0: echo "Em avaliação"; break;
                                                    		case 1: echo "Aceito"; break;
                                                    		case 2: echo "Recusado"; break;
                                                    	}
                                                    	
                                                    ?></td>
                                                    <td><a href="verapp.php?id=<?=$resh['ID']?>" class="client-link"><i class="fa fa-eye"></i></a></td>
                                                    
                                                </tr>
                                                
                                                <?php } ?>
                                     		</tbody>
	                        	</table>
                        	</div>
                        <?php
                        	}
                        }
                        else
                        {
                        	echo "<center><h2>Você não tem nenhum personagem aceito... Tente <a href='criar.php'>criar um personagem</a> antes.<br>:(</h2></center>";
                        }
                        ?>
                        
  
                        </div>
                    </div>
                    
                </div>
                
            </div>
            <?php include('ads.php'); ?>
            </div>
           
       
       	
        <div class="footer">
            <div>
                <?=$footer;?>
            </div>
        </div>
        </div>
        </div>



    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Jquery Validate -->
    <script src="js/plugins/validate/jquery.validate.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

</body>
</html>
<?php 
}
else { header("Location: index.php"); exit;	} //Redireciona o visitante para login
?>