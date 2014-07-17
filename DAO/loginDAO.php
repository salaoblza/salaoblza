<?php
/*
 * Created on 18/06/2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
/**
* Sistema de segurança com acesso restrito
*
* Usado para restringir o acesso de certas páginas do seu site
*
* @author Thiago Belem <contato@thiagobelem.net>
* @link http://thiagobelem.net/
*
* @version 1.0
* @package SistemaSeguranca
*/

include_once '../entity/Conexao.php';
include_once '../entity/Seguranca.php';

class loginDAO {
	
	static public $conexao;
	static public $session;
	
	
	static function start() {
		 self::$conexao = Conexao::singleton();
		 if (self::$conexao == null) {
		 	// Erro na conexão!!!;
		 }
	}
		
	static function startSession () {
		 self::$session = Seguranca::singleton();
	}
	
	static function finish() {
		mysql_close(self::$conexao->db_conexao); 
	}

	/**
	* Função que valida um usuário e senha
	*
	* @param string $usuario - O usuário a ser validado
	* @param string $senha - A senha a ser validada
	*
	* @return bool - Se o usuário foi validado ou não (true/false)
	*/
	static function validaLogin($login, $senha) {
		self::startSession();
		self::start();
		// Usa a função addslashes para escapar as aspas
		$nlogin = addslashes($login);
		$nsenha = addslashes($senha);
		
		// Monta uma consulta SQL (query) para procurar um usuário
		$sql = "SELECT * FROM usuario WHERE BINARY login = '".$nlogin."' AND BINARY senha = '".$nsenha."' LIMIT 1";
		$query = mysql_query($sql);
		$resultado = mysql_fetch_assoc($query);
		
		// Verifica se encontrou algum registro
		if (empty($resultado)) {
			// Nenhum registro foi encontrado => o usuário é inválido
			return false;
		
		} else {
			// O registro foi encontrado => o usuário é valido
			
			// Definimos dois valores na sessão com os dados do usuário
			$_SESSION['usuarioID'] = $resultado['id_usuario']; // Pega o valor da coluna 'id do registro encontrado no MySQL
			$_SESSION['usuarioNome'] = $resultado['nome']; // Pega o valor da coluna 'nome' do registro encontrado no MySQL
		
			// Definimos dois valores na sessão com os dados do login
			$_SESSION['usuarioLogin'] = $login;
			$_SESSION['usuarioSenha'] = $senha;
			
			//Definimos demais dados para a tela de profile
			$_SESSION['usuarioTelefone'] = $resultado['telefone'];
			$_SESSION['usuarioEmail'] = $resultado['email'];
			$_SESSION['usuarioDt_Nasc'] = $resultado['dt_nasc'];
			$_SESSION['usuarioSexo'] = $resultado['sexo'];
			$_SESSION['usuarioFacebook'] = $resultado['facebook'];
			$_SESSION['usuarioTwitter'] = $resultado['twitter'];
	
			return true;
		}
	}

	/**
	* Função que protege uma página
	*/
	static function protegePagina() {
		self::startSession();
		
		if (!isset($_SESSION['usuarioID']) OR !isset($_SESSION['usuarioNome'])) {
			// Não há usuário logado, manda pra página de login
			self::expulsaVisitante();
		} else {
			// logado;
			// check to see if $_SESSION['timeout'] is set
			if(isset($_SESSION['start']) ) {
			    $session_life = time() - $_SESSION['start'];
				if($session_life > self::$session->getInatividade())	{
					self::expulsaVisitante();						
				}
			}
			$_SESSION['start'] = time();
		}
	}
	

	/**
	* Função para expulsar um visitante
	*/
	static function expulsaVisitante() {
		global $_SG;
		
		self::mataSession();
		self::finish();
		// Manda pra tela de login
		header("Location: /salaoblza/login.php");
	}
	
	static function mataSession () {
		self::startSession();
		session_destroy();
	}
 
} 
?>
