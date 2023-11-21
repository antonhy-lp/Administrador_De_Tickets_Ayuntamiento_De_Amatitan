<?php

include_once '../../Conexion_/conexion.php';

class ManejadorEquipos {
    private $conexion;

    public function __construct() {
        $objeto = new Conexion();
        $this->conexion = $objeto->Conectar();
    }

    public function agregarEquipo($equipoMo, $equipoMa, $equipoDes) {
        $consulta = "CALL spEquipoAgregar('$equipoMo', '$equipoMa', '$equipoDes')";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        return $this->mostrarEquipos();
    }

    public function modificarEquipo($id, $equipoMo, $equipoMa, $equipoDes) {
        $consulta = "CALL spEquipoModificar('$id', '$equipoMo', '$equipoMa', '$equipoDes')";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        return $this->buscarEquipoPorId($id);
    }

    public function darDeBajaEquipo($id) {
        $consulta = "CALL spEquipoAltaBaja('$id')";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        return $this->buscarEquipoPorId($id);
    }

    public function mostrarEquipos() {
        $consulta = "CALL spEquipoLim()";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarEquipoPorId($id) {
        $consulta = "CALL spEquipoBuscarId('$id')";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }
}

$manejadorEquipos = new ManejadorEquipos();

$EquipoMo = (isset($_POST['EquipoMo'])) ? $_POST['EquipoMo'] : '';
$EquipoMa = (isset($_POST['EquipoMa'])) ? $_POST['EquipoMa'] : '';
$EquipoDes = (isset($_POST['EquipoDes'])) ? $_POST['EquipoDes'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id = (isset($_POST['EquipoNo'])) ? $_POST['EquipoNo'] : '';

switch($opcion){
    case 1: // Alta
        $data = $manejadorEquipos->agregarEquipo($EquipoMo, $EquipoMa, $EquipoDes);
        break;
    case 2: // Modificación
        $data = $manejadorEquipos->modificarEquipo($id, $EquipoMo, $EquipoMa, $EquipoDes);
        break;
    case 3: // Baja
        $data = $manejadorEquipos->darDeBajaEquipo($id);
        break;
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);

$conexion = NULL;
