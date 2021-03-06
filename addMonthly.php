<?php
    include_once 'PRIVATE.php';

    require __DIR__ . '/vendor/autoload.php';

    $pdo = new PDO("mysql:host=".$host.";dbname=".$dbname, $username, $password);
    $fluent = new FluentPDO($pdo);

    $values = array('amount' => $_POST['amount'], 'description' => $_POST['name'], 'date' => $_POST['day']);

    $query = $fluent->insertInto('monthly', $values)->execute();

    header('Location: https://buffr.jbarrow.me/settings.php');
    exit;
?>