<?php
session_start(); 	//A seção deve ser iniciada em todas as páginas
if (!isset($_SESSION['usuarioID'])) 
{		//Verifica se há seções
	session_destroy();						//Destroi a seção por segurança
	header("Location: login.php"); exit;	//Redireciona o visitante para login
}

include('func/database.php');

if (isset($_GET['fac'])) 
{
	$fac_id = mysql_escape_string($_GET['fac']);
}
else
{
	header("Location: index.php"); exit;
	echo "deuRuim";
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
                        	
                        	
                        	<div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <tbody>
                                                <tr style="text-align:center;">
                                                    <td><b>Nome do Personagem</b></td>
                                                    <td><b>Último Login</b></td>
                                                </tr>
                                                
                        	<?php 
                        		$query_check_acc = "SELECT * FROM accounts WHERE id='".$_SESSION['usuarioID']."' LIMIT 1";
					$result_check_acc = mysql_query($query_check_acc)or die (mysql_error());
					$row_check=mysql_fetch_array($result_check_acc);
					
					if($row_check['admin'] < 1)
					{
						header("Location: index.php"); exit;
					}
			
                        		$quant_pers = "SELECT * FROM characters WHERE faction='$fac_id' ORDER BY LastLogin DESC";
					$result_quant_pers = mysql_query($quant_pers)or die (mysql_error());
					
					$quant_fac = "SELECT * FROM factions WHERE factionID='$fac_id' LIMIT 1";
					$result_quant_fac = mysql_query($quant_fac)or die (mysql_error());
					$resf=mysql_fetch_array($result_quant_fac);
					
					echo "<h1><center>".$resf['factionName']."</center></h1><br>";
					
					while($resh=mysql_fetch_array($result_quant_pers))
                                        {
							
					?>
					<tr style="text-align:center;">
                                                
                                                    <td><?=str_replace("_"," ", $resh['Charname']);?></td>
                                                    <td><?=date("d/m/Y H:i",$resh['LastLogin']); ?></td>
                                                    
                                                </tr>
                                                
                                                <?php } ?>
                                                </tbody>
                                            </table>


           
        </div>

                            
                            
                        </div></div>
                        <?php include('ads.php'); ?>
                </div>
                <div class="footer">
                    <div>
                        <strong>Copyright</strong> PR:RP &copy; 2018~2023
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
