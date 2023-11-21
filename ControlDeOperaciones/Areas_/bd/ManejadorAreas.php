<?php

include_once '../../Conexion_/conexion.php';

class ManejadorAreas {
    private $conexion;

    public function __construct() {
        $objeto = new Conexion();
        $this->conexion = $objeto->Conectar();
    }

    public function agregarArea($nombre, $localizacion) {
        $consulta = "CALL spAreaAgregar('$nombre', '$localizacion')";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        return $this->mostrarAreas();
    }

    public function modificarArea($id, $nombre, $localizacion) {
        $consulta = "CALL spAreaModificar('$id', '$nombre', '$localizacion')";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        return $this->buscarAreaPorId($id);
    }

    public function darDeBajaArea($id) {
        $consulta = "CALL spAreaAltaBaja('$id')";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        return $this->buscarAreaPorId($id);
    }

    public function mostrarAreas() {
        $consulta = "CALL spAreaMostrarLim";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarAreaPorId($id) {
        $consulta = "CALL spAreaBuscarId('$id')";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }
}

$manejadorAreas = new ManejadorAreas();

$Localizacion = (isset($_POST['LocalizacionAr'])) ? $_POST['LocalizacionAr'] : '';
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id = (isset($_POST['Id'])) ? $_POST['Id'] : '';

switch($opcion){
    case 1: // Alta
        $data = $manejadorAreas->agregarArea($nombre, $Localizacion);
        break;
    case 2: // Modificación
        $data = $manejadorAreas->modificarArea($id, $nombre, $Localizacion);
        break;
    case 3: // Baja
        $data = $manejadorAreas->darDeBajaArea($id);
        break;
    // Otros casos y operaciones
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);
