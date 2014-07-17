<?php
/*
 * Created on 30/10/2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

include_once '../entity/Atendimento.php';
include_once '../entity/ProcessoAtendimento.php';
include_once '../DAO/AtendimentoDAO.php';
include_once '../entity/Situacao.php';


//act();


class AtendimentoAction {

	public function consultarProcessosAtendimentos() {

		$atendimentoDao = new AtendimentoDAO();
		$processosDeAtendimento = $atendimentoDao->consultarProcessosAtendimentos(null);

		return $processosDeAtendimento;

	}

	public function inicia() {
		$atendimentoDAO = new AtendimentoDAO();
		$atendimentoDAO->inicia();

	}

	public function consultarClienteExistente($cliente) {
		$atendimentoDAO = new AtendimentoDAO();
		return $atendimentoDAO->consultarClienteExistente($cliente);
	}
	
	public function inserir($cliente, $hora) {
		$atendimento = new ProcessoAtendimento();
		$atendimento->setCliente($cliente);
		$atendimento->setHora($hora);
		$atendimento->setSituacao(1);
		
		$atendimentoDAO = new AtendimentoDAO();
		$atendimentoDAO->insere($atendimento);

	}

	public function deletar($idCliente, $entrada) {
		$atendimento = new ProcessoAtendimento();
		$atendimento->setId($idCliente);
		$atendimento->setEntrada($entrada);
		$atendimento->setSituacao(Situacao::getDesistencia());

		$atendimentoDAO = new AtendimentoDAO();
		return $atendimentoDAO->deleta($atendimento);
	}

	public function atender($idCliente) {
		$atendimento = new ProcessoAtendimento();
		$atendimento->setId($idCliente);
		$atendimento->setSituacao(Situacao::getEmAtendimento());

		$atendimentoDAO = new AtendimentoDAO();
		return $atendimentoDAO->atualiza($atendimento);
	}
	
	
	public function retornar($idCliente) {
		$atendimento = new ProcessoAtendimento();
		$atendimento->setId($idCliente);
		$atendimento->setSituacao(Situacao::getRetornado());

		$atendimentoDAO = new AtendimentoDAO();
		return $atendimentoDAO->atualiza($atendimento);
	}
	
	public function encerrar($idCliente, $entrada) {
		$atendimento = new ProcessoAtendimento();
		$atendimento->setId($idCliente);
		$atendimento->setEntrada($entrada);
		$atendimento->setSituacao(Situacao::getEncerrado());

		$atendimentoDAO = new AtendimentoDAO();
		return $atendimentoDAO->encerra($atendimento);
	}
	
}

?>
