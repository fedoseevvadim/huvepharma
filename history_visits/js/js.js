$(document).ready(function() {
    $('#example').DataTable(
        {
            "dom": 'rft<"bottom"lp>',
            initComplete: function () {
                this.api().columns().every( function () {
                    var column = this;
                    var select = $('<select class="filter"><option value=""></option></select>')
                        .appendTo( $("#example thead tr:eq(1) th").eq(column.index()).empty() )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );

                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option>'+d+'</option>' );
                    } );
                } );
            },
            orderCellsTop: true,
            language: {
                "searchPlaceholder": "Поиск",
                "processing": "Подождите...",
                "search": "Поиск:",
                "lengthMenu": "Показать _MENU_ записей",
                "info": "Записи с _START_ до _END_ из _TOTAL_ записей",
                "infoEmpty": "Записи с 0 до 0 из 0 записей",
                "infoFiltered": "(отфильтровано из _MAX_ записей)",
                "infoPostFix": "",
                "loadingRecords": "Загрузка записей...",
                "zeroRecords": "Записи отсутствуют.",
                "emptyTable": "В таблице отсутствуют данные",
                "paginate": {
                    "first": "Первая",
                    "previous": "Предыдущая",
                    "next": "Следующая",
                    "last": "Последняя"
                }
            }
        }
    );
} );
