<?php
/*
 * Created on 27/11/2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


include_once '../entity/Atendimento.php';
include_once '../DAO/SituacaoDAO.php';

class SituacaoAction{
	public function consultarSituacoes(){
		$situacaoDao = new SituacaoDAO();
		$situacoes = $situacaoDao->consultarSituacoes();

		return $situacoes;
	}
}
?>
