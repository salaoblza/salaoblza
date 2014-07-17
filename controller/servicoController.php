<?php

include_once '../DAO/ServicoDAO.php';
include_once '../entity/Servico.php';

	$funcao = '';

	// busca a funcao solicitada nos parametros
	if (isset($_POST['funcao'])) {
		$funcao = mysql_real_escape_string($_POST['funcao']);
	}
	
	// realiza cada tratamento, de acordo com a funcao passada
	if ($funcao != null) {
		switch ($funcao) { 
			// utilizado pelo flexigrid do menu "gerênciar serviços"
			case "consultaViaGridComPaginacao": {					
				$page = 1; 			// página default
				$sortname = 'nome'; // coluna para ordenação
				$sortorder = 'asc'; // ordenação ascendente
				$qtype = ''; 		// coluna default para pesquisa
				$query = ''; 		// string de pesquisa
				$rp = 5;			// quantidade de dados por pagina
				
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
				
				$dao = new ServicoDAO();
				
				// chamada do método DAO correspondente com passagem de parametros POST
				$retorno =  $dao->consultaViaGridComPaginacao($page, $sortname, $sortorder, $qtype, $query, $rp);
				
				echo $retorno;
				
				break;
			} // case consulta grid com paginacao
			case "insereOuAtualizaViaGrid": {
				//declara um novo servico
				$servico = new Servico();
				
				// busca os dados do servico passado por post
				if (isset($_POST['id_servico'])) {
					$servico->setId(mysql_real_escape_string($_POST['id_servico']));
				}				
				if (isset($_POST['nome'])) {
					$servico->setNome(mysql_real_escape_string($_POST['nome']));
				}
				if (isset($_POST['preco'])) {
					$servico->setPreco(mysql_real_escape_string($_POST['preco']));
				}
				if (isset($_POST['descricao'])) {
					$servico->setDescricao(mysql_real_escape_string($_POST['descricao']));
				}
				
				// dao usado para conexao com banco de dados
				$dao = new ServicoDAO();
				
				/* se o id_servico é passado então trata-se de uma atualização, caso contrário trata-se de uma inserção */		
				if ($servico->getId() != null) {						
					// chamada do método DAO correspondente com passagem de parametros POST
					$retorno =  $dao->atualizaViaGrid($servico);	
				} else {
					// chamada do método DAO correspondente com passagem de parametros POST
					$retorno =  $dao->insereViaGrid($servico);					
				}
				
				echo $retorno;
				
				break;				
			} // case insere com grid
			case "apagaViaGrid": {
				//servico a ser excluido
				$servico = new Servico();
				
				// busca os dados do servico passado por post
				if (isset($_POST['id_servico'])) {
					$servico->setId(mysql_real_escape_string($_POST['id_servico']));
				}

				// dao usado para conexao com banco de dados
				$dao = new ServicoDAO();
				
				/* se o id_servico é passado então exclui o serviço */		
				if ($servico->getId() != null) {						
					// chamada do método DAO correspondente com passagem de parametros POST
					$retorno =  $dao->apagaViaGrid($servico);	
				} 
				
				echo $retorno;
				
				break;
			}
		}		
	} 

?>