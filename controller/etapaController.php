<?php

include_once '../DAO/EtapaDAO.php';
include_once '../entity/Etapa.php';

	$funcao = '';

	// busca a funcao solicitada nos parametros
	if (isset($_POST['funcao'])) {
		$funcao = mysql_real_escape_string($_POST['funcao']);
	}
	
	// realiza cada tratamento, de acordo com a funcao passada
	if ($funcao != null) {
		switch ($funcao) { 
			// utilizado pelo flexigrid do menu "gerênciar serviços" (operação de gerenciar etapas)
			case "consultaViaGridComPaginacao": {					
				$page = 1; 				// página default
				$sortname = 'id_etapa'; // coluna para ordenação
				$sortorder = 'asc'; 	// ordenação ascendente
				$qtype = ''; 			// coluna default para pesquisa
				$query = ''; 			// string de pesquisa
				$rp = 5;				// quantidade de dados por pagina
				$id_servico = '';
				
				// verificação dos parametros via post
				if (isset($_POST['page'])) {
					$page = mysql_real_escape_string($_POST['page']);
				}
				if (isset($_POST['sortname'])) {
					$sortname = mysql_real_escape_string($_POST['sortname']);
				}
				if (isset($_POST['sortorder'])) {
					$sortorder = mysql_real_escape_string($_POST['sortorder']);
				}
				if (isset($_POST['qtype'])) {
					$qtype = mysql_real_escape_string($_POST['qtype']);
				}
				if (isset($_POST['query'])) {
					$query = mysql_real_escape_string($_POST['query']);
				}	
				if (isset($_POST['rp'])) {
					$rp = mysql_real_escape_string($_POST['rp']);
				}
				if (isset($_POST['id_servico'])) {
					$id_servico = mysql_real_escape_string($_POST['id_servico']);
				}
				
				$dao = new EtapaDAO();
				
				// chamada do método DAO correspondente com passagem de parametros POST
				$retorno =  $dao->consultaViaGridComPaginacao($page, $sortname, $sortorder, $qtype, $query, $rp, $id_servico);
				
				echo $retorno;
				
				break;
			} // case consulta grid com paginacao
			case "insereOuAtualizaViaGrid": {
				//declara uma nova etapa
				$etapa = new Etapa();
				
				// busca os dados da etapa passados por post
				if (isset($_POST['id_etapa'])) {
					$etapa->setId(mysql_real_escape_string($_POST['id_etapa']));
				}
				if (isset($_POST['id_servico'])) {
					$etapa->setIdServico(mysql_real_escape_string($_POST['id_servico']));
				}								
				if (isset($_POST['tipo'])) {
					$etapa->setTipo(mysql_real_escape_string($_POST['tipo']));
				}
				if (isset($_POST['descricao'])) {
					$etapa->setDescricao(mysql_real_escape_string($_POST['descricao']));
				}				
				if (isset($_POST['tempo'])) {
					$etapa->setTempo(mysql_real_escape_string($_POST['tempo']));
				}
				
				// dao usado para conexao com banco de dados
				$dao = new EtapaDAO();
				
				/* se o id_etapa é passado então trata-se de uma atualização, caso contrário trata-se de uma inserção */		
				if ($etapa->getId() != null) {						
					// chamada do método DAO correspondente com passagem de parametros POST
					$retorno =  $dao->atualizaViaGrid($etapa);	
				} else {
					// chamada do método DAO correspondente com passagem de parametros POST
					$retorno =  $dao->insereViaGrid($etapa);					
				}
				
				echo $retorno;
				
				break;				
			} // case insere com grid
			case "apagaViaGrid": {
				// etapa a ser excluida
				$etapa = new Etapa();
				
				// busca os dados da etapa passados por post
				if (isset($_POST['id_etapa'])) {
					$etapa->setId(mysql_real_escape_string($_POST['id_etapa']));
				}

				// dao usado para conexao com banco de dados
				$dao = new EtapaDAO();
				
				/* se o id_etapa é passado então exclui a etapa */
				if ($etapa->getId() != null) {						
					// chamada do método DAO correspondente com passagem de parametros POST
					$retorno =  $dao->apagaViaGrid($etapa);	
				} 
				
				echo $retorno;
				
				break;
			}
		}		
	} 

?>