<?php
namespace  CalendarApp;

class CalendarApp {


    function getCalendar() {

        $queryUrl = 'http://'.$_SERVER['SERVER_NAME']. '/local/index.php';

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

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /// WORKING WITH ENTITIES
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    /**
     * base function
     * @return array
     */
    private function getEntity($entityName) {

        $queryUrl = 'https://'.$_SERVER['SERVER_NAME']. '/rest/entity.item.get.json';

        $queryData = http_build_query([
                "ENTITY" => $entityName,
                "auth" => $_REQUEST['AUTH_ID']
            ]
        );

        return $this->postURL($queryUrl, $queryData);
    }


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /// ADDITIONAL FUNCTIONS
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function postURL ($queryUrl, $queryData) {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $queryUrl,
            CURLOPT_POSTFIELDS => $queryData,
        ));

        $result = json_decode(curl_exec($curl), true);

        curl_close($curl);

        return $result;

    }

}