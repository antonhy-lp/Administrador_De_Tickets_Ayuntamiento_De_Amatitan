<?php 
session_start();

// Verificar si el usuario no ha iniciado sesión
if (!isset($_SESSION["myUser"]) || isset($_GET["x"])) {
    // Eliminar todas las variables de sesión
    session_unset();
    echo '<script> alert ("Para acceder inicia sesion"); </script>';?>
    <script language="javascript"> window.location="/index.php"; </script>
    <?php
    session_destroy();

    // Redirigir a la página de inicio con un mensaje de alerta
    header("Location: /index.php?login=false");
    exit(); // Terminar el script después de redirigir
}
 require_once "../Recursos_/Vistas/NabVar.php";?>
 <?php error_reporting( E_ERROR  );?>
 <!-- error_reporting(E_ERROR | E_PARSE); -->
<!--INICIO del cont principal-->
<div class="container">
    <h2>Prestamos de insumos</h2>
 <?php
include_once '../Conexion_/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();


$consulta = "Call spPrestamosMostrar();";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);
$resultado->nextRowset();
?>


<div class="container" id="Contenido">
        <div class="row">
            <div class="col-lg-12">            
            <button id="btnNuevo" type="button" class="btn btn-success" data-toggle="modal" title='Ingresar nuevo prestamo' name="Nuevo">Nuevo prestamo</button>  
            </div>    
        </div>    
    </div>    
    <br>  
<div class="container">
        <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">        
                        <table id="tablaPersonas" class="table table-striped table-bordered table-condensed" style="width:100%">
                        <thead class="text-center">
                            <tr>
                                <th>Id prestamo</th>
                                <th>Equipo entregado</th>
				                <th>Fecha de entregado</th>
                                <th>Fecha de limite</th>
				                <th>Area</th>
                                <th>Personal responsable</th>
                                <th>Observaiones</th>			                
                                <th>Estado</th>
				                <th>Acciones</th>
                            </tr>
                            </thead>
                        <!-- INFINITUM2BC1:   6r7N3XKqqR -->
                        <tbody>
                            <?php                            
                            foreach($data as $dat) {                                                        
                            ?>
                            <tr>
                            <td data-label="Id prestamo"><?php echo $dat['idPrestamo'] ?></td>
                                <td data-label="Equipo entregado"><?php echo $dat['EquipoMo'] ?></td>
                                <td data-label="Fecha de entregado"><?php echo $dat['FechaEntrega'] ?></td>
                                <td data-label="Fecha de limite"><?php echo $dat['FechaRecepcion'] ?></td>   
                                <td data-label="Area"><?php echo $dat['Area'] ?></td> 
                                <td data-label="Personal responsable"><?php echo $dat['PersonalNo'] ?></td>
                                <td data-label="Observaiones"><?php echo $dat['Descripcion'] ?></td>  
                                <td data-label="Estado" id="textEstado"><?php /*if( $dat['estatus']==1){
                                   $E ="Activo";
                                }else if($dat['Estatus']==0){
                                    $E ="Inactivo";
                                } echo $E;*/ echo $dat['estatus']; ?></td>  
                                <td></td>
                            </tr>
                            <?php
                                }
                            ?>                                
                        </tbody>        
                       </table>                    
                    </div>
                </div>
        </div>  
    </div>    
      
<!--Modal para CRUD-->
<div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
        <form id="formPersonas">    
            <div class="modal-body">
                <div class="form-group">
                <div class="form-group">
                 <label  for="Equipo" class="col-form-label">Selecciona un equipo:</label>
                 <?php // Consultar la base de datos
                  $consul = "Call spEquipoMostrar();";
                  $resul = $conexion->prepare($consul);
                  $resul->execute();
                  //lista de opciones
                  echo "<select title='Selecciona un Equipo' name='Equipo' id='EquipoMo' class='form-control input-sm' required>";
				  echo "<option value='No asignado'>_ _ _ _</option>";
                  while($data=$resul->fetch()){
                  echo "<option id='".$data['EquipoMo']."' name='".$data['EquipoNo']."' class=col-form-label  value='".$data['EquipoMo']."'>".$data['EquipoMo']."</option>";
						}/*impimir*/ echo "</select>"; /* Cerrar Consulta*/ $resul->nextRowset(); ?>
                </div>
                <label for="nombre" class="col-form-label">Fecha limite de entrega:</label>
                <input type="date" class="form-control" id="FechaRecepcion" required>
                </div>
                <div class="form-group">
                 <label  for="PersonalNo" class="col-form-label">Empleado a cargo:</label>
                 <?php // Consultar la base de datos
                  $consul = "Call spPersonalMostrar();";
                  $resul = $conexion->prepare($consul);
                  $resul->execute();
                  //lista de opciones
                  echo "<select title='Selecciona un empleado' name='empleadoAsig' id='PersonalNo' class='form-control input-sm' required>";
				  echo "<option value='No asignado'>Asigna un empleado</option>";
                  while($dto=$resul->fetch()){
                  echo "<option id='".$dto['PersonalNo']."' name='".$dto['PersonalId']."' class=col-form-label  value='".$dto['PersonalNo']."'>".$dto['PersonalNo']."</option>";
						}/*impimir*/ echo "</select>"; /* Cerrar Consulta*/ $resul->nextRowset(); ?>
                </div>              
                <div class="form-group">
                <!--Datos para agregar no editables-->
                <input type="text" id="EquipoNo" hidden>
                <!-- <input type="text" id="FechaSalidas" hidden>
                <input type="text" id="FechaRegistro" hidden> -->
                <input type="text" id="Estatus" hidden>
                <input type="text" id="idPrestamo" hidden>
                <div class="form-group">
                 <label for="Area" class="col-form-label">Area a la que pertenecera:</label>
                 <?php // Consultar la base de datos
                  $consul = "Call spAreaMostrarActivos();";
                  $resul = $conexion->prepare($consul);
                  $resul->execute();
                  //lista de opciones
                  echo "<select title='Selecciona una nueva area a asignar' name='Area' id='Area' class='form-control input-sm' required>";
				  echo "<option value=''>Asigna una area</option>";
                  while($dto=$resul->fetch()){
                  echo "<option id='".$dto['Area']."' name='".$dto['Area']."' class=col-form-label  value='".$dto['Area']."'>".$dto['Area']."</option>";
						}/*impimir*/ echo "</select>"; /* Cerrar Consulta*/?>
                </div>  
                <label for="descripcion" class="col-form-label">Observaciones:</label>
                <input  class="form-control" id="Descripcion" required>
                </div>            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal" onclick="cerrar();">Cancelar</button>
                <button type="submit" id="btnGuardar" class="btn btn-dark">Guardar</button>
            </div>
        </form>    
        </div>
    </div>
