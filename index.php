<?php
    include_once 'PRIVATE.php';

    require __DIR__ . '/vendor/autoload.php';

    $api = new RestClient([
        'base_url' => "https://api.teller.io",
        'headers' => ['Authorization' => 'Bearer '.$api_key],
    ]);

    $result = $api->get('/accounts/'.$account_info.'/transactions');

    var_dump($result);

    echo "<ul>";
    foreach ($result as $key => $value) {
        echo "<li>".$value->amount.' '.$value->counterparty.' '.$value->date."</li>";
    }
    echo "</ul>";
?>