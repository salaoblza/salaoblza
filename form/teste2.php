<?php
  	include_once '../util/Hora.php';

  	include_once '../entity/ProcessoAtendimento.php';
  	include_once '../entity/Situacao.php';
  	include_once '../action/atendimentoAction.php';

	$hora = new Hora();

	$atendimentoAction = new AtendimentoAction();

	if (isset($_POST['inserir'])) {
		$atendimentoAction->inserir($_POST['cliente'], $hora);
		$mensagem = $_POST['cliente'] . ' entrou na fila de espera.';

	} elseif (isset($_POST['deletar'])) {
		if ($atendimentoAction->deletar($_POST['idCliente']) > 0) {
			$mensagem = $_POST['cliente'] . ' saiu da fila de espera.';
		}
	} elseif (isset($_POST['atender'])) {
		if ($atendimentoAction->atender($_POST['idCliente']) > 0) {
			$mensagem = $_POST['cliente'] . ' está em atendimento.';
		}
	} elseif (isset($_POST['encerrar'])) {
		if ($atendimentoAction->encerrar($_POST['idCliente']) > 0) {
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

<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" lang="en-US">
<![endif]-->
<!--[if IE 7]>
<html id="ie7" lang="en-US">
<![endif]-->
<!--[if IE 8]>
<html id="ie8" lang="en-US">
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html lang="en-US">
<!--<![endif]-->
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width" />
<title>SalaoBlza</title>
<link type="text/css" href="../form/css/cupertino/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" media="all" href="css/teste.css" />
<style type="text/css">
		#site-title a,
		#site-description {
			color: #37ef5f !important;
		}

		#primary {
			float: left;
			margin: 0 -26.4% 0 0;
			width: 40%;
		}
		#content {
			margin: 0 4px 0 10px;
			width: 100%;
		}
		#secondary {
			float: right;
			margin-right: 0 0 10px;
			width: 50%;
		}

</style>
</head>

