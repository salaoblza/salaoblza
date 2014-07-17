<?php
/*
 * Created on 27/11/2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


include_once '../entity/Atendimento.php';
include_once '../DAO/AtendimentoDAO.php';

class RelatorioAtendimentoAction {

	public function consultarQuantidadeAtendimentos($codigoFuncaoPeriodo, $situacao){
		$atendimentoDao = new AtendimentoDAO();
		$relatorioAtendimento = $atendimentoDao->consultarQuantidadeAtendimentos($codigoFuncaoPeriodo, $situacao);

		return $relatorioAtendimento;

	}

	public function consultarClientesMaisFrequentes(){
		$atendimentoDao = new AtendimentoDAO();
		$relatorioAtendimento = $atendimentoDao->consultarClientesMaisFrequentes();

		return $relatorioAtendimento;
	}


}
?>
