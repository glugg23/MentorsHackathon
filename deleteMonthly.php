<?php
    include_once 'PRIVATE.php';

    require __DIR__ . '/vendor/autoload.php';

    $pdo = new PDO("mysql:host=".$host.";dbname=".$dbname, $username, $password);
    $fluent = new FluentPDO($pdo);

    $query = $fluent->deleteFrom('monthly', $_GET['id'])->execute();

    header('Location: https://buffr.jbarrow.me/settings.php');
    exit;
?>