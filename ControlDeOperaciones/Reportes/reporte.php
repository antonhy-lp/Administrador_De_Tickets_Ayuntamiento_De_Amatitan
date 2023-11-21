<?php error_reporting(0);
   //Secion
   session_start();

   if(!isset($_SESSION["myUser"])|| isset($_GET["x"])){
   unset($_SESSION);
    echo '<script>
    alert ("Para acceder inicia sesion");
    </script>';
   session_destroy();
   header("Location: ../../index.php");?>
   <script>
     window.location="/index.php";
     </script>
  <?php die();
}?>
<?php             
/************************************************************
*  Formulario para generar reporte                          *
*                                                           *
* Web:    Proximamente!                                     *
* Fecha:  2022-09-01                                        *
* Autor:  Antonio Lopez                                     *
************************************************************/
include "../Conexion_/conexion.php";
require "plantilla.php";
$objeto = new Conexion();
$conexion = $objeto->Conectar();
global $conexion;
//Si es boton pdf
if (isset($_POST['export_pdf'])) {
    //Mostrar datos contenidos en el post
  // var_dump($_POST);
    //die();
    $FechaInicio = ($_POST['Inicio']);
    $FechaFinal = ( $_POST['Final']);
    //$sql = "SELECT a.id, a.nombre, a.edad, a.matricula, a.correo, g.grado FROM alumnos AS a INNER JOIN grados AS g ON a.id_grado=g.id WHERE g.id = $grado";
    //$sql = "SELECT ti.TicketId, so.SolicitudId, e.EquipoNo, ti.TicketDes, ti.TicketsFe, ti.Estatus from vsttickets ti, vstsolicitud so, vstequipo e where ti.EquipoNo = e.EquipoNo and so.SolicitudId = ti.SolicitudId and (ti.TicketsFe  BETWEEN '$FechaInicio' AND '$FechaFinal')";
    $sql = "CALL spTicketsFechaAFecha('$FechaInicio','$FechaFinal')";
    $resultado = $conexion->prepare($sql);
    $resultado->execute();
    //Formato del PDF
    $pdf = new PDF("P", "mm", "letter");
    $pdf->AliasNbPages();
    //Margen
    $pdf->SetMargins(10, 10, 10);
    //Nueva pagina
    $pdf->AddPage();
    //Fuente y Letra
    $pdf->SetFont("Arial", "B", 9);
    //Columnas - filas
    $pdf->Cell(8, 5, "ID", 1, 0, "C");
    $pdf->Cell(40, 5, "Descripcion de solicitud", 1, 0, "C");
    $pdf->Cell(20, 5, "Equipo", 1, 0, "C");
    $pdf->Cell(38, 5, "Descripcion Ticket", 1, 0, "C");
    $pdf->Cell(28, 5, "Solucion", 1, 0, "C");
    $pdf->Cell(28, 5, "Problema", 1, 0, "C");
    $pdf->Cell(30, 5, "Fecha", 1, 1, "C");
    //$pdf->Cell(20, 5, "Estatus TCK", 1, 1, "C");

    /*$pdf->Cell(10, 5, "Id TC", 1, 0, "C");
    $pdf->Cell(12, 5, "Id SCT", 1, 0, "C");
    $pdf->Cell(20, 5, "Id De EQ", 1, 0, "C");
    $pdf->Cell(98, 5, "Descripcion del Ticket", 1, 0, "C");
    $pdf->Cell(30, 5, "Fecha", 1, 0, "C");
    $pdf->Cell(20, 5, "Estatus TCK", 1, 1, "C");*/
     //Fuente
    $pdf->SetFont("Arial", "", 9);
     //Cargar datos por while hasta dar los resultados con los parametros de fecha a fecha
    while ($fila = $resultado->fetch()) {

      
        $pdf->Cell(8, 5, $fila['TicketId'], 1, 0, "C");
        //-  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  /
        $pdf->Cell(40, 5, $fila['SolicitudDes'], 1, 0, "C");
        $pdf->Cell(20, 5, $fila['EquipoMo'], 1, 0, "C");
       // $col1=$fila['TicketDes'];
      //$pdf->MultiCell(38, 5, $fila['TicketDes'],1, 0);
        $pdf->Cell(38, 5, $fila['TicketDes'], 1, 0, "C");
       // $pdf->Ln();
        $pdf->Cell(28, 5, $fila['TicketSol'], 1, 0, "C");
        $pdf->Cell(28, 5, $fila['TicketPro'], 1, 0, "C");
        $pdf->Cell(30, 5, $fila['TicketsFe'], 1, 1, "C");
        
        /*$width = 100;
$lineHeight = 40;
$fill = false;
$pdf->MultiCell($width, $lineHeight, $fill);*/
       /* //si es 1 es activo
        if ($fila['Estatus']==1){
            $pdf->Cell(20, 5, $fila['Estatus']='Activo', 1, 1, "C");
            //Si no entonces es igual a
        }elseif($fila['Estatus']==0){
            $pdf->Cell(20, 5, $fila['Estatus']='Inactivo', 1, 1, "C");
        }*/
    }//Exportar y motrar resultado
    //$pdf->Output('Reporte_del_'.$FechaInicio.'_a_'.$FechaFinal.'.pdf','I');
    
    $pdf->Output('Reporte_del_'.$FechaInicio.'_a_'.$FechaFinal.'.pdf','D');
 //Si es boton excel
}elseif(isset($_POST['export_data'])) {
 include('../../vendor/phpoffice/phpexcel/Classes/PHPExcel.php');
   include "PHPExcel.php";
   include('../../vendor/phpoffice/phpexcel/Classes/PHPExcel/Writer/Excel2007.php');
  // include ('../../vendor/composer/autoload_real.php');
 // include('../../vendor/phpoffice/phpexcel/Classes/PHPExcel/Autoloader.php');
 
    $FechaInicio = ($_POST['Inicio']);
    $FechaFinal = ( $_POST['Final']);
    
    //$sql = "SELECT a.id, a.nombre, a.edad, a.matricula, a.correo, g.grado FROM alumnos AS a INNER JOIN grados AS g ON a.id_grado=g.id WHERE g.id = $grado";
    //$sql = "SELECT ti.TicketId, so.SolicitudId, e.EquipoNo, ti.TicketDes, ti.TicketsFe, ti.Estatus from vsttickets ti, vstsolicitud so, vstequipo e where ti.EquipoNo = e.EquipoNo and so.SolicitudId = ti.SolicitudId and (ti.TicketsFe  BETWEEN '$FechaInicio' AND '$FechaFinal')";
    $sql = "CALL spTicketsFechaAFecha('$FechaInicio','$FechaFinal')";
    $result = $conexion->prepare($sql);
    $result->execute();
/* Lo siguiente que hacemos es declararnos un array vacío al que hemos llamado “libros” y donde meteremos
todos los registros que hemos recuperado de la base de datos. Esto lo hacemos mediante un bucle “while”
y la llamada a la función de PHP “mysqli_fetch_assoc()” en cada iteración. A cada paso, esa función nos
devolverá un registro que guardaremos en el array “libros” para su procesamiento posterior.*/
if ($result->fetchColumn() > 0)
    {   
      //obtenr tiempo
        date_default_timezone_set('America/Mexico_City');
        $date = new DateTime();
        $date = $date->getTimestamp();
       //NUevo archivo de excel
        $excel = new Excel("Control_De_Tickets_De_{$FechaInicio}_hasta_{$FechaFinal}");
        $excel->sheet("Reporte_$date", function (PHPExcel_Worksheet $sheet) use ($result)
        {
            //Tomar numero total de filas y sumarle dos para establecer estilo a las celdas que se encuentran
            $numero = $result->rowCount()+2;
            
           // $numero.
            //Establecer variable que reciban el post con los parametros de la fecha inicio y de finD
            $inc = $_POST['Inicio'];
            $fn = $_POST['Final'];
            //Cabeceras
            $sheet->setCellValue('A1','Reporte De Tickets Del '.$inc.' Al '.$fn.'');
            $sheet->setCellValue('A2', 'IDº Ticket');
            $sheet->setCellValue('B2', 'Descripcion de solicitud');
            $sheet->setCellValue('C2', 'Modelo del equipo');
            $sheet->setCellValue('D2', 'Descripcion Del Ticket');
            $sheet->setCellValue('E2', 'Solucion');
            $sheet->setCellValue('F2', 'Problema');
            $sheet->setCellValue('G2', 'Fecha De Generacion');
            //Establecer marguen automatico
            $sheet->getColumnDimension('A')->setAutoSize(true);
            $sheet->getColumnDimension('B')->setAutoSize(true);
            $sheet->getColumnDimension('C')->setAutoSize(true);
            $sheet->getColumnDimension('D')->setAutoSize(true);
            $sheet->getColumnDimension('E')->setAutoSize(true);
            $sheet->getColumnDimension('F')->setAutoSize(true);
            $sheet->getColumnDimension('G')->setAutoSize(true);
            //Estilos
            $h1 = array(
                'font' => array(
                  'bold' => true, 
                  'size' => 11, 
                  'name' => 'Tahoma'
                ), 
                'borders' => array(
                  'allborders' => array(
                    'style' => 'thin'
                  )
                ), 
                'alignment' => array(
                  'vertical' => 'center', 
                  'horizontal' => 'center'
                )
              ); 
              //Obtener estilo y aplicarlo del array de columna A a F en linea 1
            $sheet->getStyle('A1:G1')->applyFromArray($h1);
            //Obtener estilo y aplicarlo del array de columna A a F en linea 2
            $sheet->getStyle('A2:G'.$numero.'')->applyFromArray($h1);
            //Combinar Celda 1 De A a F
            $sheet->mergeCells('A1:G1');
          
            //pintar estilo a partir de la celda 3 / 4 por num_rows + 2
            $row = 3; /* $_data=$result->fetchAll(PDO::FETCH_ASSOC);*/

         

            error_reporting( 0);
 $FechaInicio = ($_POST['Inicio']);
    $FechaFinal = ( $_POST['Final']);
    $objeto = new Conexion();
$conexion = $objeto->Conectar();
            $sqll = "CALL spTicketsFechaAFecha('$FechaInicio','$FechaFinal')";
    $resultt = $conexion->prepare($sqll);
    $resultt->execute();
    $dtt=$resultt->fetchAll(PDO::FETCH_ASSOC);
    //Siguiente proceso PDO
    $resultt->nextRowset();
            //Obtener la lista de resultado de consulta igual a avance, conteniendo los datos de cada horizontal
           foreach($dtt as $avance)
              {
                $num= $avance['TicketId'];
               // $num2= $avance['TicketId'];
                //String $n = String.valueOf($num);ss
                //A string
                $miCadena = (string)$num;
                //$miCadena2 = (string)$num2;
                //echo $miCadena;
                $sheet->setCellValueByColumnAndRow(0, $row, $miCadena);
                $sheet->setCellValueByColumnAndRow(1, $row, $avance['SolicitudDes']);
                $sheet->setCellValueByColumnAndRow(2, $row, $avance['EquipoMo']);
                $sheet->setCellValueByColumnAndRow(3, $row, $avance['TicketDes']);
                $sheet->setCellValueByColumnAndRow(4, $row, $avance['TicketSol']);
                $sheet->setCellValueByColumnAndRow(5, $row, $avance['TicketPro']);
                $sheet->setCellValueByColumnAndRow(6, $row, $avance['TicketsFe']);
                $row++;
              }
            });
        //aquí defines la extensión de descarga
        //Soporta xls y xlsx     
        //$excel->show();     
        $excel->download('xls');
    }
}
?>

 </tbody>
 </table>
</div>
