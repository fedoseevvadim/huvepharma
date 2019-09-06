<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


    <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" type="text/css"  rel="stylesheet" >

    <style>

        table.dataTable thead th, table.dataTable thead td {
            padding: 10px 18px;
            border-bottom: 0px solid #111;

        }

        table.dataTable thead .sorting, table.dataTable thead .sorting_asc, table.dataTable thead .sorting_desc, table.dataTable thead .sorting_asc_disabled, table.dataTable thead .sorting_desc_disabled {
            cursor: pointer;
            *cursor: hand;
            background-repeat: no-repeat;
            background-position: center left;
        }

        table.dataTable tbody th, table.dataTable tbody td {
            padding: 8px 18px;
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
</head>
<?
use Bitrix\Main\Application;

function getCalendar($ID, $ORDER = "DESC", $BY = "DATE_FROM") {

    $queryUrl = 'http://'.$_SERVER['SERVER_NAME']. '/local/task/get_task.php?ID='.$ID."&ORDER=".$ORDER."&BY=".$BY;

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $queryUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    return $response;
}

function getBXGrid() {

    $queryUrl = 'http://'.$_SERVER['SERVER_NAME']. '/local/task/history.ajax.php';

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $queryUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    return $response;
}


$placementOptions = $_REQUEST['PLACEMENT_OPTIONS'];
$placementType = htmlspecialchars($_REQUEST['PLACEMENT']);
$placementOptions = json_decode($placementOptions, true);


$isEditMode = (($placementType != 'USERFIELD_TYPE') || ($placementOptions['MODE'] == 'edit')) ? 1 : 0;

$bgColor = $placementType == 'USERFIELD_TYPE'
	? (
	$placementOptions['MODE'] == 'edit'
		? 'white'
		: '#f9fafb'
	)
	: '#ffffff'
?>
<body style="padding: 10px;background-color: <?=$bgColor?>">
<?
require_once('tools.php');

$domain = htmlspecialchars($_REQUEST['DOMAIN']);
$accessToken = htmlspecialchars($_REQUEST['AUTH_ID']);

//echo "<pre>request: "; print_r($_REQUEST); echo "</pre>";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// История визитов
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if( $_REQUEST['action'] == 'COMPANY_HISTORY_VISITS' ):

    $ID = $placementOptions["ID"];

    $arrData = getCalendar($ID);
    $arrData = json_decode($arrData, true);

    if ( count($arrData) > 0 ) {
        ?>
        <table id="example" class="display">
            <thead class="main-grid-header">
            <tr>
                <th scope="col">Название встречи</th>
                <th scope="col">Дата встречи</th>
                <th scope="col">Фамилия, Имя</th>
            </tr>
            <tr>
                <th data-orderable="false" scope="col">Название встречи</th>
                <th data-orderable="false" scope="col">Дата встречи</th>
                <th data-orderable="false" scope="col">Фамилия, Имя</th>
            </tr>
            </thead>
            <tbody>

            <?
            foreach ($arrData as $data) {
                ?>
                <tr>
                    <td class="span_txt">
                        <?= $data["NAME"] ?>
                    </td>
                    <td scope="row">
                        <?= $data["DATE_FROM"] ?>
                    </td>
                    <td>
                        <?= $data["USER_NAME"] . " " . $data["USER_LAST_NAME"] ?>
                    </td>

                </tr>
                <?
            }
            ?>

            </tbody>
        </table>
        <?
    }
?>
<? endif; ?>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>-->
<script src="//api.bitrix24.com/api/v1/dev/"></script>

<script src="/local/history_visits/js/js.js"></script>

<script>
	function fitHeight()
	{
		BX24.resizeWindow(document.body.clientWidth,
			document.getElementsByClassName("workarea")[0].clientHeight);
	}

	BX24.init(function()
	{
		//set value
		var editMode = <?echo $isEditMode;?>;

		if(editMode)
		{
			BX24.placement.call('setValue', 'dummy-value', function()
			{
				console.log('value is set');
			});
		}

	});

	function getRandomInt(min, max)
	{
		return Math.floor(Math.random() * (max - min + 1)) + min;
	}


</script>

</body>
</html>