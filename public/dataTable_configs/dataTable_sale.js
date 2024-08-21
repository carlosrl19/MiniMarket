(function($) {
    "use strict"

    var table = $('#example').DataTable({
        dom: 'lBfrtip',
        buttons: [],
        language: {
            paginate: {
                next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                previous:
                    '<i class="fa fa-angle-double-left" aria-hidden="true"></i>',
            },

            // Personaliza el mensaje de búsqueda
            search: "Buscar",
            searchPlaceholder: "Ingresa tu búsqueda...",

            // Personaliza el mensaje de cantidad de filas mostradas
            // Remove the lengthMenu option
            // infoFiltered: "- Filtrado de _MAX_ registros.",
            //info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
            emptyTable: "No se encontraron registros.",
            zeroRecords:
                "No se encontraron registros que coincidan con la búsqueda.",
        },
        responsive: true,
        paginate: true,
        info: true,
        searching: true,
        lengthChange: true,
        ordering: false, // Deshabilitar la funcionalidad de ordenamiento
        // Remove the aLengthMenu option
        // lengthChange: false,
        // aLengthMenu: [
        //     [10, 20, 50],
        //     [10, 20, 50]
        // ],
    });

    table.on("click", "tbody tr", function() {
        var $row = table.row(this).nodes().to$();
        var hasClass = $row.hasClass("selected");
        if (hasClass) {
            $row.removeClass("selected");
        } else {
            $row.addClass("selected");
        }
    });
})(jQuery)
