<?php var_dump($_POST); ?>
<?php
include_once '../../Conexion_/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();




// Recepción de los datos enviados mediante POST desde el JS 
//Personal  
$IdPersonal = (isset($_POST['IdPersonal'])) ? $_POST['IdPersonal'] : '';
//Solicitud
$PersonalNo = (isset($_POST['IdSolicitud'])) ? $_POST['IdSolicitud'] : '';


$opcion = (isset($_POST['Opcion'])) ? $_POST['Opcion'] : '';
die();
switch($opcion){
    case 1: //alta
        $consulta="CALL spPersonalAgregar('$Ar', '$PersonalNo', '$PersonalPu')";
        //$consulta = "INSERT INTO insumos (nombre,modelo,descripcion,FechaRegistro,destino) VALUES('$nombre', '$modelo', '$descripcion','$Fecha','$destino')";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        //echo "Alta";

        $consulta = "CALL spPersonalMostrarLim";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
        $consulta = "CALL spPersonalModificar('$id','$Ar','$PersonalNo','$PersonalPu')";
        //$consulta = "UPDATE insumos SET nombre='$nombre', modelo='$modelo', descripcion='$descripcion', destino='$destino' WHERE idInsumo='$id'";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();  
        
        //echo "Modificacion";
        
        $consulta = "CALL spPersonalArea('$id')";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;        
    case 3://baja
        $consulta = "CALL spPersonalAltaBaja('$id')";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                           
        $data=$resultado->fetch(PDO::FETCH_ASSOC);  
        
        $consulta = "CALL spPersonalArea('$id')";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break; 
        //echo "Baja";
    case 4; // Personal notificacion funcionando
    
        $consulta = "CALL spPersonalNotificacion('$IdPersonal')";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                           
        $data=$resultado->fetch(PDO::FETCH_ASSOC);  
        
        $consulta = "CALL spPersonalArea('$IdPersonal')";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break; 
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;