<?php

include_once '../../Conexion_/conexion.php';

class ManejadorPersonal {
    private $conexion;

    public function __construct() {
        $objeto = new Conexion();
        $this->conexion = $objeto->Conectar();
    }

    public function agregarPersonal($areaId, $personalNo, $personalPu) {
        $consulta = "CALL spPersonalAgregar('$areaId', '$personalNo', '$personalPu')";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        return $this->mostrarPersonal();
    }

    public function modificarPersonal($id, $areaId, $personalNo, $personalPu) {
        $consulta = "CALL spPersonalModificar('$id','$areaId','$personalNo','$personalPu')";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        return $this->buscarPersonalPorId($id);
    }

    public function darDeBajaPersonal($id) {
        $consulta = "CALL spPersonalAltaBaja('$id')";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        return $this->buscarPersonalPorId($id);
    }

    public function mostrarPersonal() {
        $consulta = "CALL spPersonalMostrarLim";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPersonalPorId($id) {
        $consulta = "CALL spPersonalArea('$id')";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function spAreaBuscarNombre($AreaID) {
        $consulta = "CALL spAreaBuscarNombre('$AreaID')";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        $dt = $resultado->fetch();
        return $dt['AreaID'];
    }
}

$manejadorPersonal = new ManejadorPersonal();


$id     = (isset($_POST['PersonalId'])) ? $_POST['PersonalId'] : '';
$Area   = (isset($_POST['AreaID'])) ? $_POST['AreaID'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$PersonalPu = (isset($_POST['PersonalPu'])) ? $_POST['PersonalPu'] : '';
$PersonalNo = (isset($_POST['PersonalNo'])) ? $_POST['PersonalNo'] : '';

$Ar = $manejadorPersonal->spAreaBuscarNombre($Area);

switch($opcion){
    case 1: // Alta
        $data = $manejadorPersonal->agregarPersonal($Ar, $PersonalNo, $PersonalPu);
        break;
    case 2: // Modificación
        $data = $manejadorPersonal->modificarPersonal($id, $Ar, $PersonalNo, $PersonalPu);
        break;
    case 3: // Baja
        $data = $manejadorPersonal->darDeBajaPersonal($id);
        break;
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);
