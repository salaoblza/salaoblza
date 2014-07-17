<?php
/*
 * Created on 30/10/2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

include_once '../entity/Conexao.php';
include_once '../entity/Situacao.php';
include_once '../util/Data.php';

/**
 * Classe para mapear os comandos de interação com o banco de dados que dizem respeito ao Atendimento
 */
class AtendimentoDAO {
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

	public function inicia() {
		// inicializa a conexão
		$this->start();

		$sql = "delete from processo_atendimento";

		mysql_query($sql);

		return mysql_affected_rows() ;
	}

	public function insere($atendimento) {
		// inicializa a conexão
		$this->start();
		$cliente=$atendimento->getCliente();
		$situacao = $atendimento->getSituacao();
		$sql_processo_atendimento = "INSERT INTO processo_atendimento(cliente, situacao) ".
                        " VALUES ('$cliente', '$situacao')";

		if (!$sql_processo_atendimento) {
			die('Invalid query: ' . mysql_error());
		} else {
			mysql_query($sql_processo_atendimento, $this->conexao->db_conexao);

			$hora = $this->consultarHora($cliente);

			$sql_atendimento = "INSERT INTO atendimento(cliente, entrada) ".
    			             " VALUES ('$cliente', '$hora')";

    		// relaciona processo atendimento com atendimento através da hora de entrada
			$this->atualizaEntrada($cliente, $hora);

    		if (!$sql_atendimento) {
				die('Invalid query: ' . mysql_error());
			} else {
    			mysql_query($sql_atendimento, $this->conexao->db_conexao);
    		}

		}
	}


	//Evita repetir o nome dos clientes no atendimento
	//TODO Desconsiderar situação encerrada
	public function consultarClienteExistente($cliente) {
		$retorno = false;
		$this->start();

		$sql = "select hora from processo_atendimento";
		$sql = $sql . " where cliente = '". $cliente . "'";

		if (!$sql) {
			die('Invalid query: ' . mysql_error());
		} else {
			$resultado = mysql_query($sql);
			if (!$resultado) {
				return "ERRO - Não foi possível executar a consulta ($sql) no banco de dados: " . mysql_error();
				exit;
			} else {
				if (mysql_num_rows ($resultado)>0) {
					$retorno = true;
				}
			}
			mysql_free_result($resultado);
		}
		return $retorno;
	}


	public function consultarHora($cliente) {
		$this->start();
		$hora = null;

		$sql = "select hora from processo_atendimento";
		$sql = $sql . " where cliente = '". $cliente . "'";

		if (!$sql) {
			die('Invalid query: ' . mysql_error());
		} else {
			$resultado = mysql_query($sql);
			if (!$resultado) {
				return "ERRO - Não foi possível executar a consulta ($sql) no banco de dados: " . mysql_error();
				exit;
			} else {
				$row = mysql_fetch_array($resultado);
				$hora = $row['hora'];
			}
			mysql_free_result($resultado);

		}

		return $hora;
	}

	public function atualizaEntrada($cliente, $hora) {
		$this->start();

		$sql = "update processo_atendimento set entrada = ' ".  $hora . "' where cliente = '". $cliente . "'";

		mysql_query($sql);
		if (mysql_affected_rows() == 0) {
			return "ERRO - Nenhum registro foi atualizado" . mysql_error();
			exit;
		}

		return mysql_affected_rows() ;
	}



	public function consultarProcessosAtendimentos($situacao) {
		$data = null;
		// inicializa a conexão
		$this->start();

		$sql = "select id_processo_atendimento, cliente, entrada, hora, situacao from processo_atendimento";

		if(isset($situacao)) {
			$sql = $sql . ' where situacao = '. $situacao;
		}

		$sql = $sql . ' order by hora ASC';

		if (!$sql) {
			die('Invalid query: ' . mysql_error());
		} else {
			$resultado = mysql_query($sql);
			if (!$resultado) {
				return "ERRO - Não foi possível executar a consulta ($sql) no banco de dados: " . mysql_error();
				exit;
			} else {
				$count = 0;
				$data = array();
				while ($row = mysql_fetch_array($resultado)) {
					$processoAtendimento = new ProcessoAtendimento();
					$processoAtendimento->setId($row['id_processo_atendimento']);
					$processoAtendimento->setCliente($row['cliente']);
					$processoAtendimento->setEntrada($row['entrada']);
					$processoAtendimento->setHora($row['hora']);
					$processoAtendimento->setSituacao($row['situacao']);

					$data[$count] = $processoAtendimento;
					$count++;
				}
			}
			mysql_free_result($resultado);

		}

//		$this->finish();
		return $data;
	}

