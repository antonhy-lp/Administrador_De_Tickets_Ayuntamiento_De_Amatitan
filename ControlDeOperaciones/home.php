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
} error_reporting(E_ERROR | E_PARSE);

	include "./Conexion_/conexion.php"; include "./Recursos_/Vistas/NabVar.php";?>
<script>document.cookie = "promo_shown=1; Max-Age=2600000; Secure","promo_shown=1; Max-Age=2600000; Secure SameSite=Strict"</script>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Inicio</title>
</head>
<body>
<div class="cargando">
    <div class="loader-outter"></div>
    <div class="loader-inner"></div>
</div>
    <ul class="navbar-nav mr-auto collapse navbar-collapse">
      <li class="nav-item active">
        <a href="home.php">    
        </a>
      </li>
    </ul>
   
</nav>
		<section class="full-width text-center" style="padding: 40px 0;">
			<h3 class="text-center tittles">Informacion General</h3>
			<!-- Tiles -->
			<article class="full-width tile">
				<div class="tile-text">
					<span class="text-condensedLight">
						-<br>
						<small>Prestamos no entregados</small>
					</span>
				</div>
				<i class="zmdi zmdi-account tile-icon"></i>
			</article>
			<article class="full-width tile">
				<div class="tile-text">
					<span class="text-condensedLight">
						-<br>
						<small>Solicitudes pendientes</small>
					</span>
				</div>
				<i class="zmdi zmdi-accounts tile-icon"></i>
			</article>
			<article class="full-width tile">
				<div class="tile-text">
					<span class="text-condensedLight">
						-<br>
						<small>Solicitudes en proceso</small>
					</span>
				</div>
				<i class="zmdi zmdi-truck tile-icon"></i>
			</article>
			<article class="full-width tile">
				<div class="tile-text">
					<span class="text-condensedLight">
						-<br>
						<small>Insumos</small> 
					</span>
				</div>
				<i class="zmdi zmdi-washing-machine tile-icon"></i>
				
			</article>
		<section class="full-width" style="margin: 30px 0;">
			<h3 class="text-center tittles">Bievenido <?php echo $_SESSION['myUser']; ?>
				<div id="current_date"></p>
			</h3><?php //include_once "Autor.php"; ?>
	</section>
	</section>
</body>
</html>