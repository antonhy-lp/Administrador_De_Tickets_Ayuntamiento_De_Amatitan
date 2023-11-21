$(document).ready(function () {
    var tablaPersonas;
    var EquipoNo;
    var opcion;

    function inicializarTabla() {
        tablaPersonas = $("#tablaPersonas").DataTable({
            lengthMenu: [9, 15, 25, 30, 100, 200, 500],
            "columnDefs": [{
                "targets": -1,
                "data": null,
                "select": true,
                "defaultContent": "<div class='text-center'><div class='btn-group'><button title='Modificar datos del equipo' class='btn btn-primary btnEditar' id='Editar' name='Edicion'> ⇄ </button><button class='btn btn-danger btnBorrar' title='Cambiar estado del equipo'> ⇅ </button></div></div>"
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

    // Llamada a funciones y eventos al inicio
    var tablaPersonas = inicializarTabla();

    function abrirModalNuevoEquipo() {
        $("#formPersonas").trigger("reset");
        $(".modal-header").css("background-color", "#1cc88a");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Ingrese el nuevo equipo");
        $("#modalCRUD").modal("show");
        EquipoNo = null;
        opcion = 1; // Alta
    }

    var fila; //capturar la fila para editar o borrar el registro

    function editarEquipo($tr) {
        fila = $tr.closest("tr");
        EquipoNo = parseInt(fila.find('td:eq(0)').text());
        EquipoMo = fila.find('td:eq(1)').text();
        EquipoMa = fila.find('td:eq(2)').text();
        EquipoDes = fila.find('td:eq(3)').text();
        Estatus = fila.find('td:eq(4)').text();
        opcion = 2; //editar
        //Campos del modal para traer datos con su id
        $("#EquipoNo").val(EquipoNo);
        $("#EquipoMo").val(EquipoMo);
        $("#EquipoMa").val(EquipoMa);
        $("#EquipoDes").val(EquipoDes);
        $("#Estatus").val(Estatus);


        $(".modal-header").css("background-color", "#4e73df");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Modificando el equipo: " + EquipoNo + "");
        $("#modalCRUD").modal("show");


    }

    function borrarEquipo($tr) {
        fila = $tr.closest("tr");
        EquipoNo = parseInt(fila.find('td:eq(0)').text());
        Nom = fila.find('td:eq(1)').text();
        Est = fila.find('td:eq(4)').text();
        console.log(Est);
        if (Est == 'Activo') {
            Es = 'Inactivo';
        } else {
            Es = 'Activo';
        }
        EquipoMo = $.trim($("#EquipoMo").val());
        EquipoMa = $.trim($("#EquipoMa").val());
        EquipoDes = $.trim($("#EquipoDes").val());
        Estatus = $.trim($("#Estatus").val());
        console.log(EquipoNo);
        opcion = 3 //borrar

        $(this).removeClass('selected');
        alertify.confirm('Cambiar estado', '¿Esta seguro de cambiar el equipo ' + Nom + ' al estado ' + Es + '?',
            function () {
                $.ajax({
                    url: "bd/ManejadorEquipos.php",
                    type: "POST",
                    dataType: "json",
                    data: { EquipoMo: EquipoMo, EquipoMa: EquipoMa, EquipoDes: EquipoDes, Estatus: Estatus, EquipoNo: EquipoNo, opcion: opcion },
                    success: function (data) {
                        // console.log(data);
                        EquipoNo = data[0].EquipoNo;
                        EquipoMo = data[0].EquipoMo;
                        EquipoMa = data[0].EquipoMa;
                        EquipoDes = data[0].EquipoDes;
                        Estatus = data[0].Estatus;
                        if (Estatus == 1) {
                            Estatus = 'Activo';

                        } else {
                            Estatus = 'Inactivo';
                        } $(this).removeClass('selected');
                        tablaPersonas.row(fila).data([EquipoNo, EquipoMo, EquipoMa, EquipoDes, Estatus]);
                        desactivarBotonEditar(fila);
                        alertify.success('Se actualizo a ' + Estatus + ' el equipo ' + EquipoMo); $(this).addClass('selected');
                    }
                })
            }, function () { alertify.error('Cancelado') })
    }

    function enviarFormulario(e) {
        e.preventDefault();
        EquipoNo = $.trim($("#EquipoNo").val());
        EquipoMo = $.trim($("#EquipoMo").val());
        EquipoMa = $.trim($("#EquipoMa").val());
        EquipoDes = $.trim($("#EquipoDes").val());
        Estatus = $.trim($("#Estatus").val());
        $.ajax({
            url: "bd/ManejadorEquipos.php",
            type: "POST",
            dataType: "json",
            data: { EquipoNo: EquipoNo, EquipoMo: EquipoMo, EquipoMa: EquipoMa, EquipoDes: EquipoDes, Estatus: Estatus, EquipoNo: EquipoNo, opcion: opcion },
            success: function (data) {
                //console.log(data);
                EquipoNo = data[0].EquipoNo;
                EquipoMo = data[0].EquipoMo;
                EquipoMa = data[0].EquipoMa;
                EquipoDes = data[0].EquipoDes;
                Estatus = data[0].Estatus;
                if (Estatus == 1) {
                    Estatus = 'Activo';
                } else {
                    Estatus = 'Inactivo';
                }
                Destino = data[0].Destino
                if (opcion == 1) { tablaPersonas.row.add([EquipoNo, EquipoMo, EquipoMa, EquipoDes, Estatus]).draw(); alertify.success('El equipo ' + EquipoMo + ' a sido registrado!'); }
                else { tablaPersonas.row(fila).data([EquipoNo, EquipoMo, EquipoMa, EquipoDes, Estatus]); alertify.success('El equipo ' + EquipoNo + ' a sido modificado!'); $(this).removeClass('selected'); }
            }
        });
        $("#modalCRUD").modal("hide");

    }

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
        abrirModalNuevoEquipo();
        PersonalId = null;
        opcion = 1; // Alta
    });

    $(document).on("click", ".btnEditar", function () {
        editarEquipo($(this));
    });

    $(document).on("click", ".btnBorrar", function (e) {
        borrarEquipo($(this));
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


