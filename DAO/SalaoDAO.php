<?php
/*
 * Created on 31/07/2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
include_once '../entity/Conexao.php';
include_once '../entity/Salao.php';

/**
 * Classe para mapear os comandos de interação com o banco de dados que dizem respeito a Salão
 */
class SalaoDAO {
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

	public function insere($salao) {
		// inicializa a conexão
		$this->start();
		
        $sql = "INSERT INTO endereco(rua, numero, bairro, cidade, estado, cep) ".
                        " VALUES ('%s', '%s', '%s', '%s', '%s', '%s');";
		
		$sql = sprintf($sql, $salao->endereco, null, $salao->bairro, $salao->municipio, $salao->estado, 
		 			   null);

        $sql = "INSERT INTO salao(nome, email, site, facebook, twitter) ".
                        " VALUES ('%s', '%s', '%s', '%s', '%s');";
		
		$sql = sprintf($sql, $salao->nome, $salao->email, $salao->site, $salao->facebook, $salao->twitter);
	
		if (!$sql) {
			die('Invalid query: ' . mysql_error());
		} else {
			$conexao->db_conexao;
			mysql_query($sql, $this->conexao->db_conexao);
			echo "Salão cadastrado com sucesso";		
		}
		
		
		// finaliza a conexão	
		$this->finish();
	}	
	
	
	/**
	 * Realiza a inserção de um usuário no banco de dados utilizando interface com flexigrid/janela modal jquery.
	 */
	public function insereViaGrid($salao) {
		//inicializa a conexão
		$this->start();			
						
		//TODO: Verificar outra forma de atualizar a senha
		if ($salao != null) {			
			$sql = " INSERT INTO salao(login, senha, nome, telefone, email, dt_nasc, sexo, twitter, facebook) ".
		           " VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s') ";
			
			$sql = sprintf($sql, $salao->login, $salao->senha, $salao->nome, $salao->telefone, $salao->email, 
			                     $salao->dt_nasc, $salao->sexo, $salao->twitter, $salao->facebook);	
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
	public function atualizaViaGrid($salao) {				
		//inicializa a conexão
		$this->start();

		//TODO: não tá atualizando a data
		
		//TODO: Verificar outra forma de atualizar a senha		
		if ($salao != null) {			
			$sql = " UPDATE salao SET " .
			   	   " login='%s', senha='%s', nome='%s', telefone='%s', email='%s', dt_nasc='%s', sexo='%s', twitter='%s', facebook='%s' " .
				   " WHERE id_salao=%d ";
	
			$sql = sprintf($sql, $salao->login, $salao->senha, $salao->nome, $salao->telefone, $salao->email, $salao->dt_nasc, 
			                     $salao->sexo, $salao->twitter, $salao->facebook, $salao->id_salao);	
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
}
?>
