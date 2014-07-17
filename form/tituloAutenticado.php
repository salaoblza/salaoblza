<?php
/*
 * Created on 28/07/2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 	include_once '../util/Data.php';
 
	$data = new Data();
?>
	<div id="topbar" class="topbar" >	
		<a href="principal.php"><img class="topbar-img topbar" src="../img/salaoblzaLogo02.png"></a>		
		<h1 class="topbar-user topbar">	Bem vindo, <?= $_SESSION['usuarioNome'] ?></h1>
		<h1 class="topbar-out  topbar">[<a href="logout.php">Sair</a>]</h1>		
		<h1 class="topbar-time topbar"><? print_r($data->retornaHoje()); ?></h1>						
	</div>
