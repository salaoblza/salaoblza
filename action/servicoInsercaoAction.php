<?php
/*
 * Created on 22/02/2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
include_once '../entity/Servico.php';
include_once '../entity/Etapa.php';
include_once '../DAO/servicoDAO.php';
include_once '../DAO/etapaDAO.php';
 

act();
	
function act() {
	session_start("servicos");
//	print_r($_SESSION);
//	print_r($_POST);
	$servico = new servico(null, $_SESSION["nome"],$_SESSION["descricaoServico"],$_SESSION["preco"]);
		
	servicoDAO::insere($servico);

	//@TODO rever a forma de chamar o inserir etapa...
	for ($i = 1; $i <= $_POST["qtdEtapas"]; $i++) {
		echo "ID Servico " . $servico->id_servico;
	    $etapa = new etapa(null, $servico->id_servico,$_POST["tipoEtapa" . $i], $_POST["descricaoEtapa" . $i],$_POST["tempoEtapa" . $i]);
		etapaDAO::insere($etapa);
	}
 	
  
}


 
?>
