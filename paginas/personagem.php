<?php
if (isset($_GET['pers'])) 
{
	$p_id = $_GET['pers'];
	$pers_stats = 0;

	
	$result = $mysqli->query("SELECT * FROM accounts WHERE ID='".$p_id."' LIMIT 1");
	$count = $result->num_rows;
	if($count == 0) $pers_stats = 0;
	else {
		
		$row = $result->fetch_array();
		if($row['ucpOwn'] == $_SESSION['usuarioID']) $pers_stats = 1;
		else $pers_stats = 0;
	}
	$result->close();
}
else
{
	die('<script type="text/javascript">window.location.href="inicio";</script>');
}
?>


<div class="row">
	<div class="col-lg-12">
   		<div class="wrapper wrapper-content">
       		<div class="row">
            <?php 
				if($pers_stats == 0){
			?>
                	<div class="ibox float-e-margins ">
                    	<div style="text-align:center;">
                        	<h4> Você não pode vizualizar personagens que não lhe pertencem! </h4><br/>
                        	<font size="+4">:(</font>
                        </div>
                    </div>
					<?php
				}
				else {
					?>
                    <div class="wrapper wrapper-content animated fadeInRight">
						<style>
                        	.div-menu {
                            	margin-left:10px;
                               	height:70px;
                            }
                            .botao-menu {
                            	height:50px;
                                width:70px;
                                float:left;
                            }
                            .trocar-skin {
                            	background-image: url('<?=$url_base;?>/img/skin.png');
                                background-size: 50px 50px;
                                height:50px;
                                width:50px;
                           	}
                        </style>
						
            			<div class="row m-b-lg m-t-lg">
            				<div class="col-md-6">
                    			<div class="profile-image" style="height:304px; width:239px; background-image:url(<?=$url_base;?>/img/skins/<?=$row['Skin'];?>.png); background-repeat:no-repeat; background-size:contain;">
                        		</div>
                    			<div class="profile-info">
									<div class="">
										<div>
											<h2 class="">
												<?=str_replace("_"," ", $row['Username']);?> 
											</h2>
											<?php 
												if($row['Fac'] > 0){
													
													$resultf = $mysqli->query("SELECT * FROM faccoes WHERE fID='".$row['Fac']."' LIMIT 1");
													$rowf = $resultf->fetch_array();
													
													echo "<h4>".$rowf['fNome']."</h4><small>- ".$rowf['fRank'.$row['FacCargo'].'']."</small><br/><br/>";
													$resultf->close();
											?>
												<!-- <small><i class="fa fa-circle text-navy"></i> Online status</small> -->
											<?php
												}
												else echo "<h4>DESEMPREGADO</h4>";
											?>
										</div>
									</div>
                    			</div>
               	 			</div>
                			<div class="col-md-4">
                            	<div><div class="btn btn-primary block"> Informações do Personagem </div> </div>
										<div class="ibox-content">
										<table class="table small m-b-xs">

											<tbody>
												<tr>
												<td><strong>Poupança:</strong> <?=$row['pSavings'];?></td>
												<td><strong>Dinheiro:</strong> <?=$row['Grana'];?></td>
												<td><strong>D. de Nascimento:</strong> <?=$row['Birthdate'];?></td>
												</tr><tr>
												<td><strong>Banco:</strong> <?=$row['pBanco'];?></td>
												<td><strong>Origem:</strong> <?=$row['Origin'];?></td>
												<td><strong>H. Jogadas:</strong> <?=$row['Level'];?></td>
												</tr><tr>
												<td><strong>Contato:</strong> <?=$row['Celular'];?></td>
												<td><strong>Doador:</td>
												<td><?=str_replace("_"," ", $row->pDoador);?>
				                                    <?php 
													$status_p = 0;
													if($status_p == 0) { ?>Nenhum<?php } //1.Bronze|2.Prata|3.Ouro
													else if($status_p == 1) { ?>Pacote Bronze<?php }
													else if($status_p == 2) { ?>Pacote Prata<?php }
													else if($status_p == 3) { ?>Pacote Ouro<?php }
													?></td>
													<td><strong>Namechanges:</strong> <?=$row['pChangeNames'];?></td>
													</td>
											</tbody>
										</table>
                             </div>
						</div>
<div class="col-lg-4 m-b-lg">
    <div class="btn btn-info block" style="background:#; ">Licenças</div>
		<div class="ibox-content">
		<table class="table small m-b-xs">
			<td><strong>C. Motorista:</strong></td>												
			<td><?=str_replace("_"," ", $row->pDriveLic);?> 
				<?php 
				$status_p = 0;
				if($status_p == 0) { ?>Não possui<?php }
				else if($status_p == 1) { ?>Possui<?php }
				?></td>
				</td>
			<td><strong>C. Caminheiro:</strong></td>												
			<td><?=str_replace("_"," ", $row->pTruckLic);?> 
				<?php 
				$status_p = 0;
				if($status_p == 0) { ?>Não possui<?php }
				else if($status_p == 1) { ?>Possui<?php }
				?></td>
				</td>
				</tr><tr>
			<td><strong>L. Avião:</strong></td>												
			<td><?=str_replace("_"," ", $row->pFlyLic);?> 
				<?php 
				$status_p = 0;
				if($status_p == 0) { ?>Não possui<?php }
				else if($status_p == 1) { ?>Possui<?php }
				?></td>
				</td>
			<td><strong>P. Armas:</strong></td>												
			<td><?=str_replace("_"," ", $row->pWeoLic);?> 
				<?php 
				$status_p = 0;
				if($status_p == 0) { ?>Não possui<?php }
				else if($status_p == 1) { ?>Possui<?php }
				?></td>
				</td>

	</tbody>
		</table>
			</div>
</div>			
            			<div class="row">
                       		<div class="col-lg-8">
                    			<div class="ibox">
                                	<div class="btn btn-info block" style="background:#;"><h3>Sobre <?=str_replace("_"," ", $res['Charname']);?></h3></div>
                        			<div class="ibox-content">
                                		<p class="small">
                                		<?php
											$resulth = $mysqli->query("SELECT * FROM ucp_aplic WHERE char_id='$p_id' LIMIT 5");
											$rowh = $resulth->fetch_array();
                                            echo $rowh['histpers'];
										?>
                                        </p>
									</div>
                    			</div>
								<div style="margin-bottom:20px;"></div>
                    				<div class="ibox">
                                    	<center><div class="btn btn-info block" style="background:#; margin-bottom:-2px;"><h3>Veículos Registrados</h3></div></center>
                                        	<div style="margin-left:40px;">
                                            <?php
	$VehicleName = Array( 
    400 => 'landstalker', 401 => 'bravura', 402 => 'buffalo', 403 => 'linerunner', 404 => 'perenail', 405 => 'sentinel', 406 => 'dumper', 407 => 'firetruck', 408 => 'trashmaster', 409 => 'stretch', 410 => 'manana', 411 => 'infernus', 412 => 'voodoo', 413 => 'pony', 414 => 'mule', 415 => 'cheetah', 416 => 'ambulance', 417 => 'levetian', 418 => 'moonbeam', 419 => 'esperanto', 420 => 'taxi', 421 => 'washington', 422 => 'bobcat', 423 => 'mr whoopee', 424 => 'bf injection', 425 => 'hunter', 426 => 'premier', 427 => 'enforcer', 428 => 'securicar', 429 => 'banshee', 430 => 'predator', 431 => 'bus', 432 => 'rhino', 433 => 'barracks', 434 => 'hotknife', 435 => 'artic trailer 1', 436 => 'previon', 437 => 'coach', 438 => 'cabbie', 439 => 'stallion', 440 => 'rumpo', 441 => 'rc bandit', 
    442 => 'romero', 443 => 'packer', 444 => 'monster', 445 => 'admiral', 446 => 'squalo', 447 => 'seasparrow', 448 => 'pizza boy', 449 => 'tram', 450 => 'artic trailer 2', 451 => 'turismo', 452 => 'speeder', 453 => 'reefer', 454 => 'tropic', 455 => 'flatbed', 456 => 'yankee', 457 => 'caddy', 458 => 'solair', 459 => 'top fun', 460 => 'skimmer', 461 => 'pcj 600', 462 => 'faggio', 463 => 'freeway', 464 => 'rc baron', 465 => 'rc raider', 466 => 'glendale', 467 => 'oceanic', 468 => 'sanchez', 469 => 'sparrow', 470 => 'patriot', 471 => 'quad', 472 => 'coastgaurd', 473 => 'dinghy', 474 => 'hermes', 475 => 'sabre', 476 => 'rustler', 477 => 'zr 350', 478 => 'walton', 479 => 'regina', 480 => 'comet', 481 => 'bmx', 482 => 'burriro', 483 => 'camper', 484 => 'marquis', 485 => 'baggage',  
    486 => 'dozer', 487 => 'maverick', 488 => 'vcn maverick', 489 => 'rancher', 490 => 'fbi rancher', 491 => 'virgo', 492 => 'greenwood', 493 => 'jetmax', 494 => 'hotring', 495 => 'sandking', 496 => 'blistac', 497 => 'police maverick', 498 => 'boxville', 499 => 'benson', 500 => 'mesa', 501 => 'rc goblin', 502 => 'hotring a', 503 => 'hotring b', 504 => 'blood ring banger', 505 => 'rancher (lure)', 506 => 'super gt', 507 => 'elegant', 508 => 'journey', 509 => 'bike', 510 => 'mountain bike', 511 => 'beagle', 512 => 'cropduster', 513 => 'stuntplane', 514 => 'petrol', 515 => 'roadtrain', 516 => 'nebula', 517 => 'majestic', 518 => 'buccaneer', 519 => 'shamal', 520 => 'hydra', 521 => 'fcr 900', 522 => 'nrg 500', 523 => 'hpv 1000', 524 => 'cement', 525 => 'towtruck', 526 => 'fortune', 
    527 => 'cadrona', 528 => 'fbi truck', 529 => 'williard', 530 => 'fork lift', 531 => 'tractor', 532 => 'combine', 533 => 'feltzer', 534 => 'remington', 535 => 'slamvan', 536 => 'blade', 537 => 'freight', 538 => 'streak', 539 => 'vortex', 540 => 'vincent', 541 => 'bullet', 542 => 'clover', 543 => 'sadler', 544 => 'firetruck la', 545 => 'hustler', 546 => 'intruder', 547 => 'primo', 548 => 'cargobob', 549 => 'tampa', 550 => 'sunrise', 551 => 'merit', 552 => 'utility van', 553 => 'nevada', 554 => 'yosemite', 555 => 'windsor', 556 => 'monster a', 557 => 'monster b', 558 => 'uranus', 559 => 'jester', 560 => 'sultan', 561 => 'stratum', 562 => 'elegy', 563 => 'raindance', 564 => 'rc tiger', 565 => 'flash', 566 => 'tahoma', 567 => 'savanna', 568 => 'bandito', 569 => 'freight flat', 
    570 => 'streak', 571 => 'kart', 572 => 'mower', 573 => 'duneride', 574 => 'sweeper', 575 => 'broadway', 576 => 'tornado', 577 => 'at 400', 578 => 'dft 30', 579 => 'huntley', 580 => 'stafford', 581 => 'bf 400', 582 => 'news van', 583 => 'tug', 584 => 'petrol tanker', 585 => 'emperor', 586 => 'wayfarer', 587 => 'euros', 588 => 'hotdog', 589 => 'club', 590 => 'freight box', 591 => 'artic trailer 3', 592 => 'andromada', 593 => 'dodo', 594 => 'rc cam', 595 => 'launch', 596 => 'cop car ls', 597 => 'cop car sf', 598 => 'cop car lv', 599 => 'ranger', 600 => 'picador', 601 => 'swat tank', 602 => 'alpha', 603 => 'phoenix', 604 => 'glendale (damage)', 605 => 'sadler (damage)', 606 => 'bag box a', 607 => 'bag box b', 608 => 'stairs', 609 => 'boxville (black)', 610 => 'farm trailer', 611 => 'utility van trailer' 
); 
														
	$resultv = $mysqli->query("SELECT * FROM rp_vehicles WHERE owning_character='".$row['ID']."' AND truncated='0'");
	$countv = $resultv->num_rows;
	if($countv > 0){
		while($rowv = $resultv->fetch_array()){
		?>
			<div style="border-radius:3px; border:2px solid #999; width:200px; border-radius:5px; width:213px; box-shadow:3px -5px 4px #999; float:left; background-color:#dffffc; margin-right:10px; margin-top:10px;">
				<div style="text-align:center;">
                	<div style="background-image:url(<?=$url_base;?>/img/vehicles/Vehicle_<?=$rowv['model'];?>.jpg); background-repeat:no-repeat; background-size:contain; height:120px; width:200px; margin-top:8px; margin-left:8px;"></div> 
                    	<h2><?php echo ucfirst($VehicleName["".$rowv['model'].""]);?></h2><hr style="margin-top:-5px;">
                    </div>
                    <div style="margin-left:8px; margin-bottom:10px;">
                    	<b>Placa:</b> <?=$rowv['plate'];?><br>
                        <b>Milhas:</b> <?=$rowv['mileage'];?>
                    </div>
                </div>
				<?php
		}
		$resultv->close();
	}
	else
	{
				?>
				<center><font size="+1"><br/></br/>Você não possui veículo.<br></font></center>
				<?php
	}
				?> 
     </div>
     </div>
</div>
<div class="col-lg-3 m-b-lg">
	<div class="ibox">
		<div class="btn btn-info block" style="background:#; "><h3>Minhas Residências</h3></div>
        	<div class="ibox-content">
            <?php
				$resulth = $mysqli->query("SELECT * FROM casas WHERE Dono='".$row['ID']."' AND Criada='1'");
				$counth = $resulth->num_rows;
				if($counth > 0){
					?>
					<ul class="list-unstyled file-list">
					<?php
					while($rowh = $resulth->fetch_array()){
					?>
						<li><i class="fa fa-home"></i><b> <b> Endereço:</b></b> $<?=$rowh['hEndereco'];?></b>
                       		<br/><div style="margin-left:18px;">
                        	<b>Valor:</b> $<?=$rowh['Preco'];?>
                        	</div>
                        </li>
					<?php
					}
					?></ul><?php
					$resulth->close();
				}
				else
				{
					?>- Você não possui residência.<?php
				}
				?> 
                                                        
            </div>
        </div>
        <div style="margin-bottom:20px;"></div>
            <div class="ibox">
            	<div class="btn btn-info block" style="background:#;"><h3>Minhas Empresas</h3></div>
                	<div class="ibox-content">
                    <?php
						
					
						$resulte = $mysqli->query("SELECT * FROM empresas WHERE Dono='".$row['ID']."' AND Criada='1'");
						$counte = $resulte->num_rows;
						if($counte > 0){
					?>
							<ul class="list-unstyled file-list">
					<?php
							while($rowe = $resulte->fetch_array()){
					?>
								<li><i class="fa fa-home"></i> <b>Endereço:</b> <?=$rowe['Nome'];?>
									<br><div style="margin-left:15px;">
									<b>Valor:</b> $<?=$rowe['Preco'];?>
									</div>
								</li>
					<?php
							}
							$resulte->close();
					?>		
							</ul>
					<?php
						}
						else {
							?>- Você não possui nenhuma empresa registrada em seu nome.<?php
						}
					?> 
                    </div>
				</div>


			        <div style="margin-bottom:20px;"></div>
            <div class="ibox">
            	<center><div class="btn btn-info block" style="background:#; margin-bottom:-2px;"><h3>Info. Administrativas</h3></div></center>
                                        	<div class="ibox-content">
									<p><p>
									<td><strong>Tempo preso:</strong> <?=$row['pTemPreso'];?> segundos</td>
									<p>
									<td><strong>Avisos:</strong> <?=$row['pAvisos'];?>/3</td>
                    </div>
				</div>
			</div>
	</div>
    <?php
	}
	?>
</div>
</div>
</div>
<?php include('ads.php'); ?>
<div class="footer">
	<div>
		<?=$footer;?>
    </div>
</div>