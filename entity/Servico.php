<?php
class Servico {
	private $id_servico;
	private $nome;
	private $descricao;
	private $preco;
	
	// etapas do serviço
	private $etapas;
	
	public function __construct() 
    {
    }
	
	public function Servico ($id_servico, $nome, $descricao, $preco) {
		$this->id_servico=$id_servico;
		$this->nome=$nome;
		$this->descricao=$descricao;
		$this->preco=$preco;	
	}		
	
	public function getId() {
		return $this->id_servico;
	}
	
	public function setId($id){
		$this->id_servico = $id;
	}
	
	public function getNome() {
		return $this->nome;
	}
	
	public function setNome($nome){
		$this->nome = $nome;
	}
	
	public function getPreco() {
		return $this->preco;
	}
	
	public function setPreco($preco){
		$this->preco = $preco;
	}	
	
	public function getDescricao() {
		return $this->descricao;
	}
	
	public function setDescricao($descricao){
		$this->descricao = $descricao;
	}
	
	public function getEtapas() {
		return $this->etapas;
	}
	
	public function setEtapas($etapas){
		$this->etapas = $etapas;
	}
}
?>