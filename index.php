<?php
    include_once 'PRIVATE.php';

    require __DIR__ . '/vendor/autoload.php';

    $api = new RestClient([
        'base_url' => "https://api.teller.io",
        'format' => "json",
        'headers' => ['Authorization' => 'Bearer '.$api_key]
    ]);

    $result = $api->get('/accounts/'.$account_info.'/transactions');

    var_dump($result);
?>