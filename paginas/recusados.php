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
                    <h2>Minhas aplicações recusadas</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.php">Home</a>
                        </li>
                        <li>
                        Minhas aplicações
                        </li>
                        <li>
                            <strong>APPs Recusadas</strong>
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
			$quant_pers = "SELECT * FROM characters WHERE Username='$charname' AND status != '3'";
			$result_quant_pers = mysql_query($quant_pers)or die (mysql_error());
			if(mysql_num_rows($result_quant_pers) < 5)
			{
				$query_search = "SELECT * FROM characters WHERE Username='$charname' AND status <= '1'  ";
			        $result_ser = mysql_query($query_search)or die (mysql_error());
			        if(mysql_num_rows($result_ser) > 0)
			        {
			        	?>
			        	<div class="col-lg-3" style="float:right;">
						<div class="ibox">
	                    				<button type="submit" class="btn btn-primary block full-width m-b" title="Você já tem uma Aplicação aceita ou aguardando revisão" disabled>Enviar uma nova Aplicação</button>
										
						</div>
						</div>
			        	<?php
			        	$FoiAceitoJa = 1;
			        }
			        else
			        {
			              $FoiAceitoJa = 0;
			                                                	?>
									
                        	
				<?php } }
				
				if($_GET['acao'] == 'novaapp')
				{
					?>
					<form id="form" name="form" action="recusados.php?acao=sendapp" class="wizard-big" method="post">
					<h1>Criando uma nova APP</h1>
	                                <fieldset>
	                                	<div class="row">
	                                    	<div class="col-lg-8">
	                                    		<h2>Informações do personagem</h2>
	                                            <div class="form-group">
	                                                <label>Nome do personagem * <font size="-8">( Nome_Sobrenome )</font></label>
	                                                <input id="persName" name="persName" type="text" class="form-control required">
	                                            </div>
	                                            <div class="form-group">
	                                            	<label>Gênero</label>
													
	                                                	<select class="form-control m-b" name="genero" id="genero">
	                                                        <option value="1">Masculino</option>
	                                                        <option value="2">Feminino</option>
	                                                    </select>
	                                            </div>
	                                            <div class="form-group" id="data_1">
	                                                <label>Idade</label>
	                                                <div class="input-group date">
	                                                    <span class="input-group-addon"></span><input id="Age" name="Age" type="text" class="form-control" value="18 (Use somente numeros)">
	                                                </div>
	                                            </div>
	                                            <div class="form-group">
	                                                <label>Onde seu personagem nasceu? *</label>
	                                                <input id="local-nasc" name="local-nasc" type="text" class="form-control required">
	                                            </div>
	                                            <div class="form-group">
	                                                <label>Conte-nos a história de seu personagem. Pelo menos dois parágrafos *</label>
	                                                <textarea id="hist-pers" name="hist-pers" class="form-control required" style="min-height:150px;"></textarea>
	                                            </div>
	                                            <div style="border-bottom:3px solid #E5E5E5; margin-bottom:12px;"></div>
	                                            <h2>- Perguntas OOC -</h2>
	                                            <div class="form-group">
	                                                <label>Defina Roleplay *</label>
	                                                <textarea id="def-rol" name="def-rol" class="form-control required"></textarea>
	                                            </div>
	                                            <div class="form-group">
	                                                <label>O que é Metagaming? Dê três exemplos. *</label>
	                                                <textarea id="def-mg" name="def-mg" class="form-control required"></textarea>
	                                            </div>
	                                            <div class="form-group">
	                                                <label>Quando você pode matar outro jogador? Dê três exemplos. *</label>
	                                                <textarea id="def-matar" name="def-matar" class="form-control required"></textarea>
	                                            </div>
	                                            <div class="form-group">
	                                                <label>O que é Fear RP? Dê três exemplos. *</label>
	                                                <textarea id="def-fear" name="def-fear" class="form-control required"></textarea>
	                                            </div>
	                                            <div class="form-group">
	                                                <label>O que é Powergaming? Cite três exemplos. *</label>
	                                                <textarea id="def-pg" name="def-pg" class="form-control required"></textarea>
	                                            </div>
	                                            <div class="form-group">
	                                                <label>O que é IC e OOC? Cite três exemplos de cada. *</label>
	                                                <textarea id="def-ioc" name="def-ioc" class="form-control required"></textarea>
	                                            </div>
	                                        </div>
	                                        
	                                        
					
	                                	</div>
	                                <div class="col-lg-12" style="float:right;">
					<div class="ibox">
	                    			<button type="submit" class="btn btn-primary block full-width m-b">Enviar Aplicação</button>					
					</div>
					</div>
	                                </fieldset>
	                                
	                                </form>
					<?php
				}
				else if($_GET['acao'] == 'sendapp')
				{
					
					if(isset($_POST['def-rol']))
					 $rp=mysql_escape_string($_POST['def-rol']);
					if(isset($_POST['def-mg']))
					 $mg=mysql_escape_string($_POST['def-mg']);
					if(isset($_POST['def-matar']))
					 $kill=mysql_escape_string($_POST['def-matar']);
					if(isset($_POST['def-fear']))
					 $fear=mysql_escape_string($_POST['def-fear']);
					if(isset($_POST['def-ioc']))
					 $ioc=mysql_escape_string($_POST['def-ioc']);
					if(isset($_POST['def-pg']))
					 $fpg=mysql_escape_string($_POST['def-pg']);
					
					if(isset($_POST['persName']))
					 $persName=mysql_escape_string($_POST['persName']);
					if(isset($_POST['genero']))
					 $genero=mysql_escape_string($_POST['genero']);
					if(isset($_POST['Age']))
					 $nascdate=mysql_escape_string($_POST['Age']);
					if(isset($_POST['local-nasc']))
					 $localnasc=mysql_escape_string($_POST['local-nasc']);
					if(isset($_POST['hist-pers']))
					 $histper=mysql_escape_string($_POST['hist-pers']);
					 
					if(!$rp || !$mg || !$kill || !$fear || !$ioc || !$fpg || !$charname || !$genero || !$nascdate || !$localnasc || !$histper)
					{
						echo "Você deixou alguma questão em branco..";
					}
					else
					{
						$date1 = date('m/d/Y h:i:s a', time());
						//Consulta no banco de dados 
						$date = new DateTime();
						$timestamp = $date->getTimestamp();
						$checar_se_pers_existe ="SELECT * FROM `characters` WHERE `Charname` = '".$persName."' AND status != '3'"; 
				  		$resultados_p = mysql_query($checar_se_pers_existe)or die (mysql_error());
					  	if (mysql_num_rows($resultados_p) == 0)
						{
							$sql2="INSERT INTO characters (Username,Charname,Gender,Age,Origin,status,CreateDate,Skin) VALUES ('$charname','$persName','$genero','$nascdate','$localnasc','0','$timestamp','7')"; 
							mysql_query($sql2)or die (mysql_error("Deu ruim 1"));
							$own = mysql_insert_id();
							
							$sql_app="INSERT INTO ucp_aplic (OwnId,def_rol, avaliado) VALUES ('$own','$rp','0')";
							mysql_query($sql_app)or die (mysql_error("Deu ruim 2"));
							
							$sql_app2="UPDATE ucp_aplic SET def_mg='$mg', def_matar='$kill' WHERE OwnId = '$own'"; 
							mysql_query($sql_app2)or die (mysql_error("Deu ruim 3"));
							
							$sql_app3="UPDATE ucp_aplic SET def_fear='$fear', def_ioc='$ioc', histpers='$histper' WHERE OwnId = '$own'"; 
							mysql_query($sql_app3)or die (mysql_error("Deu ruim 4"));
							
							$sql_app4="UPDATE ucp_aplic SET def_pg='$fpg' WHERE OwnId = '$own'"; 
							mysql_query($sql_app4)or die (mysql_error("Deu ruim 5"));
							
							$timestaaaamp = time();
							$sql_app5="INSERT INTO ucp_notific (OwnId,icon,text,timestamp,visto) VALUES('$ACCID','user','Bem vindo a UCP do 90:RP','$timestaaaamp','0')"; 
							mysql_query($sql_app5)or die (mysql_error("Deu ruim 6"));
					
							echo "<center>Aplicação enviada, aguarde até que um administrador possa revisa-la.</center>";
						}
						else
						{
							?>
							<center>
							<div class="col-lg-12">
							<div class="ibox btn-danger"><br><h3>Este nome de personagem já está em uso.</h3><br></div>
							</div>
							</center>
							
							</hr>
							
							<form id="form" name="form" action="recusados.php?acao=sendapp" class="wizard-big" method="post">
							<h1>Criando uma nova APP</h1>
			                                <fieldset>
			                                	<div class="row">
			                                    	<div class="col-lg-8">
			                                    		<h2>Informações do personagem</h2>
			                                            <div class="form-group">
			                                                <label>Nome do personagem * <font size="-8">( Nome_Sobrenome )</font></label>
			                                                <input id="persName" name="persName" type="text" class="form-control required" value="<?=$persName;?>" >
			                                            </div>
			                                            <div class="form-group">
			                                            	<label>Gênero</label>
															
			                                                	<select class="form-control m-b" name="genero" id="genero">
			                                                        <option value="1">Masculino</option>
			                                                        <option value="2">Feminino</option>
			                                                    </select>
			                                            </div>
			                                            <div class="form-group" id="data_1">
			                                                <label>Data de Nascimento</label>
			                                                <div class="input-group date">
			                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="Age" name="Age" type="text" class="form-control" value="<?=$nascdate;?>">
			                                                </div>
			                                            </div>
			                                            <div class="form-group">
			                                                <label>Onde seu personagem nasceu? *</label>
			                                                <input id="local-nasc" name="local-nasc" type="text" class="form-control required" value="<?=$localnasc;?>" >
			                                            </div>
			                                            <div class="form-group">
			                                                <label>Conte-nos a história de seu personagem. Pelo menos dois parágrafos *</label>
			                                                <textarea id="hist-pers" name="hist-pers" class="form-control required" style="min-height:150px;"><?=$histper;?></textarea>
			                                            </div>
			                                            <div style="border-bottom:3px solid #E5E5E5; margin-bottom:12px;"></div>
			                                            <h2>- Perguntas OOC -</h2>
			                                            <div class="form-group">
			                                                <label>Defina Roleplay *</label>
			                                                <textarea id="def-rol" name="def-rol" class="form-control required"><?=$rp;?></textarea>
			                                            </div>
			                                            <div class="form-group">
			                                                <label>O que é Metagaming? Dê três exemplos. *</label>
			                                                <textarea id="def-mg" name="def-mg" class="form-control required"><?=$mg;?></textarea>
			                                            </div>
			                                            <div class="form-group">
			                                                <label>Quando você pode matar outro jogador? Dê três exemplos. *</label>
			                                                <textarea id="def-matar" name="def-matar" class="form-control required"><?=$kill;?></textarea>
			                                            </div>
			                                            <div class="form-group">
			                                                <label>O que é Fear RP? Dê três exemplos. *</label>
			                                                <textarea id="def-fear" name="def-fear" class="form-control required"><?=$fear;?></textarea>
			                                            </div>
			                                            <div class="form-group">
			                                                <label>O que é Powergaming? Cite três exemplos. *</label>
			                                                <textarea id="def-pg" name="def-pg" class="form-control required"><?=$fpg;?></textarea>
			                                            </div>
			                                            <div class="form-group">
			                                                <label>O que é IC e OOC? Cite três exemplos de cada. *</label>
			                                                <textarea id="def-ioc" name="def-ioc" class="form-control required"><?=$ioc;?></textarea>
			                                            </div>
			                                        </div>
			                                        
			                                        
							
			                                	</div>
			                                <div class="col-lg-12" style="float:right;">
							<div class="ibox">
			                    			<button type="submit" class="btn btn-primary block full-width m-b">Enviar Aplicação</button>					
							</div>
							</div>
			                                </fieldset>
			                                
			                                </form>
							<?php
						}
					}
				}	
				else
				{
					if($FoiAceitoJa == 0)
					{
						?>
						<div class="col-lg-3" style="float:right;">
						<div class="ibox">
	                    				<a href="recusados.php?acao=novaapp"><button type="submit" class="btn btn-primary block full-width m-b">Enviar uma nova Aplicação</button></a>
										
						</div>
						</div>
						<?php
					}
				?>
                            <h2>Aplicações</h2>
                            <p>
                                Confira o seu histórico de aplicações recusadas.
                            </p>
                            
                            <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <tbody>
                                                <tr style="text-align:center;">
                                                    <td><b>Nome do Personagem</b></td>
                                                    <td><b>Tipo</b></td>
                                                    <td><b>Origem do Personagem</b></td>
                                                    <td><b>Vizualizar APP</b></td>
                                                </tr>
                                            	
                                                
                                                <?php
                                                $query_search = "SELECT * FROM characters WHERE Username='".$_SESSION['nomeUsuario']."' AND status='3' ORDER BY id DESC ";
                                                $result_ser = mysql_query($query_search)or die (mysql_error());
                                                while($resh=mysql_fetch_array($result_ser))
                                                {
                                                	$query_searchapp = "SELECT * FROM ucp_aplic WHERE OwnId='".$resh['ID']."'";
                                                	$result_serapp = mysql_query($query_searchapp)or die (mysql_error());
                                                	$reshapp=mysql_fetch_array($result_serapp);
						?>
						
                                                <tr style="text-align:center;">
                                                
                                                    <td><?=str_replace("_"," ", $resh['Charname']);?></td>
                                                    <td><?php if($reshapp['novopers']) echo "Personagem";
                                                    	else echo "Aplicação";
                                                    ?></td>
                                                    <td><?=$resh['Origin']?></td>
                                                    <td><a href="verapp.php?id=<?=$resh['ID']?>" class="client-link"><i class="fa fa-eye"></i></a></td>
                                                    
                                                </tr>
                                                
                                                <?php } ?>
                                                </tbody>
                                            </table>
                            
                            
                            
                            
                            
                            

                        </div>
                        
                        <?php
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