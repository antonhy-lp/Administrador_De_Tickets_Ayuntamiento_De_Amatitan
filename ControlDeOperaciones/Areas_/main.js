$(document).ready(function(){
    var tablaPersonas;
    var Id;
    var opcion;
    tablaPersonas = $("#tablaPersonas").DataTable({
        lengthMenu: [9, 15, 25, 30, 100, 200, 500],
        "columnDefs":[{
            "targets": -1,
            "data":null,
            "select":true, 
            "defaultContent": "<div class='text-center'><div class='btn-group'><button title='Modificar datos del empleado' class='btn btn-primary btnEditar' id='Editar' name='Edicion'> ⇄ </button><button class='btn btn-danger btnBorrar' title='Cambiar estado del empleado'> ⇅ </button></div></div>"  
        }],
        "language": {
            "lengthMenu": "Mostrando:  _MENU_ ",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(Filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast":"Último",
                "sNext":"Siguiente",
                "sPrevious": "Anterior"
                },
                "sProcessing":"Procesando...",
            }
    });

    function abrirModalAlta() {
        $("#formPersonas").trigger("reset");
        $(".modal-header").css("background-color", "#1cc88a");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Ingrese la nueva area");            
        $("#modalCRUD").modal("show");        
        Id=null;
        opcion = 1; //alta
    }

    function editarRegistro($tr) {
        fila = $tr.closest("tr");
        Id = parseInt(fila.find('td:eq(0)').text());
        Area = fila.find('td:eq(1)').text();
        Localizacion = fila.find('td:eq(2)').text();
        Estatus = fila.find('td:eq(3)').text();
        opcion = 2; //editar
        $("#Id").val(Id);
        $("#nombre").val(Area);
        $("#LocalizacionAr").val(Localizacion);
        $("#Estatus").val(Estatus);
        $(".modal-header").css("background-color", "#4e73df");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Modificando el area: "+Id+"");            
        $("#modalCRUD").modal("show"); 
    }

    function cambiarEstado($tr) {
        fila = $tr.closest("tr");
        Id = parseInt(fila.find('td:eq(0)').text());
        Nom = fila.find('td:eq(1)').text();
        Es = fila.find('td:eq(3)').text();
        console.log(Id);
        if(Es=='Activo'){
            Es='Inactivo';
        }else{
            Es='Actvo';
        }
        Localizacion = $.trim($("#LocalizacionAr").val());
        nombre  = $.trim($("#nombre").val());
        Estatus = $.trim($("#Estatus").val());     
        opcion  = 3 

        $(this).removeClass('selected');
        alertify.confirm('Cambiar estado a: '+Es+'.', '¿Esta seguro de cambiar el estado del  '+Nom+'?',
        function(){ 
            $.ajax({
                url: "bd/ManejadorAreas.php",
                type: "POST",
                dataType: "json",
                data: {Localizacion:Localizacion, nombre:nombre, Estatus:Estatus, Id:Id, opcion:opcion},
                success: function(data){
                // console.log(data);
                AreaID = data[0].AreaID;   
                Area = data[0].Area;
                Localizacion = data[0].Localizacion
                Estatus = data[0].Estatus;
                if(Estatus==1){
                    Estatus ='Activo';
                }else{
                    Estatus='Inactivo';
                }                        
                tablaPersonas.row(fila).data([ AreaID,Area,Localizacion,Estatus]);       
                desactivarBotonEditar(fila);
                $(this).removeClass('selected');       
                alertify.success('Se actualizo a '+Estatus+' el  ' + Area);  $(this).addClass('selected');
                }})
        } , function(){ alertify.error('Cancelado')}
        )
    }

    function submitForm(e) {
        e.preventDefault();    
        Id = $.trim($("#Id").val());
        nombre = $.trim($("#nombre").val());
        LocalizacionAr = $.trim($("#LocalizacionAr").val());
        Estatus = $.trim($("#Estatus").val());     
        $.ajax({
            url: "bd/ManejadorAreas.php",
            type: "POST",
            dataType: "json",
            data: {LocalizacionAr:LocalizacionAr, nombre:nombre, Estatus:Estatus, Id:Id, opcion:opcion},
            success: function(data){  
                console.log(data);
                AreaID = data[0].AreaID;   
                Area = data[0].Area;
                Localizacion = data[0].Localizacion
                Estatus = data[0].Estatus;
                if(Estatus==1){
                    Estatus ='Activo';
                }else{
                    Estatus='Inactivo';
                }     
                if(opcion == 1){tablaPersonas.row.add([AreaID,Area,Localizacion,Estatus]).draw(); alertify.success('El '+Area+' a sido registrado!');}
                else{tablaPersonas.row(fila).data([AreaID,Area,Localizacion,Estatus]); alertify.success('El area '+Id+' a sido modificada!');  $(this).removeClass('selected');}            
            }});
        $("#modalCRUD").modal("hide");   
    }

    $("#btnNuevo").click(function(){
        abrirModalAlta();
        Id = null;
        opcion = 1; // Alta
    });

    $(document).on("click", ".btnEditar", function(){
        editarRegistro($(this));
    });

    $(document).on("click", ".btnBorrar", function(e){
        cambiarEstado($(this));
    });

    $("#formPersonas").submit(function(e){
        submitForm(e);
    });

    function desactivarBotonEditar( tr ) {
       // console.log(tr);
        let isInactive = tr.find('td#textEstado').text() === "Inactivo";
        tr.find('#Editar').prop("disabled", isInactive);
    }
    tablaPersonas.rows().every(function() {
        let tr = this.node(); // Obtener el nodo de la fila actual
        let isInactive = $(tr).find('td#textEstado').text().trim() === "Inactivo";
        $(tr).find('#Editar').prop("disabled", isInactive);
        return true;
    });
    $('#tablaPersonas tbody').on('click', 'tr', function () {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            tablaPersonas.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });
    
});
