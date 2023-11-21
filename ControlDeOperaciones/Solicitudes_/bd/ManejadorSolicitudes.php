<?php

include_once '../../Conexion_/conexion.php';

class ManejadorSolicitudes {
    private $conexion;

    public function __construct() {
        $objeto = new Conexion();
        $this->conexion = $objeto->Conectar();
    }

    public function agregarSolicitud($empleadoId, $solicitudDes, $prioridadEs, $fecha) {
        $consulta = "CALL spSolicitudAgregar('$empleadoId', '$solicitudDes', '$prioridadEs', '$fecha')";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        return $this->mostrarSolicitudes();
    }

    public function modificarSolicitud($id, $empleadoId, $solicitudDes, $prioridadEs, $fecha) {
        $consulta = "CALL spSolicitudModificar('$id', '$empleadoId', '$solicitudDes', '$prioridadEs', '$fecha')";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        return $this->buscarSolicitudPorId($id);
    }

    public function darDeBajaSolicitud($id, $es) {
        $consulta = "CALL spSolicitudAltaBaja('$id', '$es')";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        return $this->buscarSolicitudPorId($id);
    }

    public function agregarTicket($id, $equipo, $ticketDescripcion, $ticketProblema, $ticketSolucion, $fecha) {
        $consulta = "CALL spTicketsAgregarSoli('$id', '$equipo', '$ticketDescripcion', '$ticketProblema', '$ticketSolucion', '$fecha')";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        return $this->buscarSolicitudPorId($id);
    }

    public function mostrarSolicitudes() {
        $consulta = "CALL spSolicitudMostrarLimit";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarSolicitudPorId($id) {
        $consulta = "CALL spSolicitudBuscarId('$id')";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarEmpleadoPorNombre($nombre) {
        $consulta = "CALL spPersonalBuscarNombre('$nombre')";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        $dt = $resultado->fetch();
        $resultado->nextRowset();
        return $dt['PersonalId'];
    }
}

$manejadorSolicitudes = new ManejadorSolicitudes();

$prioridadEs = (isset($_POST['prioridadEs'])) ? $_POST['prioridadEs'] : '';
$Es = (isset($_POST['Es'])) ? $_POST['Es'] : '';
$SolicitudDes = (isset($_POST['SolicitudDes'])) ? $_POST['SolicitudDes'] : '';
$empleadoAsig = (isset($_POST['empleadoAsig'])) ? $_POST['empleadoAsig'] : '';
$Estatus = (isset($_POST['Estatus'])) ? $_POST['Estatus'] : '';
$Fecha = date('Y-m-d h:i:s');

$TicketDescripcion = (isset($_POST['TicketDescripcion'])) ? $_POST['TicketDescripcion'] : '';
$Equipo = (isset($_POST['Equipo'])) ? $_POST['Equipo'] : '';
$TicketProblema = (isset($_POST['TicketProblema'])) ? $_POST['TicketProblema'] : '';
$TicketSolucion = (isset($_POST['TicketSolucion'])) ? $_POST['TicketSolucion'] : '';

$empleadoId = $manejadorSolicitudes->buscarEmpleadoPorNombre($empleadoAsig);

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id = (isset($_POST['SolicitudId'])) ? $_POST['SolicitudId'] : '';

switch($opcion) {
    case 1: // Alta
        $data = $manejadorSolicitudes->agregarSolicitud($empleadoId, $SolicitudDes, $prioridadEs, $Fecha);
        break;
    case 2: // Modificación
        $data = $manejadorSolicitudes->modificarSolicitud($id, $empleadoId, $SolicitudDes, $prioridadEs, $Fecha);
        break;
    case 3: // Baja
        $data = $manejadorSolicitudes->darDeBajaSolicitud($id, $Es);
        break;
    case 4: // Ticket
        $data = $manejadorSolicitudes->agregarTicket($id, $Equipo, $TicketDescripcion, $TicketProblema, $TicketSolucion, $Fecha);
        break;
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);

$conexion = NULL;
