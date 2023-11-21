<?php error_reporting(0);
class Conexion{	  
    public static function Conectar() {        
        define('servidor', 'localhost');
        define('nombre_bd', 'bdtickets');
        define('usuario', 'root');
        define('password', 'root');					        
        $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');			
        try{
            $conexion = new PDO("mysql:host=".servidor."; dbname=".nombre_bd, usuario, password, $opciones);
            /*ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION: este atributo indica a PDO que inicie una excepción que se puede registrar para depuración. */
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
            /*TTR_EMULATE_PREPARES, false: esta opción aumenta la seguridad al indicar al motor de la base de datos MySQL que realice la preparación. */
            $conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);		
            return $conexion;
        }catch (Exception $e){
            die("El error de Conexión es: ". $e->getMessage());
        }
    }
}