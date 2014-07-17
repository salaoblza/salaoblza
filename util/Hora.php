<?php
/*
 * Created on 03/12/2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

class Hora {

	function retornaHora () {
		date_default_timezone_set('America/Recife');
		    		
		$time = localtime(time(),true);
		switch ($time["tm_min"]) {
		    case 0:
		        $min = "00";
		        break;
		    case 1:
		        $min = "01";
		        break;
		    case 2:
		        $min = "02";
		        break;
		    case 3:
		        $min = "03";
		        break;        
		    case 4:
		        $min = "04";
		        break;
		    case 5:
		        $min = "05";
		        break;       
		    case 6:
		        $min = "06";
		        break;
		    case 7:
		        $min = "07";
		        break;		        
		    case 8:
		        $min = "08";
		        break;		
		    case 9:
		        $min = "09";
		        break;		
		    default:
		        $min = $time["tm_min"];
		        break;                         
		}
		
		return $agora = $time["tm_hour"] . ":" . $min;
		
	}	
}
?>

