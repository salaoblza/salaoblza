<html xmlns="http://www.w3.org/1999/xhtml">	
<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link type="text/css" href="./css/style.css" rel="stylesheet" />
		<link type="text/css" href="./css/cupertino/jquery-ui-1.8.21.custom.css" rel="stylesheet" />		
		<script type="text/javascript" src="./js/jquery-1.7.2.min.js"></script>		
		<script type="text/javascript" src="./js/jquery-ui-1.8.21.custom.min.js"></script>
</head>
<body >
	<!-- script para tratamento de inserção de usuário -->
	<script type="text/javascript">
		$(function() {
			// aplica estilo ao botção e programa a função do clique
			$(".botaoAdd")
				.button()
				.click(function() {
					cadastrar();
				});				
				
			// aplica estilo ao botção e programa a função do clique			
			$(".botaoCancel")
				.button()
				.click(function() {
					voltar();				
				});
			
			//variaveis para validacao do form					
			var login = $( "#login" ),
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
	
			//funcao para atualizar seção de dicas e mensagens de erro
			function updateTips( t ) {
				tips
					.text( t )
					.addClass( "ui-state-highlight" );
				setTimeout(function() {
					tips.removeClass( "ui-state-highlight", 1500 );
				}, 500 );
			}
	
			//validacao do tamanho dos campos
			function checkLength( o, n, min, max ) {
				if ( o.val().length > max || o.val().length < min ) {
					o.addClass( "ui-state-error" );
					updateTips( "Tamanho do campo " + n + " deve ser entre " +	min + " e " + max + "." );
					return false;
				} else {
					return true;
				}
			}
	
			//verificacao do formato do dado inserido
			function checkRegexp( o, regexp, n ) {
				if ( !( regexp.test( o.val() ) ) ) {
					o.addClass( "ui-state-error" );
					updateTips( n );
					return false;
				} else {
					return true;
				}
			}
			
			/* função de cadastro de usuario. 
			 * realiza a validacao dos campos e, na sequencia, uma chamada ajax para o controller fazer a chamada para o metodo de insercao */
			function cadastrar() {
				var bValid = true;
				allFields.removeClass( "ui-state-error" );
				
				// definicao das validacoes
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

				// realizacao da validacao			
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
						url: "../controller/usuarioController.php",	// quem trata a chamada		
						type: "POST",					
	        			dataType: "text", // tipo de dados de retorno do servidor
	        			timeout: 60000,
	        			//importante passar o nome da função para o controller
	        			data: {"funcao": 'insereOuAtualizaViaGrid', "id_usuario": $('#id_usuario').val(), "login": $('#login').val(), 
	        				   "senha": $('#senha').val(), "nome": $('#nome').val(), "telefone": $('#telefone').val(), "email": $('#email').val(), 
	        				   "dt_nasc": $('#dt_nasc').val(), "sexo": $('#sexo').val(), "twitter": $('#twitter').val(), "facebook": $('#facebook').val()
	        				  },                			
					  	beforeSend: function() {return true;},
					  	complete: function() {return true;},
					  	success: function (data, textStatus, jqXHR) {
					  		//exibe mensagem de sucesso
					  		alert("Mensagem: "+data);
					  		window.location = "../login.php";					    	
					  	}
					});						
					
					//limpa o campo id_usuario
					$('#id_usuario').val("");
				}							
				return false;
			}
			
			// programação do botão voltar. redireciona para a tela de login
			function voltar() {
				allFields.val( "" ).removeClass( "ui-state-error" );
				window.location = "../login.php";
				return false;
			}
		});
	</script>
	
	<div id="cadastroUsuario" class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-draggable ui-resizable" 
	     style="display: block; vertical-align: middle; z-index: 1002; outline: 0px none; height: auto; width: 500px; left: 377.5; top: 65px; margin: auto;" 
	     tabindex="-1" role="dialog" aria-labelledby="ui-dialog-title-dialog-form">
	     
		<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
			<span id="ui-dialog-title-dialog-form" class="ui-dialog-title">Cadastro de Novo Usuário</span>			
		</div>
		<p class="validateTips" style="padding: 0.4em 1em">Os campo marcados com * são obrigatórios.</p>		
	
		<fieldset style="padding: 0.5em 1em">	
			<label for="login">Login*</label>
			<input type="text" name="login" id="login" class="text ui-widget-content ui-corner-all" />
			<label for="senha">Senha*</label>
			<input type="password" name="senha" id="senha" value="" class="text ui-widget-content ui-corner-all" />
			<label for="nome">Nome*</label>
			<input type="text" name="nome" id="nome" class="text ui-widget-content ui-corner-all" />
			<label for="telefone">Telefone</label>
			<input type="text" name="telefone" id="telefone" class="text ui-widget-content ui-corner-all" />
			<label for="email">Email*</label>
			<input type="text" name="email" id="email" class="text ui-widget-content ui-corner-all" />
			<label for="dt_nasc">Data de Nascimento</label>
			<input type="text" name="dt_nasc" id="dt_nasc" class="text ui-widget-content ui-corner-all" />
			<label for="sexo">Sexo*</label>
			<input type="text" name="sexo" id="sexo" class="text ui-widget-content ui-corner-all" />			
			<label for="twitter">Twitter</label>
			<input type="text" name="twitter" id="twitter" value="" class="text ui-widget-content ui-corner-all" />
			<label for="facebook">Facebook</label>
			<input type="text" name="facebook" id="facebook" value="" class="text ui-widget-content ui-corner-all" />
		</fieldset>
		<center>
			<button class="botaoAdd" >Cadastrar</button>
			<button class="botaoCancel">Voltar</button>
		</center>		
	</div>
	
	<!-- usado pra teste - não remover -->
	<!--
	<div id="container" style="background-color:red;overflow:hidden;width:200px">
	  <div id="inner" style="overflow:hidden;width: 2000px">
	     <div style="float:left;background-color:blue;width:50px;height:50px">
	     </div>
	     <div style="float:left;background-color:blue;width:50px;height:50px">
	     </div>
	     <div style="float:left;background-color:blue;width:50px;height:50px">
	     </div>
	     ...
	  </div>
	</div>
	-->
</body>
</html>