$(document).ready(function () {
    var tablaPersonas;
    var idPrestamo;
    var opcion;

    function inicializarTabla() {
        tablaPersonas = $("#tablaPersonas").DataTable({
            lengthMenu: [9, 15, 25, 30, 100, 200, 500],
            "columnDefs": [{
                "targets": -1,
                "data": null,
                "select": true,
                "defaultContent": "<div class='text-center'><div class='btn-group'><button title='Modificar datos del préstamo' class='btn btn-primary btnEditar' id='Editar' name='Edicion'> ⇄ </button><button class='btn btn-danger btnBorrar' title='Cambiar estado del préstamo'> ⇅ </button></div></div>"
            }],
            "language": {
                "lengthMenu": "Mostrando  _MENU_  registros",
                "zeroRecords": "No se encontraron resultados",
                "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "infoFiltered": "(Filtrado de un total de _MAX_ registros)",
                "sSearch": "Buscar:",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "sProcessing": "Procesando...",
            }
        });
        return tablaPersonas;
    }
    var tablaPersonas = inicializarTabla();

    function abrirModalNuevoPrestamo() {
        $("#formPersonas").trigger("reset");
        $(".modal-header").css("background-color", "#1cc88a");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Ingrese datos del préstamo");
        $("#modalCRUD").modal("show");
        idPrestamo = null;
        opcion = 1; //alta
    }

    function editarPrestamo($tr) {
        fila = $tr.closest("tr");
        idPrestamo = parseInt(fila.find('td:eq(0)').text());
        EquipoMo = fila.find('td:eq(1)').text();
        FechaEntrega = fila.find('td:eq(2)').text();
        FechaRecepcion = fila.find('td:eq(3)').text();
        Area = fila.find('td:eq(4)').text();
        PersonalNo = fila.find('td:eq(5)').text();
        Descripcion = fila.find('td:eq(6)').text();
        Estatus = fila.find('td:eq(7)').text();
        opcion = 2; //editar
        //Campos del modal para traer datos con su id
        $("#idPrestamo").val(idPrestamo);
        $("#EquipoMo").val(EquipoMo);
        $("#FechaRecepcion").val(FechaRecepcion);
        $("#Area").val(Area);
        $("#PersonalNo").val(PersonalNo);
        $("#Descripcion").val(Descripcion);
        $("#Estatus").val(Estatus);


        $(".modal-header").css("background-color", "#4e73df");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Modificando el prestamo: " + idPrestamo + "");
        $("#modalCRUD").modal("show");
    }

    function borrarPrestamo($tr) {
        fila = $tr.closest("tr");
        idPrestamo = parseInt(fila.find('td:eq(0)').text());
        Nom = fila.find('td:eq(1)').text();
        //Letrero
        Estado = fila.find('td:eq(7)').text();
        console.log(Estado);
        if (Estado == "En proceso") {
            Estado = "Terminado";
        } else if (Estado == "Terminado") {
            Estado = "Rechazado";
        } else if (Estado == "Rechazado") {
            Estado = "En proceso";
        }
        EquipoMo = $.trim($("#EquipoMo").val());
        FechaEntrega = $.trim($("#FechaEntrega").val());
        FechaRecepcion = $.trim($("#FechaRecepcion").val());
        Area = $.trim($("#Area").val());
        PersonalNo = $.trim($("#PersonalNo").val());
        Descripcion = $.trim($("#Descripcion").val());
        // Estatus = $.trim($("#Estatus").val()); 
        Estatus = fila.find('td:eq(7)').text();
        console.log("Estatus numerico es: " + Estado);
        if (Estatus == "En proceso") {
            Estatus = 2;
        }/*else if(Estado=="Terminado"){
        Estado = "Cancelado";
        }*/else if (Estatus == "Terminado") {
            Estatus = 3;
        } else if (Estatus == "Rechazado") {
            Estatus = 1;
        }
        console.log(Estatus);
        opcion = 3 //borrar
        //console.log(Nom);
        $(this).removeClass('selected');
        alertify.confirm('Cambiar estado', '¿Esta seguro de cambiar el prestamo del equipo ' + Nom + ' al estado ' + Estado + '?',
            function () {
                $.ajax({
                    url: "bd/ManejadorPrestamos.php",
                    type: "POST",
                    dataType: "json",
                    data: { EquipoMo: EquipoMo, FechaEntrega: FechaEntrega, FechaRecepcion: FechaRecepcion, Area: Area, PersonalNo: PersonalNo, Descripcion: Descripcion, Estatus: Estatus, idPrestamo: idPrestamo, opcion: opcion },
                    success: function (data) {
                        // console.log(data);
                        idPrestamo = data[0].idPrestamo;
                        FechaEntrega = data[0].FechaEntrega;
                        FechaRecepcion = data[0].FechaRecepcion;
                        Area = data[0].Area;
                        EquipoNo = data[0].EquipoNo;
                        EquipoMo = data[0].EquipoMo;
                        PersonalNo = data[0].PersonalNo;
                        Descripcion = data[0].Descripcion;
                        estatus = data[0].estatus;
                        $(this).removeClass('selected');
                        tablaPersonas.row(fila).data([idPrestamo, EquipoMo, FechaEntrega, FechaRecepcion, Area, PersonalNo, Descripcion, estatus]);
                        desactivarBotonEditar(fila);
                        alertify.success('Se actualizo a ' + estatus + ' el equipo ' + EquipoMo); $(this).addClass('selected');
                    }
                })
            }, function () { alertify.error('Cancelado') })
    
 }

    function enviarFormulario(e) {
        e.preventDefault();
        idPrestamo = $.trim($("#idPrestamo").val());
        EquipoMo = $.trim($("#EquipoMo").val());
        FechaEntrega = $.trim($("#FechaRecepcion").val());
        FechaRecepcion = $.trim($("#FechaRecepcion").val());
        Area = $.trim($("#Area").val());
        PersonalNo = $.trim($("#PersonalNo").val());
        Descripcion = $.trim($("#Descripcion").val());
        $.ajax({
            url: "bd/ManejadorPrestamos.php",
            type: "POST",
            dataType: "json",
            data: { EquipoMo: EquipoMo, FechaEntrega: FechaEntrega, FechaRecepcion: FechaRecepcion, Area: Area, PersonalNo: PersonalNo, Descripcion: Descripcion, idPrestamo: idPrestamo, opcion: opcion },
            success: function (data) {
                //console.log(data);
                idPrestamo = data[0].idPrestamo;
                FechaEntrega = data[0].FechaEntrega;
                FechaRecepcion = data[0].FechaRecepcion;
                Area = data[0].Area;
                EquipoNo = data[0].EquipoNo;
                EquipoMo = data[0].EquipoMo;
                PersonalNo = data[0].PersonalNo;
                Descripcion = data[0].Descripcion;
                estatus = data[0].estatus;
                if (opcion == 1) { tablaPersonas.row.add([idPrestamo, EquipoMo, FechaEntrega, FechaRecepcion, Area, PersonalNo, Descripcion, estatus]).draw(); alertify.success('El prestamo del equipo ' + EquipoMo + ' a sido registrado!'); }
                else { tablaPersonas.row(fila).data([idPrestamo, EquipoMo, FechaEntrega, FechaRecepcion, Area, PersonalNo, Descripcion, estatus]); alertify.success('El prestamo ' + idPrestamo + ' a sido modificado!'); $(this).removeClass('selected'); }
            }
        });
        $("#modalCRUD").modal("hide");
    }

    function desactivarBotonEditar( fila ) {
        let estadosActual = fila.find('td#textEstado').text();
        let estadoNuevo = (estadosActual === "Terminado" || estadosActual === "Rechazado" ) ? true : false ;
        fila.find('#Editar').prop("disabled", estadoNuevo);
    }
    tablaPersonas.rows().every(function() {
        let fila = this.node(); // Obtener el nodo de la fila actual
        let estadosActual = $(fila).find('td#textEstado').text();
        let estadoNuevo = (estadosActual === "Terminado" || estadosActual === "Rechazado" ) ? true : false ;
        $(fila).find('#Editar').prop("disabled", estadoNuevo);
        return true;
    });


    $("#btnNuevo").click(function () {
        abrirModalNuevoPrestamo();
    });

    $(document).on("click", ".btnEditar", function () {
        editarPrestamo($(this));
    });

    $(document).on("click", ".btnBorrar", function (e) {
        borrarPrestamo($(this));
    });

    $("#formPersonas").submit(function (e) {
        enviarFormulario(e);
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

