<?php
include('../func/database.php');
?>
<div class="row">
	<div class="col-lg-12">
   		<div class="wrapper wrapper-content">
        	<div class="row">
             	<?php
				error_reporting(E_ALL);
				ini_set('display_startup_errors', 1);
				ini_set('display_errors', '1');
            
				$userId = $_SESSION['usuarioID'];
				$charname = $_SESSION['nomeUsuario'];

				$quant_pers = "SELECT * FROM ucp_aplic WHERE char_id='$userId' AND status = '1';";
				$result_quant_pers = $mysqli->query($quant_pers);

				var_dump(mysqli_error($mysqli));

				if(mysqli_num_rows($result_quant_pers) < 3)
				{
					$query_search = "SELECT * FROM ucp_aplic WHERE char_id='$userId' AND avaliado = '1'  ";

			        $result_ser = $mysqli->query($query_search);
			        if(mysqli_num_rows($result_ser) > 0)
			        	$semapp = 0;
			        else {
			       		echo "<h3><center>Você precisa ter uma aplicação aceita antes de criar novos personagems.</center></h3></div>";
			        	$semapp = 1;
					}
					if($semapp == 0)
					{
						?>
                        <form action="criar" method="post">
							<div class="col-lg-10 full-width" style="background:#FFF; border-radius:8px;">
                            <h2>Informações do personagem</h2>
                            <?php
								$Erros= 0;
								$Erro_nome = '';
								$Erro_Birthdate = '';
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
											$NomeP = $mysqli->escape_string($_POST['persName']);
											$sql_existe = "SELECT * FROM accounts WHERE Charname = '$NomeP' AND status != '3'";
											$resultados = $mysqli->query($sql_existe);
											if (@mysqli_num_rows($resultados) != 0){
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
										$LocalNasc = $mysqli->escape_string($_POST['local-nasc']);
									else {
										$Erro_Birthdate = "Você não escolheu o local de nascimento ao seu personagem..";
										$Erros++;
                                    }
									if($_POST['hist-pers'] != '')
										$Localhist = $mysqli->escape_string($_POST['hist-pers']);
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
												if($Erro_Birthdate != '')
													if($Erro_nome != '') echo "<br>".$Erro_Birthdate;
														else echo $Erro_Birthdate;
													if($Erro_hist != '')
														if($Erro_nome != '' || $Erro_Birthdate != '') echo "<br>".$Erro_hist;
														else echo $Erro_hist;
											?>
                                            </div>
                                        </div>
                                        <?php	
									}
									else {
										$NomeP = $mysqli->escape_string($_POST['persName']);
										$sql_existe = "SELECT * FROM accounts WHERE Charname = '$NomeP' AND status != '3'";
										$resultados = $mysqli->query($sql_existe);
										if (@mysqli_num_rows($resultados) != 0){
											$Erro_nome = "Este nome de personagem já está em uso!";
											?>
											<div class="box-erro"><div style="padding-top:5px;padding-bottom:5px;">
											<?php
												if($Erro_nome != '') echo $Erro_nome;
													if($Erro_Birthdate != '')
														if($Erro_nome != '') echo "<br>".$Erro_Birthdate;
															else echo $Erro_Birthdate;
														if($Erro_hist != '')
															if($Erro_nome != '' || $Erro_Birthdate != '') echo "<br>".$Erro_hist;
																else echo $Erro_hist;
											?>
											</div></div>
											<?php	
										}
										else {
											$histper = $mysqli->escape_string($_POST['hist-pers']);
											$login = $mysqli->escape_string($_POST['persName']);
											$localnasc = $mysqli->escape_string($_POST['local-nasc']);
											$histper = $mysqli->escape_string($_POST['hist-pers']);
											$charname = $_SESSION['nomeUsuario'];
											$genero = $mysqli->escape_string($_POST['genero']);
											$Birthdate = $mysqli->escape_string($_POST['Birthdate']);
											$date = new DateTime();
											$timestamp = $date->getTimestamp();

											$UserID = $_SESSION['usuarioID'];
											
											$query_aplic = "SELECT * FROM ucp_aplic WHERE char_id='$UserID' AND avaliado ='2' LIMIT 1 ";
											$result_aplic = $mysqli->query($query_aplic);

											$res1=mysqli_fetch_array($result_aplic);
														
											$rp = $res1['def_rol'];
											$mg = $res1['def_mg'];
											$kill = $res1['def_matar'];
											$fear = $res1['def_fear'];
											$ioc = $res1['def_ioc'];
											$pg = $res1['def_pg'];
														
											$sql2="INSERT INTO accounts (Username,Charname,Skin,Gender,Birthdate,Origin,CreateDate) VALUES ('$charname','$login','29','$genero','$Birthdate','$localnasc','$timestamp')"; 
											$mysqli->query($sql2);
											$own = mysqli_insert_id();
														
											$sql_app="INSERT INTO ucp_aplic (OwnId,def_rol, avaliado) VALUES ('$own','$rp','0')";
											$mysqli->query($sql_app);
												
											$sql_app2="UPDATE ucp_aplic SET def_mg='$mg', def_matar='$kill' WHERE OwnId = '$own'"; 
											$mysqli->query($sql_app2);
														
											$sql_app3="UPDATE ucp_aplic SET def_fear='$fear', def_ioc='$ioc', histpers='$histper' WHERE OwnId = '$own'"; 
											$mysqli->query($sql_app3);
														
											$sql_app4="UPDATE ucp_aplic SET def_pg='$pg', novopers='1', histpers='$histper' WHERE OwnId = '$own'"; 
											$mysqli->query($sql_app4);
														
				
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
                                        <input id="Birthdate" name="Birthdate" type="text" class="form-control required" value="<?php if($_POST['Birthdate']) echo $_POST['Birthdate'];?>">
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
	                                    <span class="input-group-addon"></span><input id="Birthdate" name="Birthdate" type="text" class="form-control" value="18 (Use somente numeros)">
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