<?php
date_default_timezone_set('America/Mexico_City');
include_once '../../Conexion_/conexion.php';

class ManejadorInsumos {
    private $conexion;

    public function __construct() {
        $objeto = new Conexion();
        $this->conexion = $objeto->Conectar();
    }

    public function agregarInsumo($nombre, $modelo, $descripcion, $destino, $unidades) {
        $fecha = date('Y-m-d h:i:s');
        $consulta = "CALL spInsumoAgregar('$nombre', '$modelo', '$descripcion','$fecha','$destino','$unidades')";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        return $this->obtenerTodosLosInsumos();
    }

    public function modificarInsumo($id, $nombre, $modelo, $descripcion, $destino, $unidades) {
        $consulta = "CALL spInsumoModificar('$id','$nombre','$modelo','$descripcion','$destino','$unidades')";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        return $this->buscarInsumoPorId($id);
    }

    public function darDeBajaInsumo($id) {
        $fecha = date('Y-m-d h:i:s');
        $consulta = "CALL spInsumoBajAlta('$id','$fecha')";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        return $this->buscarInsumoPorId($id);
    }

    public function obtenerTodosLosInsumos() {
        $consulta = "CALL spInsumoBuscarLim";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarInsumoPorId($id) {
        $consulta = "CALL spInsumoBuscar('$id')";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    // Otros métodos relevantes para manejar los insumos
}

try {
// Uso de la clase ManejadorInsumos
$manejadorInsumos = new ManejadorInsumos();

// Obtener datos de la solicitud
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

// Realizar operaciones CRUD basadas en la opción proporcionada
switch ($opcion) {
    case 1: // Alta
        $data = $manejadorInsumos->agregarInsumo($_POST['nombre'], $_POST['modelo'], $_POST['descripcion'], $_POST['destino'], $_POST['unidades']);
        break;
    case 2: // Modificación
        $data = $manejadorInsumos->modificarInsumo($_POST['idInsumo'], $_POST['nombre'], $_POST['modelo'], $_POST['descripcion'], $_POST['destino'], $_POST['unidades']);
        break;
    case 3: // Baja
        $data = $manejadorInsumos->darDeBajaInsumo($_POST['idInsumo']);
        break;
    // Otros casos y operaciones CRUD
}

// Devolver los datos obtenidos como respuesta a la solicitud
echo json_encode($data, JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {
    // Manejo de errores
    echo json_encode(['error' => $e->getMessage()]);
}