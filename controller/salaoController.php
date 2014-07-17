<?php
/*
 * Created on 31/07/2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

include_once '../DAO/SalaoDAO.php';
include_once '../entity/Salao.php';

	$funcao = '';

	// busca a funcao solicitada nos parametros
	if (isset($_POST['funcao'])) {
		$funcao = mysql_real_escape_string($_POST['funcao']);
	}
	
	// realiza cada tratamento, de acordo com a funcao passada
	if ($funcao != null) {
		switch ($funcao) { 
			case "insereOuAtualizaViaGrid": {
				//declara um novo salao
				$salao = new salao();
				
				// busca os dados do salao passado por post
				if (isset($_POST['id_salao'])) {
					$salao->id_salao = mysql_real_escape_string($_POST['id_salao']);
				}
				if (isset($_POST['nome'])) {
					$salao->nome = mysql_real_escape_string($_POST['nome']);
				}
				if (isset($_POST['endereco'])) {
					$salao->endereco = mysql_real_escape_string($_POST['endereco']);
				}
				if (isset($_POST['bairro'])) {
					$salao->bairro = mysql_real_escape_string($_POST['bairro']);
				}
				if (isset($_POST['municipio'])) {
					$salao->municipio = mysql_real_escape_string($_POST['municipio']);
				}
				if (isset($_POST['estado'])) {
					$salao->estado = mysql_real_escape_string($_POST['estado']);
				}
				if (isset($_POST['telefone1'])) {
					$salao->telefone1 = mysql_real_escape_string($_POST['telefone1']);
				}
				if (isset($_POST['telefone2'])) {
					$salao->telefone2 = mysql_real_escape_string($_POST['telefone2']);
				}
				if (isset($_POST['email'])) {
					$salao->email = mysql_real_escape_string($_POST['email']);
				}
				if (isset($_POST['twitter'])) {
					$salao->twitter = mysql_real_escape_string($_POST['twitter']);
				}
				if (isset($_POST['facebook'])) {
					$salao->facebook = mysql_real_escape_string($_POST['facebook']);
				}	
				if (isset($_POST['site'])) {
					$salao->site = mysql_real_escape_string($_POST['site']);
				}	
				
				// dao usado para conexao com banco de dados
				$dao = new salaoDAO();				
				
				/* se o id_salao é passado então trata-se de uma atualização, caso contrário trata-se de uma inserção */		
				if ($salao->id_salao != null) {						
					// chamada do método DAO correspondente com passagem de parametros POST
					$retorno =  $dao->atualizaViaGrid($salao);	
				} else {
					// chamada do método DAO correspondente com passagem de parametros POST
//					$retorno =  $dao->insereViaGrid($salao);
					$retorno =  $dao->insere($salao);						
				}
				
				echo $retorno;
				
				break;				
			} // case insere com grid
		}		
	} 

?>
?>
