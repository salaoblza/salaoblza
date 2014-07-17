<?php
 
include_once '../entity/Conexao.php';
include_once '../entity/Servico.php';
include_once '../entity/Etapa.php';

/**
 * Classe para mapear os comandos de interação com o banco de dados que dizem respeito a Etapa
 */
class EtapaDAO {
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

	public function insere($etapa) {
		self::start();
        $sql = " INSERT INTO etapa (id_etapa, id_servico, tipo, descricao, tempo) " .
               " VALUES ('%s', '%s', '%s', '%s', '%s');";
		
		if ($etapa->getTipo() == "Execução") {
			$sql = sprintf($sql, $etapa->getId(), $etapa->getIdServico(), "1", $etapa->getDescricao(), $etapa->getTempo());	
		} else {
			$sql = sprintf($sql, $etapa->getId(), $etapa->getIdServico(), "2", $etapa->getDescricao(), $etapa->getTempo());			
		}

		if (!$sql) {
			die('Invalid query: ' . mysql_error());
		} else {
			mysql_query($sql, self::$conexao->db_conexao);
			echo "Etapa cadastrada com cucesso";		
		}	
//			self::finish();
	}	            
	
	/**
	 * Realiza busca das etapas existentes no banco de dados para um dado serviço através de um flexigrid, utilizando paginação.
	 */
	public function consultaViaGridComPaginacao($page, $sortname, $sortorder, $qtype, $query, $rp, $id_servico) {
		//inicializa a conexão
		$this->start();			
					
		// Consulta base
		$sql = " select id_etapa, id_servico, tipo, descricao, tempo from etapa where id_servico=$id_servico ";
				
		if ($sortname == "descTipo") {
			$sortname = "tipo";
		}		
		
		// condição de ordenação e pesquisa
		$sortSql   = " order by $sortname $sortorder ";
		$searchSql = ($qtype != '' && $query != '') ? " and $qtype like '%$query%'" : '';
	
		// consulta de totalização para paginação
		$sqlTotal = " select count(*) from etapa where id_servico=$id_servico ";
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
			$descTipo = '';
			if ($row['tipo'] == '1') {
				$descTipo = "Execução";
			} else {
				$descTipo = "Espera";
			}
			$data['rows'][] = array(
				  'id' => $row['id_etapa'],
				  'cell' => array('id_etapa'   =>$row['id_etapa'],
				                  'id_servico' =>$row['id_servico'], 
				                  'tipo'       =>$row['tipo'],
				                  'descTipo'   =>$descTipo,
				                  'descricao'  =>$row['descricao'], 
				                  'tempo'      =>$row['tempo'] 
				                  )
			);
		}

		// finaliza a conexão	
		$this->finish();
				
		// retorno do json
		return json_encode($data);		
	}
	
	/**
	 * Realiza a inserção de uma etapa em um serviço no banco de dados utilizando interface com flexigrid/janela modal jquery.
	 */
	public function insereViaGrid($etapa) {
		//inicializa a conexão
		$this->start();			
						
		if ($etapa != null) {			
	        $sql = " INSERT INTO etapa (id_etapa, id_servico, tipo, descricao, tempo) " .
	               " VALUES ('%s', '%s', '%s', '%s', '%s');";
			
			$sql = sprintf($sql, $etapa->getId(), $etapa->getIdServico(), $etapa->getTipo(), $etapa->getDescricao(), $etapa->getTempo());
			/*
			if ($etapa->getTipo() == "Execução") {
				$sql = sprintf($sql, $etapa->getId(), $etapa->getIdServico(), "1", $etapa->getDescricao(), $etapa->getTempo());	
			} else {
				$sql = sprintf($sql, $etapa->getId(), $etapa->getIdServico(), "2", $etapa->getDescricao(), $etapa->getTempo());			
			}*/				
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
				echo "SUCESSO - Etapa cadastrada. ";
			}						
		}	
	}
	
	/**
	 * Realiza a atualização de uma etapa em um serviço no banco de dados utilizando interface com flexigrid/janela modal jquery
	 */
	public function atualizaViaGrid($etapa) {				
		//inicializa a conexão
		$this->start();
	
		if ($etapa != null) {			
			$sql = " UPDATE etapa ".
			       " SET tipo='%s', descricao='%s', tempo='%s' " .
				   " WHERE id_etapa=%d and id_servico=%d ";
	
			$sql = sprintf($sql, $etapa->getTipo(), $etapa->getDescricao(), $etapa->getTempo(), $etapa->getId(), $etapa->getIdServico());			
		} else {
			die('ERRO - Nenhuma etapa para edição: ' . mysql_error());
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
				echo "SUCESSO - Etapa atualizada. ";
			}									
		}	
	}
	
	/**
	 * Apaga uma etapa de um serviço do banco de dados através de uma interface com flexigrid
	 */
	public function apagaViaGrid($etapa) {				
		//inicializa a conexão
		$this->start();

		if ($etapa != null) {			
			$sql = "DELETE FROM etapa WHERE id_etapa=%d ";	
			$sql = sprintf($sql, $etapa->getId());	
		} else {
			die('ERRO - Nenhuma etapa para exclusão: ' . mysql_error());
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
				echo "SUCESSO - Etapa excluída.";
			}											
		}	
	}	
}
?>
