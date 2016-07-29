<?php

    require_once('../app/core/init.php');

    if (isset($_POST['ProductID']))
    {

        $db->prep("UPDATE `products` SET `Inventory` = :value WHERE `ProductID` = :value1");
        $db->bind(":value", $_POST['Inventory']);
        $db->bind(":value1", $_POST['ProductID']);

    }

    $result = $db->runQuery();

    $_POST = array();

    echo json_encode(array("resp" => "true"));
