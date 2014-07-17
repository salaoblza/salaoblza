<?php
/*
 * Created on 26/02/2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class etapa {
	private $id_etapa;
	private $id_servico;
	private $tipo;
	private $descricao;
	private $tempo;
	
	public function __construct() 
    {
    }
    
	function etapa ($id_etapa, $id_servico, $tipo, $descricao, $tempo) {
		$this->id_etapa=$id_etapa;
		$this->id_servico=$id_servico;
		$this->tipo=$tipo;
		$this->descricao=$descricao;
		$this->tempo=$tempo;	
	}
	
	public function getId() {
		return $this->id_etapa;
	}
	
	public function setId($id){
		$this->id_etapa = $id;
	}
	
	public function getIdServico() {
		return $this->id_servico;
	}
	
	public function setIdServico($id){
		$this->id_servico = $id;
	}
	
	public function getTipo() {
		return $this->tipo;
	}
	
	public function setTipo($tipo){
		$this->tipo = $tipo;
	}
	
	public function getDescricao() {
		return $this->descricao;
	}
	
	public function setDescricao($descricao){
		$this->descricao = $descricao;
	}
	
	public function getTempo() {
		return $this->tempo;
	}
	
	public function setTempo($tempo){
		$this->tempo = $tempo;
	}
}
?>

