<?php
session_start();
header('Access-Control-Allow-Origin: *');
$resultado['estado'] = "Error";
$datos = json_decode(file_get_contents("php://input"));
if($datos->user == "" || $datos->pass==""){
    $resultado['estado'] = "Error: Datos Vacíos";
}else{
    require_once("config.php");
    require_once("connect.php");
    require_once("Usuario.php");
    //require_once("../ControlDeOperaciones/Dispositivo.php");
    $c = new Conectar($conData);
    $d = new Usuario($c->getConnection());

    $datos->clave = $_CLAVE;
    $res = $d->getLogin($datos);
    if($res['estado'] == "OK"){
        if($res['filas'] == 1){
            foreach($res['datos'] as $fila){
                $_SESSION['myUser'] = $fila['nombre'];
            }
            $resultado['estado'] = "OK";
        }else{
            $resultado['estado'] = "Nombre o usuario incorrecto";
        }
    }else{
        $resultado['estado'] = "es: " . $res['estado'];
    }
}
echo json_encode($resultado);
?>