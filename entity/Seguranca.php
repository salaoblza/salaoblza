<?php
/*
 * Created on 07/07/2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

class Seguranca {
 	private static $instance;
 	private static $inatividade = 1200; //20 minutos 
 	
 	private function __construct() 
    {
    }
    
    public static function getInatividade() {
    	return self::$inatividade;
    }
    
    public static function singleton() {
            session_start("login");
        if ($_SESSION['iSeguranca']==null) {
            $segurancaClass = __CLASS__;
            self::$instance = new $segurancaClass;
            session_cache_expire( self::$inatividade );
            $_SESSION['start'] = time();
            $_SESSION['iSeguranca'] = self::$instance;
        }
		return $_SESSION['iSeguranca'];
    }
 } 
?>