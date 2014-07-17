<?php
/*
 * Created on 26/11/2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

  	include_once '../util/Data.php';
  	include_once '../entity/Atendimento.php';
  	include_once '../entity/Situacao.php';
  	include_once '../action/relatorioAtendimentoAction.php';
  	include_once '../action/situacaoAction.php';

	$periodo = "";
	$situacao = "";
	$mes = "";
	$qtdAtendimentosPorPeriodo = 0;

  	$relatorioAtendimentoAction = new RelatorioAtendimentoAction();
  	$situacaoAction = new SituacaoAction();

	if (isset($_POST['codigoFuncaoPeriodo'])) {
		$data = new Data();
		$periodo = $data->getFuncaoPeriodoTexto($_POST['codigoFuncaoPeriodo']);
		$situacao = $_POST['situacao'];
		$qtdAtendimentosPorPeriodo = $relatorioAtendimentoAction->consultarQuantidadeAtendimentos(
			$_POST['codigoFuncaoPeriodo'], $_POST['situacao']);
	}


 	$clientesMaisFrequentes = $relatorioAtendimentoAction->consultarClientesMaisFrequentes();
 	$situacoes = $situacaoAction->consultarSituacoes();

?>
		<html>
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>Salaoblza - Atendimento</title>
				<link type="text/css" href="../form/css/cupertino/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
				<link type="text/css" href="../form/css/style.css" rel="stylesheet" />
				<script type="text/javascript" src="../form/js/jquery-1.7.2.min.js"></script>
				<script type="text/javascript" src="../form/js/jquery-ui-1.8.21.custom.min.js"></script>
			</head>

			<body>
				<?  include("../form/tituloRealizeAtendimento.php");
					include("../form/menuAtendimento.php");?>
				<br />
				<div>
					<div id="leftbaratendimento" class="leftbaratendimento">
						<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
							<h1 class="titulo">Clientes Mais Frequentes</h1>
						</div>
						<div>
							<table id="clientesMaisFrequentes" width="650" border="1" align="center" cellpadding="0" cellspacing="0">
								<tr>
									<td align="center" class="ui-dialog-titlebar ui-widget-header ">Ordem</td>
			   						<td align="center" class="ui-dialog-titlebar ui-widget-header ">Cliente</td>
			   						<td align="center" class="ui-dialog-titlebar ui-widget-header ">Atendimentos Encerrados</td>
								</tr>

								<?
									$size=sizeof($clientesMaisFrequentes);
									if ($size>5) {
										$size = 5;
									}
									for ($i = 0; $i < $size; $i++) {

								?>
									<tr>
										<td align="center" ><?= $i + 1 ?>°</td>
										<td style="margin-left:10px;"><?= $clientesMaisFrequentes[$i]->cliente ?></td>
										<td align="center";"><?= $clientesMaisFrequentes[$i]->qtdAtendimento ?></td>
									</tr>
								<?
									} // end for atendimentos em espera
								?>
							</table>
							<br> </br>
						</div>
				</div>

				<div>
					<div id="rightbaratendimento" class="rightbaratendimento">
						<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
							<h1 class="titulo">Consulta por Período e Situação</h1>
						</div>

						<div>
							<form action="./relatorioAtendimento.php" method="post">
							<table id="atendimentosPorPeriodo" width="650" border="1" align="center" cellpadding="0" cellspacing="0">
								<tr>
									<td align="right" style="vertical-align:top">
										Periodo:
										<br/>
										Situacao:
									</td>
									<td align="left">
										<select name="codigoFuncaoPeriodo" id="codigoFuncaoPeriodo">
										  <option value="1">Dia</option>
										  <option value="2">Mes</option>
										  <option value="3">Ano</option>
										</select>
										<br />
										<?
											//print_r($situacoes);
											if(sizeof($situacoes) > 0) {
										?>
												<select name="situacao" id="situacao">
										<?
												for ($i = 0; $i < 0; $i++) {
										?>
													<option value="<?= $situacoes[$i]->$id_situacao ?>"><?= $situacoes[$i]->situacao ?></option>
										<?
												}
										?>
												<option value="3">Concluídos</option>
												<option value="5">Desistidos</option>
												</select>
										<?
											} //end if
										?>
										<br />
									</td>
									<td align="center">
										<input class="esperaimgatendimento" type="image" name="consultar" value="consultar" src="../img/search.png"></td>
									</td>

								</tr>
							</table>

								<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
									<? 	if (strcmp($situacao, Situacao::getEncerrado())==0) { ?>
											<h1 class="titulo">Atendimentos concluídos por <?= $periodo ?></h1>
									<? } else { ?>
											<h1 class="titulo">Atendimentos desistidos por <?= $periodo ?></h1>
									<? } ?>
								</div>

							<table id="resultadoAtendimentosPorPeriodo" width="650" border="1" align="center" cellpadding="0" cellspacing="0">
								<tr>
									<td align="center" class="ui-dialog-titlebar ui-widget-header ">Periodo</td>
			   						<td align="center" class="ui-dialog-titlebar ui-widget-header ">Quantidade</td>
								</tr>

								<?
									if ($qtdAtendimentosPorPeriodo) {
										for ($i = 0; $i < sizeof($qtdAtendimentosPorPeriodo); $i++) {
								?>
									<tr>
										<td align="center" style="margin-left:10px;"><?= $qtdAtendimentosPorPeriodo[$i]["periodo"] ?></td>
										<td align="center"><?= $qtdAtendimentosPorPeriodo[$i]["quantidade"] ?></td>
									</tr>
								<?
										} // end for qtd atendimentos por periodo
									} else {
								?>
									<tr>
										<td align="center" colspan="2" style="margin-left:10px;"><?= $qtdAtendimentosPorPeriodo ?></td>
									</tr>
								<?
									} // end else-if

								?>

							</table>
							</form>
							<br> </br>
						</div>
						</div>
					</div>
				</div>
			</body>
		</html>