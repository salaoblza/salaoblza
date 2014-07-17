<?php

include_once '../DAO/UsuarioDAO.php';
include_once '../entity/Usuario.php';

	$funcao = '';

	// busca a funcao solicitada nos parametros
	if (isset($_POST['funcao'])) {
		$funcao = mysql_real_escape_string($_POST['funcao']);
	}
	
	// realiza cada tratamento, de acordo com a funcao passada
	if ($funcao != null) {
		switch ($funcao) { 
			// utilizado pelo flexigrid do menu "gerênciar usuários"
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
				
				$dao = new UsuarioDAO();
				
				// chamada do método DAO correspondente com passagem de parametros POST
				$retorno =  $dao->consultaViaGridComPaginacao($page, $sortname, $sortorder, $qtype, $query, $rp);
				
				echo $retorno;
				
				break;
			} // case consulta grid com paginacao
			case "insereOuAtualizaViaGrid": {
				//declara um novo usuario
				$usuario = new Usuario();
				
				// busca os dados do usuario passado por post
				if (isset($_POST['id_usuario'])) {
					$usuario->setId(mysql_real_escape_string($_POST['id_usuario']));
				}
				if (isset($_POST['login'])) {
					$usuario->setLogin(mysql_real_escape_string($_POST['login']));
				}
				if (isset($_POST['senha'])) {
					$usuario->setSenha(mysql_real_escape_string($_POST['senha']));
				}
				if (isset($_POST['nome'])) {
					$usuario->setNome(mysql_real_escape_string($_POST['nome']));
				}
				if (isset($_POST['telefone'])) {
					$usuario->setTelefone(mysql_real_escape_string($_POST['telefone']));
				}
				if (isset($_POST['email'])) {
					$usuario->setEmail(mysql_real_escape_string($_POST['email']));
				}
				if (isset($_POST['dt_nasc'])) {
					$usuario->setDtNasc(mysql_real_escape_string($_POST['dt_nasc']));
				}
				if (isset($_POST['sexo'])) {
					$usuario->setSexo(mysql_real_escape_string($_POST['sexo']));
				}		
				if (isset($_POST['twitter'])) {
					$usuario->setTwitter(mysql_real_escape_string($_POST['twitter']));
				}
				if (isset($_POST['facebook'])) {
					$usuario->setFacebook(mysql_real_escape_string($_POST['facebook']));
				}	
				
				// dao usado para conexao com banco de dados
				$dao = new UsuarioDAO();				
				
				/* se o id_usuario é passado então trata-se de uma atualização, caso contrário trata-se de uma inserção */		
				if ($usuario->getId() != null) {						
					// chamada do método DAO correspondente com passagem de parametros POST
					$retorno =  $dao->atualizaViaGrid($usuario);	
				} else {
					// chamada do método DAO correspondente com passagem de parametros POST
					$retorno =  $dao->insereViaGrid($usuario);					
				}
				
				echo $retorno;
				
				break;				
			} // case insere com grid
			case "apagaViaGrid": {
				//usuario a ser excluido
				$usuario = new Usuario();
				
				// busca os dados do usuario passado por post
				if (isset($_POST['id_usuario'])) {
					$usuario->setId(mysql_real_escape_string($_POST['id_usuario']));
				}

				// dao usado para conexao com banco de dados
				$dao = new UsuarioDAO();				
				
				/* se o id_usuario é passado então exclui o usuário */		
				if ($usuario->getId() != null) {						
					// chamada do método DAO correspondente com passagem de parametros POST
					$retorno =  $dao->apagaViaGrid($usuario);	
				} 
				
				echo $retorno;
				
				break;
			}
		}		
	} 

?>