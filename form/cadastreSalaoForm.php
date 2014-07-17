<?php
	include("../DAO/loginDAO.php"); 

	loginDAO::protegePagina(); // Chama a função que protege a página	
?>
<html xmlns="http://www.w3.org/1999/xhtml">	
<head>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link type="text/css" href="../form/css/style.css" rel="stylesheet" />
	<link type="text/css" href="./css/cupertino/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
	<link type="text/css" href="./css/flexigrid/flexigrid.css" rel="stylesheet" />
	<script type="text/javascript" src="./js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="./js/jquery-ui-1.8.21.custom.min.js"></script>
	<script type="text/javascript" src="./js/flexigrid.js"></script></head>
<body >
	<?  include("../form/tituloAutenticado.php");?> 	
	<div>
		<?  include("../form/identidade.php");?>
	
		<div id="centerbar" class="centerbar" >	
			<?  include("../form/menuPrincipal.php");?>

			<!-- div que conterá todos os objetos da parte central da pagina -->
			<div id="divPrincipal" class="ui-dialog ui-widget ui-widget-content ui-corner-all" style="overflow-x: auto; overflow-y: auto;  height: 83%; width: auto;">
					     

			
			<!-- script para criação da tela de diálogo modal para inserção/atualização de usuário -->
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
			var nome = $( "#nome" ),
				endereco = $( "#endereco" ),
				bairro = $( "#bairro" ),
				municipio = $( "#municipio" ),
				estado = $( "#estado" ),
				telefone1 = $( "#telefone1" ),
				telefone2 = $( "#telefone2" ),
				email = $( "#email" ),
				twitter = $( "#twitter" ),
				facebook = $( "#facebook" ),
				site = $( "#site" ),

				allFields = $( [] ).add( nome ).add( endereco ).add( bairro ).add( municipio ).add( estado ).add( telefone1 ).add( telefone2 ).add( email ).add( twitter ).add( facebook ).add( site ),
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
				bValid = bValid && checkLength( nome, "nome", 1, 80 );
				bValid = bValid && checkLength( endereco, "endereco", 1, 80 );
				bValid = bValid && checkLength( bairro, "bairro", 1, 80 );
				bValid = bValid && checkLength( municipio, "municipio", 1, 80 );
				bValid = bValid && checkLength( estado, "estado", 1, 80 );
				bValid = bValid && checkLength( telefone1, "telefone1", 1, 20 );
				bValid = bValid && checkLength( telefone2, "telefone2", 1, 20 );
				bValid = bValid && checkLength( email, "email", 1, 80 );
				bValid = bValid && checkLength( twitter, "twiter", 0, 80 );
				bValid = bValid && checkLength( facebook, "facebook", 0, 80 );
				bValid = bValid && checkLength( site, "site", 0, 80 );
				
				bValid = bValid && checkRegexp( email, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "Exemplo. fulano@gmail.com" );					

				// realizacao da validacao			
				if ( bValid ) {
					$( "#users tbody" ).append( "<tr>" +
						"<td>" + nome.val() + "</td>" +
						"<td>" + endereco.val() + "</td>" +
						"<td>" + bairro.val() + "</td>" +
						"<td>" + municipio.val() + "</td>" +
						"<td>" + estado.val() + "</td>" +
						"<td>" + telefone1.val() + "</td>" +
						"<td>" + telefone2.val() + "</td>" + 
						"<td>" + email.val() + "</td>" +
						"<td>" + twitter.val() + "</td>" +
						"<td>" + facebook.val() + "</td>" +
						"<td>" + site.val() + "</td>" +
					"</tr>" ); 

					// chamada ajax para inserção do usuário						
					$.ajax({
						async: true,
						url: "../controller/salaoController.php",	// quem trata a chamada		
						type: "POST",					
	        			dataType: "text", // tipo de dados de retorno do servidor
	        			timeout: 60000,
	        			//importante passar o nome da função para o controller
	        			data: {"funcao": 'insereOuAtualizaViaGrid', "id_salao": $('#id_salao').val(), 
	        				   "nome": $('#nome').val(), "endereco": $('#endereco').val(), "bairro": $('#bairro').val(), 
	        				   "municipio": $('#municipio').val(), "estado": $('#estado').val(), 
	        				   "telefone1": $('#telefone1').val(), "telefone2": $('#telefone2').val(), "email": $('#email').val(), 
	        				   "twitter": $('#twitter').val(), "facebook": $('#facebook').val(), "site": $('#site').val()
	        				  },                			
					  	beforeSend: function() {return true;},
					  	complete: function() {return true;},
					  	success: function (data, textStatus, jqXHR) {
					  		//exibe mensagem de sucesso
					  		alert("Mensagem: "+data);
					  		window.location = "../form/principal.php";					    	
					  	}
					});						
					
					//limpa o campo id_salao
					$('#id_salao').val("");
				}							
				return false;
			}
			
			// programação do botão voltar. redireciona para a tela de login
			function voltar() {
				window.location = "../form/principal.php";
			}
		});

			
			</script>
					     
					     
					     
				<div id="divMenuPrincipal" class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
					<span>Cadastro de Novo Salão</span>			
				</div>
				<p class="validateTips" style="padding: 0.4em 1em">Os campo marcados com * são obrigatórios.</p>				
					<fieldset  style="padding: 0.5em 1em">
						<label for="nome">Nome*</label>
						<input type="text" name="nome" id="nome" class="text ui-widget-content ui-corner-all" />
						<label for="endereco">Endereço*</label>
						<input type="text" name="endereco" id="endereco" class="text ui-widget-content ui-corner-all" />
						<label for="bairro">Bairro*</label>
						<input type="text" name="bairro" id="bairro" class="text ui-widget-content ui-corner-all" />
						<label for="municipio">Municipio*</label>
						<input type="text" name="municipio" id="municipio" class="text ui-widget-content ui-corner-all" />
						<label for="estado">Estado*</label>
						<input type="text" name="estado" id="estado" class="text ui-widget-content ui-corner-all" />
						<label for="telefone1">Telefone 1</label>
						<input type="text" name="telefone1" id="telefone1" class="text ui-widget-content ui-corner-all" />
						<label for="telefone2">Telefone 2</label>
						<input type="text" name="telefone2" id="telefone2" class="text ui-widget-content ui-corner-all" />
						<label for="email">Email</label>
						<input type="text" name="email" id="email" class="text ui-widget-content ui-corner-all" />
						<label for="twitter">Twitter</label>
						<input type="text" name="twitter" id="twitter" value="" class="text ui-widget-content ui-corner-all" />
						<label for="facebook">Facebook</label>
						<input type="text" name="facebook" id="facebook" value="" class="text ui-widget-content ui-corner-all" />
						<label for="site">Site</label>
						<input type="text" name="site" id="site" value="" class="text ui-widget-content ui-corner-all" />
					</fieldset>
					<center>
						<button class="botaoAdd" >Salvar</button>
						<button class="botaoCancel">Voltar</button>
					</center>
			</div>
		</div> 
	</div>
	<?  include("../form/meusSaloes.php");?>	
	<?  include("../form/agendaServicos.php");?>	
	<?  include("../form/rodape.php");?>
</body>
</html>