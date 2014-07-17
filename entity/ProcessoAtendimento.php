<?php
/*
 * Created on 30/10/2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

class ProcessoAtendimento {
	var $id_processo_atendimento;
	var $cliente;
	var $entrada;
	var $hora;
	var $situacao;

	function __construct()
    {
    }

	function ProcessoAtendimento()
    {
    }

	public function getId() {
		return $this->id_processo_atendimento;
	}

	public function setId($id){
		$this->id_processo_atendimento = $id;
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

	public function getHora() {
		return $this->hora;
	}

	public function setHora($hora){
		$this->hora = $hora;
	}

	public function getSituacao() {
		return $this->situacao;
	}

	public function setSituacao($situacao){
		$this->situacao = $situacao;
	}

}


?>
