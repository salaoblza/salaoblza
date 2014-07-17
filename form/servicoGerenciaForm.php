<?php
	include("../DAO/loginDAO.php"); 

	loginDAO::protegePagina(); // Chama a função que protege a página	
?>
<html xmlns="http://www.w3.org/1999/xhtml">	
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link type="text/css" href="../form/css/style.css" rel="stylesheet" />
	<link type="text/css" href="./css/cupertino/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
	<link type="text/css" href="./css/flexigrid/flexigrid.css" rel="stylesheet" />
	<script type="text/javascript" src="./js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="./js/jquery-ui-1.8.21.custom.min.js"></script>
	<script type="text/javascript" src="./js/flexigrid.js"></script>	
</head>
<body>
		<?  include("../form/tituloAutenticado.php");?> 	
		<div>
		<?  include("../form/identidade.php");?>

		<div id="centerbar" class="centerbar" >	
		<?  include("../form/menuPrincipal.php");?>
	<!-- tabela que conterá o flexgrid -->
	<table id="gridServicos" style="display:none"></table>
	<!-- script para criação do flexgrid -->
	<script type="text/javascript">
		$("#gridServicos").flexigrid({
			url: '../controller/servicoController.php',
			dataType: 'json',
			colModel : [
				{display: 'Id',         name : 'id_servico', width : 150, sortable : true, align: 'left',   hide: true},
				{display: 'Nome',       name : 'nome',       width : 300, sortable : true, align: 'left',   hide: false},
				{display: 'Preço',      name : 'preco',      width : 100, sortable : true, align: 'left',   hide: false},
				{display: 'Descrição',  name : 'descricao',  width : 400, sortable : false,align: 'left',   hide: false}
				],
			buttons : [
				{id: 'btnAddService', name: 'Novo Serviço',       bclass: 'add',    onpress : inserir},
				{id: 'btnDelService', name: 'Apagar Selecionado', bclass: 'delete', onpress : apagar},
				{separator: true},				
				{id: 'btnEdtService', name: "Editar Selecionado", bclass: 'edit',   onpress : editar},
				{id: 'btnEtpService', name: "Etapas Selecionado", bclass: 'edit',   onpress : gerirEtapa},
				{separator: true}
				],
			searchitems : [
				{display: 'Nome', name : 'nome', isdefault: true},
				{display: 'Descricao', name : 'descricao'}
				],
			sortname: "nome",
			sortorder: "asc",
			usepager: true,
			title: 'Serviços',
			useRp: true,
			rp: 10,
			showTableToggleBtn: true,
			width: 768,
			height: 250,
			singleSelect : true,
			pagestat: 'Mostrando de {from} até {to} de {total} serviços',
        	procmsg: 'Processando, aguarde...',
        	nomsg: 'Nenhum item',
        	params: [{name: 'funcao', value: 'consultaViaGridComPaginacao'}]
		});   	
		
		function inserir(com, g) {		
			// apenas exibe a janela modal
			$("#dialog-form").dialog( "open" );			
		}
		
		function apagar(com, g) {	
			var linhas = $('.trSelected', g).length;
			
			if (linhas ==1) {
				var resposta = confirm('Excluir serviço selecionado?');
				// pede confirmação do usuario
				if (resposta == true) {
					// recupera as informacoes de servico do grid
					var vId = $('.trSelected', g)[0].id.substr(3);				
					// chamada ajax para exclusao do servico						
					$.ajax({
						async: true,
						url: "../controller/servicoController.php",		
						type: "POST",					
            			dataType: "text", // tipo de dados de retorno do servidor
            			timeout: 60000,
            			data: {"funcao": 'apagaViaGrid', "id_servico": vId},
					  	beforeSend: function() {return true;},
					  	complete: function() {return true;},
					  	success: function (data, textStatus, jqXHR) {
					  		//exibe mensagem de sucesso
					  		alert("Mensagem: "+data);					    	
							//recarrega grid
					    	$( "#gridServicos" ).flexReload();
					  	}
					});					
				}				
			} else if (linhas > 1) {
		        alert('Por favor, selecione APENAS um serviço para excluir. Obrigado', 'ATENÇÃO');
			} else {
		        alert('Por favor, selecione um serviço para excluir. Obrigado.', 'ATENÇÃO');
			}		
		}
		
		function editar(com, g) {		
			var linhas = $('.trSelected', g).length;
			
			if (linhas ==1) {
		        //Seleciona o Índice inteiro
		        //var vRow = $('.trSelected', g)[0].id;		 

				// recupera as informacoes de servico do grid
				var vId 	   = $('.trSelected', g)[0].id.substr(3);				
		        var vNome      = $('.trSelected', g).find('td').eq(1).text();
		        var vPreco     = $('.trSelected', g).find('td').eq(2).text();
		        var vDescricao = $('.trSelected', g).find('td').eq(3).text();		        
				
				// seta os valores dos campos de servico nos input usados pela janela de dialogo modal
				$('#id_servico').val(vId);
				$('#nome').val(vNome);
				$('#preco').val(vPreco);
				$('#descricao').val(vDescricao);				
				
				// abre a janela de dialogo modal
				$("#dialog-form").dialog( "open" );				
			} else if (linhas > 1) {
		        alert('Por favor selecione APENAS um serviço para editar', 'ATENÇÃO');
			} else {
		        alert('Por favor, selecione um serviço para editar. Obrigado.', 'ATENÇÃO');
			}			
		}
		
		function gerirEtapa(com, g) {		
			var linhas = $('.trSelected', g).length;
			
			if (linhas ==1) {		        
				// recupera as informacoes de servico do grid
				var vId 	   = $('.trSelected', g)[0].id.substr(3);				
		        var vNome      = $('.trSelected', g).find('td').eq(1).text();
		        var vPreco     = $('.trSelected', g).find('td').eq(2).text();
		        var vDescricao = $('.trSelected', g).find('td').eq(3).text();		        
				
				window.location = "./etapaGerenciaForm.php?idServico="+vId+"&nomeServico="+vNome+"&precoServico="+vPreco+"&descricaoServico="+vDescricao+" ";
				return false;				
				/*	
				$.ajax({
					async: false,
					url: "./etapaGerenciaForm.php",		
					type: "POST",					
        			dataType: "html", // tipo de dados de retorno do servidor        			
        			data: {"idServico": vId, "nomeServico": vNome, "precoServico": vPreco, "descricaoServico": vDescricao},
				  	success: function (data, textStatus, jqXHR) {
				  		//var url = "http://www.google.com.br";    
						window.document.write(data);					    	
				  	}
				});*/					
											
			} else if (linhas > 1) {
		        alert('Por favor selecione APENAS um serviço para gerenciar as etapas', 'ATENÇÃO');
			} else {
		        alert('Por favor, selecione um serviço para gerenciar as etapas. Obrigado.', 'ATENÇÃO');
			}			
		}

	</script>
	
	<!-- script para criação da tela de diálogo modal para inserção/atualização de serviço -->
	<script type="text/javascript">
		$(function() {
			$( "#dialog-form" ).dialog( "destroy" );
			
			var id_servico = $( "#id_servico" ),
				nome      = $( "#nome" ),
				preco     = $( "#preco" ),
				descricao = $( "#descricao" ),
				
				allFields = $( [] ).add( nome ).add( preco ).add( descricao )
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
						
						bValid = bValid && checkLength( nome, "nome", 1, 80 );
						bValid = bValid && checkLength( preco, "preco", 1, 20 );
						bValid = bValid && checkLength( descricao, "descricao", 1, 120 );
						
						bValid = bValid && checkRegexp( nome, /^[a-z]([0-9a-zA-Z ])+$/i, "Nome deve possuir caracteres de a-z, A-Z, 0-9, e começar com uma letra." );					
						bValid = bValid && checkRegexp( preco, /^([0-9.])+$/i, "Preço de possuir apenas dígitos ou . (ponto)." );
						bValid = bValid && checkRegexp( descricao, /^([0-9a-zA-Z])+$/, "Descrição deve possuir apenas caracteres: [a-z] [A-Z] [0-9]" );					
	
						if ( bValid ) {
							$( "#users tbody" ).append( "<tr>" +
								"<td>" + nome.val() + "</td>" +
								"<td>" + preco.val() + "</td>" + 
								"<td>" + descricao.val() + "</td>" +
							"</tr>" ); 
							
							// chamada ajax para inserção do serviço						
							$.ajax({
								async: true,
								url: "../controller/servicoController.php",		
								type: "POST",					
	                			dataType: "text", // tipo de dados de retorno do servidor
	                			timeout: 60000,
	                			data: {"funcao": 'insereOuAtualizaViaGrid', "id_servico": $('#id_servico').val(),  
	                				   "nome": $('#nome').val(), "preco": $('#preco').val(), "descricao": $('#descricao').val()	                				   
	                				  },                			
							  	beforeSend: function() {return true;},
							  	complete: function() {return true;},
							  	success: function (data, textStatus, jqXHR) {
							  		//exibe mensagem de sucesso
							  		alert("Mensagem: "+data);					    	
							    	//fechar a janela de dialogo
									$( this ).dialog( "close" );
									//recarrega grid
							    	$( "#gridServicos" ).flexReload();
							  	}
							});						
							
							//limpa o campo id_servico
							$('#id_servico').val("");
							//fechar a janela de dialogo
							$( this ).dialog( "close" );						
						}
					},
					Cancel: function() {
						$( this ).dialog( "close" );					
					}
				},
				close: function() {
					allFields.val( "" ).removeClass( "ui-state-error" );
				}
			});			
		});
	</script>
	
	<!-- Formulário usado para inserção e atualização de serviços -->	
	<div id="dialog-form" title="Cadastro de Novo Serviço">
		<p class="validateTips">Os campo marcados com * são obrigatórios.</p>		
		<form id="formInsereServico">
		<fieldset>			
			<input type="hidden" name="id_servico" id="id_servico"/>
			<label for="nome">Nome*</label>
			<input type="text" name="nome" id="nome" class="text ui-widget-content ui-corner-all" />
			<label for="preco">Preço*</label>
			<input type="text" name="preco" id="preco" class="text ui-widget-content ui-corner-all" />
			<label for="descricao">Descrição*</label>
			<input type="text" name="descricao" id="descricao" class="text ui-widget-content ui-corner-all" />
		</fieldset>
		</form>
	</div>
			
		</div>

		<?  include("../form/meusSaloes.php");?>	

		<?  include("../form/agendaServicos.php");?>	
	
	<?  include("../form/rodape.php");?>

	
</body>
</html>