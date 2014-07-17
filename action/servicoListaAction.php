<?php
/*
 * Created on 07/06/2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
include_once '../entity/Servico.php';
include_once '../entity/Etapa.php';
include_once '../entity/Conexao.php'; 

lista();
	
function lista() {
	$conexao = conexao::singleton();
	
    $sql = "SELECT * FROM Servico ORDER BY nome";
	
	$query = mysql_query($sql) or die(mysql_error());
	 
	while($array = mysql_fetch_array($query))
	{
	  echo $array['nome']." ".$array['descricao']."<br />";
	}	
}


 
?>
