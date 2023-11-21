<?php
 /*class conexion
 {
    public $server;
     public $user;
     public $database;
     public $con;
     public $proceso;
     function __construct(){
         $this->server = "localhost";
         $this->user = "root";
         $this->pass = "33344481722";
         $this->database = "bdtickets";
         $this->con = mysqli_connect($this->server,$this->user,$this->pass,$this->database);
         if(!$this->con){
             die("Conexión fallida: ". mysqli_connect_error() );
         }
     }
     function sentencias($sql){
         $this->proceso = mysqli_query($this->con, $sql);
     
         if(!$this->proceso){
             echo "Error". $sql . "<br>" . mysqli_error($this->con);
         }
     }
     function datos(){
         return mysqli_fetch_array($this->proceso);
     }
     function get_conection(){
         return $this->con;
     }
     function close(){
         mysqli_close($this->con);
     }
     public function next_result()
{
  if (is_object($this->conn_id))
  {
     return mysqli_next_result($this->conn_id);
  }
}
 }*/

 class Conectar{
	private $host;
	private $user;
	private $pass;
	private $db;

	public function __construct($datos){
		$this->host = $datos['host'];
		$this->user = $datos['user'];
		$this->pass = $datos['pass'];
		$this->db = $datos['db'];
	}


	function getConnection(){
		$conn = "";
		try {
			$cadena = "mysql:host=".$this->host.";dbname=".$this->db;
			$conn = new PDO($cadena, $this->user, $this->pass);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		} catch (PDOException $e) {
			echo $e->getMessage();
		}
		return $conn;
    }


 }
/*
//Configuracion de conexion al servidor
$usuario  = "root";
$password = "33344481722";
$servidor = "localhost";
$basededatos = "bdtickets";
$con = mysqli_connect($servidor, $usuario, $password) or die("No se ha podido conectar al Servidor ):");
mysqli_query($con,"SET SESSION collation_connection ='utf8mb4_unicode_ci'");
$db = mysqli_select_db($con, $basededatos) or die("Upps! Error en conectar a la Base de Datos");



define('DB_NAME', 'bdtickets');
define('DB_USER', 'root');
define('DB_PASSWORD', '33344481722');
define('DB_HOST', 'localhost');
/*Con la siguiente línea de su archivo se inicia un objeto de datos de PHP (PDO) y se conecta a la base de datos MySQL: */
//$pdo = new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
/*ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION: este atributo indica a PDO que inicie una excepción que se puede registrar para depuración. */
//$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
/*TTR_EMULATE_PREPARES, false: esta opción aumenta la seguridad al indicar al motor de la base de datos MySQL que realice la preparación en lugar de PDO. */
//$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);


/*function conexion(){
    $servidor="localhost";
    $usuario="root";
    $password="33344481722";
    $bd="pruebas";

    $conexion=mysqli_connect($servidor,$usuario,$password,$bd);

    return $conexion;
}*/


class Conexionn{	  
    public static function Conectar() {        
        define('servidor', 'localhost');
        define('nombre_bd', 'bdtickets');
        define('usuario', 'root');
        define('password', 'root');					        
        $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');			
        try{
            $conexion = new PDO("mysql:host=".servidor."; dbname=".nombre_bd, usuario, password, $opciones);			
            return $conexion;
        }catch (Exception $e){
            die("El error de Conexión es: ". $e->getMessage());
        }
    }
}

