<?php

include_once '../entity/Conexao.php';
include_once '../entity/Usuario.php';

/**
 * Classe para mapear os comandos de interação com o banco de dados que dizem respeito a Usuario
 */
class UsuarioDAO {
	public $conexao;

	public function start() {
		 $this->conexao = Conexao::singleton();
		 if ($this->conexao == null) {
		 	echo "Erro na conexão!";
		 }
	}

	public function finish() {
		mysql_close($this->conexao->db_conexao);
	}

	public function insere($usuario) {
		// inicializa a conexão
		$this->start();

        //$sql = "INSERT INTO usuario(login, senha, nome, telefone, email, dt_nasc, sexo, facebook, twitter) ".
        //                " VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');";

		$sql = "INSERT INTO usuario(login, senha, nome, telefone, email, dt_nasc, sexo, twitter, facebook) ".
                        " VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');";

		$sql = sprintf($sql, $usuario->getLogin(), $usuario->getSenha(), $usuario->getNome(), $usuario->getTelefone(), $usuario->getEmail(),
		                     $usuario->getDtNasc(), $usuario->getSexo(), $usuario->getTwitter(), $usuario->getFacebook());

		if (!$sql) {
			die('Invalid query: ' . mysql_error());
		} else {
			$conexao->db_conexao;
			mysql_query($sql, $this->conexao->db_conexao);
			echo "Usuário cadastrado com sucesso";
		}

		// finaliza a conexão
		$this->finish();
	}

	/**
	 * Realiza busca dos usuários existentes no banco de dados através de um flexigrid, utilizando paginação.
	 */
	public function consultaViaGridComPaginacao($page, $sortname, $sortorder, $qtype, $query, $rp) {
		//inicializa a conexão
		$this->start();

		// Consulta base
		$sql      = "select id_usuario, login, nome, telefone, email, date_format(dt_nasc, '%d/%m/%Y') dt_nasc, sexo, twitter, facebook from usuario";

		// condição de ordenação e pesquisa
		$sortSql   = "order by $sortname $sortorder";
		$searchSql = ($qtype != '' && $query != '') ? "where $qtype like '%$query%'" : '';

		// consulta de totalização para paginação
		$sqlTotal = "select count(1) from usuario";
		$sqlTotal = "$sqlTotal $searchSql";

		//validacao da consulta e posterior execucao
		if (!$sqlTotal) {
			die('ERRO - Comando SQL inválido: ' . mysql_error());
		} else {
			$resultTotal = mysql_query($sqlTotal, $this->conexao->db_conexao);
			if (!$resultTotal) {
			    return "ERRO - Não foi possível executar a consulta ($sqlTotal) no banco de dados: " . mysql_error();
			    exit;
			}
		}
		$rowTotal = mysql_fetch_array($resultTotal);
		$total = $rowTotal[0];

		// configuração de paginação
		$pageStart = ($page-1)*$rp;
		$limitSql = "limit $pageStart, $rp";

		// preparação de retorno via json
		$data = array();
		$data['page'] = $page;
		$data['total'] = $total;
		$data['rows'] = array();

		// complemento da consulta
		$sql = "$sql $searchSql $sortSql $limitSql";

		//validacao da consulta e posterior execucao
		if (!$sql) {
			die('ERRO - Comando SQL inválido: ' . mysql_error());
		} else {
			$results = mysql_query($sql, $this->conexao->db_conexao);
			if (!$results) {
			    echo "ERRO - Não foi possível executar a consulta ($sql) no banco de dados: " . mysql_error();
			    exit;
			}
		}

		// montagem dos dados json para formato de flexigrid
		while ($row = mysql_fetch_assoc($results)) {
			$data['rows'][] = array(
				  'id' => $row['id_usuario'],
				  'cell' => array('id_usuario' =>$row['id_usuario'],
								  'login'      =>$row['login'],
				                  'nome'       =>$row['nome'],
				                  'telefone'   =>$row['telefone'],
				                  'email'      =>$row['email'],
				                  'dt_nasc'    =>$row['dt_nasc'],
				                  'sexo'       =>$row['sexo'],
				                  'twitter'    =>$row['twitter'],
				                  'facebook'   =>$row['facebook'])
			);
		}

		// finaliza a conexão
		$this->finish();

		// retorno do json
		return json_encode($data);
	}