</div>  
      
 <!-- <script src="/vendor/jquery/jquery.min.js"></script> -->   
 <script type="text/javascript" src="main.js"></script>
 
	<!-- Tablas dinamicas y menu programable -->
	<!-- Bootstrap core JavaScript-->
	<script src="../Recursos_/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../Recursos_/js/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="../Recursos_/js/sb-admin-2.min.js"></script>

<!-- Menu selectivo -->
<script rel="stylesheet" src="../Recursos_/ctxmenu/ctxmenu.js"></script>
<link rel="stylesheet" src="../Recursos_/ctxmenu/ctxmenu.css">

  <!-- datatables JS -->
  <script type="text/javascript" src="../Recursos_/js/datatables.min.js"></script>    
    
    <!-- Fin de nesesarios para las tablas -->
</div>

 <!-- Cerrar modal -->
    <script type="text/javascript">
             function cerrar(){
             $('#modalCRUD').modal("hide");}
    </script>
       
    
   
  <!-- datatables para botones bonitos-->
  <script src="/ControlDeOperaciones/Recursos_/js/jquery.dataTables.min.js"></script>
    
<!--FIN del cont principal-->
<?php require_once "./vistas/parte_inferior.php"?>



<script>


	//  -  -  -  -  -  -  -  -  //
	//     Example Menu de seleccion     //
	//  -  -  -  -  -  -  -  -  //


	// Initialize a context menu for the entire page
	var contextMenu = CtxMenu();

	// Add our custom function to the menu
	contextMenu.addItem("Nuevo prestamo", 
          function(){
            console.log('Nuevo equipo');
            document.querySelector('button[name=Nuevo]').click();
          },Icon = "../Recursos_/ctxmenu/boton-agregar.png",
		index = undefined,
		bInvertIconDarkMode = true
	);

    contextMenu.addItem("Siguiente pagina", 
          function(){
            console.log('Siguiente pagina');
            var parrafo = document.getElementById("paginate_button next");
            document.querySelector('.next').click();
          },Icon = "../Recursos_/ctxmenu/siguiente-boton.png",
		index = undefined,
		bInvertIconDarkMode = true
	);

    contextMenu.addItem("Anterior pagina", 
          function(){
            console.log('Anterior pagina');
            var parrafo = document.getElementById("paginate_button next");
            document.querySelector('.previous').click();
          },Icon = "../Recursos_/ctxmenu/anterior.png",
		index = undefined,
		bInvertIconDarkMode = true
	);
    

	// Add a separator
	contextMenu.addSeparator();

	// Add a second item to the menu, this time with an icon
	contextMenu.addItem("Actualizar",
		function(){
			location.reload();
		},
		Icon = "../Recursos_/ctxmenu/icon.png",
		index = undefined,
		bInvertIconDarkMode = true
	);
	// Add our custom function to the menu
	/*contextMenu.addItem("Pantalla completa", 
          function(){
            console.log('Modo pantalla');
            //document.querySelector('button[name=Nuevo]').click();
            cambiopantalla();
          },Icon = "../Recursos_/ctxmenu/fullscreen.png",
		index = undefined,
		//bInvertIconDarkMode = true
	);*/


	//  -  -  -  -  -  -  -  -  //
	//      Example Menu Two    //
	//  -  -  -  -  -  -  -  -  //


	// Example function to change the background color of an element
	// Note that the first argument in a function called from the ctx menu will be the element that was clicked on.
	function ChangeElementColor(element){
		var color = [
			Math.random() * 255,
			Math.random() * 255,
			Math.random() * 255
		];
		element.style.background = "rgb(" + color + ")"
	}

	// Initialize a special custom menu for the "CustomContextMenu" div
	var contextMenuTwo = CtxMenu("#Contenido");
	contextMenuTwo.addItem("Cambiar color", ChangeElementColor);

</script>
