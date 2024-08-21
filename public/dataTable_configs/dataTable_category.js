(function($) {
    "use strict"

    var table = $('#example').DataTable({
        dom: 'lBfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                customize: function(xlsx) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];

                    // Aplicar estilos
                    $(sheet).find("row:nth-child(n+3) c[r^='E']").each(function() {
                        $(this).attr("s", "40");
                    });
                    
                    // Aplicar estilos a la fila 2 para todas las columnas
                    $(sheet).find("row:nth-child(2) c").each(function() {
                        $(this).attr("s", "47");
                    });

                    // Aplicar estilo personalizado a las filas que contienen '0 unidades' en la columna 'C'
                    $('row', sheet).each(function () {
                        var cellC = $(this).find("c[r^='C'] t");
                        if (cellC.text() === 'Inactivo') {
                            $(this).attr("s", "42"); // Establecer el estilo personalizado
                        }
                    });

                    // Show datetime
                    var currentDate = new Date();
                    var dateString = currentDate.toLocaleString('es-ES', { timeZone: 'America/Tegucigalpa' })

                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    $('row c[r^="A1"]', sheet).each( function () {
                        if ( $('is t', this).text() == 'ACAI' ) {
                            $('is t', this).text( 'Categorias - ACAI '+ dateString );
                        } else {
                            $('is t', this).text( 'Categorias - ACAI'+ dateString );
                        }
                    });
                },
                className: 'btn btn-success dt-buttons btnExcel',
                filename: function() {
                    var date = new Date();
                    var day = date.getDate();
                    var monthNames = ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"];
                    var month = monthNames[date.getMonth()];
                    var year = date.getFullYear();
                    return 'Categoria de productos - ' + day + ' de ' + month + ' de ' + year;
                },
                exportOptions: {
                    modifier: {
                        search: 'applied',
                    },
                    columns: [0, 1, 2, 3]
                },
                text: '<i class="fas fa-file-excel"></i> Exportar',
            },
            {
                extend: 'pdfHtml5',
                className: 'btn btn-danger dt-buttons btnPDF',
                filename: function() {
                    var date = new Date();
                    var day = date.getDate();
                    var monthNames = ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"];
                    var month = monthNames[date.getMonth()];
                    var year = date.getFullYear();
                    return 'Categoria de productos - ' + day + ' de ' + month + ' de ' + year;
                },
                
                customize: function (doc) {
                    // Show datetime
                    var currentDate = new Date();
                    var dateString = currentDate.toLocaleString('es-ES', { timeZone: 'America/Tegucigalpa' })

                    doc.content.splice(0, 1, {
                        text: ' Categorias - ACAI\n' + dateString,
                        fontSize: 12,
                        alignment: 'center',
                        margin: [0, 0, 0, 12]
                    });

                    // Get all page width
                    doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');

                    // Center table registers
                    doc.content[1].table.body.forEach(function(row) {
                        row.forEach(function(cell) {
                            cell.alignment = 'center';
                        });
                    });

                    // Marcar filas en rojo claro que contienen '0 unidades' en la columna 'C'
                    doc.content[1].table.body.forEach(function(row) {
                        if (row[3].text === 'No') {
                            row.forEach(function(cell) {
                                cell.fillColor = '#ff6868'; // Rojo claro
                                cell.color = 'white'; // Texto blanco
                            });
                        }
                    });
                },
                exportOptions: {
                    modifier: {
                        search: 'applied',
                    },
                    columns: [0, 1, 2, 3]
                },
                text: '<i class="fas fa-file-pdf"></i> Exportar',
            },
        ],
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
            lengthMenu: "Mostrando _MENU_ registros por página",
            infoFiltered: "- Filtrado de _MAX_ registros.",
            info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
            emptyTable: "No se encontraron registros.",
            zeroRecords:
                "No se encontraron registros que coincidan con la búsqueda.",
        },
        responsive: true,
        paginate: true,
        info: true,
        searching: true,
        lengthChange: true,
        aLengthMenu: [
            [10, 20, 50],
            [10, 20, 50]
        ],
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
})(jQuery);
