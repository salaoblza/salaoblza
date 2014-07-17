<?php
include_once '../entity/Usuario.php';
include_once '../DAO/usuarioDAO.php'; 

act();
	
function act() {
	$usuario = new Usuario();
	$usuario->login = $_POST["login"];
	$usuario->senha = $_POST["senha"];
	$usuario->nome = $_POST["nome"];
	$usuario->telefone = $_POST["telefone"];
	$usuario->email = $_POST["email"];
	$usuario->dt_nasc = $_POST["dt_nasc"];
	$usuario->sexo = $_POST["sexo"];
	$usuario->facebook = $_POST["facebook"];
	$usuario->twitter = $_POST["twitter"];
        
    print_r($_POST);
    print_r($usuario);

	usuarioDAO::insere($usuario);	 
}
 
?>
