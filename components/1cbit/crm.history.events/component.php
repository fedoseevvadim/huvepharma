<?php

use Bitrix\Main\Grid\Options;

if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

if (!CModule::IncludeModule('crm'))
{
    ShowError(GetMessage('CRM_MODULE_NOT_INSTALLED'));
    return;
}


$ID = (int) $_POST["PARAMS"]["companyId"];

if ( $ID  === 0 ) {

    if ( isset($_COOKIE["COMPANY_ID"] ) ) {
        $ID = $_COOKIE["COMPANY_ID"];
    }

}

if ( $ID > 0 ) {
    setcookie("COMPANY_ID", $ID);
}

$ORDER  = "DESC";
$BY     = "DATE_FROM";

// Сделаем сортировку
if ( isset ( $_GET["by"] ) ) {
    if ( isset ( $_GET["order"] ) ) {

        $ORDER  = $_GET["order"];
        $BY     = $_GET["by"];

    }
}

//For custom reload with params
$ajaxLoaderParams = array(
    'url' => '/bitrix/components/bitrix/crm.event.view/lazyload.ajax.php?&site='.SITE_ID.'&'.bitrix_sessid_get(),
    'method' => 'POST',
    'dataType' => 'ajax',
    'data' => array('PARAMS' => $componentData)
);


$arrData = getCalendar($ID, $ORDER, $BY);
$arrData = json_decode($arrData, true);

foreach ( $arrData as $data ) {
    $list[]["data"] = $data;
}

$filter = [];
$filterOption = new Bitrix\Main\UI\Filter\Options('history_events');
$filterData = $filterOption->getFilter([]);

foreach ($filterData as $k => $v) {
    $filter[$k] = $v;
}

$arResult["GRID_DATA"] = $list;

$arResult['FILTER'] = [
    ['id' => 'DATE_FROM', 'name' => 'Дата', 'type' => 'date'],
    ['id' => 'NAME', 'name' => 'Название', 'type' => 'string'],
    ['id' => 'USER_NAME', 'name' => 'Имя', 'type' => 'string'],
    ['id' => 'USER_LAST_NAME', 'name' => 'Фамилия', 'type' => 'string'],
];


$grid_options = new Bitrix\Main\Grid\Options('history_events');
$sort = $grid_options->GetSorting(
    ['sort' => ['ID' => 'ASC'], 'vars' => ['by' => 'by', 'order' => 'order']]
);


$this->IncludeComponentTemplate();
?>

