<?php
    include_once 'PRIVATE.php';

    require __DIR__ . '/vendor/autoload.php';

    $pdo = new PDO("mysql:host=".$host.";dbname=".$dbname, $username, $password);
    $fluent = new FluentPDO($pdo);

    var_dump($_POST);
?>