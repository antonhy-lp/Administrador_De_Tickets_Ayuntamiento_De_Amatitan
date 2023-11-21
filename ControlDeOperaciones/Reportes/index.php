<?php 
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
require "../Recursos_/Vistas/NabVar.php";?>
<!--/************************************************************
*  Formulario para generar reporte                          *
*                                                           *
* Web:    Proximamente!                                     *
* Fecha:  2022-09-01                                        *
* Autor:  Antonio Lopez                                     *
************************************************************/-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar reporte</title>
</head>
<body>
<?php date_default_timezone_set('America/Mexico_City'); /*Fecha*/ $Fecha = date('Y-m-d'); ?>
<div class="full-width divider-menu-h"></div>
<div class="mdl-grid">
			<div class="mdl-cell mdl-cell--12-col">
				<div class="full-width panel mdl-shadow--2dp">
					<div class="full-width panel-tittle bg-primary text-center tittles">
						Reportes
					</div>
					<div class=" panel-content" >
    <h2>Reporte de tickets</h2>
  <!-- Seleccionador normal -->
    <form action="reporte.php" method="POST" autocomplete="off">
    <div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
	<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
        Selecciona fecha inicial:
       <input class="mdl-textfield__input" type="date" name="Inicio" id="Inicio" required>
        Selecciona fecha final:
       <input class="mdl-textfield__input" type="date" name="Final" id="Final" value="<?php echo date("Y-m-d");?>" required>
    </div>
    </div>
        <button  id="export_pdf" name="export_pdf" class="btn btn-primary btn-sm pdf" type="submit">Generar PDF</button>
        <script>  $(document).on("click", ".pdf", function(e){ 
        
        /*alertify.success('Se creo el reporte de');*/
        swal({
                      title: "Reporte generado!",
                      text: "El reporte a sido guardado en descargas",
                      //timer: 3000,
                      showConfirmButton: true
                    }); }); </script>
        <button  id="export_data" name="export_data" class="btn btn-primary btn-sm excel" type="submit">Generar excel</button>
        <script>  $(document).on("click", ".excel", function(e){ 
        
        /*alertify.success('Se creo el reporte de');*/
        swal({
                      title: "Reporte generado!",
                      text: "El reporte a sido guardado en descargas",
                      //timer: 3000,
                      showConfirmButton: true
                    }); }); </script>
    </form>

    <!-- Menu selectivo -->
<script rel="stylesheet" src="../Recursos_/ctxmenu/ctxmenu.js"></script>
<link rel="stylesheet" src="../Recursos_/ctxmenu/ctxmenu.css">


<script>


	//  -  -  -  -  -  -  -  -  //
	//     Example Menu de seleccion     //
	//  -  -  -  -  -  -  -  -  //


	// Initialize a context menu for the entire page
	var contextMenu = CtxMenu();

	// Add our custom function to the menu
	/*contextMenu.addItem("Nuevo ticket", 
          function(){
            console.log('Nuevo ticket');
            document.querySelector('button[name=Nuevo]').click();
          },Icon = "../Recursos_/ctxmenu/boton-agregar.png",
		index = undefined,
		bInvertIconDarkMode = true
	);*/


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
    var contextMenuTree = CtxMenu("#btnNuevo");
	contextMenuTree+contextMenuTwo.addItem("Cambiar color", ChangeElementColor);
</script>

</body>
</html>