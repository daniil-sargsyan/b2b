<?php

$id = 6;


$deal_params = [
    'select' => [
        'UF_CRM_1659963517898', /* Откуда */
        'UF_CRM_1659963537984', /* Куда */
        'UF_CRM_1659963576680'], /* Тип транспорта */
    'filter' => ['=ID' => $id]

];

$deal_params_query = http_build_query($deal_params);


$deal_curl = curl_init();

curl_setopt_array($deal_curl, array(
    CURLOPT_URL => 'https://b24-7kcrzr.bitrix24.ru/rest/1/eehyd320mxj6y28v/crm.deal.list?' . $deal_params_query . '.json',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Cookie: BITRIX_SM_SALE_UID=0; qmb=.'
    ),
));

$deal_response = curl_exec($deal_curl);

curl_close($deal_curl);


$decode_deal = json_decode($deal_response)->result[0];



$deal_array =[
    $decode_deal->UF_CRM_1659963517898,
    $decode_deal->UF_CRM_1659963537984,
    $decode_deal->UF_CRM_1659963576680

];





function lower_case(array $arr):array {

    $new_arr = [] ;

    for ($i = 0; $i < count($arr); $i++) {
          $new_arr[]= mb_strtolower($arr[$i]);
    }

    return $new_arr;
}



echo '<pre>';

print_r($deal_array);

echo '</pre>';

//------------------------------------------------------------------------------------------
//выводит имена тех компаний которые имеют россылку на Whatsapp



$curl = curl_init();

$params = [

    'select' => [
        "UF_CRM_1659965411351",
        "UF_CRM_1659965425775",
        "UF_CRM_1659965521229",
        "UF_CRM_1659965568708",
        "UF_CRM_1659965583885",
        "UF_CRM_1659965597789",
    ],

    'filter' => [

        '=UF_CRM_1659954437000' => 'Whatsapp'

    ]

];

$params_query = http_build_query($params);


curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://b24-7kcrzr.bitrix24.ru/rest/1/bupmhzya10jn20vc/crm.company.list?' . $params_query,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Cookie: BITRIX_SM_SALE_UID=0; qmb=.',
    ),
));


$response = curl_exec($curl);

curl_close($curl);


foreach (json_decode($response)->result as $key => $value) {

    $supply_array[$value->ID] = [

            [
                $value->UF_CRM_1659965411351,
                $value->UF_CRM_1659965425775,
                $value->UF_CRM_1659965521229
            ],

            [
                $value->UF_CRM_1659965568708,
                $value->UF_CRM_1659965583885,
                $value->UF_CRM_1659965597789
            ]
        ,
    ];

}



echo '<pre>';

print_r($supply_array);

echo '</pre>';




function search_company (array $deal_array, array $supply_array) {
    $companies_array = [];
    foreach ($supply_array as $id => $params) {
        for ($i = 0; $i < count($params) ; $i++){
            if(lower_case($deal_array) === lower_case($params[$i]) ){
                $companies_array[] = $id;
            }
        }
    }


    var_dump($companies_array);

}


search_company($deal_array, $supply_array);



