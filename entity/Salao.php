<?php
/*
 * Created on 31/07/2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
class Salao {
	var $id_salao;
	var $nome;
	var $endereco;
	var $bairro;
	var $municipio;
	var $estado;
	var $telefone1;
	var $telefone2;
	var $email;
	var $facebook;
	var $twitter;
	var $site;
	
	function __construct() 
    {
    }
	
	function Salao ($id_salao, $nome, $endereco, $bairro, $municipio, $estado, $telefone1, $telefone2, $email, $facebook, $twitter, $site) {
		$this->nome=$nome;
		$this->endereco=$endereco;
		$this->bairro=$bairro;				
		$this->municipio=$municipio;
		$this->estado=$estado;						
		$this->telefone1=$telefone1;
		$this->telefone2=$telefone2;		
		$this->email=$email;
		$this->facebook=$facebook;
		$this->twitter=$twitter;
		$this->site=$site;		
	}	
}
?>
