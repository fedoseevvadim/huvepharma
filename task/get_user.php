<?

use Bitrix\Main\Application;

define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS",true);
define("BX_CRONTAB", true);
define('BX_WITH_ON_AFTER_EPILOG', true);
define('BX_NO_ACCELERATOR_RESET', true);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$connection = Application::getConnection();

$ID     =  filter_input(INPUT_GET, "BX_USER_ID");

if ( strlen($ID) > 0 ) {

    $sql = "
                SELECT * FROM b_user
                WHERE BX_USER_ID = '$ID'
            ";

    $recordset = $connection->query($sql);
    $session = bitrix_sessid();

    while ($record = $recordset->fetch()) {

        $arrVals["ID"] = $record["ID"];

        $arr[] = $arrVals;
    }

    echo json_encode($arr);

}
