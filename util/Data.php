<?php
/*
 * Created on 28/07/2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

class Data {

	function retornaHoje () {
		 date_default_timezone_set("Brazil/East");
		 $data = getDate();
		 switch ($data["wday"]) {
		    case 0:
		        $dia = "Domingo";
		        break;
		    case 1:
		        $dia = "Segunda-Feira";
		        break;
		    case 2:
		        $dia = "Terça-Feira";
		        break;
		    case 3:
		        $dia = "Quarta-Feira";
		        break;
		    case 4:
		        $dia = "Quinta-Feira";
		        break;
		    case 5:
		        $dia = "Sexta-Feira";
		        break;
		    case 6:
		        $dia = "Sábado";
		        break;
		}
		 switch ($data["mon"]) {
		    case 1:
		        $mes = "janeiro";
		        break;
		    case 2:
		        $mes = "fevereiro";
		        break;
		    case 3:
		        $mes = "março";
		        break;
		    case 4:
		        $mes = "abril";
		        break;
		    case 5:
		        $mes = "maio";
		        break;
		    case 6:
		        $mes = "junho";
		        break;
		    case 7:
		        $mes = "julho";
		        break;
		    case 8:
		        $mes = "agosto";
		        break;
		    case 9:
		        $mes = "setembro";
		        break;
		    case 10:
		        $mes = "outubro";
		        break;
		    case 11:
		        $mes = "novembro";
		        break;
		    case 12:
		        $mes = "dezembro";
		        break;
		}
		return $hoje = $dia. ", " . $data["mday"] . " de " . $mes . " de " . $data["year"];

	}

	function retornaMes ($numeroMes) {
		 switch ($numeroMes) {
		    case 1:
		        $mes = "Janeiro";
		        break;
		    case 2:
		        $mes = "Fevereiro";
		        break;
		    case 3:
		        $mes = "Março";
		        break;
		    case 4:
		        $mes = "Abril";
		        break;
		    case 5:
		        $mes = "Maio";
		        break;
		    case 6:
		        $mes = "Junho";
		        break;
		    case 7:
		        $mes = "Julho";
		        break;
		    case 8:
		        $mes = "Agosto";
		        break;
		    case 9:
		        $mes = "Setembro";
		        break;
		    case 10:
		        $mes = "Outubro";
		        break;
		    case 11:
		        $mes = "Novembro";
		        break;
		    case 12:
		        $mes = "Dezembro";
		        break;
		}
		return $mes;

	}

	function getFuncaoPeriodo($codigoFuncaoPeriodo) {
		$funcaoPeriodo = "";
		switch ($codigoFuncaoPeriodo) {
		case 1 :
			$funcaoPeriodo = "date";
			break;
		case 2 :
			$funcaoPeriodo = "month";
			break;
		case 3 :
			$funcaoPeriodo = "year";
			break;
		default :
			$funcaoPeriodo = "month";
			break;
		};

		return $funcaoPeriodo;
	}

	function getFuncaoPeriodoTexto($codigoFuncaoPeriodo) {
		$funcaoPeriodo = "";
		switch ($codigoFuncaoPeriodo) {
		case 1 :
			$funcaoPeriodo = "dia";
			break;
		case 2 :
			$funcaoPeriodo = "mês";
			break;
		case 3 :
			$funcaoPeriodo = "ano";
			break;
		default :
			$funcaoPeriodo = "mês";
			break;
		};

		return $funcaoPeriodo;
	}
}
?>
