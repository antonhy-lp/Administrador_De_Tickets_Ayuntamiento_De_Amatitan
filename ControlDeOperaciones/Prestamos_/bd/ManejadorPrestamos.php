<?php

include_once '../../Conexion_/conexion.php';

class ManejadorPrestamos {
    private $conexion;

    public function __construct() {
        $objeto = new Conexion();
        $this->conexion = $objeto->Conectar();
    }

    public function agregarPrestamo($equipoMo, $fecha, $fechaRecepcion, $areaID, $personalId, $descripcion) {
        $consulta = "CALL spPrestamosAgregar('$equipoMo', '$fecha', '$fechaRecepcion','$areaID','$personalId','$descripcion')";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        return $this->mostrarPrestamos();
    }

    public function modificarPrestamo($id, $equipoMo, $fechaRecepcion, $areaID, $personalId, $descripcion) {
        $consulta = "CALL spPrestamosModificar('$id','$equipoMo', '$fechaRecepcion','$areaID','$personalId','$descripcion')";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        return $this->buscarPrestamoPorId($id);
    }

    public function darDeBajaPrestamo($id, $estatus) {
        $consulta = "CALL spPrestamoAltaBaja('$id','$estatus')";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        return $this->buscarPrestamoPorId($id);
    }

    public function mostrarPrestamos() {
        $consulta = "CALL spPrestamosMostrarLim()";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPrestamoPorId($id) {
        $consulta = "CALL spPrestamosBuscarid('$id')";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }
    public function spEquipoBuscarModelo($EquipoMo) {
        $consulta = "CALL spEquipoBuscarModelo('$EquipoMo')";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        $dt = $resultado->fetch();
        return $dt['EquipoNo'];
    }

    public function spAreaBuscarIdn($Area) {
        $consulta = "CALL spAreaBuscarIdn('$Area')";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        $dt = $resultado->fetch();
        return $dt['AreaID'];
    }

    public function spPersonalBuscarNombre($PersonalNo) {
        $consulta = "CALL spPersonalBuscarNombre('$PersonalNo')";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        $dt = $resultado->fetch();
        return $dt['PersonalId'];
    }
}

$manejadorPrestamos = new ManejadorPrestamos();

$id = (isset($_POST['idPrestamo'])) ? $_POST['idPrestamo'] : '';
$Fecha = date('Y-m-d h:i:s');
$Area  = (isset($_POST['Area'])) ? $_POST['Area'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$Estatus = (isset($_POST['Estatus'])) ? $_POST['Estatus'] : '';
$EquipoNo = (isset($_POST['EquipoNo'])) ? $_POST['EquipoNo'] : '';
$EquipoMo = (isset($_POST['EquipoMo'])) ? $_POST['EquipoMo'] : '';
$PersonalNo = (isset($_POST['PersonalNo'])) ? $_POST['PersonalNo'] : '';
$Descripcion = (isset($_POST['Descripcion'])) ? $_POST['Descripcion'] : '';
$FechaEntrega = (isset($_POST['FechaEntrega'])) ? $_POST['FechaEntrega'] : '';
$FechaRecepcion = (isset($_POST['FechaRecepcion'])) ? $_POST['FechaRecepcion'] : '';

// ... (código para obtener IDs de equipo, área y personal)

switch ($opcion) {
    case 1: // Alta
        //var_dump($EquipoNo, $Fecha, $FechaRecepcion, $Area, $PersonalNo, $Descripcion);
        $EquipoID   = $manejadorPrestamos->spEquipoBuscarModelo($EquipoMo);
        $AreaID     = $manejadorPrestamos->spAreaBuscarIdn($Area);
        $PersonalID = $manejadorPrestamos->spPersonalBuscarNombre($PersonalNo);
        $data = $manejadorPrestamos->agregarPrestamo($EquipoID, $Fecha, $FechaRecepcion, $AreaID, $PersonalID, $Descripcion);
        break;
    case 2: // Modificación
        $EquipoID   = $manejadorPrestamos->spEquipoBuscarModelo($EquipoMo);
        $AreaID     = $manejadorPrestamos->spAreaBuscarIdn($Area);
        $PersonalID = $manejadorPrestamos->spPersonalBuscarNombre($PersonalNo);
        $data = $manejadorPrestamos->modificarPrestamo($id, $EquipoID, $FechaRecepcion, $AreaID, $PersonalID, $Descripcion);
        break;
    case 3: // Baja
        $data = $manejadorPrestamos->darDeBajaPrestamo($id, $Estatus);
        break;
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);