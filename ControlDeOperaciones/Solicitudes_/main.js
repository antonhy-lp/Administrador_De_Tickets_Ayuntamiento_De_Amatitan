$(document).ready(function () {
    var tablaPersonas;
    var SolicitudId;
    var opcion;

    function inicializarTabla() {
        tablaPersonas = $("#tablaPersonas").DataTable({
            lengthMenu: [9, 15, 25, 30, 100, 200, 500],
            "columnDefs": [{
                "targets": -1,
                "data": null,
                "select": true,
                "defaultContent": "<div class='text-center'><div class='btn-group'><button title='Modificar datos de la solicitud' class='btn btn-primary btnEditar' id='Editar' name='Edicion'> ⇄ </button><button class='btn btn-danger btnBorrar' title='Cambiar estado de la solicitud' id='Estado' name='Estado'> ⇅ </button> <button type='button' title='Generar ticket' class='btn btn-primary btnEdicionTicket' id='EdicionTicket' name='EdicionTicket'> ⇄ </button> </div></div>"
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
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "sProcessing": "Procesando...",
            }
        });
    }

    function mostrarElementosModalSolicitud() {
        $('#empleadoAsig').show();
        $('#Labelasig').show();
        $('#SolicitudDes').show();
        $('#SoliDes').show();
        $('#prioridadEs').show();
        $('#PrioriEs').show();
    }

    function ocultarElementosModalSolicitud() {
        $('#empleadoAsig').hide();
        $('#Labelasig').hide();
        $('#SolicitudDes').hide();
        $('#SoliDes').hide();
        $('#prioridadEs').hide();
        $('#PrioriEs').hide();
    }

    function mostrarElementosModalTicket() {
        $('#Equipo').show();
        $('#LabelEq').show();
        $('#TickDes').show();
        $('#TicketDescripcion').show();
        $('#TickPr').show();
        $('#TicketProblema').show();
        $('#TickSl').show();
        $('#TicketSolucion').show();
    }

    function ocultarElementosModalTicket() {
        $('#Equipo').hide();
        $('#LabelEq').hide();
        $('#TickDes').hide();
        $('#TicketDescripcion').hide();
        $('#TickPr').hide();
        $('#TicketProblema').hide();
        $('#TickSl').hide();
        $('#TicketSolucion').hide();
    }

    var fila; //capturar la fila para editar o borrar el registro

    function abrirModalNuevoSolicitud() {
        $("#formPersonas").trigger("reset");
        $(".modal-header").css("background-color", "#1cc88a");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Ingresar nueva solicitud");
        $("#modalCRUD").modal("show");
        SolicitudId = null;
        opcion = 1; //alta

        mostrarElementosModalSolicitud();
        ocultarElementosModalTicket();
    }


    //-------------------------------------------------------------------------------------------//

    function abrirModalEditar($tr) {
        fila = $tr.closest("tr");
        SolicitudId = parseInt(fila.find('td:eq(0)').text());
        PersonalIdt = fila.find('td:eq(1)').text();
        SolicitudDes = fila.find('td:eq(2)').text();
        prioridadEs = fila.find('td:eq(3)').text();
        Estatus = fila.find('td:eq(4)').text();
        opcion = 2; //editar
        console.log(PersonalIdt);
        $("#SolicitudId").val(SolicitudId);
        $("#PersonalId").val(SolicitudId);
        $("#empleadoAsig").val(PersonalIdt);
        $("#SolicitudDes").val(SolicitudDes);
        $("#prioridadEs").val(prioridadEs);
        $("#Estatus").val(Estatus);
        $(".modal-header").css("background-color", "#4e73df");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Modificando la solicitud: " + SolicitudId + "");
        $("#modalCRUD").modal("show");

        ocultarElementosModalTicket();
        mostrarElementosModalSolicitud();
    }

    function abrirModalTicket($tr) {
        fila = $tr.closest("tr");
        SolicitudId = parseInt(fila.find('td:eq(0)').text());
        opcion = 4; //editar
        console.log(fila);
        $("#SolicitudId").val(SolicitudId);
        $(".modal-header").css("background-color", "#4e73df");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Generando ticket de la solicitud: " + SolicitudId + "");
        $('#modalCRUD').modal("show");

        ocultarElementosModalSolicitud();
        mostrarElementosModalTicket()
    }


    //-----------------------------------------------------------------------------------------//


    function borrarSolicitud($tr) {
        fila = $tr.closest("tr");
        SolicitudId = parseInt(fila.find('td:eq(0)').text());
        Nom = fila.find('td:eq(2)').text();
        Estado = fila.find('td:eq(5)').text();
        switch (Estado) {
            case "En proceso":
                Estado = "Cancelado";
                Es = 4;
                break;
            case "Cancelado":
                Estado = "En espera";
                Es = 2;
                break;
            case "En espera":
                Estado = "En proceso";
                Es = 1;
                break;
        }

        //console.log(Es);
        empleadoAsig = $.trim($("#empleadoAsig").val());
        SolicitudDes = $.trim($("#SolicitudDes").val());
        prioridadEs = $.trim($("#prioridadEs").val());
        opcion = 3 //Cambiar estado

        $(this).removeClass('selected');

        alertify.confirm('Cambiar estado a: ' + Estado + ' ', '¿Esta seguro de cambiar de estado la solicitud ' + Nom + '?',
            function () {
                try {
                    $.ajax({
                        url: "bd/ManejadorSolicitudes.php",
                        type: "POST",
                        dataType: "json",
                        data: { empleadoAsig: empleadoAsig, SolicitudDes: SolicitudDes, prioridadEs: prioridadEs, Es: Es, SolicitudId: SolicitudId, opcion: opcion },
                        success: function (data) {
                            PersonalNo = data[0].PersonalNo;
                            SolicitudDes = data[0].SolicitudDes
                            SolicitudPri = data[0].SolicitudPri;
                            SolicitudFe = data[0].SolicitudFe;
                            Estatus = data[0].Estatus;
                            SolicitudId = data[0].SolicitudId

                            // Remover fila seleccionada
                            $(this).removeClass('selected');
                            tablaPersonas.row(fila).data([SolicitudId, PersonalNo, SolicitudDes, SolicitudPri, SolicitudFe, Estatus]);
                            desactivarBotonEditar($(fila));
                            alertify.success('Se actualizo al estado: ' + Estatus + ' la solicitud ' + SolicitudId);
                            $(this).addClass('selected');
                        },
                        error: function (xhr, status, error) {
                            alert('Error: ' + error); // Manejo del error
                        }
                    })
                } catch (error) {
                    console.error('Ocurrió un error: ', error); // Manejo del error
                }
            }, function () {
                alertify.error('Cancelado');
            });
    }


    function enviarFormulario(e) {
        e.preventDefault();
        //Solicitud - - - - - - - - - - - - - - - - - -  - -/
        SolicitudId = $.trim($("#SolicitudId").val());
        empleadoAsig = $.trim($("#empleadoAsig").val());
        SolicitudDes = $.trim($("#SolicitudDes").val());
        prioridadEs = $.trim($("#prioridadEs").val());
        Estatus = $.trim($("#Estatus").val());
        //Ticket - - - - - - - - - - - - - - - - - - -  - -/
        TicketDescripcion = $.trim($("#TicketDescripcion").val());
        Equipo = $.trim($("#Equipo").val());
        TicketProblema = $.trim($("#TicketProblema").val());
        TicketSolucion = $.trim($("#TicketSolucion").val());
        $.ajax({
            url: "bd/ManejadorSolicitudes.php",
            type: "POST",
            dataType: "json",
            data: { empleadoAsig: empleadoAsig, SolicitudDes: SolicitudDes, prioridadEs: prioridadEs, Estatus: Estatus, SolicitudId: SolicitudId, TicketDescripcion: TicketDescripcion, Equipo: Equipo, TicketProblema: TicketProblema, TicketSolucion: TicketSolucion, opcion: opcion },
            success: function (data) {
                console.log(data);
                PersonalNo = data[0].PersonalNo;
                SolicitudDes = data[0].SolicitudDes
                SolicitudPri = data[0].SolicitudPri;
                SolicitudFe = data[0].SolicitudFe;
                Estatus = data[0].Estatus;
                SolicitudId = data[0].SolicitudId
                if (opcion == 1) {
                    tablaPersonas.row.add([SolicitudId, PersonalNo, SolicitudDes, SolicitudPri, SolicitudFe, Estatus]).draw();
                    desactivarBotonEditar($(fila));
                    alertify.success('La solicitud ' + SolicitudId + ' ' + SolicitudDes + ' a sido registrada!');
                }
                else {
                    tablaPersonas.row(fila).data([SolicitudId, PersonalNo, SolicitudDes, SolicitudPri, SolicitudFe, Estatus]);
                    desactivarBotonEditar($(fila));
                    alertify.success('La solicitud ' + SolicitudId + ' a sido modificada!'); $(this).removeClass('selected');
                }
            }
        });
        $("#modalCRUD").modal("hide");

    }


    // Eventos de clic para botones
    inicializarTabla();

    $("#btnNuevo").click(function () {
        abrirModalNuevoSolicitud();
    });

    $(document).on("click", ".btnEdicionTicket", function () {
        abrirModalTicket($(this));
    });

    $(document).on("click", ".btnEditar", function () {
        abrirModalEditar($(this));
    });

    $(document).on("click", ".btnBorrar", function (e) {
        borrarSolicitud($(this));
    });

    $("#formPersonas").submit(function (e) {
        enviarFormulario(e);
    });

    function desactivarBotonEditar(fil) {
        // console.log("Fila contiene: " + fila);
        fila = $(fil)
        let opcion = fila.find('td#textEstado').text().trim(); // Este valor puede variar
        console.log('llegue');
        switch (opcion) {
            case "Terminado":
                fila.find('#Estado').prop("disabled", true);
                fila.find('#Editar').prop("disabled", true);
                fila.find('#EdicionTicket').prop("disabled", true);
                break;
            case "Cancelado":
                fila.find('#Editar').prop("disabled", true);
                fila.find('#EdicionTicket').prop("disabled", true);
                break;
            case "En espera":
                fila.find('#EdicionTicket').prop("disabled", true);
                break;
        }
    }

    tablaPersonas.rows().every(function () {
        let fila = this.node();
        desactivarBotonEditar(fila);
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
