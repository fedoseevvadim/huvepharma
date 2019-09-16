<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="css/app.css">
	<title>Настройки - История Встреч</title>
</head>
<body>

<?
include('tools.php');

$domain = htmlspecialchars($_REQUEST['DOMAIN']);
$accessToken = htmlspecialchars($_REQUEST['AUTH_ID']);

global $PLACEMENTS, $USERFIELDS;

if ( isset ( $_POST["PLACEMENT_OPTIONS"] ) ) {

    $Options    = json_decode($_POST["PLACEMENT_OPTIONS"]);
    $arrOptions = (array) $Options;


?>

 <?


} else {


    if(isset($_REQUEST['save']))  {

        // remove existed handlers
        $batch = array();
        $call = 0;
        foreach($PLACEMENTS as $placementCode => $placement)
        {
            $batch['exec_'.$call] =
                'placement.unbind?'.http_build_query(array(
                    'PLACEMENT' => $placement['PLACEMENT'],
                    'HANDLER' => $placement['HANDLER'],
                ));

            $call++;
        }


        // set marked placements
        if(isset($_REQUEST['placements']))
        {
            $submitPlacements = $_REQUEST['placements'];

            foreach($PLACEMENTS as $placementCode => $placement)
            {
                if(in_array($placementCode, $submitPlacements))
                {
                    $batch['exec_'.$call] =
                        'placement.bind?'.http_build_query([
                            'PLACEMENT' => $placement['PLACEMENT'],
                            'HANDLER' => $placement['HANDLER'],
                        ]);

                    $methosd[$call] = "placement.bind";

                        $call++;
                }
            }
        }

        // set marked fields

        $submitFields = $_REQUEST['userfields'];

        foreach($USERFIELDS as $userFieldTypeCode => $userFieldType)
        {
            if(in_array($userFieldTypeCode, $submitFields))
            {
                $userField = array(
                    'USER_TYPE_ID' => $userFieldType['USER_TYPE_ID'],
                    'HANDLER' => $userFieldType['HANDLER'],
                    'TITLE' => $userFieldType['TITLE'],
                    'DESCRIPTION' => $userFieldType['DESCRIPTION'],
                );

                $batch['exec_'.($call++)] = 'userfieldtype.add?'.http_build_query($userField);

                $userField = array(
                    'FIELDS' => array(
                        'FIELD_NAME' => $userFieldType['USER_FIELD_NAME'],
                        'EDIT_FORM_LABEL' => $userFieldType['EDIT_FORM_LABEL'],
                        'USER_TYPE_ID' => $userFieldType['USER_TYPE_ID'],
                    )
                );

                $batch['exec_'.($call++)] = 'crm.contact.userfield.add?'.http_build_query($userField);
                $batch['exec_'.($call++)] = 'crm.company.userfield.add?'.http_build_query($userField);
                        }
            else
            {
                $userField = array('USER_TYPE_ID' => $userFieldType['USER_TYPE_ID']);
                $batch['exec_'.($call++)] = 'userfieldtype.delete?'.http_build_query($userField);
            }
        }


        // echo "<pre>batch: "; print_r($batch); echo "</pre>";
    //    $batchResult = executeREST (
    //                                    'placement.bind?',
    //                                    [
    //                                            "PLACEMENT" => "CRM_COMPANY_DETAIL_ACTIVITY",
    //                                            "HANDLER" =>
    //                                        ],
    //                                    $domain,
    //                                    $accessToken
    //                                );

        // https://localhost/rest/placement.bind?PLACEMENT=CRM_COMPANY_DETAIL_ACTIVITY&HANDLER=https://f-vv.ru/embedded24/handler.php?action=COMPANY_CREATE_ORDER&auth=3565665d003f89b2003f7960000000017062034d253767b0c04e65049f935f796f1e79

        $batchResult = executeREST('batch', array('cmd' => $batch), $domain, $accessToken);

        // echo "<pre>batch result: "; print_r($result); echo "</pre>";

    }

    $activeUserFields = array();

    $activePlacements = array();

    // get current placement handlers
    $handlers = executeREST('placement.get', array(), $domain, $accessToken);
    // echo "<pre>handlers: "; print_r($result['result']); echo "</pre>";

    foreach($handlers['result'] as $handler)
    {
        if(preg_match('/=[A-Z_]+/', $handler['handler'], $matches))
        {
            $activePlacements[] = substr($matches[0], 1, strlen($matches[0]) - 1);
        }
    }

    // get current user-fields
    foreach($USERFIELDS as $userFieldTypeCode => $userFieldType)
    {

        $result = executeREST('userfieldtype.list', array(), $domain, $accessToken);

        // search for our user field type
        foreach($result['result'] as $resutFieldType)
        {
            if($resutFieldType['USER_TYPE_ID'] == $userFieldType['USER_TYPE_ID'])
            {
                $activeUserFields[] = $userFieldTypeCode;
            }
        }

    }

    /*
    echo "<pre>request: "; print_r($_REQUEST); echo "</pre>";
    echo "<pre>active placements: "; print_r($activePlacements); echo "</pre>";
    echo "<pre>active fields: "; print_r($activeUserFields); echo "</pre>";
    */

    ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                <form method="post">
                    <?
                    foreach($PLACEMENTS as $placementCode => $placement)
                    {
                        ?>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="placements[]" value="<?=$placementCode;?>"
                                    <?
                                    if(in_array($placementCode, $activePlacements)): ?>checked<?
                                endif ?>>
                                <strong><?=$placement['TITLE'];?></strong> <i><?=$placement['DESCRIPTION'];?></i>
                            </label>
                        </div>
                        <?
                    }
                    ?>

                    <?
                    foreach($USERFIELDS as $userTypeCode => $userType)
                    {
                        ?>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="userfields[]" value="<?=$userTypeCode;?>"
                                    <?
                                    if(in_array($userTypeCode, $activeUserFields)): ?>checked<?
                                endif ?>>
                                <strong><?=$userType['TITLE'];?></strong> <i><?=$userType['DESCRIPTION'];?></i>
                            </label>
                        </div>
                        <?
                    }
                    ?>

                    <input type="hidden" name="save" value="Y">
                    <input type="hidden" name="DOMAIN" value="<?=$domain;?>">
                    <input type="hidden" name="AUTH_ID" value="<?=$accessToken;?>">
                    <input type="submit" class="btn btn-primary btn-lg" value="Сохранить">
                </form>
            </div>
        </div>

        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <? if(isset($_REQUEST['save'])): ?>
                            <li>
                                <a class="btn" role="button" data-toggle="collapse" href="#batch" aria-expanded="false" aria-controls="batch">Batch</a>
                            </li>
                            <li>
                                <a class="btn" role="button" data-toggle="collapse" href="#batch-result" aria-expanded="false" aria-controls="batch-result">Batch Result</a>
                            </li>
                        <? endif; ?>
                        <li>
                            <a class="btn" role="button" data-toggle="collapse" href="#handlers" aria-expanded="false" aria-controls="handlers">Handlers</a>
                        </li>
                        <li>
                            <a class="btn" role="button" data-toggle="collapse" href="#active-placements" aria-expanded="false" aria-controls="active-placements">Active Placements</a>
                        </li>
                        <li>
                            <a class="btn" role="button" data-toggle="collapse" href="#active-types" aria-expanded="false" aria-controls="active-types">Active Types</a>
                        </li>
                        <li>
                            <a class="btn" role="button" data-toggle="collapse" href="#request" aria-expanded="false" aria-controls="request">Request</a>
                        </li>

                    </ul>
                </div><!-- /.navbar-collapse -->

                <? if(isset($_REQUEST['save'])): ?>
                    <div class="collapse" id="batch">
                        <div class="well">
                            <? echo "<pre>batch: ";
                            print_r($batch);
                            echo "</pre>"; ?>
                        </div>
                    </div>

                    <div class="collapse" id="batch-result">
                        <div class="well">
                            <? echo "<pre>batch result: ";
                            print_r($batchResult);
                            echo "</pre>"; ?>
                        </div>
                    </div>
                <? endif; ?>

                <div class="collapse" id="handlers">
                    <div class="well">
                        <? echo "<pre>handlers: ";
                        print_r($handlers);
                        echo "</pre>"; ?>
                    </div>
                </div>

                <div class="collapse" id="active-placements">
                    <div class="well">
                        <? echo "<pre>active placements: ";
                        print_r($activePlacements);
                        echo "</pre>"; ?>
                    </div>
                </div>

                <div class="collapse" id="active-types">
                    <div class="well">
                        <? echo "<pre>active types: ";
                        print_r($activeUserFields);
                        echo "</pre>"; ?>
                    </div>
                </div>

                <div class="collapse" id="request">
                    <div class="well">
                        <? echo "<pre>request: ";
                        print_r($_REQUEST);
                        echo "</pre>"; ?>
                    </div>
                </div>

            </div><!-- /.container-fluid -->
        </nav>

    </div>
<?
}
?>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="//api.bitrix24.com/api/v1/dev/"></script>

<script>
	BX24.init(function()
	{
		var size = BX24.getScrollSize();
		BX24.resizeWindow(size.scrollWidth, 1200);
		console.log(size);
	});

	$('.navbar-nav').find('a').on('click', function()
	{
		$(this).toggleClass('active');
	})


    BX.ajax({
        'url': '/bitrix/components/bitrix/crm.activity.editor/ajax.php?siteID=s1&sessid='+SESSION+'&id='+ID+'&action=get_activity',
        'method': 'POST',
        'dataType': 'json',
        'data':
            {
                'ACTION' : 'GET_ACTIVITY',
                'ID': ID,
            },
        onsuccess: BX.delegate(
            function(data)
            {
                if(typeof(data['ACTIVITY']) !== 'undefined')
                {
                    this._handleActivityChange(data['ACTIVITY']);
                    this.openActivityDialog(BX.CrmDialogMode.view, id, options, null);
                }
            },
            this
        ),
        onfailure: function(data){}
    });


</script>

</body>
</html>