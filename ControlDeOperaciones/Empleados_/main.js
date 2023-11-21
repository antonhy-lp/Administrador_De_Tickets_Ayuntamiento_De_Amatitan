$(document).ready(function () {
    var tablaPersonas;
    var PersonalId;
    var opcion;

    // Inicializar la tabla
    function inicializarTabla() {
        tablaPersonas = $("#tablaPersonas").DataTable({
            lengthMenu: [9, 15, 25, 30, 100, 200, 500],
        "columnDefs": [{
            "targets": -1,
            "data": null,
            "select": true,
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
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "sProcessing": "Procesando...",
        }
        });
        return tablaPersonas;
    }

    // Llamada a funciones y eventos al inicio
    var tablaPersonas = inicializarTabla();
    // Abrir modal para agregar nuevo personal

    function abrirModalAlta() {
        $("#formPersonas").trigger("reset");
        $(".modal-header").css("background-color", "#1cc88a");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Ingrese el nuevo personal");
        $("#modalCRUD").modal("show");
        PersonalId = null;
        opcion = 1; //alta
    }

    var fila; //capturar la fila para editar o borrar el registro

    // Editar un registro de personal
    function editarRegistro($tr) {
        fila = $tr.closest("tr");
        PersonalId = parseInt(fila.find('td:eq(0)').text());
        AreaID = fila.find('td:eq(1)').text();
        PersonalNo = fila.find('td:eq(2)').text();
        PersonalPu = fila.find('td:eq(3)').text();
        Estatus = fila.find('td:eq(4)').text();
        opcion = 2; //editar
        console.log(AreaID);
        $("#PersonalId").val(PersonalId);
        $("#Area").val(AreaID);
        $("#PersonalNo").val(PersonalNo);
        $("#PersonalPu").val(PersonalPu);
        $("#Estatus").val(Estatus);


        $(".modal-header").css("background-color", "#4e73df");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Modificando el personal: " + PersonalId + "");
        $("#modalCRUD").modal("show");

    }

    // Borrar un registro de personal
    function borrarRegistro($tr) {
        fila = $tr.closest("tr");
        PersonalId = parseInt(fila.find('td:eq(0)').text());
        Nom = fila.find('td:eq(2)').text();
        Es = fila.find('td:eq(4)').text();
        console.log(PersonalId);
        if (Es == 'Activo') {
            Es = 'Inactivo';
        } else {
            Es = 'Actvo';
        }
        AreaID = $.trim($("#Area").val());
        PersonalNo = $.trim($("#PersonalNo").val());
        PersonalPu = $.trim($("#PersonalPu").val());
        Estatus = $.trim($("#Estatus").val());
        opcion = 3 //borrar
        $(this).removeClass('selected');
        alertify.confirm('Cambiar estado', '¿Esta seguro de cambiar el personal ' + Nom + ' al estado ' + Es + '?',
            function () {
                $.ajax({
                    url: "bd/ManejadorPersonal.php",
                    type: "POST",
                    dataType: "json",
                    data: { AreaID: AreaID, PersonalNo: PersonalNo, PersonalPu: PersonalPu, Estatus: Estatus, PersonalId: PersonalId, opcion: opcion },
                    success: function (data) {
                        // console.log(data);
                        PersonalId = data[0].PersonalId;
                        Area = data[0].Area;
                        PersonalNo = data[0].PersonalNo;
                        PersonalPu = data[0].PersonalPu;
                        Estatus = data[0].Estatus;
                        if (Estatus == 1) {
                            Estatus = 'Activo';
                        } else {
                            Estatus = 'Inactivo';
                        } $(this).removeClass('selected');
                        tablaPersonas.row(fila).data([ PersonalId, Area, PersonalNo, PersonalPu, Estatus]);
                        desactivarBotonEditar(fila);
                        alertify.success('Se actualizo a ' + Estatus + ' el personal ' + PersonalNo); $(this).addClass('selected');
                    }
                })
            }, function () { alertify.error('Cancelado') })
    }

    // Enviar formulario de personal
    function enviarFormulario(e) {
        e.preventDefault();
        PersonalId = $.trim($("#PersonalId").val());
        AreaID = $.trim($("#Area").val());
        PersonalNo = $.trim($("#PersonalNo").val());
        PersonalPu = $.trim($("#PersonalPu").val());
        Estatus = $.trim($("#Estatus").val());
        $.ajax({
            url: "bd/ManejadorPersonal.php",
            type: "POST",
            dataType: "json",
            data: { AreaID: AreaID, PersonalNo: PersonalNo, PersonalPu: PersonalPu, Estatus: Estatus, PersonalId: PersonalId, opcion: opcion },
            success: function (data) {
                console.log(data);
                PersonalId = data[0].PersonalId;
                Area = data[0].Area;
                PersonalNo = data[0].PersonalNo
                PersonalPu = data[0].PersonalPu;
                Estatus = data[0].Estatus;
                if (Estatus == 1) {
                    Estatus = 'Activo';
                } else {
                    Estatus = 'Inactivo';
                }
                Destino = data[0].Destino
                if (opcion == 1) { tablaPersonas.row.add([PersonalId, Area, PersonalNo, PersonalPu, Estatus]).draw(); alertify.success('El personal ' + PersonalNo + ' a sido registrado!'); }
                else { tablaPersonas.row(fila).data([PersonalId, Area, PersonalNo, PersonalPu, Estatus]); alertify.success('El personal ' + PersonalId + ' a sido modificado!'); $(this).removeClass('selected'); }
            }
        });
        $("#modalCRUD").modal("hide");

    }

    // Desactivar botón de editar según el estado
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


   
    $("#btnNuevo").click(function () {
        abrirModalAlta();
        PersonalId = null;
        opcion = 1; // Alta
    });

    $(document).on("click", ".btnEditar", function () {
        editarRegistro($(this));
    });

    $(document).on("click", ".btnBorrar", function (e) {
        borrarRegistro($(this));
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




