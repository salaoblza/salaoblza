<?php
/*
 * Created on 18/06/2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

include_once '../DAO/loginDAO.php'; 

act();
	
function act() {
	// Verifica se um formulário foi enviado
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// Salva duas variáveis com o que foi digitado no formulário
		// Detalhe: faz uma verificação com isset() pra saber se o campo foi preenchido
		$login = (isset($_POST['login'])) ? $_POST['login'] : '';
		$senha = (isset($_POST['senha'])) ? $_POST['senha'] : '';
	
		// Utiliza uma função criada no seguranca.php pra validar os dados digitados
		if (loginDAO::validaLogin($login, $senha) == true) {
			// O usuário e a senha digitados foram validados, manda pra página interna
			header("Location: ../form/principal.php");
		} else {
			// O usuário e/ou a senha são inválidos, manda de volta pro form de login
			// Para alterar o endereço da página de login, verifique o arquivo seguranca.php
			loginDAO::expulsaVisitante();		
		}
	} 
}
?>