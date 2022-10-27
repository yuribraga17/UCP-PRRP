<?php
$result = $mysqli->query("SELECT admin FROM ucp_users WHERE uID='".$_SESSION['usuarioID']."' LIMIT 1");
$row = $result->fetch_object();
$pAdmin = $row->admin;
$result->close;

if($pAdmin > 0){ 
?>
	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-lg-10">
       		<h2>Aplicações Pendentes</h2>
            <ol class="breadcrumb">
                <li>
                	<a href="inicio">Home</a>
                </li><li>
                    Administração
                </li><li class="active">
                    <strong>Aplicações</strong>
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
                    	<h2>Aplicações</h2>
                        <p>
                        	Nesta área você encontrará aplicações aguardando avaliação.
                        </p>
                        <div class="clients-list">
                            <ul class="nav nav-tabs">
                            	<?php
								$total_count = 0;
								$result1 = $mysqli->query("SELECT * FROM ucp_aplic WHERE avaliado='0' ORDER BY appID ASC");
								$total_count = $result1->num_rows;
								?>
                                <span class="pull-right small text-muted"><?=$total_count?> não avaliadas</span>
                                <li class="active"><a data-toggle="tab" href="#tab-1"><i class="fa fa-user"></i> Em avaliação</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-2"><i class="fa fa-check"></i> Aceitas</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-3"><i class="fa fa-ban"></i> Negadas</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                	<div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <tbody>
                                                <tr>
                                                    <td><b>#Pos</b></td>
                                                    <td><b>Nome do Personagem</b></td>
                                                    <td><b>Nome OOC</b></td>
                                                    <td><b>Tipo da APP</b></td>
                                                    <td style="text-align:right;"><b>Vizualizar</b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="full-height-scroll">
                                        <div class="table-responsive">
                                        	
                                            <table class="table table-striped table-hover">
                                                <tbody>
                                                
                                                <?php
												$posFila = 0;
												while($rowv = $result1->fetch_array()){
													$posFila++;
													
													$result_nome = $mysqli->query("SELECT uNome FROM ucp_users WHERE uID='".$rowv['ucp_user_owner']."' LIMIT 1");
													$row_nome = $result_nome->fetch_array();
													$nome = $row_nome['uNome'];
													$result_nome->close;
												?>
                                                <tr>
                                                    <td>#<?=$posFila;?></td>
                                                    <td><a href="verapp/<?=$rowv['appID'];?>" class="client-link"><?=str_replace("_"," ", $rowv['Charname']);?></a></td>
                                                    <td><?=$nome;?></td>
                                                    <td><?php if($row_neg['novopers']) echo "Personagem";
                                                    	else echo "Aplicação";?></td>
                                                    <td><a href="verapp/<?=$rowv['appID'];?>" class="client-link"><i class="fa fa-eye"></i></a></td>
                                                </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab-2" class="tab-pane">
                                	<div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <tbody>
                                                <tr>
                                                    <td><b>Nome do Personagem</b></td>
                                                    <td><b>Nome OOC</b></td>
                                                    <td><b>Tipo da APP</b></td>
                                                    <td style="text-align:right;"><b>Vizualizar</b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="full-height-scroll">
                                        <div class="table-responsive">
                                        	
                                            <table class="table table-striped table-hover">
                                                <tbody>
                                                
                                                <?php
												$result_avaliados = $mysqli->query("SELECT * FROM ucp_aplic WHERE avaliado='1' ORDER BY appID DESC");
	
												while($row_av = $result_avaliados->fetch_array()){
													
													$result_nome = $mysqli->query("SELECT uNome FROM ucp_users WHERE uID='".$row_av['ucp_user_owner']."' LIMIT 1");
													$row_nome = $result_nome->fetch_array();
													$nome = $row_nome['uNome'];
													$result_nome->close;
												?>
                                                <tr>
                                                    <td><a href="verapp/<?=$row_av['appID']?>" class="client-link"><?=str_replace("_"," ", $row_av['Charname']);?></a></td>
                                                    <td><?=$nome;?></td>
                                                    <td><?php if($row_av['novopers']) echo "Personagem";
                                                    	else echo "Aplicação";?></td>
                                                    <td><a href="verapp/<?=$row_av['apppID']?>" class="client-link"><i class="fa fa-eye"></i></a></td>
                                                </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab-3" class="tab-pane">
                                	<div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <tbody>
                                                <tr>
                                                    <td><b>Nome do Personagem</b></td>
                                                    <td><b>Nome OOC</b></td>
                                                    <td><b>Tipo da APP</b></td>
                                                    <td style="text-align:right;"><b>Vizualizar</b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="full-height-scroll">
                                        <div class="table-responsive">
                                        	
                                            <table class="table table-striped table-hover">
                                                <tbody>
                                                
                                                <?php
												$result_negados = $mysqli->query("SELECT * FROM ucp_aplic WHERE avaliado='2' ORDER BY appID DESC");
	
												while($row_neg = $result_negados->fetch_array()){
													
													$result_nome = $mysqli->query("SELECT uNome FROM ucp_users WHERE uID='".$row_neg['ucp_user_owner']."' LIMIT 1");
													$row_nome = $result_nome->fetch_array();
													$nome = $row_nome['uNome'];
													$result_nome->close;
												?>
                                                <tr>
                                                    <td><a href="verapp/<?=$row_neg['appID']?>" class="client-link"><?=str_replace("_"," ", $row_neg['Charname']);?></a></td>
                                                    <td><?=$nome;?></td>
                                                    <td><?php if($row_neg['novopers']) echo "Personagem";
                                                    	else echo "Aplicação";?></td>
                                                    <td><a href="verapp/<?=$row_neg['appID']?>" class="client-link"><i class="fa fa-eye"></i></a></td>
                                                </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div style="height: 80px;"></div>
                            </div>

                            </div>
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
       <?php } ?>