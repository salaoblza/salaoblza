<?php
 
include_once '../entity/Conexao.php';
include_once '../entity/Servico.php';
include_once '../entity/Etapa.php';
include_once '../DAO/EtapaDAO.php';

/**
 * Classe para mapear os comandos de interação com o banco de dados que dizem respeito a Servico
 */
class ServicoDAO {
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


	function insere($servico) {
		$this->start();
	    $sql = " INSERT INTO servico (id_servico, nome, descricao, preco) " .
	           " VALUES ('%s', '%s', '%s', '%s') ";
		
		$sql = sprintf($sql, $servico->getId(), $servico->getNome(), $servico->getDescricao(), $servico->getPreco());
	            
		if (!$sql) {
			die('Invalid query: ' . mysql_error());
		} else {
			$conexao->db_conexao;
			mysql_query($sql, $this->conexao->db_conexao);
			echo "Serviço Cadastrado com Sucesso";					
		}
		//TODO Pensar melhor onde abrir e fechar as conexoes... 
		//self::finish();	
	}
	
	/**
	 * Realiza busca dos serviços existentes no banco de dados através de um flexigrid, utilizando paginação.
	 */
	public function consultaViaGridComPaginacao($page, $sortname, $sortorder, $qtype, $query, $rp) {
		//inicializa a conexão
		$this->start();			
					
		// Consulta base
		$sql = " select id_servico, nome, preco, descricao from servico";				
		
		// condição de ordenação e pesquisa
		$sortSql   = " order by $sortname $sortorder ";
		$searchSql = ($qtype != '' && $query != '') ? "where $qtype like '%$query%'" : '';
	
		// consulta de totalização para paginação
		$sqlTotal = " select count(*) from servico ";
		$sqlTotal = " $sqlTotal $searchSql ";
		
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
		$limitSql = " limit $pageStart, $rp ";
		
		// preparação de retorno via json
		$data = array();
		$data['page'] = $page;
		$data['total'] = $total;
		$data['rows'] = array();
		
		// complemento da consulta
		$sql = " $sql $searchSql $sortSql $limitSql ";
		
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
				  'id' => $row['id_servico'],
				  'cell' => array('id_servico' =>$row['id_servico'],
				                  'nome'       =>$row['nome'], 
				                  'preco'      =>$row['preco'], 
				                  'descricao'  =>$row['descricao'] 
				                  )
			);
		}

		// finaliza a conexão	
		$this->finish();
				
		// retorno do json
		return json_encode($data);		
	}
	
	/**
	 * Realiza a inserção de um serviço no banco de dados utilizando interface com flexigrid/janela modal jquery.
	 */
	public function insereViaGrid($servico) {
		//inicializa a conexão
		$this->start();			
						
		//TODO: Verificar outra forma de atualizar a senha
		if ($servico != null) {			
			$sql = " INSERT INTO servico (nome, preco, descricao) ".
		           " VALUES ('%s', '%s', '%s') ";
			
			$sql = sprintf($sql, $servico->getNome(), $servico->getPreco(), $servico->getDescricao());	
		} else {
			die('ERRO - Nenhum serviço para inserção: ' . mysql_error());
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
				echo "SUCESSO - Serviço cadastrado. ";
			}						
		}	
	}
	
	/**
	 * Realiza a atualização de um serviço no banco de dados utilizando interface com flexigrid/janela modal jquery
	 */
	public function atualizaViaGrid($servico) {				
		//inicializa a conexão
		$this->start();
	
		if ($servico != null) {			
			$sql = " UPDATE servico SET " .
			   	   " nome='%s', preco='%s', descricao='%s' " .
				   " WHERE id_servico=%d ";
	
			$sql = sprintf($sql, $servico->getNome(), $servico->getPreco(), $servico->getDescricao(), $servico->getId());	
		} else {
			die('ERRO - Nenhum serviço para edição: ' . mysql_error());
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
				echo "SUCESSO - Serviço atualizado. ";
			}									
		}	
	}
	
	/**
	 * Apaga um serviço do banco de dados através de uma interface com flexigrid
	 */
	public function apagaViaGrid($servico) {				
		//inicializa a conexão
		$this->start();

		if ($servico != null) {			
			$sql = "DELETE FROM servico WHERE id_servico=%d ";	
			$sql = sprintf($sql, $servico->getId());	
		} else {
			die('ERRO - Nenhum serviço para exclusão: ' . mysql_error());
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
				echo "SUCESSO - Serviço excluído.";
			}											
		}	
	}	
}
?>
