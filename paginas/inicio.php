<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-sm-4">
		<h2>Personagens</h2>
       	<ol class="breadcrumb">
            <li class="active">
            	<strong>Meus personagens</strong>
            </li>
        </ol>
	</div>
</div>
<div class="row">
	<div class="col-sm-10"> 
    	<div class="wrapper wrapper-content">
        	<div class="row">
            <?php 
				$personagens_count = 0;
				$result = $mysqli->query("SELECT ID,Username,Skin,CreateDate,UltimoLogin FROM accounts WHERE ucpOwn='".$_SESSION['usuarioID']."'");
				$count = $result->num_rows;
				if($count > 0){
					while($row = $result->fetch_object()){
						$personagens_count++;
			?>
						
                    	<div class="col-lg-5">
                        	<div class="ibox float-e-margins ">
                            	<div class="ibox-title">
                                	<h5><center><?=str_replace("_"," ", $row->Username);?></center></h5> 
                                    <?php 
									$status_p = 1;
									if($status_p == 0) { ?><span class="label label-primary pull-right bg-warning">Em avaliação</span><?php }
									else if($status_p == 1) { ?><span class="label label-primary pull-right">Vivo</span><?php }
									else if($status_p == 2) { ?><span class="label label-primary pull-right bg-danger">Morto</span><?php }
									else if($status_p == 3) { ?><span class="label label-primary pull-right bg-danger">Banido</span><?php }
									?>
                                    <div class="ibox-tools">
                                    	<a class="collapse-link" style="margin-right:8px;">
                                        	<i class="fa fa-chevron-up"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="ibox-content">
                                	<div>
                                    	<h4>
										<style>
                                        .img-skin-<?=$row->Skin?> {
                                        	background:url(img/skins/<?=$row->Skin;?>.png);
                                            width:200px;
                                           	height:200px;
                                            background-repeat:no-repeat;
                                            background-size:contain;
                                            margin-left:25%;
                                        }
                                        </style>
                                      	<div class="img-skin-<?=$row->Skin;?>"></div><hr>
                                       	<table>
                                            <tr>
                                                <td><small class="m-r"><b>Data de Criação:</b></small></td><td><small class="m-r">
												<?php echo date("d/m/Y",$row->CreateDate); ?></small></td>
                                            </tr><tr>
                                                <td><small class="m-r"><b>Último login:</b></small></td><td><small class="m-r"><?=$row->UltimoLogin;?> </small></td>
											</tr>
                                        </table><br/><br/>
                                        
                                        <?php 
											$status_p = 1;
											if($status_p == 0) { ?><button type="submit" class="btn btn-primary block full-width m-b" disabled>Em avaliação</button><?php }
											else if($status_p > 0) { ?><a href="personagem/<?=$row->ID;?>"><button type="submit" class="btn btn-info block full-width m-b">Ver Informações</button></a><?php }
										?>
                                        
                                        </h4>
                                    </div>
								</div>
							</div>
						</div>
                        <?php
					}
				}
				if ($result1 = $mysqli->query("SELECT Charname,Skin,CreateDate,avaliado,appID FROM ucp_aplic WHERE ucp_user_owner='".$_SESSION['usuarioID']."' AND avaliado!='1'")) {
					while($row1 = $result1->fetch_object()){
						$personagens_count++;
			?>
					
                    	<div class="col-lg-4">
                        	<div class="ibox float-e-margins ">
                            	<div class="ibox-title">
                                	<h5><center><?=str_replace("_"," ", $row1->Charname);?></center></h5> 
                                    <?php 
									$status_p = $row1->avaliado;
									if($status_p == 0) { ?><span class="label label-primary pull-right bg-warning">Em avaliação</span><?php }
									else if($status_p == 1) { ?><span class="label label-primary pull-right">Vivo</span><?php }
									else if($status_p == 2) { ?><span class="label label-primary pull-right bg-danger">Negado</span><?php }
									else if($status_p == 3) { ?><span class="label label-primary pull-right bg-danger">Banido</span><?php }
									?>
                                    <div class="ibox-tools">
                                    	<a class="collapse-link" style="margin-right:8px;">
                                        	<i class="fa fa-chevron-up"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="ibox-content">
                                	<div>
                                    	<h4>
										<style>
                                        .img-skin-<?=$row1->Skin?> {
                                        	background:url(img/skins/<?=$row1->Skin;?>.png);
                                            width:170px;
                                           	height:170px;
                                            background-repeat:no-repeat;
                                            background-size:contain;
                                            margin-left:25%;
                                        }
                                        </style>
                                      	<div class="img-skin-<?=$row1->Skin;?>"></div><hr>
                                       	<table>
                                            <tr>
                                                <td><small class="m-r"><b>Data de Criação:</b></small></td><td><small class="m-r">
												<?php echo date("d/m/Y",$row1->CreateDate); ?></small></td>
                                            </tr><tr>
                                                <td><small class="m-r"><b>Último login:</b></small></td><td><small class="m-r">Nunca </small></td>
											</tr>
                                        </table><br/><br/>
                                        
                                        <?php 
											$status_p = $row1->avaliado;
											if($status_p == 0) { ?><button type="submit" class="btn btn-primary block full-width m-b" disabled>Em avaliação</button><?php }
											else if($status_p == 2) { ?><button type="submit" class="btn btn-danger block full-width m-b" disabled>Negado</button>
											<a href="verapp/<?=$row1->appID;?>"><center><br/><u>Reenviar aplicação</u></center></a><?php }
										?>
                                        
                                        </h4>
                                    </div>
								</div>
							</div>
						</div>
                        <?php
					}
				}
				
				if($personagens_count == 0) {
						?>
                	<div class="ibox float-e-margins ">
                    	<div style="text-align:center;">
                        	<h4> Você não tem personagens... Tente criar um! </h4><br/>
                            <font size="+4">:(</font>
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
</div>
     
