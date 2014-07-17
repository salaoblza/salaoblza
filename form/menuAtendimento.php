<?php
/*
 * Created on 26/11/2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
	<script language="Javascript">
	function confirmacao () {
		var resposta = confirm ("Deseja iniciar novo atendimento?");
		if (resposta == true) {
			window.location.href="realizeAtendimento.php?iniciarAtendimento=sim";
		}
	}	
	</script>		
	<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
		<h1 class="titulo">Menu Atendimento</h1>			
	</div>
	<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
		<a href="javascript:func()" onclick="confirmacao()"><img class="centerbar-img" alt="Novo Atendimento" src="../img/novoAtendimento.png"></a>
		<a href="realizeAtendimento.php"><img class="centerbar-img" alt="Atendimento" src="../img/atendimento.png"></a>
		<a href="relatorioAtendimento.php"><img class="centerbar-img" alt="Relatório" src="../img/relatorios.png"></a>
	</div>