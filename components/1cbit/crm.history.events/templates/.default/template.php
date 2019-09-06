<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<link href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" type="text/css"  rel="stylesheet" >

<style>

    table.dataTable thead th, table.dataTable thead td {
        padding: 10px 18px;
        border-bottom: 0px solid #111;

    }

    table.dataTable.display tbody tr.even>.sorting_1, table.dataTable.order-column.stripe tbody tr.even>.sorting_1 {
        background-color: #ffffff;
    }


    table.dataTable.no-footer {
        border-bottom: 0px solid #111;
    }

    table.dataTable.display tbody tr.odd {
        background-color: #ffffff;
    }

    table.dataTable.display tbody tr.odd>.sorting_1, table.dataTable.order-column.stripe tbody tr.odd>.sorting_1 {
        background-color: #ffffff;
    }

    body {
        color: #535c69;
    }


</style>

<?php

//$APPLICATION->IncludeComponent('bitrix:main.ui.filter', '', [
//    'FILTER_ID' => "history_events",
//    'GRID_ID' => "history_events",
//    'FILTER' => $arResult['FILTER'],
//    'ENABLE_LIVE_SEARCH' => true,
//    'ENABLE_LABEL' => true,
//    //'AJAX_ID' => \CAjax::getComponentID('1cbit:crm.history.events', '.default', ''),
////    'LAZY_LOAD' => '/local/components/1cbit/ccrm.history.events/history.ajax.php?&site=s1&sessid='.bitrix_sessid()
//]);

///local/components/1cbit/crm.history.events/history.ajax.php?site=s1&sessid=c2ff56819ec3924eb8e5c5a095ad424f&by=DATE_FROM&order=asc
?>
<!--<form name="form_history_events" action="/local/components/1cbit/crm.history.events/history.ajax.php?site=s1&amp;sessid=c2ff56819ec3924eb8e5c5a095ad424f" method="POST">-->
<!---->

<!---->
<!--</form>-->


<!--<span class="webform-small-button webform-small-button-blue" data-role="start-button" >-->
<!--        <span class="webform-small-button-text" onclick="loadFutureEvents()">-->
<!--            Предстоящие события-->
<!--        </span>-->
<!--</span>-->
<!---->
<!--<span class="webform-small-button webform-small-button-blue" data-role="start-button" >-->
<!--        <span class="webform-small-button-text">-->
<!--            <a href="/local/components/1cbit/crm.history.events/history.ajax.php?site=s1&by=DATE_FROM&order=asc&sessid=--><?//=bitrix_sessid_get()?><!--&internal=true&grid_id=history_events&grid_action=sort">Прошедшие события</a>-->
<!--        </span>-->
<!--</span>-->


<!--<div style="padding-bottom: 10px;"></div>-->
<?

//$AJAX_ID = \CAjax::getComponentID('bitrix:main.ui.grid', '.default', '');

//$APPLICATION->IncludeComponent('bitrix:main.ui.grid', '', [
//
//    'CACHE_TIME' => 3600,
//    'GRID_ID' => 'history_events',
//    'COLUMNS' => [
//        ['id' => 'NAME',            'name' => 'Название',   'sort' => 'NAME',           'default' => true],
//        ['id' => 'DATE_FROM',       'name' => 'Дата',       'sort' => 'DATE_FROM',      'default' => true],
//        ['id' => 'USER_NAME',       'name' => 'Имя',        'sort' => 'USER_NAME',      'default' => true],
//        ['id' => 'USER_LAST_NAME',  'name' => 'Фамилия',    'sort' => 'USER_LAST_NAME', 'default' => true],
//    ],
//    'ROWS' => $arResult["GRID_DATA"],
//    'SORT' => "ID",
//    'SORT_VARS' => "asc",
//    'TOTAL_ROWS_COUNT' => count($arResult["GRID_DATA"]),
//    'SHOW_ROW_CHECKBOXES' => false,
//    'NAV_OBJECT' => $nav,
//    'AJAX_MODE' => 'Y',
//    //'AJAX_ID' => \CAjax::getComponentID('bitrix:main.ui.grid', '.default', ''),
//    'PAGE_SIZES' => [
//        ['NAME' => "5", 'VALUE' => '5'],
//        ['NAME' => '10', 'VALUE' => '10'],
//        ['NAME' => '20', 'VALUE' => '20'],
//        ['NAME' => '50', 'VALUE' => '50'],
//        ['NAME' => '100', 'VALUE' => '100']
//    ],
//    'ACTION_PANEL'              => [
//        'GROUPS' => [
//            'TYPE' => [
//                'ITEMS' => [
//                    [
//                        'ID'    => 'set-type',
//                        'TYPE'  => 'DROPDOWN',
//                        'ITEMS' => [
//                            ['VALUE' => '', 'NAME' => '- Выбрать -'],
//                            ['VALUE' => 'plus', 'NAME' => 'Поступление'],
//                            ['VALUE' => 'minus', 'NAME' => 'Списание']
//                        ]
//                    ],
//                    [
//                        'ID'       => 'edit',
//                        'TYPE'     => 'BUTTON',
//                        'TEXT'        => 'Редактировать',
//                        'CLASS'        => 'icon edit',
//                        'ONCHANGE' => ''
//                    ],
//                    [
//                        'ID'       => 'delete',
//                        'TYPE'     => 'BUTTON',
//                        'TEXT'     => 'Удалить',
//                        'CLASS'    => 'icon remove',
//                    ],
//                ],
//            ]
//        ],
//    ],
//    'AJAX_OPTION_JUMP'          => 'N',
//    'SHOW_CHECK_ALL_CHECKBOXES' => false,
//    'SHOW_ROW_ACTIONS_MENU'     => false,
//    'SHOW_GRID_SETTINGS_MENU'   => false,
//    'SHOW_NAVIGATION_PANEL'     => false,
//    'SHOW_PAGINATION'           => false,
//    'SHOW_SELECTED_COUNTER'     => true,
//    'SHOW_TOTAL_COUNTER'        => true,
//    'SHOW_PAGESIZE'             => true,
//    'SHOW_ACTION_PANEL'         => false,
//    'ALLOW_COLUMNS_SORT'        => true,
//    'ALLOW_COLUMNS_RESIZE'      => true,
//    'ALLOW_HORIZONTAL_SCROLL'   => true,
//    'ALLOW_SORT'                => true,
//    'ALLOW_PIN_HEADER'          => true,
//    'AJAX_OPTION_HISTORY'       => 'N'
//]);



?>

<?
//echo getBXGrid();
?>


<table id="example" class="display">
    <thead class="main-grid-header">
        <tr>
            <th scope="col">Название встречи</th>
            <th scope="col">Дата встречи</th>
            <th scope="col">Фамилия, Имя</th>
        </tr>
        <tr>
            <th data-orderable="false"  scope="col">Название встречи</th>
            <th data-orderable="false" scope="col">Дата встречи</th>
            <th data-orderable="false"  scope="col">Фамилия, Имя</th>
        </tr>
    </thead>
    <tbody>

    <?
    foreach ( $arResult["GRID_DATA"] as $data ) {
        ?>
        <tr>
            <td class="span_txt">
                <?=$data["data"]["NAME"]?>
            </td>
            <td scope="row">
                <?=$data["data"]["DATE_FROM"]?>
            </td>
            <td>
                <?=$data["data"]["USER_NAME"] . " " . $data["data"]["USER_LAST_NAME"]?>
            </td>

        </tr>
        <?
    }
    ?>

    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#example').DataTable(
            {
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

</script>