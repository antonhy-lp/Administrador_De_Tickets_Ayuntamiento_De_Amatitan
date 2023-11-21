<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<link rel="stylesheet" href="/ControlDeOperaciones/Recursos_/css/normalize.css">
	<link rel="stylesheet" href="/ControlDeOperaciones/Recursos_/css/sweetalert.css">
	<link rel="stylesheet" href="/ControlDeOperaciones/Recursos_/css/material.min.css">
	<link rel="stylesheet" href="/ControlDeOperaciones/Recursos_/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" href="/ControlDeOperaciones/Recursos_/css/jquery.mCustomScrollbar.css">
	<link rel="stylesheet" href="/ControlDeOperaciones/Recursos_/css/main.css">
    <!-- Icono de pestana -->
	<link rel="shortcut icon" type="image/x-icon" href="/assets/img/favicon.ico" >
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/jquery-1.11.2.min.js"><\/script>')</script>
	<script src="/ControlDeOperaciones/Recursos_/js/material.min.js" ></script>
	<!-- <script src="js/sweetalert2.min.js" ></script> -->
	<script src="/ControlDeOperaciones/Recursos_/js/jquery.mCustomScrollbar.concat.min.js" ></script>
	<script src="/ControlDeOperaciones/Recursos_/js/main.js" ></script>
    <!-- <script src="js/sweetalert2.all.min.js" ></script> -->
    <script src="/ControlDeOperaciones/Recursos_/js/sweetalert.min.js" ></script>
</head>
<body>
	<div class="login-wrap cover">
		<div class="container-login">
			<div class="loader-outter"></div>
            <div class="loader-inner"></div>
			<p class="text-center" style="font-size: 80px;">
				<i class="zmdi zmdi-account-circle"></i>
			</p>
			
			<p class="text-center text-condensedLight">Iniciar sesion</p>
			<form action="login.php" method="POST">
				
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				    <input class="mdl-textfield__input" type="text" id="usuario" name="usuario" placeholder="Escribe tu nombre de usuario">
					
				    <label class="mdl-textfield__label" for="usuario">Nombre De Usuario</label>
				</div>
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				    <input class="mdl-textfield__input" type="password" id="palabra_secreta" name="palabra_secreta" placeholder="Contraseña">
				    <label class="mdl-textfield__label" for="palabra_secreta">Contraseña</label>
				</div>
				<!-- <button class="mdl-button mdl-js-button mdl-js-ripple-effect" style="color: #3F51B5; margin: 0 auto; display: block;" type="submit"> -->
				<button type="button" style="color: #3F51B5; margin: 0 auto; display: block;" class="mdl-button mdl-js-button mdl-js-ripple-effect" onclick="javascript:frmLogin();" class="btn btn-primary">
					Inciar sesion
				</button>
				<!-- <video class="bg-video" playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop"><source src="assets/mp4/bg.mp4" type="video/mp4" /></video> -->
			</form>
		</div>
	</div>
	<script>
    function frmLogin(){
        let u = document.getElementById('usuario');
        let p = document.getElementById('palabra_secreta');
        let datos = new Object();
        if(u.value == ""){
            swal("Ingresa un usuario");
            u.focus();
            return;
        }
        if(p.value == ""){
            swal("Ingresa la contrasena");
            p.focus();
            return; 
        }
        datos.user = u.value;
        datos.pass = p.value;
        let json = JSON.stringify(datos);
        console.log(json);
        let url = "ControlDeOperaciones/Conexion_/wsLogin.php";
        $.post(url, json, function(responseText, status){
            try {
                console.log(responseText);
                if(status == 'success'){
                    let resp = JSON.parse(responseText);
                    if(resp.estado == "OK"){
                        swal("¡Bienvenido!", "Accediendo. ..", "success");
                        <?php session_start();?>
                        window.location.href = "ControlDeOperaciones/home.php";
                    }else{
                        throw e = resp.estado;
                    }
                }else{
                    throw e = status;
                }
            } catch (e) {
               // alert("El resultado " + e)
              // console.log(e)
               swal({
                      title: "Verifica las credenciales!",
                      text: "Intenta dentro de 3 segundos. ..",
                      timer: 3000,
                      showConfirmButton: false
                    });
            }
        });
    }
</script>
               <script src="/ControlDeOperaciones/Recursos_/js/jquery.min.js"></script>
               <script src="/ControlDeOperaciones/Recursos_/js/popper.min.js"></script>
               <script src="/ControlDeOperaciones/Recursos_/js/bootstrap.min.js"></script>
               <script type="text/javascript">
                 $(document).ready(function() {
                 $(window).load(function() {
                 $(".login-wrap cover").fadeOut(1000);
             });
    });
</script>
</body>
</html>