$(document).ready(function(){
    tablaPersonas = $("#tablaPersonas").DataTable({
        lengthMenu: [9, 15, 25, 30, 100, 200, 500],
       "columnDefs":[{
        "targets": -1,
        "data":null,
        "select":true, 
        "aoColumnDefs": [
            { "bSortable": false, "aTargets": [ 0 ] },
            { "sWidth": "50px", "aTargets": [0,1,2,3,4,5,6,9,11,12,13,14,15] },
            { "sWidth": "80px", "aTargets": [7,8,10] },
        ],
        "bAutoWidth": false,
        "defaultContent": "<div class='text-center'><div class='btn-group'><button title='Mostrar datos de reparacion' class='btn btn-primary btnEditar' id='Editar' name='Edicion'> ⇄ </button></div>"  
       }],
        
    "language": {
            "lengthMenu": "Mostrar:  _MENU_ ",
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

var fila; //capturar la fila para editar o borrar el registro
    
//botón EDITAR    
$(document).on("click", ".btnEditar", function(){
    fila = $(this).closest("tr");
    Nequipo = parseInt(fila.find('td:eq(0)').text());
    descripcion = fila.find('td:eq(1)').text();
    Nequipo = fila.find('td:eq(2)').text();
    Modelo = fila.find('td:eq(3)').text();
    Problema = fila.find('td:eq(4)').text();
    solucion = fila.find('td:eq(5)').text();
    Fentrega = fila.find('td:eq(6)').text();
    opcion = 2; //editar
    
    $("#Nticket").val(Nequipo);
    $("#descripcion").val(descripcion);
    $("#Nequipo").val(Nequipo);
    $("#Modelo").val(Modelo);
    $("#Problema").val(Problema);
    $("#solucion").val(solucion);
    $("#Fentrega").val(Fentrega);
    
    
    $(".modal-header").css("background-color", "#4e73df");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Mostrando informacion del equipo: "+Modelo+"");            
    $("#modalCRUD").modal("show");  
  
});


        $('#tablaPersonas tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                tablaPersonas.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        } );

    });
