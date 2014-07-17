<?php
/*
 * Created on 13/11/2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

class Situacao {
	const EM_ESPERA = 1;
	const EM_ATENDIMENTO = 2;
	const ENCERRADO = 3;
	const RETORNADO = 4;
	const DESISTENCIA = 5;

	var $id_situacao;
	var $situacao;

	function __construct()
    {
    }

    function Situacao($id_situacao, $situacao) {
    	$this->$id_situacao = $id_situacao;
		$this->$situacao = $situacao;
    }

    public function getId() {
    	return $this->$id_situacao;
    }

    public function setId($id_situacao) {
    	$this->$id_situacao = $id_situacao;
    }

	public function getSituacao() {
    	return $this->$situacao;
    }

    public function setSituacao($situacao) {
    	$this->$situacao = $situacao;
    }

  	public static function getEmEspera()
  	{
    	return self::EM_ESPERA;
  	}

  	public static function getEmAtendimento()
  	{
    	return self::EM_ATENDIMENTO;
  	}

  	public static function getEncerrado()
  	{
    	return self::ENCERRADO;
  	}

  	public static function getRetornado()
  	{
    	return self::RETORNADO;
  	}

  	public static function getDesistencia()
  	{
    	return self::DESISTENCIA;
  	}

}


?>

