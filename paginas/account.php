<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-sm-4">
    	<h2>Minha conta</h2>
        <ol class="breadcrumb">
        	<li class="active">
        		<strong>Mudar senha</strong>
            </li>
        </ol>
     </div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="wrapper wrapper-content">
      		<div class="row">
           		<div class="col-sm-8">
              		<div class="ibox">
                  		<div class="ibox-content">
                        	<?php
                        	if(isset($_POST['pass1']))
                        	{
                        		$senhaatt = $mysqli->real_escape_string($_POST['pass1']);
  								$senhanova = $mysqli->real_escape_string($_POST['pass2']);
  				
  								$login = $_SESSION['nomeUsuario'];
  				
  								$hashedPassword = strtoupper(hash( 'whirlpool',$senhaatt)); 
  								$hashedPasswordnew = strtoupper(hash( 'whirlpool',$senhanova)); 
  								
								$resulti = $mysqli->query("SELECT uSenha FROM ucp_users WHERE uNome='".$login."' AND uSenha='".$hashedPassword."' LIMIT 1");
								$count = $resulti->num_rows;
								if($count == 1){
									$row = $resulti->fetch_array();

									if($hashedPassword == $row['uSenha'])
									{
										$resultp = $mysqli->query("UPDATE ucp_users SET uSenha='".$hashedPasswordnew."' WHERE uNome='".$login."' LIMIT 1");
										
										echo "Senha alterada com sucesso.";
									} 
									else
										echo "Ocorreu um erro durante a troca de senha... Se persistir, contate o Freeze.";
								}
								else
									echo "A senha atual está incorreta.";
                        	}
                        	else
                        	{
                        		?>
								<form id="form" name="form" action="account" class="wizard-big" method="post">
	                                <fieldset>
	                                	<div class="row">
	                                    	<div class="col-md-4">
	                                    		<h2>Alterar senha da conta</h2>
	                                    <label>Digite sua senha atual</label>
                                          <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                              <input id="pass1" name="pass1" type="password" class="form-control required">
                                             </div>
                                          </div>
                                          		<label>Digite sua nova senha </label>
												<p>Essa senha nao altera a senha do seu personagem. Para isso devera alterar dentro do jogo.</p>
	                                            <div class="form-group">
	                                            	<div class="input-group">
	                                            	<span class="input-group-addon"><i class="fa fa-key"></i></span>
	                                                <input id="pass2" name="pass2" type="password" class="form-control required">
	                                            </div>
	                                        </div>
               
	                                <div class="col-lg-12" style="float:right;">
										<div class="ibox">
											 <button type="submit" class="btn btn-primary btn-outline float-button-light waves-effect waves-button waves-float waves-light">Alterar Senha</button>			
										</div>
									</div>
	                              	</fieldset>
	                            </form>
                            	<?php
                            }
                            	?>
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
</div>
        
