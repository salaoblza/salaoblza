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
<body >
	<?  include("../form/tituloAutenticado.php");?>	
	<?  include("../form/identidade.php");?>
			
	<div id="centerbar" class="centerbar" >	
		<?  include("../form/menuPrincipal.php");?>
		
		<!-- tabela que conterá o flexgrid -->
		<table id="tabUsuarios" style="display:none"></table>
	
		<!-- script para criação do flexgrid -->
		<script type="text/javascript">
			$("#tabUsuarios").flexigrid({			
				url: '../controller/usuarioController.php',
				dataType: 'json',
				colModel : [
					{display: 'Id',         name : 'id_usuario', width : 150, sortable : true, align: 'left',   hide: true},
					{display: 'Login',      name : 'login',      width : 154, sortable : true, align: 'left',   hide: false},
					{display: 'Nome',       name : 'nome',       width : 300, sortable : true, align: 'left',   hide: false},
					{display: 'Telefone',   name : 'telefone',   width : 100, sortable : true, align: 'left',   hide: false},
					{display: 'Email',      name : 'email',      width : 200, sortable : false,align: 'left',   hide: false},
					{display: 'Nascimento', name : 'dt_nasc',    width :  80, sortable : true, align: 'left',   hide: false},
					{display: 'Sexo',       name : 'sexo',       width :  80, sortable : true, align: 'left',   hide: false},
					{display: 'Twitter',    name : 'twitter',    width : 120, sortable : false,align: 'left',   hide: false},
					{display: 'Facebook',   name : 'facebook',   width : 120, sortable : false,align: 'left',   hide: false}
					],
				buttons : [
					{id: 'btnAddUser', name: 'Novo Usuário',       bclass: 'add',    onpress : inserir},
					{id: 'btnDelUser', name: 'Apagar Selecionado', bclass: 'delete', onpress : apagar},
					{separator: true},				
					{id: 'btnEdtUser', name: "Editar Selecionado", bclass: 'edit',   onpress : editar},
					{separator: true}
					],
				searchitems : [
					{display: 'Nome', name : 'nome', isdefault: true},
					{display: 'Email', name : 'email'}
					],
				sortname: "nome",
				sortorder: "asc",
				usepager: true,
				title: 'Usuários',
				useRp: true,
				rp: 10,
				showTableToggleBtn: true,
				width: 760,
				height: 350,
				resizable: false,
				singleSelect : true,
				pagestat: 'Mostrando de {from} até {to} de {total} usuários',
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
					var resposta = confirm('Excluir usuário selecionado?');
					// pede confirmação do usuario
					if (resposta == true) {
						// recupera as informacoes de usuario do grid
						var vId = $('.trSelected', g)[0].id.substr(3);				
						// chamada ajax para exclusão do usuário						
						$.ajax({
							async: true,
							url: "../controller/usuarioController.php",		
							type: "POST",					
	            			dataType: "text", // tipo de dados de retorno do servidor
	            			timeout: 60000,
	            			data: {"funcao": 'apagaViaGrid', "id_usuario": vId},
						  	beforeSend: function() {return true;},
						  	complete: function() {return true;},
						  	success: function (data, textStatus, jqXHR) {
						  		//exibe mensagem de sucesso
						  		alert("Mensagem: "+data);					    	
								//recarrega grid
						    	$( "#tabUsuarios" ).flexReload();
						  	}
						});					
					}				
				} else if (linhas > 1) {
			        alert('Por favor, selecione APENAS um usuário para excluir. Obrigado', 'ATENÇÃO');
				} else {
			        alert('Por favor, selecione um usuário para excluir. Obrigado.', 'ATENÇÃO');
				}			
			}
			
			function editar(com, g) { 
				var linhas = $('.trSelected', g).length;
				if (linhas ==1) {
			        //Seleciona o Índice inteiro
			        //var vRow = $('.trSelected', g)[0].id;		 
	
					// recupera as informacoes de usuario do grid
					var vId 	  = $('.trSelected', g)[0].id.substr(3);				
					var vLogin    = $('.trSelected', g).find('td').eq(1).text();				
			        var vNome     = $('.trSelected', g).find('td').eq(2).text();
			        var vTelefone = $('.trSelected', g).find('td').eq(3).text();
			        var vEmail    = $('.trSelected', g).find('td').eq(4).text();		        
			        var vDtNasc   = $('.trSelected', g).find('td').eq(5).text();
			        var vSexo     = $('.trSelected', g).find('td').eq(6).text();
			        var vTwitter  = $('.trSelected', g).find('td').eq(7).text();
			        var vFacebook = $('.trSelected', g).find('td').eq(8).text();
					
					// seta os valores dos campos de usuario nos input usados pela janela de dialogo modal
					$('#id_usuario').val(vId);
					$('#login').val(vLogin);				
					$('#nome').val(vNome);
					$('#telefone').val(vTelefone);
					$('#email').val(vEmail);				
					$('#dt_nasc').val(vDtNasc);
					$('#sexo').val(vSexo);
					$('#twitter').val(vTwitter);
					$('#facebook').val(vFacebook);				
					
					// abre a janela de dialogo modal
					$("#dialog-form").dialog( "open" );				
				} else if (linhas > 1) {
			        //alert('Você selecionou ' + linhas + ' linha(s)', 'ATENÇÃO');
			        alert('Você mais de uma linha', 'ATENÇÃO');
				} else {
			        alert('Por favor, selecione um usuário para editar. Obrigado.', 'ATENÇÃO');
				}			
			}			
		</script>
		
		<!-- script para criação da tela de diálogo modal para inserção/atualização de usuário -->
		<script type="text/javascript">
		$(function() {
			$( "#dialog-form" ).dialog( "destroy" );
			
			var id_usuario = $( "#id_usuario" ),
				login = $( "#login" ),
				senha = $( "#senha" ), 
				nome = $( "#nome" ),
				telefone = $( "#telefone" ),
				email = $( "#email" ),
				dt_nasc = $( "#dt_nasc" ),
				sexo = $( "#sexo" ),
				twitter = $( "#twitter" ),
				facebook = $( "#facebook" ),
				
				allFields = $( [] ).add( login ).add( senha ).add( nome ).add( telefone ).add( email ).add( sexo ).add( dt_nasc ).add( twitter ).add( facebook ),
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
				height: 500,
				width: 500,
				modal: true,
				buttons: {
					"Salvar": function() {
						var bValid = true;
						allFields.removeClass( "ui-state-error" );
						
						bValid = bValid && checkLength( login, "login", 3, 16 );
						bValid = bValid && checkLength( senha, "password", 1, 16 );
						bValid = bValid && checkLength( nome, "nome", 1, 80 );
						bValid = bValid && checkLength( telefone, "telefone", 1, 20 );
						bValid = bValid && checkLength( email, "email", 1, 80 );
						bValid = bValid && checkLength( dt_nasc, "dt_nasc", 1, 14 );
						bValid = bValid && checkLength( sexo, "sexo", 1, 1 );
						bValid = bValid && checkLength( twitter, "twiter", 0, 80 );
						bValid = bValid && checkLength( facebook, "facebook", 0, 80 );
						
						bValid = bValid && checkRegexp( login, /^[a-z]([0-9a-z_])+$/i, "Login deve possuir caracteres de a-z, 0-9, underline, e começar com uma letra." );					
						bValid = bValid && checkRegexp( sexo, /^[m,f]/i, "Sexo deve ser f (feminino) ou m (masculino)." );
						bValid = bValid && checkRegexp( senha, /^([0-9a-zA-Z])+$/, "Senha deve possuir apenas caracteres: [a-z] [0-9]" );					
						bValid = bValid && checkRegexp( email, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "Exemplo. fulano@gmail.com" );					
	
						if ( bValid ) {
							$( "#users tbody" ).append( "<tr>" +
								"<td>" + login.val() + "</td>" +
								"<td>" + senha.val() + "</td>" +
								"<td>" + nome.val() + "</td>" +
								"<td>" + telefone.val() + "</td>" + 
								"<td>" + email.val() + "</td>" +
								"<td>" + dt_nasc.val() + "</td>" +
								"<td>" + sexo.val() + "</td>" + 
								"<td>" + twitter.val() + "</td>" +
								"<td>" + facebook.val() + "</td>" +
							"</tr>" ); 
							
							// chamada ajax para inserção do usuário						
							$.ajax({
								async: true,
								url: "../controller/usuarioController.php",		
								type: "POST",					
	                			dataType: "text", // tipo de dados de retorno do servidor
	                			timeout: 60000,
	                			data: {"funcao": 'insereOuAtualizaViaGrid', "id_usuario": $('#id_usuario').val(), "login": $('#login').val(), 
	                				   "senha": $('#senha').val(), "nome": $('#nome').val(), "telefone": $('#telefone').val(), "email": $('#email').val(), 
	                				   "dt_nasc": $('#dt_nasc').val(), "sexo": $('#sexo').val(), "twitter": $('#twitter').val(), "facebook": $('#facebook').val()
	                				  },                			
							  	beforeSend: function() {return true;},
							  	complete: function() {return true;},
							  	success: function (data, textStatus, jqXHR) {
							  		//exibe mensagem de sucesso
							  		alert("Mensagem: "+data);					    	
							    	//fechar a janela de dialogo
									$( this ).dialog( "close" );
									//recarrega grid
							    	$( "#tabUsuarios" ).flexReload();
							  	}
							});						
							
							//limpa o campo id_usuario
							$('#id_usuario').val("");
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

		<div id="dialog-form" title="Cadastro de Novo Usuário">
			<p class="validateTips">Os campo marcados com * são obrigatórios.</p>		
			<form id="formInsereUsuario">
				<fieldset>			
					<input type="hidden" name="id_usuario" id="id_usuario"/>
					<label for="login">Login</label>
					<input type="text" name="login" id="login" class="text ui-widget-content ui-corner-all" />
					<label for="senha">Senha</label>
					<input type="password" name="senha" id="senha" value="" class="text ui-widget-content ui-corner-all" />			
					<label for="nome">Nome</label>
					<input type="text" name="nome" id="nome" class="text ui-widget-content ui-corner-all" />
					<label for="telefone">Telefone</label>
					<input type="text" name="telefone" id="telefone" class="text ui-widget-content ui-corner-all" />
					<label for="email">Email</label>
					<input type="text" name="email" id="email" class="text ui-widget-content ui-corner-all" />
					<label for="dt_nasc">Data Nascimento</label>
					<input type="text" name="dt_nasc" id="dt_nasc" class="text ui-widget-content ui-corner-all" />
					<label for="sexo">Sexo</label>
					<input type="text" name="sexo" id="sexo" class="text ui-widget-content ui-corner-all" />			
					<label for="twitter">Twitter</label>
					<input type="text" name="twitter" id="twitter" value="" class="text ui-widget-content ui-corner-all" />
					<label for="facebook">Facebook</label>
					<input type="text" name="facebook" id="facebook" value="" class="text ui-widget-content ui-corner-all" />			
				</fieldset>
			</form>			
		</div>
	</div>
	<?  include("../form/meusSaloes.php");?>	
	<?  include("../form/agendaServicos.php");?>	
	<?  include("../form/rodape.php");?>
	
	<!--
	<div id="users-contain" class="ui-widget">
		<h1>Existing Users:</h1>
		<table id="users" class="ui-widget ui-widget-content">
			<thead>
				<tr class="ui-widget-header ">
					<th>Name</th>
					<th>Email</th>
					<th>Password</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>John Doe</td>
					<td>john.doe@example.com</td>
					<td>johndoe1</td>
				</tr>
			</tbody>
		</table>
	</div>
	
	<button id="create-user">Create new user</button>
	-->
</body>
</html>