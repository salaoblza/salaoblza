<?php
/*
 * Created on 30/10/2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
class Atendimento {
	var $id_atendimento;
	var $cliente;
	var $entrada;
	var $saida;
	var $situacao;
	var $qtdAtendimento;
	
	function __construct() 
    {
    }
	
	function Atendimento ($id_atendimento, $cliente, $entrada, $saida, $situacao) {
		$this->id_atendimento=$id_atendimento;
		$this->cliente=$cliente;
		$this->entrada=$entrada;
		$this->saida=$saida;				
		$this->situacao=$situacao;
	}	
	
	public function getId() {
		return $this->id_atendimento;
	}
		
	public function setId($id){
		$this->id_atendimento = $id;
	}
	
	public function getCliente() {
		return $this->cliente;
	}
		
	public function setCliente($cliente){
		$this->cliente = $cliente;
	}
	
	public function getEntrada() {
		return $this->entrada;
	}
		
	public function setEntrada($entrada){
		$this->entrada = $entrada;
	}

	public function getSaida() {
		return $this->saida;
	}
		
	public function setSaida($saida){
		$this->saida = $saida;
	}
	
	public function getSituacao() {
		return $this->situacao;
	}
		
	public function setSituacao($situacao){
		$this->situacao = $situacao;
	}

	public function getQtdAtendimento() {
		return $this->qtdAtendimento;
	}
		
	public function setQtdAtendimento($qtdAtendimento){
		$this->qtdAtendimento = $qtdAtendimento;
	}
}
 
 
?>
