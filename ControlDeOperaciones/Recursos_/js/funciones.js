

function agregardatos(idInsumo,Nombre,Modelo,Descripcion,Destino){

	cadena="idInsumo=" + idInsumo + 
			"&nombre=" + Nombre +
			"&modelo=" + Modelo +
			"&descripcion=" + Descripcion +
			"&destino=" + Destino;

	$.ajax({
		type:"POST",
		url:"php/agregarDatos.php",
		data:cadena,
		success:function(r){
			if(r==1){
				$('#tabla').load('componentes/tabla.php');
				 $('#buscador').load('componentes/buscador.php');
				alertify.success("agregado con exito :)");
			}else{
				alertify.error("Fallo el servidor :(");
			}
		}
	});

}

function agregaform(datos){

	d=datos.split('||');

	$('#idInsumo').val(d[0]);
	$('#nombreA').val(d[1]);
	$('#modeloA').val(d[2]);
	$('#descripcionA').val(d[3]);
	$('#destinoA').val(d[7]);
	
}

function actualizaDatos(){


	id=$('#idInsumo').val();
	Nombre=$('#nombreA').val();
	Modelo=$('#modeloA').val();
	Descripcion=$('#descripcionA').val();
	Destino=$('#destinoA').val();

	cadena= "idInsumo=" + id +
			"&nombre=" + Nombre + 
			"&modelo=" + Modelo +
			"&descripcion=" + Descripcion +
			"&destino=" + Destino;

	$.ajax({
		type:"POST",
		url:"php/actualizaDatos.php",
		data:cadena,
		success:function(r){
			
			if(r==1){
				$('#tabla').load('componentes/tabla.php');
				alertify.success("Actualizado con exito :)");
			}else{
				alertify.error("Fallo el servidor :(");
			}
		}
	});

}

function preguntarSiNo(id){
	alertify.confirm('Eliminar Datos', '¿Esta seguro de eliminar este registro?', 
					function(){ eliminarDatos(id) }
                , function(){ alertify.error('Se cancelo')});
}

function eliminarDatos(id){

	cadena="id=" + id;

		$.ajax({
			type:"POST",
			url:"php/eliminarDatos.php",
			data:cadena,
			success:function(r){
				if(r==1){
					$('#tabla').load('componentes/tabla.php');
					alertify.success("Eliminado con exito!");
				}else{
					alertify.error("Fallo el servidor :(");
				}
			}
		});
}