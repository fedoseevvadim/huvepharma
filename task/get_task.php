<?

use Bitrix\Main\Application;

define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS",true);
define("BX_CRONTAB", true);
define('BX_WITH_ON_AFTER_EPILOG', true);
define('BX_NO_ACCELERATOR_RESET', true);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$connection = Application::getConnection();

$ID     = (int) $_GET["ID"];
$BY     = $_GET["BY"];
$ORDER  = $_GET["ORDER"];

switch ($BY) {

  case "USER_NAME":
    $BY = "u.NAME";
    break;

  case "USER_LAST_NAME":
    $BY = "u.LAST_NAME";
    break;

  case "DATE_FROM":
    $BY = "ce.DATE_FROM";
    break;

  default:
    $BY = "ce.".$BY;
}

$sql = "
        SELECT uce.*, ce.*, u.NAME as USER_NAME, u.LAST_NAME as USER_LAST_NAME
        FROM b_utm_calendar_event as uce
        LEFT JOIN b_calendar_event as ce ON uce.VALUE_ID = ce.ID
        LEFT JOIN b_user as u ON ce.OWNER_ID = u.ID
        WHERE uce.VALUE = 'CO_$ID'
        ORDER BY $BY $ORDER
";


$recordset = $connection->query($sql);

while ($record = $recordset->fetch()) {

  $arrVals["ID"]              = $record["ID"];
  $arrVals["NAME"]            = $record["NAME"];
  $arrVals["USER_NAME"]       = $record["USER_NAME"];
  $arrVals["USER_LAST_NAME"]  = $record["USER_LAST_NAME"];
  $arrVals["DATE_FROM"]       = $record["DATE_FROM"]->toString();
  $arrVals["DATE_TO"]         = $record["DATE_TO"]->toString();

  $arr[] = $arrVals;
}

echo json_encode($arr);

?>

