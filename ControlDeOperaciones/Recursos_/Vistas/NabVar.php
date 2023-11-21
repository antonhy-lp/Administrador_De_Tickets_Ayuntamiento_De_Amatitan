<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php include "footer.php";
	
	include_once '../Conexion_/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();


$consulta = "Call spSolicitudMostrarNotificacion();";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);
$resultado->nextRowset();

$consultar = "Call spPersonalMostrarNotificaciones();";
$result = $conexion->prepare($consultar);
$result->execute();
$dt=$result->fetchAll(PDO::FETCH_ASSOC);
$result->nextRowset();

error_reporting(E_ERROR | E_PARSE);?>

	<!-- <script type="text/javascript" src="/ControlDeOperaciones/Direction.js"></script> -->
</head>
<body>
	<!-- Notifications area -->
	<section class="full-width container-notifications">
		<div class="full-width container-notifications-bg btn-Notification"></div>
	    <section class="NotificationArea">
	        <div class="full-width text-center NotificationArea-title tittles">Notificasiones <i class="zmdi zmdi-close btn-Notification"></i></div>
			<?php foreach($data as $dat) { 
					//echo "<strong>".$da['Notificaciones']."</strong>";
				   if($dat['Notificacion']==1){
	         echo '<a href="#"  class="Notification" id="notifation-unread-1">
	            <div class="Notification-icon"><i class="zmdi zmdi-accounts-alt bg-info"></i></div>
	            <div class="Notification-text">
	                <p>
	                    <i class="zmdi zmdi-circle"></i>
						
						<strong >Ultima solicitud</strong> 
						<strong>'.$dat['Estatus'].'</strong>
	                    <br>
	                    <small> Ingresado el '.$dat['SolicitudFe'].'</small>
						<input id="Solicitud" value='.$dat['SolicitudId'].' class="controlSolicitud" type="button"  name="Sl">
						<input id="Solicitudes" value="6" hidden>
	                </p>
	            </div>
	        	<div class="mdl-tooltip mdl-tooltip--left" for="notifation-unread-1">'.$dat['SolicitudDes'].'</div> 
	        </a>'; }else{

			}}?>

	        <a href="#" class="Notification" id="notifation-read-2">
	            <div class="Notification-icon"><i class="zmdi zmdi-cloud-download bg-primary"></i></div>
	            <div class="Notification-text">
	                <p> 
	                    <i class="zmdi zmdi-circle-o"></i>
	                    <strong>Nuevas Actualisaciones</strong> 
	                    <br>
	                    <small>Hace 30 Minutos</small>
	                </p>
	            </div>
	            <div class="mdl-tooltip mdl-tooltip--left" for="notifation-read-2">Notificacion Leida</div>
	        </a>
	        <a href="/ControlDeOperaciones/Solicitudes_" class="Notification" id="notifation-unread-3">
	            <div class="Notification-icon"><i class="zmdi zmdi-upload bg-success"></i></div>
	            <div class="Notification-text">
	                <p>
	                    <i class="zmdi zmdi-circle"></i>
	                    <strong>En Programacion</strong> 
	                    <br>
	                    <small>Hace 31 Minutos</small>
	                </p>
	            </div>
	            <div class="mdl-tooltip mdl-tooltip--left" for="notifation-unread-3">Notificacion No Leida</div>
	        </a> 
               <!-- Control de personal -->
			<?php $id =1; foreach($dt as $da) { 
                 //echo "<strong>".$da['Notificaciones']."</strong>";
				if($da['Notificacion']==1){
	        echo '<a href="#" class="Notification personal" value"'.$id++.'" name="N4" id="notifation-read-Personal">
	            <div class="Notification-icon"><i class="zmdi zmdi-mail-send bg-danger"></i></div>
	            <div class="Notification-text">
	                <p>
	                    <i class="zmdi zmdi-circle-o"></i>
                        
	                      <strong>Se agrego el empleado '.$da['PersonalNo'].'</strong>  
	                    <br>
	                    <small>Hace 37 Minutos</small>
						<input id="Personals" value='.$da['PersonalId'].' class="controlPersonal" type="button" name="Sls"">
						<input id="Personal" value="4" hidden>
	                </p>
	            </div>
	            <div class="mdl-tooltip mdl-tooltip--left" for="notifation-read-Personal">'.$da['PersonalPu'].'</div>
	        </a>';}else{
                 //Aqui algo
			}}?>
	        <a href="#" class="Notification" id="notifation-read-5">
	            <div class="Notification-icon"><i class="zmdi zmdi-folder bg-primary"></i></div>
	            <div class="Notification-text">
	                <p>
	                    <i class="zmdi zmdi-circle-o"></i>
	                    <strong>Estas son pruebas</strong> 
	                    <br>
	                    <small>Hace 1 hora</small>
	                </p>
	            </div>
	            <div class="mdl-tooltip mdl-tooltip--left" for="notifation-read-5">Notification Leida</div>
	        </a>   
	    </section>
	</section>
	<!-- navLateral -->
	<section class="full-width navLateral">
		<div class="full-width navLateral-bg btn-menu"></div>
		<div class="full-width navLateral-body">
			<div class="full-width navLateral-body-logo text-center tittles">
				<i class="zmdi zmdi-close btn-menu"></i> Control 
			</div>
			<figure class="full-width navLateral-body-tittle-menu">
				<div>
					<img src="/ControlDeOperaciones/Recursos_/assets/img/avatar-male.png" alt="Avatar" class="img-responsive">
				</div>
				<figcaption>
						<?php echo $_SESSION['myUser']; ?><br>
						<small>Nombre De Usuario</small>
					</span>
				</figcaption>
			</figure>
			<nav class="full-width">
				<ul class="full-width list-unstyle menu-principal">
					<li class="full-width">
						<a href="/ControlDeOperaciones/home.php" class="full-width">
							<div class="navLateral-body-cl">
								<i class="zmdi zmdi-view-dashboard"></i>
							</div>
							<div class="navLateral-body-cr">
								Inicio
							</div>
						</a>
					</li>
					<li class="full-width divider-menu-h"></li>
					<li class="full-width">
						<!-- Incertar Otro modulo de control -->
						<a href="/ControlDeOperaciones/Equipos_/index.php" class="full-width btn-subMenu">
						<div class="navLateral-body-cl">
								<i class="zmdi zmdi-view-dashboard"></i>
							</div>
							<div class="navLateral-body-cr">
								Control de equipos
							</div>
						</a>
						<!-- Fin de modulo de control -->
						
						<!-- Incertar Otro modulo de control -->
						<a href="/ControlDeOperaciones/Areas_/index.php" class="full-width btn-subMenu">
						<div class="navLateral-body-cl">
								<i class="zmdi zmdi-washing-machine"></i>
							</div>
							<div class="navLateral-body-cr">
								Administrar Areas
							</div>
					    </a>
                         <!-- Fin de modulo de control -->
						<!-- Fin de modulo de control -->
						<!-- Modulo -->
						<a href="/ControlDeOperaciones/Empleados_/index.php" class="full-width btn-subMenu">
							<div class="navLateral-body-cl">
								<i class="zmdi zmdi-case"></i>
							</div>
							<div class="navLateral-body-cr">
								Control De Empleados
							</div>
						</a>
                        <a href="/ControlDeOperaciones/Solicitudes_/index.php">
						<div class="navLateral-body-cl">
								<i class="zmdi zmdi-washing-machine"></i>
							</div>
							<div class="navLateral-body-cr">
								Administrar Solicitudes
							</div>
						</a>
						<!-- Fin de modulo de control 
						<a href="/ControlDeOperaciones/Tickets_/index.php" class="full-width btn-subMenu">
						<div class="navLateral-body-cl">
								<i class="zmdi zmdi-washing-machine"></i>
							</div>
							<div class="navLateral-body-cr">
								Administrar Tickets
							</div>
						</a>-->
						<!-- Incertar Otro modulo de control -->
						<a href="/ControlDeOperaciones/Reportes/index.php" class="full-width btn-subMenu">
						<div class="navLateral-body-cl">
								<i class="zmdi zmdi-view-dashboard"></i>
							</div>
							<div class="navLateral-body-cr">
								Generar Reporte
							</div>
						</a>
						<!-- Fin de modulo de control -->
						<!-- Incertar Otro modulo de control -->
						<a href="/ControlDeOperaciones/Insumos_/index.php" class="full-width btn-subMenu">
						<div class="navLateral-body-cl">
								<i class="zmdi zmdi-view-dashboard"></i>
							</div>
							<div class="navLateral-body-cr">
								Administrar Insumos
							</div>
						</a>
						<!-- Fin de modulo de control -->

						<!-- Incertar Otro modulo de control-->
						<a href="/ControlDeOperaciones/Prestamos_/index.php" class="full-width btn-subMenu">
						<div class="navLateral-body-cl">
								<i class="zmdi zmdi-view-dashboard"></i>
							</div>
							<div class="navLateral-body-cr">
								Prestamos
							</div>
						</a> 

						<!-- Incertar Otro modulo de control -->
						<a href="/ControlDeOperaciones/Banco_/index.php" class="full-width btn-subMenu">
						<div class="navLateral-body-cl">
								<i class="zmdi zmdi-view-dashboard"></i>
							</div>
							<div class="navLateral-body-cr">
								Banco de conocimientos
							</div>
						</a>
						<!-- Fin de modulo de control -->
						
						 <!-- <a href="/ControlDeOperaciones/Insumos_/index.php" class="full-width btn-subMenu">
						 <div class="navLateral-body-cl">
								<i class="zmdi zmdi-washing-machine"></i>
							</div>
							<div class="navLateral-body-cr">
								Prueba insumos
							</div>
					    </a> -->
			</nav>
		</div>
	</section>
	<!-- pageContent -->
	<section class="full-width pageContent">
	<div id="contenido"></div>
		<!-- navBar -->
		<div class="full-width navBar">
			<div class="full-width navBar-options">
				<i class="zmdi zmdi-swap btn-menu" id="btn-menu"></i>	
				<div class="mdl-tooltip" for="btn-menu">Esconder / Ver Menu</div>
				<nav class="navBar-options-list">
					<ul class="list-unstyle">
						<!-- <button id="p" onclick="cambiopantalla()" >A</button> -->
						<script>
                document.addEventListener("keydown",function(e){
					if(e.keyCode==9){
						//13 es enter, 9 tab, shift left 16
						cambiopantalla();
					}
				},false);	
                function cambiopantalla(){
					if(!document.fullscreenElement){
						document.documentElement.requestFullscreen();
					}else{
                      if(document.exitFullscreen){
						document.exitFullscreen();
						}
					}
                   // document.documentElement.requestFullscreen();
                 /*var elem = document.getElementById("p");
                 if(elem.requestFullscreen){
                    elem.requestFullscreen();
                 }*/
              //window.addEventListener("fullscreenchange",cambiopantalla.true);
                }
               
            </script> 
						<li type="button" class="btn-Notification" id="notifications"  id="notification-count" name="button" >
						<!-- onclick="javascript:myFunction();" -->
							<i class="zmdi zmdi-notifications"></i>
							<div class="mdl-tooltip" for="notifications">Notificaciones</div>
						</li>
						<li class="btn-exit" id="btn-exit" href="/logout.php">
							<i class="zmdi zmdi-power" href="/ControlDeTickets/logout.php"></i>
							<div class="mdl-tooltip" for="btn-exit" href="/logout.php">Cerrar secion</div>
						</li>
						<li class="text-condensedLight noLink" ><small><?php echo $_SESSION['myUser']; ?></small></li>
						<li class="noLink">
							<figure>
								<img src="/ControlDeOperaciones/Recursos_/assets/img/avatar-male.png" alt="Avatar" class="img-responsive">
							</figure>
						</li>
					</ul>
				</nav>
			</div>
		</div>
		</div>
		<!-- scrip para la animacion de carga -->
	<div class="full-width divider-menu-h"></div>
               <script type="text/javascript">
                 $(document).ready(function() {
					//document.body.style.zoom = "115%"; 
                 $(window).load(function() {
                 $(".cargando").fadeOut(1000);
             });
                //Ocultar mensaje
              setTimeout(function () {
              $("#contenMsjs").fadeOut(1000);
              }, 3000);
               $('.btnBorrar').click(function(e){
               e.preventDefault();
               var id = $(this).attr("id");
               var dataString = 'id='+ id;
               url = "recib_Delete.php";
               $.ajax({
               type: "POST",
               url: url,
               data: dataString,
               success: function(data)
               {
                  window.location.href="index.php";
                  $('#respuesta').html(data);
                }
            });
                  return false;
        });
    });
