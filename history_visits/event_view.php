<?
require($_SERVER['DOCUMENT_ROOT'] . '/mobile/headers.php');
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
?>

<?$APPLICATION->IncludeComponent("1cbit:activity.calendar.list","",
    Array(
        "EVENT_ID" => $_REQUEST['event_id']
    ),false
);?>

<?require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php');?>


