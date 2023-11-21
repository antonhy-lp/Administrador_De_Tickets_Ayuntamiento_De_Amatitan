<?php 
//Secion
session_start();
if(!isset($_SESSION["myUser"])|| isset($_GET["x"])){
unset($_SESSION);
 echo '<script>
 alert ("Para acceder inicia sesion");
 </script>';?>
  <script language="javascript">
       window.location="/index.php";
     </script>
 <?php
session_destroy();
die();
} require_once "../Recursos_/Vistas/NabVar.php";?>
 <?php error_reporting( );?>
 <!-- error_reporting(E_ERROR | E_PARSE); -->
<!--INICIO del cont principal-->
<div class="container">
    <h2>Control de solicitudes</h2>
 <?php
include_once '../Conexion_/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();


$consulta = "Call spSolicitudMostrar();";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);
$resultado->nextRowset();

?>


<div class="container" id="Contenido">
        <div class="row">
            <div class="col-lg-12">            
            <button id="btnNuevo" type="button" class="btn btn-success" data-toggle="modal" title='Ingresar nueva solicitud' name="Nuevo">Nueva solicitud</button>    
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
                                <th>Id</th>
                                <th>Personal</th>
				                <th>Descripcion</th>
				                <th>Prioridad</th>
                                <th>Fecha</th>
				                <th>Estatus</th>
				                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php                            
                            foreach($data as $dat) {                                                        
                            ?>
                            <tr>
                            <td data-label="Id"><?php echo $dat['SolicitudId'] ?></td>
                                <td data-label="Personal"><?php $IdSoli = $dat['PersonalId'];
                                //Seleccionar area
                                 $consult = "Call spPersonalBuscarId('$IdSoli');";
                                 $result = $conexion->prepare($consult);
                                 $result->execute();
                                 $dt=$result->fetchAll(PDO::FETCH_ASSOC);
                                 //Siguiente proceso PDO
                                 $result->nextRowset();
                                 //Para la segunda utilizar [Pocicion]['Array key']; 
                                 //donde pocicion es la unicacion en la cadena y el array su ubicacion.
                                 echo $dt[0]['PersonalNo']; /*var_dump($dt);*/?></td>
                                <td data-label="Descripcion"><?php echo $dat['SolicitudDes'] ?></td>
                                <td data-label="Prioridad"><?php echo $dat['SolicitudPri'] ?></td> 
                                <td data-label="Fecha"><?php echo $dat['SolicitudFe'] ?></td>  
                                <td data-label="Estado" id="textEstado"><?php echo $dat['Estatus']; ?></td>
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
      
<!--Modal-->
<div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
        <form id="formPersonas">    
             <div class="modal-body"> <!--Solicitud -->
                <div class="form-group">
                <label id="SoliDes" for="nombre" class="col-form-label">Descripcion:</label>
                <input maxlength="23" title='Ingresa una desripcion (Maximo 23 caracteres)' type="text" class="form-control" id="SolicitudDes">
                </div>                
                <div class="form-group">
                <!--Datos para agregar no editables-->
                <input type="text" id="SolicitudId" hidden>
                <input type="text" id="Estatus" hidden>
                </div> 
                <div class="form-group">
                 <label id="Labelasig" for="empleadoAsig" class="col-form-label">Empleado a cargo:</label>
                 <?php // Consultar la base de datos
                  $consul = "Call spPersonalMostrar();";
                  $resul = $conexion->prepare($consul);
                  $resul->execute();
                  //lista de opciones
                  echo "<select title='Selecciona un empleado' name='empleadoAsig' id='empleadoAsig' class='form-control input-sm' required>";
				  echo "<option value='No asignado'>Asigna un empleado</option>";
                  while($dto=$resul->fetch()){
                  echo "<option id='".$dto['PersonalId']."' name='".$dto['PersonalId']."' class=col-form-label  value='".$dto['PersonalNo']."'>".$dto['PersonalNo']."</option>";
						}/*impimir*/ echo "</select>"; /* Cerrar Consulta*/ $resul->nextRowset(); ?>
                </div>   
                <div class="form-group">
                 <label id="PrioriEs" for="prioridadEs" class="col-form-label">Jerarquia a la que pertenecera:</label>
                 <select title="Selecciona una jerarquia" class='form-control input-sm' name="prioridadEs" id="prioridadEs" required>
	             <option value="No asignado">Seleccionar la jerarquia</option>
	             <!-- <option value="Alta">Apertura de gmail</option>
	             <option value="Media">Mantenimiento correctivo</option>
	             <option value="Baja">Mantenimiento preventivo</option>
	             <option value="Alta">Instalacion fallo y mantenimiento de la red</option>
	             <option value="Alta">Mantenimiento o instalacion de impresora</option>
	             <option value="Alta">Cambio de consumible de impresora</option>
	             <option value="Alta">Cambio e instalacion de perifericos y equipo de computo</option>
	             <option value="Alta">Instalacion de software</option> -->
	             <option value="Presidente">Presidente</option>
	             <option value="Regidores">Regidores</option>
	             <option value="Oficial mayor">Oficial mayor</option>
	             <option value="Direcciones">Direcciones</option>
	             <option value="Usuarios">Usuarios</option>
                </select>
                <!-- Ticket -->
                <div class="form-group">
                <label id="TickDes" for="TicketDescripcion" class="col-form-label">Descripcion:</label>
                <input maxlength="23" title='Ingresa una desripcion (Maximo 23 caracteres)' type="text" class="form-control" id="TicketDescripcion">
                </div>    
                <div class="form-group">
                <label id="TickPr" for="TicketProblema" class="col-form-label">Problema:</label>
                <input title='Ingresa el problema del equipo' type="text" class="form-control" id="TicketProblema">
                </div> 
                <div class="form-group">
                <label id="TickSl" for="TicketSolucion" class="col-form-label">Solucion:</label>
                <input title='Ingresa el solucion para reparacion del equipo' type="text" class="form-control" id="TicketSolucion">
                </div> 
                <div class="form-group">
                 <label id="LabelEq" for="Equipo" class="col-form-label">Selecciona un equipo:</label>
                 <?php // Consultar la base de datos
                  $consul = "Call spEquipoMostrar();";
                  $resul = $conexion->prepare($consul);
                  $resul->execute();
                  //lista de opciones
                  echo "<select title='Selecciona un Equipo' name='Equipo' id='Equipo' class='form-control input-sm' required>";
				  echo "<option value='No asignado'>_ _ _ _</option>";
                  while($data=$resul->fetch()){
                  echo "<option id='".$data['EquipoNo']."' name='".$data['EquipoNo']."' class=col-form-label  value='".$data['EquipoNo']."'>".$data['EquipoMo']."</option>";
						}/*impimir*/ echo "</select>"; /* Cerrar Consulta*/ $resul->nextRowset(); ?>
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

<!--Modal para Ticket-->


      <!-- Fin modal -->





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
       
    
    
<!--FIN del cont principal-->
<?php require_once "./vistas/parte_inferior.php"?>



<script>


	//  -  -  -  -  -  -  -  -  //
	//     Example Menu de seleccion     //
	//  -  -  -  -  -  -  -  -  //


	// Initialize a context menu for the entire page
	var contextMenu = CtxMenu();

	// Add our custom function to the menu
	contextMenu.addItem("Nueva solicitud", 
          function(){
            console.log('Nueva solicitud');
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

