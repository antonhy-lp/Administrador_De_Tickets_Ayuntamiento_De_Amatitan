$(document).ready(function () {
    var tablaPersonas;
    var idInsumo;
    var opcion;

    function inicializarTabla() {
        tablaPersonas = $("#tablaPersonas").DataTable({
            lengthMenu: [9, 15, 25, 30, 100, 200, 500],
            "columnDefs": [{
                "targets": -1,
                "data": null,
                "select": true,
                "defaultContent": "<div class='text-center'><div class='btn-group'><button title='Modificar datos del insumo' class='btn btn-primary btnEditar' id='Editar' name='Edicion'> ⇄ </button><button class='btn btn-danger btnBorrar' title='Cambiar estado del insumo'> ⇅ </button></div></div>"
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
     // Abrir modal para agregar nuevo personal

    function abrirModalNuevoInsumo() {
        $("#formPersonas").trigger("reset");
        $(".modal-header").css("background-color", "#1cc88a");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Ingrese el nuevo insumo");
        $("#modalCRUD").modal("show");
        idInsumo = null;
        opcion = 1; // Alta
    }

    function editarInsumo($tr) {
        fila = $tr.closest("tr");
        idInsumo = parseInt(fila.find('td:eq(0)').text());
        nombre = fila.find('td:eq(1)').text();
        modelo = fila.find('td:eq(2)').text();
        descripcion = fila.find('td:eq(3)').text();
        FechaRegistro = fila.find('td:eq(4)').text();
        FechaSalida = fila.find('td:eq(5)').text();
        Estatus = fila.find('td:eq(6)').text();
        destino = fila.find('td:eq(7)').text();
        unidades = fila.find('td:eq(8)').text();
        //console.log(unidades);
        opcion = 2; //editar

        $("#idInsumo").val(idInsumo);
        $("#nombre").val(nombre);
        $("#modelo").val(modelo);
        $("#descripcion").val(descripcion);
        $("#FechaRegistro").val(FechaRegistro);
        $("#FechaSalidas").val(FechaSalida);
        $("#Estatus").val(Estatus);
        $("#destino").val(destino);
        $("#unidades").val(unidades);


        $(".modal-header").css("background-color", "#4e73df");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Modificando el insumo :" + idInsumo + "");
        $("#modalCRUD").modal("show");

    }

    function borrarInsumo($tr) {
        fila = $tr.closest("tr");
        idInsumo = parseInt(fila.find('td:eq(0)').text());
        Nom = fila.find('td:eq(1)').text();
        Es = parseInt(fila.find('td:eq(5)').text());
        //console.log(Es);
        if (Es == 0) {
            Es = 'Inactivo';
        } else {
            Es = 'Actvo';
        }
        IdInsumo = $.trim($("#idInsumo").val());
        nombre = $.trim($("#nombre").val());
        modelo = $.trim($("#modelo").val());
        descripcion = $.trim($("#descripcion").val());
        FechaRegistro = $.trim($("#FechaRegistro").val());
        FechaSalida = $.trim($("#FechaSalida").val());
        Estatus = $.trim($("#Estatus").val());
        destino = $.trim($("#destino").val());
        unidades = $.trim($("#unidades").val());
        console.log(unidades);
        opcion = 3 //borrar
        //console.log(Nom);
        $(this).removeClass('selected');
        alertify.confirm('Cambiar estado', '¿Esta seguro de cambiar el insumo ' + Nom + ' al estado ' + Es + '?',
            function () {
                $.ajax({
                    url: "bd/ManejadorInsumos.php",
                    type: "POST",
                    dataType: "json",
                    data: { nombre: nombre, modelo: modelo, descripcion: descripcion, FechaRegistro: FechaRegistro, FechaSalida: FechaSalida, Estatus: Estatus, destino: destino, unidades: unidades, idInsumo: idInsumo, opcion: opcion },
                    success: function (data) {

                        idInsumo = data[0].idInsumo;
                        Nombre = data[0].Nombre;
                        Modelo = data[0].Modelo
                        Descripcion = data[0].Descripcion;
                        FechaRegistro = data[0].FechaRegistro;
                        FechaSalida = data[0].FechaSalida;
                        Estatus = data[0].Estatus;
                        if (Estatus == 1) {
                            Estatus = 'Activo';

                        } else {
                            Estatus = 'Inactivo';
                        } $(this).removeClass('selected');
                        Destino = data[0].Destino;
                        Unidades = data[0].Unidades;
                        console.log(Unidades);
                        tablaPersonas.row(fila).data([idInsumo, Nombre, Modelo, Descripcion, FechaRegistro, FechaSalida, Estatus, Destino, Unidades]);
                        desactivarBotonEditar(fila);
                        alertify.success('Se actualizo a ' + Estatus + ' el insumo ' + Nombre); $(this).addClass('selected');
                    }
                })
            }, function(){ alertify.error('Cancelado')}
            )
        }

    function enviarFormulario(e) {
        e.preventDefault();
        IdInsumo = $.trim($("#idInsumo").val());
        nombre = $.trim($("#nombre").val());
        modelo = $.trim($("#modelo").val());
        descripcion = $.trim($("#descripcion").val());
        FechaRegistro = $.trim($("#FechaRegistro").val());
        FechaSalida = $.trim($("#FechaSalida").val());
        Estatus = $.trim($("#Estatus").val());
        destino = $.trim($("#destino").val());
        unidades = $.trim($("#unidades").val());
        console.log(unidades + " |Modificacion");
        $.ajax({
            url: "bd/ManejadorInsumos.php",
            type: "POST",
            dataType: "json",
            data: { nombre: nombre, modelo: modelo, descripcion: descripcion, FechaRegistro: FechaRegistro, FechaSalida: FechaSalida, Estatus: Estatus, destino: destino, unidades: unidades, idInsumo: idInsumo, opcion: opcion },
            success: function (data) {
                console.log(data);
                idInsumo = data[0].idInsumo;
                Nombre = data[0].Nombre;
                Modelo = data[0].Modelo
                Descripcion = data[0].Descripcion;
                FechaRegistro = data[0].FechaRegistro;
                FechaSalida = data[0].FechaSalida;
                Estatus = data[0].Estatus;
                if (Estatus == 1) {
                    Estatus = 'Activo';
                } else {
                    Estatus = 'Inactivo';
                }
                Destino = data[0].Destino
                Unidades = data[0].Unidades
                console.log(Unidades);
                if (opcion == 1) { tablaPersonas.row.add([idInsumo, Nombre, Modelo, Descripcion, FechaRegistro, FechaSalida, Estatus, destino, Unidades]).draw(); alertify.success('El insumo ' + Nombre + ' a sido registrado!'); }
                else { tablaPersonas.row(fila).data([idInsumo, Nombre, Modelo, Descripcion, FechaRegistro, FechaSalida, Estatus, Destino, Unidades]); alertify.success('El insumo ' + IdInsumo + ' a sido modificado!'); $(this).removeClass('selected'); }
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
        abrirModalNuevoInsumo();
    });

    $(document).on("click", ".btnEditar", function () {
        editarInsumo($(this));
    });

    $(document).on("click", ".btnBorrar", function (e) {
        borrarInsumo($(this));
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
