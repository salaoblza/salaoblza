<?php

	include("../DAO/loginDAO.php"); 

	loginDAO::protegePagina(); // Chama a função que protege a página	

	//session_start("salaoblza");
	$_SESSION["idServico"] = $_GET['idServico'];
	$_SESSION["nomeServico"] = $_GET['nomeServico'];
	$_SESSION["descricaoServico"] = $_GET['descricaoServico'];
	$_SESSION["precoServico"] = $_GET['precoServico'];
	
	/*
	$_SESSION["idServico"] = $_POST['idServico'];
	$_SESSION["nomeServico"] = $_POST['nomeServico'];
	$_SESSION["descricaoServico"] = $_POST['descricaoServico'];
	$_SESSION["precoServico"] = $_POST['precoServico'];
	*/	
?>
<html xmlns="http://www.w3.org/1999/xhtml">	
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link type="text/css" href="./css/cupertino/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
	<link type="text/css" href="./css/flexigrid/flexigrid.css" rel="stylesheet" />
	<script type="text/javascript" src="./js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="./js/jquery-ui-1.8.21.custom.min.js"></script>
	<script type="text/javascript" src="./js/flexigrid.js"></script>	
</head>
<body>
	<div id="servicos-contain" class="ui-widget">
		<h1>Serviço:</h1>
		<input type="hidden" name="id_servico" id="id_servico" value="<?php echo $_SESSION["idServico"];?>"/>		
		<table id="tbServicos" class="ui-widget ui-widget-content">
			<thead>
				<tr class="ui-widget-header ">
				<!--
					<th width="40%">Nome</th>
					<th width="20%">Preço</th>
					<th width="40%">Descrição</th>
				-->
					<th>Nome</th>
					<th>Preço</th>
					<th>Descrição</th>
				</tr>
			</thead>
			<tbody>
				<tr>
				<?php
			   		echo "   <td>";
				   	echo        $_SESSION["nomeServico"];
				   	echo "   </td>";
					echo "   <td>";
					echo        $_SESSION["precoServico"];
					echo "   </td>";
				   	echo "   <td>";
				   	echo        $_SESSION["descricaoServico"];
					echo "   </td>";
				?>
				</tr>
			</tbody>
		</table>
	</div>
	<br>

	<!-- tabela que conterá o flexgrid -->
	<table id="gridEtapas" style="display:none"></table>
	<!-- script para criação do flexgrid -->
	<script type="text/javascript">
		$("#gridEtapas").flexigrid({
			url: '../controller/etapaController.php',
			dataType: 'json',
			colModel : [
				{display: 'Id',         		name : 'id_etapa',   width : 150, sortable : true, align: 'left',   hide: true},
				{display: 'Id_servico', 		name : 'id_servico', width : 150, sortable : true, align: 'left',   hide: true},
				{display: 'Tipo',       		name : 'tipo',       width :  50, sortable : true, align: 'left',   hide: true},				
				{display: 'Descrição do Tipo',  name : 'descTipo',   width : 300, sortable : true, align: 'left',   hide: false},
				{display: 'Descrição',  		name : 'descricao',  width : 550, sortable : true, align: 'left',   hide: false},
				{display: 'Tempo',      		name : 'tempo',      width : 100, sortable : true, align: 'left',   hide: false}
				],
			buttons : [
				{id: 'btnAddService', name: 'Nova Etapa',       bclass: 'add',    onpress : inserir},
				{id: 'btnDelService', name: 'Apagar Selecionada', bclass: 'delete', onpress : apagar},
				{separator: true},				
				{id: 'btnEdtService', name: "Editar Selecionada", bclass: 'edit',   onpress : editar},
				{separator: true}
				],
			searchitems : [				
				{display: 'Descricao',  name : 'descricao', isdefault: true}
				],
			sortname: "id_etapa",
			sortorder: "asc",
			usepager: true,
			title: 'Etapas do serviço',
			useRp: true,
			rp: 5,
			showTableToggleBtn: true,
			width: 1000,
			height: 150,
			singleSelect : true,
			pagestat: 'Mostrando de {from} até {to} de {total} etapas',
        	procmsg: 'Processando, aguarde...',
        	nomsg: 'Nenhum item',
        	params: [{name: 'funcao', value: 'consultaViaGridComPaginacao'}, {name: 'id_servico', value: $('#id_servico').val()}]
		});   	
		
		function inserir(com, g) {		
			// apenas exibe a janela modal
			$("#dialog-form").dialog( "open" );			
		}
		
		function apagar(com, g) {	
			var linhas = $('.trSelected', g).length;
			
			if (linhas ==1) {
				var resposta = confirm('Excluir etapa selecionada?');
				// pede confirmação do usuario
				if (resposta == true) {
					// recupera as informacoes de servico do grid
					var vId = $('.trSelected', g)[0].id.substr(3);				
					// chamada ajax para exclusao da etapa					
					$.ajax({
						async: true,
						url: "../controller/etapaController.php",		
						type: "POST",					
            			dataType: "text", // tipo de dados de retorno do servidor
            			timeout: 60000,
            			data: {"funcao": 'apagaViaGrid', "id_etapa": vId, "id_servico": $('#id_servico').val()},
					  	beforeSend: function() {return true;},
					  	complete: function() {return true;},
					  	success: function (data, textStatus, jqXHR) {
					  		//exibe mensagem de sucesso
					  		alert("Mensagem: "+data);					    	
							//recarrega grid
					    	$( "#gridEtapas" ).flexReload();
					    	$('#id_etapa').val("");							
							$('#tipo').val("");							
							$('#descricao').val("");
							$('#tempo').val("");
					  	}
					});					
				}				
			} else if (linhas > 1) {
		        alert('Por favor, selecione APENAS uma etapa para excluir. Obrigado', 'ATENÇÃO');
			} else {
		        alert('Por favor, selecione uma etapa para excluir. Obrigado.', 'ATENÇÃO');
			}		
		}
		
		function editar(com, g) {		
			var linhas = $('.trSelected', g).length;
			
			if (linhas ==1) {
		        //Seleciona o Índice inteiro
		        //var vRow = $('.trSelected', g)[0].id;		 
				
				$('#id_etapa').val("");							
				$('#tipo').val("");							
				$('#descricao').val("");
				$('#tempo').val("");
	
				// recupera as informacoes de servico do grid
				var vId 	   = $('.trSelected', g)[0].id.substr(3);				
		        var vTipo      = $('.trSelected', g).find('td').eq(2).text();
		        var vDescricao = $('.trSelected', g).find('td').eq(4).text();
		        var vTempo     = $('.trSelected', g).find('td').eq(5).text();
				
				// seta os valores dos campos de etapa nos input usados pela janela de dialogo modal
				$('#id_etapa').val(vId);
				$('#tipo').val(vTipo);
				$('#descricao').val(vDescricao);
				$('#tempo').val(vTempo);				
								
				// abre a janela de dialogo modal
				$("#dialog-form").dialog( "open" );				
			} else if (linhas > 1) {
		        alert('Por favor selecione APENAS uma etapa para editar', 'ATENÇÃO');
			} else {
		        alert('Por favor, selecione uma etapa para editar. Obrigado.', 'ATENÇÃO');
			}			
		}
	</script>
	
	<!-- script para criação da tela de diálogo modal para inserção/atualização de serviço -->
	<script type="text/javascript">
		$(function() {
			$( "#dialog-form" ).dialog( "destroy" );
			
			var id_etapa  = $( "#id_etapa" ),
				tipo      = $( "#tipo" ),				
				descricao = $( "#descricao" ),
				tempo     = $( "#tempo" ),
				
				allFields = $( [] ).add( tipo ).add( descricao ).add( tempo )
				tips = $( ".validateTips" );
	
			function updateTips( t ) {
				tips
					.text( t )
					.addClass( "ui-state-highlight" );
				setTimeout(function() {
					tips.removeClass( "ui-state-highlight", 1500 );
				}, 500 );
			}
	
			function checkLength( o, n, min, max ) {
				if ( o.val().length > max || o.val().length < min ) {
					o.addClass( "ui-state-error" );
					updateTips( "Tamanho do campo " + n + " deve ser entre " +	min + " e " + max + "." );
					return false;
				} else {
					return true;
				}
			}
	
			function checkRegexp( o, regexp, n ) {
				if ( !( regexp.test( o.val() ) ) ) {
					o.addClass( "ui-state-error" );
					updateTips( n );
					return false;
				} else {
					return true;
				}
			}
			
			$( "#dialog-form" ).dialog({
				autoOpen: false,
				height: 350,
				width: 550,
				modal: true,
				buttons: {
					"Salvar": function() {
						var bValid = true;
						allFields.removeClass( "ui-state-error" );
						
						bValid = bValid && checkLength( tipo, "tipo", 1, 1 );
						bValid = bValid && checkLength( descricao, "descricao", 1, 120 );
						bValid = bValid && checkLength( tempo, "tempo", 1, 20 );
						
						
						bValid = bValid && checkRegexp( tipo, /^([0-9.])+$/i, "Tipo de possuir apenas dígitos." );
						bValid = bValid && checkRegexp( descricao, /^[a-z]([0-9a-zA-Z ])+$/i, "Descrição deve possuir caracteres de a-z, A-Z, 0-9, e começar com uma letra." );						
						bValid = bValid && checkRegexp( tempo, /^([0-9:])+$/, "Tempo deve possuir apenas dígitos." );					
	
						if ( bValid ) {
							$( "#users tbody" ).append( "<tr>" +
								"<td>" + tipo.val() + "</td>" +
								"<td>" + descricao.val() + "</td>" + 
								"<td>" + tempo.val() + "</td>" +
							"</tr>" ); 
							
							// chamada ajax para inserção da etapa						
							$.ajax({
								async: true,
								url: "../controller/etapaController.php",		
								type: "POST",					
	                			dataType: "text", // tipo de dados de retorno do servidor
	                			timeout: 60000,
	                			data: {"funcao": 'insereOuAtualizaViaGrid', "id_etapa": $('#id_etapa').val(), "id_servico": $('#id_servico').val(),
	                				   "tipo": $('#tipo').val(), "descricao": $('#descricao').val(), "tempo": $('#tempo').val()
	                				  },                			
							  	beforeSend: function() {return true;},
							  	complete: function() {return true;},
							  	success: function (data, textStatus, jqXHR) {
							    	//fechar a janela de dialogo
									$( this ).dialog( "close" );
									//recarrega grid
							    	$( "#gridEtapas" ).flexReload();
							  	}
							});						
							
							//limpa o campo id_etapa
							$('#id_etapa').val("");							
							$('#tipo').val("");							
							$('#descricao').val("");
							$('#tempo').val("");
							//fechar a janela de dialogo
							$( this ).dialog( "close" );						
						}
					},
					Cancel: function() {
						$( this ).dialog( "close" );
						$('#id_etapa').val("");							
						$('#tipo').val("");							
						$('#descricao').val("");
						$('#tempo').val("");					
					}
				},
				close: function() {
					allFields.val( "" ).removeClass( "ui-state-error" );
				}
			});			
		});
	</script>
	
	<!-- Formulário usado para inserção e atualização de serviços -->	
	<div id="dialog-form" title="Cadastro de Nova Etapa">
		<p class="validateTips">Os campo marcados com * são obrigatórios.</p>		
		<form id="formInsereEtapa">
		<fieldset>			
			<input type="hidden" name="id_etapa" id="id_etapa"/>
			<label for="tipo">Tipo*</label>
			<input type="text" name="tipo" id="tipo" class="text ui-widget-content ui-corner-all" />
			<label for="descricao">Descrição*</label>
			<input type="text" name="descricao" id="descricao" class="text ui-widget-content ui-corner-all" />
			<label for="tempo">Tempo*</label>
			<input type="text" name="tempo" id="tempo" class="text ui-widget-content ui-corner-all" />
		</fieldset>
		</form>
	</div>
	<br>
	<script type="text/javascript">
		$(function() {
			// aplica estilo ao botção e programa a função do clique			
			$("#botaoVoltar")
				.button()
				.click(function() {
					window.location = "./servicoGerenciaForm.php";
					return false;				
				});
		});		
	</script>
	<div>	     		
		<button id="botaoVoltar" class="botaoVoltar">Voltar</button>
	</div>
</body>
</html>