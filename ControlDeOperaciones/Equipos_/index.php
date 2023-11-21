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
    <h2>Administrar equipos</h2>
 <?php
include_once '../Conexion_/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();


$consulta = "Call spEquipoMostrar();";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);
?>


<div class="container" id="Contenido">
        <div class="row">
            <div class="col-lg-12">            
            <button id="btnNuevo" type="button" class="btn btn-success" data-toggle="modal" title='Ingresar nuevo equipo' name="Nuevo">Nuevo equipo</button>  
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
                                <th>Id equipo</th>
                                <th>Modelo</th>
				                <th>Marca</th>
				                <th>Descripcion</th> 				                
                                <th>Estado</th>
				                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php                            
                            foreach($data as $dat) {                                                        
                            ?>
                            <tr>
                            <td data-label="Id equipo"><?php echo $dat['EquipoNo'] ?></td>
                                <td data-label="Modelo"><?php echo $dat['EquipoMo'] ?></td>
                                <td data-label="Marca"><?php echo $dat['EquipoMa'] ?></td>   
                                <td data-label="Descripcion"><?php echo $dat['EquipoDes'] ?></td>   
                                <td data-label="Estado" id="textEstado"><?php if( $dat['Estatus']==1){
                                   $E ="Activo";
                                }else if($dat['Estatus']==0){
                                    $E ="Inactivo";
                                } echo $E; ?></td>  
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
                <label for="nombre" class="col-form-label">Modelo:</label>
                <input type="text" class="form-control" id="EquipoMo" required>
                
                </div>
                <div class="form-group">
                <label for="modelo" class="col-form-label">Marca:</label>
                <input type="text" class="form-control" id="EquipoMa" required>
                </div>                
                <div class="form-group">
                <!--Datos para agregar no editables-->
                <input type="text" id="EquipoNo" hidden>
                <!-- <input type="text" id="FechaSalidas" hidden>
                <input type="text" id="FechaRegistro" hidden> -->
                <input type="text" id="Estatus" hidden>
                <label for="descripcion" class="col-form-label">Descripcion:</label>
                <input  class="form-control" id="EquipoDes" required>
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
	contextMenu.addItem("Nuevo equipo", 
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
