<?php
class Usuario {
	private $id_usuario;
	private $login;
	private $senha;
	private $nome;
	private $telefone;
	private $email;
	private $dt_nasc;
	private $sexo;
	private $facebook;
	private $twitter;
	
	function __construct() 
    {
    }
	
	function Usuario ($id_usuario, $login, $senha, $nome, $telefone, $email, $dt_nasc, $sexo, $facebook, $twitter) {
		$this->id_usuario=$id_usuario;
		$this->login=$login;
		$this->senha=$senha;
		$this->nome=$nome;		
		$this->telefone=$telefone;
		$this->email=$email;
		$this->dt_nasc=$dt_nasc;
		$this->sexo=$sexo;
		$this->facebook=$facebook;
		$this->twitter=$twitter;		
	}	
	
	public function getId() {
		return $this->id_usuario;
	}
		
	public function setId($id){
		$this->id_usuario = $id;
	}
	
	public function getLogin() {
		return $this->login;
	}	
	
	public function setLogin($login){
		$this->login = $login;
	}	
	
	public function getSenha() {
		return $this->senha;
	}
		
	public function setSenha($senha){
		$this->senha = $senha;
	}
	
	public function getNome() {
		return $this->nome;
	}
		
	public function setNome($nome){
		$this->nome = $nome;
	}

	public function getTelefone() {
		return $this->telefone;
	}
		
	public function setTelefone($telefone){
		$this->telefone = $telefone;
	}

	public function getEmail() {
		return $this->email;
	}
		
	public function setEmail($email){
		$this->email = $email;
	}

	public function getDtNasc() {
		return $this->dt_nasc;
	}
		
	public function setDtNasc($dt_nasc){
		$this->dt_nasc = $dt_nasc;
	}	

	public function getSexo() {
		return $this->sexo;
	}
		
	public function setSexo($sexo){
		$this->sexo = $sexo;
	}

	public function getFacebook() {
		return $this->facebook;
	}
		
	public function setFacebook($facebook){
		$this->facebook = $facebook;
	}
	
	public function getTwitter() {
		return $this->twitter;
	}
		
	public function setTwitter($twitter){
		$this->twitter = $twitter;
	}
}
?>