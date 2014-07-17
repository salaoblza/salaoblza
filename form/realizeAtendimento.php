<?php
/*
 * Created on 03/12/2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
  	include_once '../util/Hora.php';

  	include_once '../entity/ProcessoAtendimento.php';
  	include_once '../entity/Atendimento.php';
  	include_once '../entity/Situacao.php';
  	include_once '../action/atendimentoAction.php';

	$hora = new Hora();

	$atendimentoAction = new AtendimentoAction();
	if (isset($_GET['iniciarAtendimento'])) {
		$atendimentoAction->inicia();
		$mensagem = 'Novo atendimento iniciado.';
	}

	if (isset($_POST['inserir'])) {
		if ($atendimentoAction->consultarClienteExistente($_POST['cliente'])==false) {
			$atendimentoAction->inserir($_POST['cliente'], $hora);
			$mensagem = $_POST['cliente'] . ' entrou na fila de espera.';
		} else {
			$mensagem = $_POST['cliente'] . ' já está em atendimento';
		}

	} elseif (isset($_POST['deletar'])) {
		if ($atendimentoAction->deletar($_POST['idCliente'], $_POST['entrada']) > 0) {
			$mensagem = $_POST['cliente'] . ' saiu da fila de espera.';
		}
	} elseif (isset($_POST['atender'])) {
		if ($atendimentoAction->atender($_POST['idCliente']) > 0) {
			$mensagem = $_POST['cliente'] . ' está em atendimento.';
		}
	} elseif (isset($_POST['encerrar'])) {
		if ($atendimentoAction->encerrar($_POST['idCliente'], $_POST['entrada']) > 0) {
			$mensagem = 'Atendimento concluído para '. $_POST['cliente'] . '.';
		}
	} elseif (isset($_POST['retornar'])) {
		if ($atendimentoAction->retornar($_POST['idCliente']) > 0) {
			$mensagem = $_POST['cliente'] . ' retornou para fila de espera.';
		}
	}

	$processosDeAtendimentos = $atendimentoAction->consultarProcessosAtendimentos();
	$atendimentosEmEspera = array();
	$atendimentosEmAndamento = array();
	$atendimentosEncerramento = array();

	$qtdAtdEmEspera = 0;
	$qtdAtdEmAndamento = 0;
	$qtdAtdEncerrados = 0;

	$size=sizeof($processosDeAtendimentos);
	for ($i = 0; $i < $size ; $i++) {
		$processoAtendimento = $processosDeAtendimentos[$i];
		if ($processoAtendimento->getSituacao() == Situacao::getEncerrado()) {
			$atendimentosEncerrados[$qtdAtdEncerrados] = $processoAtendimento;
			$qtdAtdEncerrados++;
		} else if ($processoAtendimento->getSituacao() == Situacao::getEmAtendimento()) {
			$atendimentosEmAndamento[$qtdAtdEmAndamento] = $processoAtendimento;
			$qtdAtdEmAndamento++;
		} else {
			$atendimentosEmEspera[$qtdAtdEmEspera] = $processoAtendimento;
			$qtdAtdEmEspera++;
		}
	}

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

					<br></br>

					<? if (isset($mensagem)) { ?>
						<div id="mensagembaratendimento" class="mensagembaratendimento" >
							<br>
								<img class="mensagemimgatendimento" src="../img/aviso.png">
								<b> <span class="mensagematendimento"><?=$mensagem ?> </span></b>
							<br>
						</div>
					<?
					} ?>

				<div>
					<div id="leftbaratendimento" class="leftbaratendimento">
						<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
								<h1 class="titulo">Fila de Espera</h1>
						</div>
						<div>
								<form method="post" action="./realizeAtendimento.php">
									<br />
									<h1 class="centerbar-campo">
										Cliente: <input name= "cliente" type="text" id="cliente">
										<input class="esperaimgatendimento" type="image" name="inserir" src="../img/play.png" value="Entrar na Fila" />
									</h1>
								</form>
								<br> </br>
								<?
								if($qtdAtdEmEspera > 0) {

							?>
									<table id="filaClientesEmEspera" width="650" border="1" align="center" cellpadding="0" cellspacing="0">
									<tr>
										<td class="ui-dialog-titlebar ui-widget-header "></td>
										<td align="center" class="ui-dialog-titlebar ui-widget-header ">Ordem</td>
				   						<td align="center" class="ui-dialog-titlebar ui-widget-header ">Cliente</td>
				   						<td align="center" class="ui-dialog-titlebar ui-widget-header ">Hora</td>
				   						<td class="ui-dialog-titlebar ui-widget-header "></td>
				   						<td class="ui-dialog-titlebar ui-widget-header "></td>
									</tr>
									<?
									for ($i = 0; $i < $qtdAtdEmEspera; $i++) {
									?>
										<tr>
											<form method="post" action="./realizeAtendimento.php">
											<? if ($atendimentosEmEspera[$i]->getSituacao() == Situacao::getEmEspera()) { ?>
												<td align="center"></td>
											<? } else { ?>
												<td align="center"><img class="esperaimgatendimento" src="../img/time.png"></td>
											<? } ?>
											<td align="center" ><?= $i + 1 ?>°</td>
											<td style="margin-left:10px;"><?= $atendimentosEmEspera[$i]->cliente ?></td>
											<td align="center"><?= $atendimentosEmEspera[$i]->hora ?></td>
											<input type="hidden" name='idCliente' id="idCliente" value="<?= $atendimentosEmEspera[$i]->getId() ?>" />
											<input type="hidden" name='entrada' id="entrada" value="<?= $atendimentosEmEspera[$i]->getEntrada() ?>" />
											<input type="hidden" name='cliente' id="cliente" value="<?= $atendimentosEmEspera[$i]->cliente ?>" />
											<td align="center"><input class="esperaimgatendimento" type="image" name="deletar" value="deletar" src="../img/close.png"></td>
											<td align="center"><input class="esperaimgatendimento" type="image" name="atender" value="atender" src="../img/Foward.png"></td>											</form>
										</tr>
									<?
										} // end for atendimentos em espera
									?>

									</table>
								<br> </br>
							<?
								} // end if tabela atendimentos em espera
							?>
						</div>
					</div>
					<div id="rightbaratendimento" class="rightbaratendimento">
						<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
								<h1 class="titulo">Clientes em Atendimento</h1>
						</div>
						<div>
							<?
								if($qtdAtdEmAndamento > 0) {
							?>

									<table id="filaClientesEmAtendimento" width="650" border="1" align="center" cellpadding="0" cellspacing="0">
									<tr>
										<td align="center" class="ui-dialog-titlebar ui-widget-header ">Ordem</td>
				   						<td align="center" class="ui-dialog-titlebar ui-widget-header ">Cliente</td>
				   						<td align="center" class="ui-dialog-titlebar ui-widget-header ">Hora</td>
				   						<td class="ui-dialog-titlebar ui-widget-header "></td>
				   						<td class="ui-dialog-titlebar ui-widget-header "></td>
									</tr>

									<?
										$qtdAtdEmAndamento = count($atendimentosEmAndamento);

										for ($i = 0; $i < $qtdAtdEmAndamento; $i++) {

									?>
										<tr>
											<form method="post" action="./realizeAtendimento.php">
											<td align="center" ><?= $i + 1 ?>°</td>
											<td style="margin-left:10px;"><?= $atendimentosEmAndamento[$i]->cliente ?></td>
											<td align="center"><?= $atendimentosEmAndamento[$i]->hora ?></td>
											<input type="hidden" name='idCliente' id="idCliente" value="<?= $atendimentosEmAndamento[$i]->getId() ?>" />
											<input type="hidden" name='entrada' id="entrada" value="<?= $atendimentosEmAndamento[$i]->getEntrada() ?>" />
											<input type="hidden" name='cliente' id="cliente" value="<?= $atendimentosEmAndamento[$i]->getCliente() ?>" />
											<td align="center"><input class="esperaimgatendimento" type="image" name="encerrar" src="../img/ok.png" value="Encerrar Atendimento"></td>
											<td align="center"><input type=submit name="retornar" value="Retornar pra Fila"></td>											</form>
										</tr>
									<?
										} // end for atendimentos
									?>

									</table>
								</form>
								<br> </br>
							<?
								} // end if tabela atendimentos
							?>
							<br> </br>
						</div>

						<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
							<h1 class="titulo">Atendimentos Encerrados</h1>
						</div>
						<div>
							<?
								if($qtdAtdEncerrados > 0) {
							?>
								<form method="post" action="./realizeAtendimento.php">
									<table  id="atendimentosEncerrados" width="650" border="1" align="center" cellpadding="0" cellspacing="0">
									<tr>
				   						<td align="center" class="ui-dialog-titlebar ui-widget-header ">Cliente</td>
				   						<td align="center" class="ui-dialog-titlebar ui-widget-header ">Hora</td>
									</tr>

									<?
										$qtdAtdEncerrados = count($atendimentosEncerrados);

										for ($i = 0; $i < $qtdAtdEncerrados; $i++) {

									?>
										<tr>
											<td style="margin-left:10px;"><?= $atendimentosEncerrados[$i]->cliente ?></td>
											<td align="center"><?= $atendimentosEncerrados[$i]->hora ?></td>
										</tr>
									<?
										} // end for atendimentos encerrados
									?>

									</table>
								</form>
								<br> </br>
							<?
								} // end if tabela atendimentos encerrados
							?>
							<br> </br>
						</div>
					</div>
				</div>
			</body>
		</html>
