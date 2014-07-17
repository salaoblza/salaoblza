<?php
/*
 * Created on 28/07/2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

	include_once './util/Data.php';
 
	$data = new Data();
	
?>
	<div id="topbar" class="topbar" >	
<!--		<img class="topbar-img topbar" src="./img/salaoblzaLogo04.png"/> -->
		<h1 class="topbar-app topbar"><strong>Snoood</strong></h1>
		<h1 class="topbar-time topbar"><? print_r($data->retornaHoje()); ?></h1>				
	</div>
