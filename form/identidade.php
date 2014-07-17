<?php
/*
 * Created on 28/07/2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
		<div id="leftbar" class="leftbar" >	
			<img class="leftbar-img  leftbar" src="../img/cabelo_bonito.jpg"/>
			<p> </p>
			<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
				<h1 class="titulo">Belezômetro</h1>
			</div>		
				<img class="leftbar-img-blza"src="../img/progress.png"/>			
				<p> </p>
			<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
				<h1 class="titulo">Identidade</h1>		
				<p> </p>	
			</div>
				<h1 class="leftbar-menu-op  leftbar"><?="Telefone: " . $_SESSION['usuarioTelefone'];?> </h1>
				<h1 class="leftbar-menu-op  leftbar"> <?="E-mail: " . $_SESSION['usuarioEmail'];?> </h1>
				<h1 class="leftbar-menu-op  leftbar"> <?="Data de Nascimento: " . $_SESSION['usuarioDt_Nasc'];?> </h1>
				<h1 class="leftbar-menu-op  leftbar"> <?="Sexo: " . $_SESSION['usuarioSexo'];?> </h1> 
				<h1 class="leftbar-menu-op  leftbar"> <?="Facebook: " . $_SESSION['usuarioFacebook'];?> </h1>
				<h1 class="leftbar-menu-op  leftbar"> <?="Twitter: " . $_SESSION['usuarioTwitter'];?> </h1>		
		</div>
