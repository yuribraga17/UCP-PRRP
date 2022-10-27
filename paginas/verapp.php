<?php
if (isset($_GET['id'])) {
    $p_id = $_GET['id'];
    $pers_stats = 0;

    $result = $mysqli->query("SELECT ucp_user_owner FROM ucp_aplic WHERE appID='$p_id' LIMIT 1");
    $count = $result->num_rows;
    if ($count > 0) {
        $row = $result->fetch_array();

        if ($row['ucp_user_owner'] == $_SESSION['usuarioID']) {
            $pers_stats = 1;
        }
    }
} else {
    echo 'deuRuim';
}
?>
<div class="row">
	<div class="col-lg-12">
		<div class="wrapper wrapper-content">
      		<div class="row">
            <?php
                $result_a = $mysqli->query("SELECT admin,uNome,uSenha FROM ucp_users WHERE uID='".$_SESSION['usuarioID']."' LIMIT 1");
                $row_a = $result_a->fetch_array();

                if (isset($_GET['action'])) {
                    if ($pers_stats == 0 && $row_a['admin'] < 1) {
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
                    } else {
                        $acao = $_GET['action'];
                        $result_b = $mysqli->query("SELECT * FROM ucp_aplic WHERE appID='$p_id' LIMIT 1");
                        $row_b = $result_b->fetch_array();

                        if ($acao == 'aceitar') {
                            if ($row_b['avaliado'] != 0) {
                                echo 'Essa aplicação já foi avaliada.';
                            } else {
                                $a_por = $_SESSION['usuarioID'];

                                $partes = explode('/', $data_aniver);
                                $dia = $partes[0];
                                $mes = $partes[1];
                                $ano = $partes[2];

                                $age = date('y') - $dia;

                                $result_c = $mysqli->query('SELECT * FROM ucp_users WHERE uID ='.$row_b['ucp_user_owner']);
                                $row_c = $result_c->fetch_array();

                                $result_newchar = $mysqli->query("INSERT INTO accounts (ucpOwn,	Username,Password,pNomeOOC,Birthdate,Origin,Gender,PosX,PosY,PosZ,Age,CreateDate) VALUES('".$row_b['ucp_user_owner']."','".$row_b['Charname']."','".$row_c['uSenha']."','".$row_c['uNome']."','".$row_b['Birthdate']."','".$row_b['Origin']."','".$row_b['Gender']."','$Pos_x','$Pos_y','$Pos_z','$age','".$row_b['CreateDate']."')");
                                $newcharid = $mysqli->insert_id;

                                $result_c = $mysqli->query("UPDATE ucp_aplic SET avaliado = '1', char_id='$newcharid', avaliadopor = '$a_por' WHERE appID = '$p_id'");

                                $notific_mensagem = "O seu personagem '".str_replace('_', ' ', $row_b['Charname'])."' foi aceito.";
                                $timestaaaamp = time();

                                $mysqli->query("INSERT INTO ucp_notific (OwnId,icon,text,timestamp,visto) VALUES('".$row_b['ucp_user_owner']."','user','$notific_mensagem','$timestaaaamp','0')");
                                //============

                                if ($result_c && $result_newchar) {
                                    echo 'Personagem aceito.';
                                } else {
                                    echo 'Ocorreu algum erro ao aceitar este personagem... Contate um administrador.';
                                }
                            }
                        } elseif ($acao == 'recusado') {
                            if ($row_b['avaliado'] != 0) {
                                echo 'Essa aplicação já foi avaliada.';
                            } else {
                                if (isset($_POST['motivo_recusa'])) {
                                    $a_por = $_SESSION['usuarioID'];
                                    $mot_rec = $mysqli->real_escape_string($_POST['motivo_recusa']);

                                    $sqlaccept_query = $mysqli->query("UPDATE ucp_aplic SET avaliado = '2', avaliadopor='$a_por', motivo_recusado='$mot_rec' WHERE appID='$p_id'");

                                    //Enviar Notificação na UCP
                                    $notific_mensagem = 'O seu personagem '.str_replace('_', ' ', $row_b['Charname']).' foi recusado.';
                                    $timestaaaamp = time();
                                    $mysqli->query("INSERT INTO ucp_notific (OwnId,icon,text,timestamp,visto) VALUES('".$row_b['ucp_user_owner']."','user','$notific_mensagem','$timestaaaamp','0')");
                                    //============

                                    if ($sqlaccept_query) {
                                        echo 'Personagem recusado.';
                                    } else {
                                        echo 'Ocorreu algum erro ao aceitar este personagem... Contate um administrador.';
                                    }
                                } else {
                                    ?>
									<form id="form" name="form" action="<?=$url_base; ?>/verapp/recusar/<?=$p_id; ?>" class="wizard-big" method="post">
										<div class="form-group">
											<label>Por que você está recusando essa App? *</label>
											<textarea id="motivo_recusa" name="motivo_recusa" class="form-control required"></textarea>
										</div>
										<div class="col-md-2" style="float:right;">
											<button type="submit" class="btn btn-danger block full-width m-b">Recusar Aplicação</button>
										</div>
				                    </form>
									<?php
                                }
                            }
                        } elseif ($acao == 'reenviar') {
                            if ($pers_stats == 1) {
                                if ($row_b['avaliado'] != 2) {
                                    ?>
									A sua aplicação não está negada!
									<?php
                                } else {
                                    if (isset($_POST['def-rol'])) {
                                        $rp = $mysqli->real_escape_string($_POST['def-rol']);
                                    }
                                    if (isset($_POST['def-mg'])) {
                                        $mg = $mysqli->real_escape_string($_POST['def-mg']);
                                    }
                                    if (isset($_POST['def-matar'])) {
                                        $kill = $mysqli->real_escape_string($_POST['def-matar']);
                                    }
                                    if (isset($_POST['def-fear'])) {
                                        $fear = $mysqli->real_escape_string($_POST['def-fear']);
                                    }
                                    if (isset($_POST['def-ioc'])) {
                                        $ioc = $mysqli->real_escape_string($_POST['def-ioc']);
                                    }
                                    if (isset($_POST['def-pg'])) {
                                        $fpg = $mysqli->real_escape_string($_POST['def-pg']);
                                    }
                                    if (isset($_POST['hist-pers'])) {
                                        $histper = $mysqli->real_escape_string($_POST['hist-pers']);
                                    }

                                    $sql_app2 = "UPDATE ucp_aplic SET def_mg='$mg', def_matar='$kill' WHERE appID = '$p_id'";
                                    $mysqli->query($sql_app2);

                                    $sql_app3 = "UPDATE ucp_aplic SET def_fear='$fear', def_ioc='$ioc', histpers='$histper' WHERE appID = '$p_id'";
                                    $mysqli->query($sql_app3);

                                    $sql_app4 = "UPDATE ucp_aplic SET def_rol='$rp', def_pg='$fpg', avaliado='0' WHERE appID = '$p_id'";
                                    $mysqli->query($sql_app4); ?>
									Aplicação enviada.
									<?php
                                }
                            }
                        }
                        /*else if($acao == 'reavaliar')
                        {
                                    $a_por = $_SESSION['usuarioID'];

                                    $sqlaccept = "UPDATE ucp_aplic SET avaliado = '0', avaliadopor = '$a_por', motivo_recusado = '' WHERE OwnId = '$p_id'";
                                    $result_accept = mysql_query($sqlaccept)or die (mysql_error());

                                    $sqlaccept2 = "UPDATE characters SET status = '0' WHERE ID = '$p_id'";
                                    $result_accept2 = mysql_query($sqlaccept2)or die (mysql_error());

                                    //Enviar Notificação na UCP
                                    $sqlaccept_loc = "SELECT * FROM characters WHERE ID = '$p_id'";
                                    $result_accept_loc = mysql_query($sqlaccept_loc)or die (mysql_error());
                                    $resh_loc=mysql_fetch_array($result_accept_loc);
                                    $AccountName = $resh_loc['Username'];

                                    $query_search_nt = "SELECT * FROM accounts WHERE Username='$AccountName' LIMIT 1";
                                    $result_ser_nt = mysql_query($query_search_nt)or die (mysql_error());
                                    $resh_nt=mysql_fetch_array($result_ser_nt);
                                    $QuemRecebe = $resh_nt['ID'];

                                    $notific_mensagem = "Um de seus personagens foi enviado para a reavaliação pelo administrador $a_por.";
                                    $timestaaaamp = time();
                                    $sql_notifc="INSERT INTO ucp_notific (OwnId,icon,text,timestamp,visto) VALUES('$QuemRecebe','user','$notific_mensagem','$timestaaaamp','0')";
                                    mysql_query($sql_notifc)or die (mysql_error());
                                    //============

                                    if($result_accept && $result_accept2)
                                    {
                                        echo "Personagem enviado para reavaliação.";
                                    }
                                    else
                                    {
                                        echo "Ocorreu algum erro ao aceitar este personagem... Contate o Freeze.";
                                    }

                        }*/
                    }
                } else {
                    $result_f = $mysqli->query("SELECT admin FROM ucp_users WHERE uID='".$_SESSION['usuarioID']."' LIMIT 1");
                    $row_f = $result_f->fetch_array();

                    if ($pers_stats == 0 && $row_f['admin'] < 1) {
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
                    } else {
                        $result_app = $mysqli->query("SELECT * FROM ucp_aplic WHERE appID='$p_id' LIMIT 1");
                        $row_app = $result_app->fetch_array(); ?>
                        <div class="wrapper wrapper-content animated fadeInRight">
                        	<div style="text-align:center;"><h1>
                            <?php
                                switch ($row_app['avaliado']) {
                                    case 0: echo 'AGUARDANDO AVALIAÇÃO'; break;
                                    case 1: echo "<b><font color='#00954A'>APLICAÇÃO ACEITA</font></b>"; break;
                                    case 2: echo "<b><font color='#9D0022'>APLICAÇÃO NEGADA</font></b>"; break;
                                }
                        if ($row_app['avaliado'] != 0 && $row_a['admin'] >= 1) {
                            $result_aaa = $mysqli->query("SELECT uNome FROM ucp_users WHERE uID='".$row_app['avaliadopor']."' LIMIT 1");
                            $row_aaa = $result_aaa->fetch_array();

                            echo "<br><font size='-1'>Avaliada por: ".$row_aaa['uNome'].'</font>';
                            echo "<br><font size='-1'>Proprietário: ".$row_app['ucp_user_owner'].'</font>';
                        }
                        if ($row_app['novopers'] && $row_a['admin'] >= 1) {
                            $OwnerID = $row_app['OwnId'];

                            echo "<br><b><font color='#9D0022' size='-1'>NOVO PERSONAGEM. (<a href='http://ucp.ca-roleplay.com.br/verapp/$p_id'>Ver APP</a>)</font></b>";
                        }

                        if ($row_app['avaliado'] == 2) {
                            ?>
									<hr/>
									<div class="ibox">
										<div class="ibox-heading" style="background:#F3F3F4;"><font size="+1" color='#9D0022'>> Motivo:</font></div>
										<div class="ibox-content">
											<p class="small"><font size="-1">
												<?php echo nl2br($row_app['motivo_recusado']); ?>
											</font></p>
										</div>
									</div>
									
									<?php
                        } ?>
                                </h1></div>
                                <hr>
            					<div class="row m-b-lg m-t-lg">
                					<div class="col-md-4">
                   						Nome do personagem:<br/>
                    					<h2 class="no-margins"><?=str_replace('_', ' ', $row_app['Charname']); ?> </h2><br/>
									</div>
                                    <div class="col-md-6">
                                       	<strong>Data de Nascimento:</strong> <?=$row_app['Birthdate']; ?><br/>
                                        <strong>Origem:</strong> <?=$row_app['Origin']; ?>
                                                        
                                    </div>
            					</div>
            					<div class="row">
                					<div class="col-lg-12">
                   					
                   						<?php
                                        if (!$row_app['novopers'] && $pers_stats == 0) {
                                            ?>
                    					<div class="ibox">
                                        	<div class="ibox-heading" style="background:#F3F3F4;"><h3>Sobre <?=str_replace('_', ' ', $row_app['Charname']); ?></h3></div>
                                            <div class="ibox-content">
												<p class="small">
													<?=nl2br($row_app['histpers']); ?>
												</p>
											</div>
                    					</div>
                    					<div class="ibox">
                                        	<div class="ibox-heading" style="background:#F3F3F4;"><h3>Defina Roleplay</h3></div>
                        					<div class="ibox-content">
												<p class="small">
													<?php echo nl2br($row_app['def_rol']); ?>
												</p>
 											</div>
                    					</div>
                    					<div class="ibox">
                                                				<div class="ibox-heading" style="background:#F3F3F4;"><h3>O que é Metagaming? Dê três exemplos.</h3></div>
                        							<div class="ibox-content">
                            								<p class="small">
                                							<?php echo nl2br($row_app['def_mg']); ?>
                                                        				</p>
 										</div>
                    							</div>
                    							<div class="ibox">
                                                				<div class="ibox-heading" style="background:#F3F3F4;"><h3>Quando você pode matar outro jogador?</h3></div>
                        							<div class="ibox-content">
                            								<p class="small">
                                							<?php echo nl2br($row_app['def_matar']); ?>
                                                        				</p>
 										</div>
                    							</div>
                    							<div class="ibox">
                                                				<div class="ibox-heading" style="background:#F3F3F4;"><h3>O que é Fear RP? Dê três exemplos</h3></div>
                        							<div class="ibox-content">
                            								<p class="small">
                                							<?php echo nl2br($row_app['def_fear']); ?>
                                                        				</p>
 										</div>
                    							</div>
                    							<div class="ibox">
                                                				<div class="ibox-heading" style="background:#F3F3F4;"><h3>O que é Powergaming? Cite três exemplos.</h3></div>
                        							<div class="ibox-content">
                            								<p class="small">
                                							<?php echo nl2br($row_app['def_pg']); ?>
                                                        				</p>
 										</div>
                    							</div>
                    							<div class="ibox">
                                                				<div class="ibox-heading" style="background:#F3F3F4;"><h3>O que é IC e OOC? Cite três exemplos de cada.</h3></div>
                        							<div class="ibox-content">
                            								<p class="small">
                                							<?php echo nl2br($row_app['def_ioc']); ?>
                                                        				</p>
 										</div>
                    							</div>
                    							<?php
                                        } elseif (!$row_app['novopers'] && $pers_stats == 1) {
                                            ?>
                    								<style>
														.resp_box_app{
															border:none; 
															height: 100%; 
															width: 100%; 
															min-height: 100px; 
															min-width: 100%; 
															max-width: 100%; 
															padding: 5px 5px 5px 5px;
															border-radius: 5px;
															border:1px solid #989898;
															background-image: url(../img/logo-CA.png);
															background-repeat: no-repeat;
															background-position: right bottom;
															opacity: 0.3;
															-webkit-transition: opacity 0.5s ease-in-out;
															  -moz-transition: opacity 0.5s ease-in-out;
															  -ms-transition: opacity 0.5s ease-in-out;
															  -o-transition: opacity 0.5s ease-in-out;
															  transition: opacity 0.5s ease-in-out;
															
														}
														.resp_box_app:hover{
															zoom: 1;
  															opacity: 1;
														}
													</style>
                   									<form id="form" name="form" action="reenviar/<?=$p_id; ?>" class="wizard-big" method="post">
                    								<div class="ibox">
                                        				<div class="ibox-heading" style="background:#F3F3F4;"><h3>Sobre <?=str_replace('_', ' ', $row_app['Charname']); ?></h3></div>
                                            			<textarea id="hist-pers" name="hist-pers" class="resp_box_app"><?=$row_app['histpers']; ?></textarea>
													</div>
                    								<div class="ibox">
                                                		<div class="ibox-heading" style="background:#F3F3F4;"><h3>Defina Roleplay</h3></div>
                        								<textarea id="def-rol" name="def-rol" class="resp_box_app"><?=$row_app['def_rol']; ?></textarea>	
                    								</div>
                    								<div class="ibox">
                                                		<div class="ibox-heading" style="background:#F3F3F4;"><h3>O que é Metagaming? Dê três exemplos.</h3></div>
                                                		<textarea id="def-mg" name="def-mg" class="resp_box_app"><?=$row_app['def_mg']; ?></textarea>
                    								</div>
                    								<div class="ibox">
                                                		<div class="ibox-heading" style="background:#F3F3F4;"><h3>Quando você pode matar outro jogador?</h3></div>
                   										<textarea id="def-matar" name="def-matar" class="resp_box_app"><?=$row_app['def_matar']; ?></textarea>
                    								</div>
                    								<div class="ibox">
                                                		<div class="ibox-heading" style="background:#F3F3F4;"><h3>O que é Fear RP? Dê três exemplos</h3></div>
                   										<textarea id="def-fear" name="def-fear" class="resp_box_app"><?=$row_app['def_fear']; ?></textarea>
                    								</div>
                    								<div class="ibox">
                                                		<div class="ibox-heading" style="background:#F3F3F4;"><h3>O que é Powergaming? Cite três exemplos.</h3></div>
                   										<textarea id="def-pg" name="def-pg" class="resp_box_app"><?=$row_app['def_pg']; ?></textarea>
                    								</div>
                    								<div class="ibox">
                                                		<div class="ibox-heading" style="background:#F3F3F4;"><h3>O que é IC e OOC? Cite três exemplos de cada.</h3></div>
                   										<textarea id="def-ioc" name="def-ioc" class="resp_box_app"><?=$row_app['def_ioc']; ?></textarea>
                    								</div>
                    								
                    								<div class="ibox">
	                    								<button type="submit" class="btn btn-primary block full-width m-b">Reenviar aplicação</button>
													</div>
												</form>
                    							<?php
                                        } else {
                                            echo 'Erro #05043, caso persista contate um administrador.';
                                        }

                        if ($row_app['avaliado'] == 2) {
                            if ($row_a['admin'] > 5) {
                                ?>
                    							<div class="ibox">
	                    							<a href="verapp/<?=$p_id; ?>&action=reavaliar"><button type="submit" class="btn btn-danger block full-width m-b">Enviar para Reavaliação</button></a>
										
									</div>
									<?php
                            }
                        } elseif ($row_app['avaliado'] == 0) {
                            ?>
                    							<div class="col-lg-6">
                    							<div class="ibox">
	                    							
	                    								<a href="<?=$url_base; ?>/verapp/aceitar/<?=$p_id; ?>"><button type="submit" class="btn btn-primary block full-width m-b">Aceitar Aplicação</button></a>
	                    						
									</div>
									</div>
									<div class="col-lg-6">
									<div class="ibox">
	                    							<a href="<?=$url_base; ?>/verapp/recusar/<?=$p_id; ?>"><button type="submit" class="btn btn-danger block full-width m-b">Recusar Aplicação</button></a>
										
									</div>
									</div>
									
									<?php
                        }
                    }
                }
                                ?>

                            
                            
                        </div></div>
                        <?php include 'ads.php'; ?>
                </div>
                <div class="footer">
                    <div>
                        <?=$footer; ?>
                    </div>
                </div>
                </div>