<body class="home blog custom-background single-author two-column right-sidebar">
<div id="page" class="hfeed">
	<header id="branding" role="banner">
			<hgroup>
				<?  include("../form/tituloRealizeAtendimento.php"); ?>

			</hgroup>

			<nav id="access" role="navigation">
				<h3 class="assistive-text">Menu Principal</h3>
				<div class="skip-link"><a class="assistive-text" href="#content" title="Skip to primary content">Skip to primary content</a></div>
				<div class="skip-link"><a class="assistive-text" href="#secondary" title="Skip to secondary content">Skip to secondary content</a></div>
				<div class="menu">
					<ul>
						<li class="current_page_item"><a href="realizeAtendimento.php"><img class="centerbar-img" alt="Realizar Atendimento" style="height: 50px; width: 50px;" src="../img/tesoura.png"></a></li>
						<li class="page_item page-item-2"><a href="relatorioAtendimento.php"><img class="centerbar-img" alt="Relatório" style="height: 50px; width: 50px;" src="../img/graph.png"></a></li>
						<li class="page_item page-item-3"><a href=""><img class="centerbar-img" style="height: 50px; width: 50px;" alt="Sair" src="../img/sair.png" /></a></li>
					</ul>
				</div>
			</nav><!-- #access -->
	</header><!-- #branding -->


	<div id="main">
		<div id="primary">
			<div id="content" role="main">

				<div id="post-1" >

					<? if (isset($mensagem)) { ?>
						<div id="mensagembaratendimento" class="mensagembaratendimento" >
							<br>
								<img class="mensagemimgatendimento" style="height: 15px; width: 15px;" src="../img/aviso.png">
								<b> <span class="mensagematendimento"><?=$mensagem ?> </span></b>
							<br>
						</div>
					<?
					} ?>
					<div>
							<h1 class="titulo">Fila de Espera</h1>
					</div>
					<div>
							<form method="post" action="./teste2.php">
								<br />
								<h1 class="centerbar-campo">
									Cliente: <input name= "cliente" type="text" id="cliente">
									<input type="submit" name="inserir" value="Entrar na Fila" />
								</h1>
							</form>
							<br> </br>
							<?
										if($qtdAtdEmEspera > 0) {

									?>



								<table id="filaClientesEmEspera" border="1" align="center" cellpadding="0" cellspacing="0">
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
										<form method="post" action="./teste2.php">

										<? if ($atendimentosEmEspera[$i]->getSituacao() == Situacao::getEmEspera()) { ?>
											<td align="center"></td>
										<? } else { ?>
											<td align="center"><img class="esperaimgatendimento" src="../img/time.png"></td>
										<? } ?>
										<td align="center" ><?= $i + 1 ?>°</td>
										<td style="margin-left:10px;"><?= $atendimentosEmEspera[$i]->cliente ?></td>
										<td align="center"><?= $atendimentosEmEspera[$i]->hora ?></td>
										<input type="hidden" name='idCliente' id="idCliente" value="<?= $atendimentosEmEspera[$i]->getId() ?>" />
										<input type="hidden" name='cliente' id="cliente" value="<?= $atendimentosEmEspera[$i]->cliente ?>" />
										<td><input type=submit name="deletar" value="Desistir"</td>
										<td><input type=submit name="atender" value="Atender"></td>
										</form>
									</tr>
								<?
											} // end for atendimentos em espera
										?>

								</table>
							<?
										} // end if tabela atendimentos em espera
									?>
					</div>
				</div><!-- #post-1 -->

			</div><!-- #content -->
		</div><!-- #primary -->

		<div id="secondary" class="widget-area" role="complementary">

							<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
									<h1 class="titulo">Clientes em Atendimento</h1>
							</div>
							<div>
								<?
									if($qtdAtdEmAndamento > 0) {
								?>
									<table id="filaClientesEmAtendimento" border="1" align="center" cellpadding="0" cellspacing="0">
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
											<input type="hidden" name='cliente' id="cliente" value="<?= $atendimentosEmAndamento[$i]->getCliente() ?>" />
											<td><input type=submit name="encerrar" value="Encerrar Atendimento"></td>
											<td><input type=submit name="retornar" value="Retornar pra Fila"></td>
											</form>
										</tr>
									<?
										} // end for atendimentos
									?>

									</table>
									<br> </br>
								<?
									} // end if tabela atendimentos
								?>
							</div>

							<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
								<h1 class="titulo">Atendimentos Encerrados</h1>
							</div>
							<div>
								<?
									if($qtdAtdEncerrados > 0) {
								?>
									<table  id="atendimentosEncerrados"  border="1" align="center" cellpadding="0" cellspacing="0">
									<tr>
				   						<td align="center" class="ui-dialog-titlebar ui-widget-header ">Cliente</td>
				   						<td align="center" class="ui-dialog-titlebar ui-widget-header ">Hora</td>
									</tr>

									<?
										$qtdAtdEncerrados = count($atendimentosEncerrados);

										for ($i = 0; $i < $qtdAtdEncerrados; $i++) {

									?>
										<tr>
											<form method="post" action="./realizeAtendimento.php">
											<td style="margin-left:10px;"><?= $atendimentosEncerrados[$i]->cliente ?></td>
											<td align="center"><?= $atendimentosEncerrados[$i]->hora ?></td>
											</form>
										</tr>
									<?
										} // end for atendimentos encerrados
									?>

									</table>
									<br> </br>
								<?
									} // end if tabela atendimentos encerrados
								?>
							</div>

		</div><!-- #secondary .widget-area -->

	</div><!-- #main -->

	<footer id="colophon" role="contentinfo">



			<div id="site-generator">
				<p>Copyright ©Snoood</p>
			</div>

	</footer><!-- #colophon -->
</div><!-- #page -->


</body>
</html>