</script>
<!-- Fin -->
<!-- Script para notificaciones 
<script type="text/javascript">
      function myFunction() {
        $.ajax({
          url: "../Recursos_/Vistas/notificaciones.php",
          type: "POST",
          processData:false,
          success: function(data){
            $("#notification-count").remove();                  
            $("#notification-latest").show();$("#notification-latest").html(data);
          },
          error: function(){}           
        });
      }
                                 
      $(document).ready(function() {
        $('body').click(function(e){
          if ( e.target.id != 'notification-icon'){
            $("#notification-latest").hide();
          }
        });
      });                                     
    </script>-->
<!-- Fin -->


<script>
	//Solicitud
	$(document).on("click", ".controlSolicitud", function(e){
		console.log("vi solicitud");
        var Sls = $(this).val(); // obtienes el valor de la seleccion.
		IdS=$('#Solicitudes').val();
        //console.log(IdS);
		$.ajax({
            url: "../Recursos_/Vistas/notificaciones.php",
            type: "POST",
            dataType: "json",
            data: {IdSolicitud:Sls, Opcion:IdS},
            success: function(data){
			
			}})

    });

    //Personal
	$(document).on("click", ".controlPersonal", function(e){
		console.log("vi personal");
        var Sls = $(this).val(); // obtienes el valor de la seleccion
        console.log(Sls);
		IdS=$('#Personal').val();

        //console.log(IdS);
		$.ajax({
            url: "../Recursos_/Vistas/notificaciones.php",
            type: "POST",
            dataType: "json",
            data: {IdPersonal:Sls, Opcion:IdS},
            success: function(data){
				
			}});
			document.querySelector('.personal').style.display = 'none';
    }); 
	//Personal
</script>
</body>
</html>