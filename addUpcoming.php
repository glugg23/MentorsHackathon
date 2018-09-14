<?php
    include_once 'PRIVATE.php';

    require __DIR__ . '/vendor/autoload.php';

    $pdo = new PDO("mysql:host=".$host.";dbname=".$dbname, $username, $password);
    $fluent = new FluentPDO($pdo);

    $values = array('amount' => $_POST['amount'], 'description' => $_POST['description'], 'date' => $_POST['date']);

    $query = $fluent->insertInto('upcoming', $values)->execute();

    header('Location: https://buffr.jbarrow.me/index.php');
    exit;
?>