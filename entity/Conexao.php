<?php
/*
 * Created on 22/02/2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Conexao {
 	public $db_conexao, $dbselected;
 	private static $instance;
 	public static $contador = 0;

 	private function __construct()
    {
    }

    public static function getContador (){
    	return self::$contador;
    }

    public static function singleton() {
        if (!isset(self::$instance)) {
        	self::$contador=self::$contador + 1;
            $conexaoClass = __CLASS__;
            self::$instance = new $conexaoClass;
            self::$instance->conectar();
        }

        return self::$instance;
    }


 	private function conectar () {
		//$this->db_conexao = mysqli_connect("localhost","u491199704_blza","$eulind@","u491199704_salao");
		$this->db_conexao = mysql_connect('localhost', 'root', '');
		
		if (!$this->db_conexao) {
		    die('Não foi possível conectar: ' . mysql_error());
		}

		$this->db_selected = mysql_select_db('salaoblza', $this->db_conexao);

		if (!$this->db_selected) {
			die ('Erro na conexão : ' . mysql_error());
		}

 	}

 }

?>
