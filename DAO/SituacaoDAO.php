<?php
/*
 * Created on 30/10/2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

include_once '../entity/Conexao.php';
include_once '../entity/Situacao.php';

/**
 * Classe para mapear os comandos de interação com o banco de dados que dizem respeito ao Atendimento
 */
class SituacaoDAO {
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

	public function consultarSituacoes() {
		$data = null;
		// inicializa a conexão
		$this->start();

		$sql = "select id_situacao, situacao from situacao";

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
					$situacao = new Situacao();
					$situacao->setId($row['id_situacao']);
					$situacao->setSituacao($row['situacao']);

					$data[$count] = $situacao;
					$count++;
				}
			}
			mysql_free_result($resultado);

		}

//		$this->finish();
		return $data;
	}
}

?>
