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
if($link == '/ucp/criar') echo '<li class="active">'; else echo "<li>"; 
?>
	<a href="<?=$url_base;?>/criar"><i class="fa fa-plus-square-o"></i> <span class="nav-label">Criar Personagem</span></a>
</li>

<li>
<?php 
if($link == '/ucp/account') echo '<li class="active">'; else echo "<li>";
?>
<hr style="border: 1px solid <?=$cor_linha_menu;?>; margin-top:2px; margin-bottom:2px;">
	<a href="<?=$url_base;?>/account"><i class="fa fa-gears"></i> <span class="nav-label">Painel de Controle</span></a>


<?php
if($link == '/ucp/online') echo '<li class="active">'; else echo "<li>"; 
?>
	<a href="<?=$url_base;?>/online"><i class="fa fa-id-badge"></i> <span class="nav-label">Total online</span></a>
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
	<a href="<?=$url_base;?>/log5"><i class="fa fa-cog"></i><i class="fa  fa-sort-alpha-down"></i> <span class="nav-label">Log kick's</span></a>
	<a href="<?=$url_base;?>/log6"><i class="fa fa-cog"></i><i class="fa  fa-sort-alpha-down"></i> <span class="nav-label">Log ajail</span></a>
	<a href="<?=$url_base;?>/log7"><i class="fa fa-cog"></i><i class="fa  fa-sort-alpha-down"></i> <span class="nav-label">Log banimento</span></a>
	<a href="<?=$url_base;?>/grafico"><i class="fa fa-cog"></i><i class="fa  fa-sort-alpha-down"></i> <span class="nav-label">Gráfico</span></a>
	</ul>
 </li>
 <?php } ?>

  <?php if($pAdmin > 5){ 
	?>
	<hr style="border: 1px solid <?=$cor_linha_menu;?>; margin-top:2px; margin-bottom:2px;">
	<?php
	if($link == '/ucp/apps')
		echo '<li class="active">'; else echo "<li>"; 
		
	echo '
			<a href="#"><i class="fa fa-id-card-o"></i> <span class="nav-label">Gestão</span><span class="fa arrow"></span></a>
			<ul class="nav nav-second-level collapse">';
	if($link == '/ucp/apps') echo '<li class="active">'; else echo "<li>"; 
 ?>
	<a href="<?=$url_base;?>/log4"><i class="fa fa-archive"></i><i class="fa  fa-sort-alpha-down"></i> <span class="nav-label">Log armas</span></a>
	<a href="<?=$url_base;?>/log"><i class="fa fa-archive"></i><i class="fa  fa-sort-alpha-down"></i> <span class="nav-label">Refundo arma</span></a>
	<a href="<?=$url_base;?>/log2"><i class="fa fa-archive"></i><i class="fa  fa-sort-alpha-down"></i> <span class="nav-label">Refundo dinheiro</span></a>
	<a href="<?=$url_base;?>/log3"><i class="fa fa-archive"></i><i class="fa  fa-sort-alpha-down"></i> <span class="nav-label">Refundo itens</span></a></li>

	</ul>
 </li>
 <?php } ?>

 <!-- FIM - ÁREA DE ADMINISTRADORES-->