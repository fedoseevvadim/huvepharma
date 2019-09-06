<?php
global $PLACEMENTS, $USERFIELDS;

$host = $_SERVER['HTTP_HOST'];
$protocol = $_SERVER['SERVER_PORT'] == 443 ? 'https' : 'http';

$PLACEMENTS = array(
	'COMPANY_HISTORY_VISITS' => array(
		'PLACEMENT' => 'CRM_COMPANY_DETAIL_TAB',
		'HANDLER' => $protocol.'://'.$host.'/local/history_visits/handler.php?action=COMPANY_HISTORY_VISITS',
		'TITLE' => 'История визитов',
		'DESCRIPTION' => 'История визитов в карточке компании'
	),
);


function executeREST($method, array $params, $domain, $accessToken)
{
	$queryUrl = 'http://'.$domain.'/rest/'.$method.'.json';

	$queryData = http_build_query(
		array_merge($params, array("auth" => $accessToken))
	);

	$curl = curl_init($queryUrl);
	curl_setopt_array($curl, array(
		// CURLOPT_SSL_VERIFYPEER => 0,
		CURLOPT_POST => 1,
		//CURLOPT_HEADER => 0,
		CURLOPT_RETURNTRANSFER => 1,
		//CURLOPT_URL => $queryUrl,
		CURLOPT_POSTFIELDS => $queryData,
	));

	// echo '<br/><br/>'.$queryUrl.'?'.$queryData;
	$result = curl_exec($curl);

	// echo 'rest result: ';var_dump($result);
	curl_close($curl);

	return json_decode($result, true);

}

function execute($method, array $params, $domain, $accessToken) {

    $queryUrl = 'http://'.$domain.'/rest/'.$method.'';

    $queryData = http_build_query(
        array_merge($params, array("auth" => $accessToken))
    );

    $curl = curl_init($queryUrl);
    curl_setopt_array($curl, array(
        // CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_POST => 1,
        //CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => 1,
        //CURLOPT_URL => $queryUrl,
        CURLOPT_POSTFIELDS => $queryData,
    ));

    $result = curl_exec($curl);

    curl_close($curl);

    return json_decode($result, true);
}