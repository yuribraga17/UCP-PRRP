<?php
session_start(); 	//A seção deve ser iniciada em todas as páginas
if (!isset($_SESSION['usuarioID'])) 
{		//Verifica se há seções
	session_destroy();						//Destroi a seção por segurança
	header("Location: login.php"); exit;	//Redireciona o visitante para login
}

include('func/database.php');
include('func/skins_grupos.php');

if (isset($_GET['char'])) 
{
	$p_id = $_GET['char'];
	$pers_stats = 0;

	$sql="select * from characters where ID='".$p_id."'"; 
	$resultados = mysql_query($sql)or die (mysql_error());
	$res=mysql_fetch_array($resultados); //
	if (@mysql_num_rows($resultados) == 0) $pers_stats = 0;
	else
	{
		if($res['Username'] == $_SESSION['nomeUsuario'])
			$pers_stats = 1;
	}
}
else
{
	header("Location: index.php"); exit;
}
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

    <!-- Gritter -->
    <link href="js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

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

        <div id="page-wrapper" class="gray-bg dashbard-1">
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
                
        <div class="row">
            <div class="col-lg-12">
                <div class="wrapper wrapper-content">
                        <div class="row">
                        	
                        	<?php 
								if($pers_stats == 0)
								{
									?>
				                                        <div class="ibox float-e-margins ">
				                                            
				                                                <div style="text-align:center;">
				                                                    <h4>
				                                                    Você não pode vizualizar personagens que não lhe pertencem!
				                                                    </h4><br/>
				                                                    <font size="+4">:(</font>
				                                                </div>
				                                          </div>
									<?php
								}
								else
								{
								
									if(isset($_GET['char']) && isset($_GET['skin']))
									{
										$charid = $_GET['char'];
										$skinid = $_GET['skin'];
										
										$SkinAlterada = 0;
										
										if(in_array($skinid,$SkinsCivis))
										{
											$sqlskin = "UPDATE characters SET skin = '".$skinid."' WHERE ID= '".$charid."'"; 
											$result_sqlskin = mysql_query($sqlskin)or die (mysql_error());
											
											$SkinAlterada = 1;
										}
										
										if($SkinAlterada == 1)
										{
											echo "<center>Skin Alterada com sucesso.</center>";
											?>
											<meta HTTP-EQUIV='Refresh' CONTENT='1;URL=personagem.php?pers=<?=$charid;?>'>
											<?php
										}
										else
										{
											echo "<center>Ocorreu um erro durante a troca de skin, casos persistir, contate com a Development Team.</center>";
										}
									}
									else
									{
								?>
								<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
								<script>
								$(document).ready(function(){
								    $("#MulherShow").click(function(){
								    	$("#DivMulher").show();
								    	$("#DivHomem").hide();
								    	$("#DivGangster").hide();
								    });
								    $("#HomemShow").click(function(){
								    	$("#DivHomem").show(); 
								    	$("#DivGangster").hide();
								    	$("#DivMulher").hide();
								    		
								    });
								    $("#GangstersShow").click(function(){
								    	$("#DivHomem").hide(); 
								    	$("#DivMulher").hide();
								    	$("#DivGangster").show();
								    		
								    });
								});
								</script>
								
								
								<div class="col col-lg-12" style="text-align:center;">
									<div class="col col-lg-3">
										<button id="MulherShow" class="btn btn-danger block full-width m-b" style="background-color:#ED008C; border:#ED008C;">Mulher</button>
									</div>
									<div class="col col-lg-3">
										<button id="HomemShow" class="btn btn-primary block full-width m-b" style="background-color:#00ADEF; border:#00ADEF; ">Homem</button>
									</div>
								</div>
								<div class="col col-lg-12" style="text-align:center;">
									<div class="col col-lg-3">
										<button id="GangstersShow" class="btn btn-danger block full-width m-b" style="background-color:#444444; border:#444444;">Gangsters</button>
									</div>
									
								</div>
								<div class="col col-lg-12" style="text-align:center;">
									<hr>
								</div>
								
								<style>
								.img-skin {
									height: 105px;
									width: 85px;
									z-index:9;
								}
								</style>
								
								<div id="DivHomem" hidden>
								<div style="text-align:center">Clique sobre uma skin para seleciona-la.<br><br></div>
								
								<?php
								
								for($count = 1; $count < 312; $count++)
								{
								
									if(in_array($count,$SkinIsMen))
									{
								?>
									
								
									<div class="col col-lg-1">
										<form id="form" name="form" action="skin.php?char=<?=$p_id;?>&skin=<?=$count;?>" class="wizard-big" method="post">
										<button type="submit" class="img-skin" style="
											background-image: url('img/skins/<?=$count;?>.png');
											background-size:80px 100px;
											margin-right:5px;
											margin-top:5px;
											" title="Skin <?=$count;?>"></button>
										</form>
									</div>
								<?php
									}
								}
								?>
								</div>	
								
								<!--  -->
								<div id="DivGangster" hidden>
								<div style="text-align:center">Clique sobre uma skin para seleciona-la.<br><br></div>
								
								<?php
								
								for($count = 1; $count < 312; $count++)
								{
								
									if(in_array($count,$SkinsGangster))
									{
								?>
									
								
									<div class="col col-lg-1">
										<form id="form" name="form" action="skin.php?char=<?=$p_id;?>&skin=<?=$count;?>" class="wizard-big" method="post">
										<button type="submit" class="img-skin" style="
											background-image: url('img/skins/<?=$count;?>.png');
											background-size:80px 100px;
											margin-right:5px;
											margin-top:5px;
											"></button>
										</form>
									</div>
								<?php
									}
								}
								?>
								</div>
								<!--  -->
								
								<div id="DivMulher" hidden>
								
								<div style="text-align:center">Clique sobre uma skin para seleciona-la.<br><br></div>
								
								<?php
								
								for($count = 1; $count < 312; $count++)
								{
								
									if(in_array($count,$SkinsInWoman))
									{
									?>
									
								
									<div class="col col-lg-1">
										<form id="form" name="form" action="skin.php?char=<?=$p_id;?>&skin=<?=$count;?>" class="wizard-big" method="post">
										<button type="submit" class="img-skin" style="
											background-image: url('img/skins/<?=$count;?>.png');
											background-size:80px 100px;
											margin-right:5px;
											margin-top:5px;
											"></button>
										</form>
									</div>
									<?php
									}
								}
								?>
								</div>						
							<?php
								} }
								?>

                            
                            
                        </div></div>
                </div>
                <?php include('ads.php'); ?>
                <div class="footer">
                    <div>
                        <strong>Copyright</strong>  PR:RP &copy; 2018~2023
                    </div>
                </div>
            </div>
        </div>

       
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Flot -->
    <script src="js/plugins/flot/jquery.flot.js"></script>
    <script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="js/plugins/flot/jquery.flot.spline.js"></script>
    <script src="js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="js/plugins/flot/jquery.flot.pie.js"></script>

    <!-- Peity -->
    <script src="js/plugins/peity/jquery.peity.min.js"></script>
    <script src="js/demo/peity-demo.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- jQuery UI -->
    <script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>

    <!-- GITTER -->
    <script src="js/plugins/gritter/jquery.gritter.min.js"></script>

    <!-- Sparkline -->
    <script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>

    <!-- Sparkline demo data  -->
    <script src="js/demo/sparkline-demo.js"></script>

    <!-- ChartJS-->
    <script src="js/plugins/chartJs/Chart.min.js"></script>

    <!-- Toastr -->
    <script src="js/plugins/toastr/toastr.min.js"></script>


    
        <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','../../www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-4625583-2', 'webapplayers.com');
        ga('send', 'pageview');

    </script>
</body>
</html>
