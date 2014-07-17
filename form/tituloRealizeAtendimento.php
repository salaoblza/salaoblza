<?php
/*
 * Created on 10/11/2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 	include_once '../util/Data.php';
 
	$data = new Data();
?>
	<div id="topbaratendimento" class="topbaratendimento" >	
		<img class="centerimgatendimento" src="../img/logo_marilia_01.gif">		
		<h1 class="topbar-time topbar"><? print_r($data->retornaHoje()); ?></h1>						
	</div>

