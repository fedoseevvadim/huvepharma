<?php
define('NO_KEEP_STATISTIC', 'Y');
define('NO_AGENT_STATISTIC','Y');
define('NO_AGENT_CHECK', true);
define('PUBLIC_AJAX_MODE', true);
define('DisableEventsCheck', true);

use Bitrix\Main\Page\Asset;
use Bitrix\Main\UI\Filter\Options;

$siteID = isset($_REQUEST['site']) ? substr(preg_replace('/[^a-z0-9_]/i', '', $_REQUEST['site']), 0, 2) : '';
if($siteID !== '')
{
    define('SITE_ID', $siteID);
}

require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
require_once($_SERVER["DOCUMENT_ROOT"]."/local/history_visits/handler.php");

Asset::getInstance()->addJs("https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js");

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
    die();
}

if (!CModule::IncludeModule('crm') || !CCrmSecurityHelper::IsAuthorized() || !check_bitrix_sessid())
{
    die();
}

$componentData = isset($_REQUEST['PARAMS']) && is_array($_REQUEST['PARAMS']) ? $_REQUEST['PARAMS'] : array();
$componentParams = isset($componentData['params']) && is_array($componentData['params']) ? $componentData['params'] : array();

//For custom reload with params
$ajaxLoaderParams = array(
    'url' => '/bitrix/components/bitrix/crm.event.view/lazyload.ajax.php?&site='.SITE_ID.'&'.bitrix_sessid_get(),
    'method' => 'POST',
    'dataType' => 'ajax',
    'data' => array('PARAMS' => $componentData)
);

global $APPLICATION;
Header('Content-Type: text/html; charset='.LANG_CHARSET);
$APPLICATION->ShowAjaxHead();

$componentParams['ENABLE_CONTROL_PANEL'] = false;
//Force AJAX mode
$componentParams['AJAX_MODE'] = 'Y';
$componentParams['AJAX_OPTION_JUMP'] = 'N';
$componentParams['AJAX_OPTION_HISTORY'] = 'N';
$componentParams['AJAX_LOADER'] = $ajaxLoaderParams;

$filterOption = new Bitrix\Main\UI\Filter\Options('report_list');
$filterData = $filterOption->getFilter([]);

foreach ($filterData as $k => $v) {
    $filterData['NAME'] = "%".$filterData['FIND']."%";
}

$APPLICATION->IncludeComponent('1cbit:crm.history.events', "",
    $componentParams,
    false,
    array('HIDE_ICONS' => 'Y', 'ACTIVE_COMPONENT'=>'Y')
);

require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');
die();