	public function deleta($atendimento) {
		$this->start();

		$idCliente = $atendimento->getId();
		$entrada = $atendimento->getEntrada();
		$situacao = $atendimento->getSituacao();

		$sql = "delete from processo_atendimento where id_processo_atendimento = $idCliente";

		mysql_query($sql);
		if (mysql_affected_rows() == 0) {
			return "ERRO - Nenhum registro foi apagado" . mysql_error();
			exit;
		} else {

			$sql_atendimento = "update atendimento set situacao = '". $situacao . "' where entrada = '" . $entrada . "'";
    		if (!$sql_atendimento) {
				die('Invalid query: ' . mysql_error());
			} else {
    			mysql_query($sql_atendimento, $this->conexao->db_conexao);
    		}

		}

		return mysql_affected_rows() ;
	}

	public function atualiza($atendimento) {
		$this->start();

		$idCliente = $atendimento->getId();
		$situacao = $atendimento->getSituacao();


		$sql = "update processo_atendimento set situacao = $situacao where id_processo_atendimento = $idCliente";
		mysql_query($sql);
		if (mysql_affected_rows() == 0) {
			return "ERRO - Nenhum registro foi atualizado" . mysql_error();
			exit;
		}

		return mysql_affected_rows() ;
	}

	public function encerra($atendimento) {
		$this->start();

		$idCliente = $atendimento->getId();
		$entrada = $atendimento->getEntrada();
		$situacao = $atendimento->getSituacao();


		$sql = "update processo_atendimento set situacao = $situacao where id_processo_atendimento = $idCliente";
		mysql_query($sql);
		if (mysql_affected_rows() == 0) {
			return "ERRO - Nenhum registro foi atualizado" . mysql_error();
			exit;
		} else {

			$sql_atendimento = "update atendimento set situacao = '". $situacao . "' where entrada = '" . $entrada . "'";
    		if (!$sql_atendimento) {
				die('Invalid query: ' . mysql_error());
			} else {
    			mysql_query($sql_atendimento, $this->conexao->db_conexao);
    		}

		}

		return mysql_affected_rows() ;
	}

	//===================================== métodos dos relatórios =====================================
	//Top five: Clientes que mais frequentaram - Robson
	//Atendimento mais rápido
	//Atendimento mais demorado
	//Tempo médio de atendimento total
	//Tempo médio de atendimento agrupado por periodo por situacao ordenado por tempo decrecente - Diego
	//Quantidade de Atendimento por periodo por situacao ordenado por tempo decrecente - Diego

	public function consultarQuantidadeAtendimentos($codigoFuncaoPeriodo, $situacao){
		$this->start();

		$data = new Data();

		$funcaoPeriodo = $data->getFuncaoPeriodo($codigoFuncaoPeriodo);

		$sql = "select ". $funcaoPeriodo ."(entrada) periodo, count(1) quantidade from atendimento";

		if(isset($situacao)) {
			$sql = $sql . " where situacao = ". $situacao;
		}
		$sql = $sql . " group by ". $funcaoPeriodo ."(entrada)";

		//RYSO
		$resultado = mysql_query($sql);
		$data = array();
		if (mysql_affected_rows() == 0) {
			return "Nenhum registro foi encontrado. " . mysql_error();
			exit;
		} else {
			$count = 0;
			$mes = new Data();
			while ($row = mysql_fetch_array($resultado)) {
				$periodo = $row["periodo"];
				if (strcmp($funcaoPeriodo, "month") == 0) {
					$periodo = $mes->retornaMes($row["periodo"]);
				}

				$data[$count] = array(
					"periodo" => $periodo,
					"quantidade" =>$row["quantidade"]
				);
				$count++;
			}

			mysql_free_result($resultado);
		}
		return $data;
	}

	public function consultarClientesMaisFrequentes(){

		$this->start();

		$sql = "select cliente, count(cliente) contador from atendimento where situacao = " . Situacao::getEncerrado();
		$sql = $sql . " group by cliente order by contador DESC";

		if (!$sql) {
			die('Invalid query: ' . mysql_error());
		} else {
			$resultado = mysql_query($sql);
			if (!$resultado) {
				return "ERRO - Não foi possível executar a consulta ($sql) no banco de dados: " . mysql_error();
				exit;
			} else {
				$count = 0;
				$data = array();
				while ($row = mysql_fetch_array($resultado)) {
					$atendimento = new Atendimento();
					$atendimento->setCliente($row['cliente']);
					$atendimento->setQtdAtendimento($row['contador']);

					$data[$count] = $atendimento;
					$count++;
				}
			}
			mysql_free_result($resultado);
		}
		return $data;
	}
}

?>
