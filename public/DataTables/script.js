$(document).ready( function () {
    $('#myTable').DataTable(
        {
            "aoColumnDefs": [
                { "bSortable": false, "aTargets": [ 6, 7 ] },
                { "bSearchable": false, "aTargets": [ 6, 7 ] }
            ],

            language: {
                "decimal": ",",
                "thousands": ".",
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "No se encontraron resultados",
                "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sSearch": "Buscar:",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast":"Último",
                    "sNext":"Siguiente",
                    "sPrevious": "Anterior"
                },
                "sProcessing":"Cargando..."
            }
        }
    );


} );