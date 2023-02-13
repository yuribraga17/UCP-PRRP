<div class="row">
	<div class="col-lg-12">
   		<div class="wrapper wrapper-content">
        	<div class="row">
             	<?php
             	error_reporting(1);
                ini_set(“display_errors”, 0 );
             	include('../func/database.php');
             	
				if(mysql_num_rows($result_quant_pers) < 0){
					$query_search = "SELECT * FROM accounts WHERE Username='$charname' AND status = '1'  ";
			        $result_ser = mysql_query($query_search)or die (mysql_error());
			        if(mysql_num_rows($result_ser) > 0)
			        	$semapp = 0;
			        else {
			       		echo "<h3><center>Você precisa ter uma aplicação aceita antes de criar novos personagens.</center></h3></div>";
			        	$semapp = 1;
					}
					if($semapp == 0)
					{
						?>
                        <form action="criar.php" method="post">
							<div class="col-lg-10 full-width" style="background:#FFF; border-radius:8px;">
                            <h2>Informações do personagem</h2>
                            <?php
								$Erros= 0;
								$Erro_nome = '';
								$Erro_Age = '';
								$Erro_hist = '';
								if(isset($_POST['persName']) || isset($_POST['local-nasc']) || isset($_POST['hist-pers'])){
									if($_POST['persName'] != ''){
										$findme    = '_';
										$pos1 = stripos($_POST['persName'], $findme);
										if ($pos1 === false){
											$Erro_nome = "O seu nome deve ser no formato 'Nome_Sobrenome'.";
											$Erros++;
										}
										if( preg_match('/\s/', $_POST['persName'])){
											$Erro_nome = "O Nome do seu personagem não pode conter espaço.";
											$Erros++;
										}
										if($Erros == 0){
											$NomeP = mysql_escape_string($_POST['persName']);
											$sql_existe = "SELECT * FROM accounts WHERE Charname = '$NomeP' AND status != '3'";
											$resultados = mysql_query($sql_existe)or die (mysql_error());
											if (@mysql_num_rows($resultados) != 0){
												$Erro_nome = "Este nome de personagem já está em uso!";
												$Erros++;
											}
										}
									}
									else {
										$Erro_nome = "Você não deu um nome ao seu personagem..";
										$Erros++;
                                    }
									if($_POST['local-nasc'] != '')
										$LocalNasc = mysql_escape_string($_POST['local-nasc']);
									else {
										$Erro_Age = "Você não escolheu o local de nascimento ao seu personagem..";
										$Erros++;
                                    }
									if($_POST['hist-pers'] != '')
										$Localhist = mysql_escape_string($_POST['hist-pers']);
									else {
										$Erro_hist = "Você deve escrever a história de seu personagem..";
										$Erros++;
                                    }
									
									if($Erros > 0) {
							?>
                                   		<div class="box-erro">
											<div style="padding-top:5px;padding-bottom:5px;">
											<?php
												if($Erro_nome != '') echo $Erro_nome;
												if($Erro_Age != '')
													if($Erro_nome != '') echo "<br>".$Erro_Age;
														else echo $Erro_Age;
													if($Erro_hist != '')
														if($Erro_nome != '' || $Erro_Age != '') echo "<br>".$Erro_hist;
														else echo $Erro_hist;
											?>
                                            </div>
                                        </div>
                                        <?php	
									}
									else {
										$NomeP = mysql_escape_string($_POST['persName']);
										$sql_existe = "SELECT * FROM accounts WHERE Charname = '$NomeP' AND status != '3'";
										$resultados = mysql_query($sql_existe)or die (mysql_error());
										if (@mysql_num_rows($resultados) != 0){
											$Erro_nome = "Este nome de personagem já está em uso!";
											?>
											<div class="box-erro"><div style="padding-top:5px;padding-bottom:5px;">
											<?php
												if($Erro_nome != '') echo $Erro_nome;
													if($Erro_Age != '')
														if($Erro_nome != '') echo "<br>".$Erro_Age;
															else echo $Erro_Age;
														if($Erro_hist != '')
															if($Erro_nome != '' || $Erro_Age != '') echo "<br>".$Erro_hist;
																else echo $Erro_hist;
											?>
											</div></div>
											<?php	
										}
										else {
											$histper = mysql_escape_string($_POST['hist-pers']);
											$login = mysql_escape_string($_POST['persName']);
											$localnasc = mysql_escape_string($_POST['local-nasc']);
											$histper = mysql_escape_string($_POST['hist-pers']);
											$charname = $_SESSION['nomeUsuario'];
											$genero = mysql_escape_string($_POST['genero']);
											$Age = mysql_escape_string($_POST['Age']);
											$date = new DateTime();
											$timestamp = $date->getTimestamp();
														
											$query_search = "SELECT * FROM accounts WHERE Username='$charname' and status ='1' LIMIT 1 ";
											$result_ser = mysql_query($query_search)or die (mysql_error());
											$res=mysql_fetch_array($result_ser);
														
											$UserID = $res['ID'];
											
											$query_aplic = "SELECT * FROM ucp_aplic WHERE OwnId='$UserID' AND avaliado ='2' LIMIT 1 ";
											$result_aplic = mysql_query($query_aplic)or die (mysql_error());
											$res1=mysql_fetch_array($result_aplic);
														
											$rp = $res1['def_rol'];
											$mg = $res1['def_mg'];
											$kill = $res1['def_matar'];
											$fear = $res1['def_fear'];
											$ioc = $res1['def_ioc'];
											$pg = $res1['def_pg'];
														
											$sql2="INSERT INTO accounts (Username,Charname,Skin,Gender,Age,Origin,CreateDate) VALUES ('$charname','$login','29','$genero','$Age','$localnasc','$timestamp')"; 
											mysql_query($sql2)or die (mysql_error());
											$own = mysql_insert_id();
														
											$sql_app="INSERT INTO ucp_aplic (OwnId,def_rol, avaliado) VALUES ('$own','$rp','0')";
											mysql_query($sql_app)or die (mysql_error());
												
											$sql_app2="UPDATE ucp_aplic SET def_mg='$mg', def_matar='$kill' WHERE OwnId = '$own'"; 
											mysql_query($sql_app2)or die (mysql_error());
														
											$sql_app3="UPDATE ucp_aplic SET def_fear='$fear', def_ioc='$ioc', histpers='$histper' WHERE OwnId = '$own'"; 
											mysql_query($sql_app3)or die (mysql_error());
														
											$sql_app4="UPDATE ucp_aplic SET def_pg='$pg', novopers='1', histpers='$histper' WHERE OwnId = '$own'"; 
											mysql_query($sql_app4)or die (mysql_error());
														
				
											?>
											<div style="height:40px; background-color:#096; color:#FFF; border:1px solid #093; border-radius:8px; padding-top:10px; margin-bottom:15px;">
												<center><b>Aplicação enviada com sucesso.</b></center>
											</div>
											<?php
										}
									}
								}
								if($Erros > 0) {
											?>
                                	<div class="form-group">
                                    	<label>Nome do personagem * <font size="-8">(Nome_Sobrenome)</font></label>
                                        <input id="persName" name="persName" type="text" class="form-control required" value="<?php if($_POST['persName']) echo $_POST['persName'];?>">
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
                                        <input id="Age" name="Age" type="text" class="form-control required" value="<?php if($_POST['Age']) echo $_POST['Age'];?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                    	<label>Onde seu personagem nasceu? *</label>
                                        <input id="local-nasc" name="local-nasc" type="text" class="form-control required" value="<?php if($_POST['local-nasc']) echo $_POST['local-nasc'];?>">
                                    </div>
                                    <div class="form-group">
                                    	<label>Conte-nos a história de seu personagem *</label>
                                        <textarea id="hist-pers" name="hist-pers" class="form-control required" style="min-height:150px;"><?php if($_POST['hist-pers']) echo $_POST['hist-pers']; ?></textarea>
                                    </div>
                                    <div align="right">
                                    	<button type="submit" class="btn btn-primary block m-b">Enviar Aplicação</button>
                                    </div>
                                    <?php
								}
								else {
									?>
									<div class="form-group">
										<label>Nome do personagem * <font size="-8">(Nome_Sobrenome)</font></label>
										<input id="persName" name="persName" type="text" class="form-control required" value="">
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
										<input id="local-nasc" name="local-nasc" type="text" class="form-control required" value="">
									</div>
									<div class="form-group">
										<label>Conte-nos a história de seu personagem *</label>
										<textarea id="hist-pers" name="hist-pers" class="form-control required" style="min-height:150px;"></textarea>
									</div>
									<div align="right">
										<button type="submit" class="btn btn-primary block m-b">Enviar Aplicação</button>
									</div>	
                                    <?php
								}
									?>
							</div>
                        </form>
					</div>
                    <?php
				}
			}
			else {
					?>
            	<div class="box-erro"><div style="padding-top:5px;padding-bottom:5px;">
                	Você já alcançou o limite de personagens.
                </div></div>
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
