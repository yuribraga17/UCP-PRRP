<?php

$link=$_SERVER['REQUEST_URI'];

$result = $mysqli->query("SELECT admin FROM ucp_users WHERE uID='".$_SESSION['usuarioID']."' LIMIT 1");
$row = $result->fetch_object();
$pAdmin = $row->admin;
$result->close();





if($link == '/ucp/inicio') echo '<li class="active">'; else echo "<li>";
?>
<hr style="border: 1px solid <?=$cor_linha_menu;?>; margin-top:2px; margin-bottom:2px;">
	<a href="<?=$url_base;?>/inicio"><i class="fa fa-bars"></i> <span class="nav-label">Inicio</span></a>
	</li>

<hr style="border: 1px solid <?=$cor_linha_menu;?>; margin-top:2px; margin-bottom:2px;">
<?php
if($link == '/ucp/faq') echo '<li class="active">'; else echo "<li>"; 

?>
	<a href="<?=$url_base;?>/faq"><i class="fa fa-stack-exchange"></i> <span class="nav-label">FAQ</span></a>
</li>
<?php 
if($link == '/ucp/doacoes') echo '<li class="active">'; else echo "<li>";
?>
<hr style="border: 1px solid <?=$cor_linha_menu;?>; margin-top:2px; margin-bottom:2px;">
	<a href="<?=$url_base;?>/doacoes"><i class="fa fa-usd"></i> <span class="nav-label">Premium</span></a>

</li>

<?php 
if($link == '/ucp/inicio') echo '<li class="active">'; else echo "<li>";
?>
<hr style="border: 1px solid <?=$cor_linha_menu;?>; margin-top:2px; margin-bottom:2px;">
	<a href="<?=$url_base;?>/inicio"><i class="fa fa-user"></i> <span class="nav-label">Meus Personagens</span></a>

</li>
<?php 
if($link == '/ucp/account') echo '<li class="active">'; else echo "<li>";
?>
<hr style="border: 1px solid <?=$cor_linha_menu;?>; margin-top:2px; margin-bottom:2px;">
	<a href="<?=$url_base;?>/account"><i class="fa fa-gears"></i> <span class="nav-label">Painel de Controle</span></a>

<?php
if($link == '/ucp/criar') echo '<li class="active">'; else echo "<li>"; 
?>
	<a href="<?=$url_base;?>/criar"><i class="fa fa-plus-square-o"></i> <span class="nav-label">Criar Personagem</span></a>
</li>











<!-- ÁREA DE ADMINISTRADORES-->
 <?php if($pAdmin > 1){ 
	?>
	<hr style="border: 1px solid <?=$cor_linha_menu;?>; margin-top:2px; margin-bottom:2px;">
	<?php
	if($link == '/ucp/apps')
		echo '<li class="active">'; else echo "<li>"; 
		
	echo '
			<a href="#"><i class="fa fa-gavel"></i> <span class="nav-label">Administração</span><span class="fa arrow"></span></a>
			<ul class="nav nav-second-level collapse">';
	if($link == '/ucp/apps') echo '<li class="active">'; else echo "<li>"; 
 ?>
	<a href="<?=$url_base;?>/apps"><i class="fa fa-folder-open"></i> <span class="nav-label">Aplicações</span></a>
	<a href="logsadmin"><i class="fa  fa-sort-alpha-down"></i> <span class="nav-label">Log Administrativo</span></a></li>

	</ul>
 </li>
 <?php } ?>

 <!-- FIM - ÁREA DE ADMINISTRADORES-->





<!-- Start Footer Section --> 
<?php 
	?>
	<hr style="border: 1px solid <?=$cor_linha_menu;?>; margin-top:2px; margin-bottom:2px;">
	<?php
	if($link == '/ucp')
		echo '<li class="active">'; else echo "<li>"; 
		
	echo '
			<a href="#"><i class="fa fa-flag"></i> <span class="nav-label">Links Úteis</span><span class="fa arrow"></span></a>
			<ul class="nav nav-second-level collapse">';
	if($link == 'www.google.cm') echo '<li class="active">'; else echo "<li>"; 
?>
	<a href="https://forum.sp-roleplay.com.br"><i class="fa  fa-angle-right"></i> <span class="nav-label">Fórum</span></a>
	<a href="https://forum.sp-roleplay.com.br/viewforum.php?f=36"><i class="fa  fa-angle-right"></i> <span class="nav-label">Regras</span></a>
	<a href="https://forum.sp-roleplay.com.br/viewforum.php?f=142"><i class="fa  fa-angle-right"></i> <span class="nav-label">Reporte um bug</span></a>
	<a href="https://forum.sp-roleplay.com.br/viewforum.php?f=109"><i class="fa  fa-angle-right"></i> <span class="nav-label">Denúncias</span></a>
	<a href="https://forum.sp-roleplay.com.br/viewforum.php?f=131"><i class="fa  fa-angle-right"></i> <span class="nav-label">Equipe de Banimentos</span></a>

	</ul></li></li>
</li>
<!-- Start Footer Section -->
