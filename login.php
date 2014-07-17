<?php
/*
 * Created on 18/06/2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<html xmlns="http://www.w3.org/1999/xhtml">	

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link type="text/css" href="./form/css/style.css" rel="stylesheet" />
		<link type="text/css" href="./form/css/cupertino/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
		<script type="text/javascript" src="./form/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="./form/js/jquery-ui-1.8.21.custom.min.js"></script>
<body>

<?  include("./form/titulo.php");?> 

<form method="post" action="./action/loginValidaAction.php">
	<div id="entracebar" class="entracebar">
		<img class="entracebar-img" src="./img/entradaLogo01.png"/>
	</div>
	
	<div id="loginbar" class="loginbar">
		<h1 class="loginbar-campos loginbar">
		</h1>
			<h1 class="loginbar-campos loginbar"><label>Login</label>
				<input type="text" name="login" maxlength="50" />
		</h1>
		<h1 class="loginbar-campos loginbar"><label>Senha</label>
				<input type="password" name="senha" maxlength="50" />
		</h1>
		<h1 class="loginbar-campos loginbar">
			<input type="submit" value="Entrar" />
		</h1>
		<h1 class="loginbar-campos loginbar">
			<a href="./form/cadastreSeForm.php">Cadastre-se</a></p>
		</h1>
	</div>
	<?  include("./form/rodape.php");?>
</body>
</html>