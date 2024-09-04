(function($) {
    "use strict"

    var table = $('#example').DataTable({
        dom: 'lBfrtip',
        language: {
            paginate: {
                next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                previous:
                    '<i class="fa fa-angle-double-left" aria-hidden="true"></i>',
            },

            // Personaliza el mensaje de búsqueda
            search: "<i class='fas fa-search' style='background-color: #e74a3b; color: white; padding: 5px; border-radius: 5px'></i>",
            searchPlaceholder: "Buscar en la lista...",

            // Personaliza el mensaje de cantidad de filas mostradas
            lengthMenu: "Mostrando _MENU_ registros por página",
            infoFiltered: "- Filtrado de _MAX_ registros.",
            sInfoEmpty: "Sin registros para mostrar",
            info: "Total de lista de compras: _TOTAL_ productos.",
            emptyTable: "No se encontraron registros de pagarés pagados para mostrar.",
            zeroRecords:
                "No se encontraron registros que coincidan con la búsqueda.",
        },
        columns: [
            { "orderable": false }, // i++
            { "orderable": true },
            { "orderable": false }, // Input to quantity
            { "orderable": true },
            { "orderable": true },
            { "orderable": false } // Remove item buttom
        ],
        order: [
            [1, 'desc']
        ],
        responsive: true,
        paginate: false,
        info: false,
        searching: true,
        lengthChange: false,
        aLengthMenu: [
            [5, 10, 20],
            [5, 10, 20]
        ],
    });
})(jQuery);