	/**
	 * Realiza a inserção de um usuário no banco de dados utilizando interface com flexigrid/janela modal jquery.
	 */
	public function insereViaGrid($usuario) {
		//inicializa a conexão
		$this->start();

		//TODO: Verificar outra forma de atualizar a senha
		if ($usuario != null) {
			$novaData = substr($usuario->getDtNasc(),6,4) . "-" . substr($usuario->getDtNasc(),3,2) . "-" . substr($usuario->getDtNasc(),0,2);

			$sql = "INSERT INTO usuario(login, senha, nome, telefone, email, dt_nasc, sexo, twitter, facebook) ".
                   " VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');";

			//$sql = " INSERT INTO usuario(login, senha, nome, telefone, email, dt_nasc, sexo, twitter, facebook) ".
		    //       " VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s') ";

			$sql = sprintf($sql, $usuario->getLogin(), $usuario->getSenha(), $usuario->getNome(), $usuario->getTelefone(), $usuario->getEmail(),
			                     $novaData, $usuario->getSexo(), $usuario->getTwitter(), $usuario->getFacebook());
		} else {
			die('ERRO - Nenhum usuário para inserção: ' . mysql_error());
		}

		//validacao da consulta e posterior execucao
		if (!$sql) {
			die('ERRO - Comando SQL inválido: ' . mysql_error());
		} else {
			$result = mysql_query($sql, $this->conexao->db_conexao);
			if (!$result) {
			    echo "ERRO - Não foi possível executar a consulta ($sql) no banco de dados: " . mysql_error();
			    exit;
			} else {
				echo "SUCESSO - Usuário cadastrado. ";
			}
		}
	}

	/**
	 * Realiza a atualização de um usuário no banco de dados utilizando interface com flexigrid/janela modal jquery
	 */
	public function atualizaViaGrid($usuario) {
		//inicializa a conexão
		$this->start();

		//TODO: Verificar outra forma de atualizar a senha
		if ($usuario != null) {
			$novaData = substr($usuario->getDtNasc(),6,4) . "-" . substr($usuario->getDtNasc(),3,2) . "-" . substr($usuario->getDtNasc(),0,2);
			$sql = " UPDATE usuario SET " .
			   	   " login='%s', senha='%s', nome='%s', telefone='%s', email='%s', dt_nasc='%s', sexo='%s', twitter='%s', facebook='%s' " .
				   " WHERE id_usuario=%d ";

			$sql = sprintf($sql, $usuario->getLogin(), $usuario->getSenha(), $usuario->getNome(), $usuario->getTelefone(), $usuario->getEmail(),
			                     $novaData, $usuario->getSexo(), $usuario->getTwitter(), $usuario->getFacebook(), $usuario->getId());
		} else {
			die('ERRO - Nenhum usuário para edição: ' . mysql_error());
		}

		//validacao da consulta e posterior execucao
		if (!$sql) {
			die('ERRO - Comando SQL inválido: ' . mysql_error());
		} else {
			$results = mysql_query($sql, $this->conexao->db_conexao);
			if (!$results) {
			    echo "ERRO - Não foi possível executar a consulta ($sql) no banco de dados: " . mysql_error();
			    exit;
			} else {
				echo "SUCESSO - Usuário atualizado. ";
			}
		}
	}

	/**
	 * Apaga um usuário do banco de dados através de uma interface com flexigrid
	 */
	public function apagaViaGrid($usuario) {
		//inicializa a conexão
		$this->start();

		if ($usuario != null) {
			$sql = "DELETE FROM usuario WHERE id_usuario=%d ";
			$sql = sprintf($sql, $usuario->getId());
		} else {
			die('ERRO - Nenhum usuário para exclusão: ' . mysql_error());
		}

		//validacao da consulta e posterior execucao
		if (!$sql) {
			die('ERRO - Comando SQL inválido: ' . mysql_error());
		} else {
			$results = mysql_query($sql, $this->conexao->db_conexao);
			if (!$results) {
			    echo "ERRO - Não foi possível executar a consulta ($sql) no banco de dados: " . mysql_error();
			    exit;
			} else {
				echo "SUCESSO - Usuário excluído.";
			}
		}
	}

}
?>
