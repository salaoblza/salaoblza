<?php
/*
 * Created on 07/07/2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
	include("../DAO/loginDAO.php"); 

	loginDAO::protegePagina(); // Chama a função que protege a página	
 
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Salao BLZA</title>
		<link type="text/css" href="../form/css/cupertino/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
		<link type="text/css" href="../form/css/style.css" rel="stylesheet" />
		<script type="text/javascript" src="../form/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="../form/js/jquery-ui-1.8.21.custom.min.js"></script>
</head>

<html>
	<body>
	<?  include("../form/tituloAutenticado.php");?> 
	<div>
		<?  include("../form/identidade.php");?>		
		<div id="centerbar" class="centerbar" >	
			<?  include("../form/menuPrincipal.php");?>
			<?  include("../form/salaoDestaque.php");?>
		</div>
		<?  include("../form/meusSaloes.php");?>	
		<?  include("../form/agendaServicos.php");?>	

	</div>

	<?  include("../form/rodape.php");?> 

	</body>
</html> 

