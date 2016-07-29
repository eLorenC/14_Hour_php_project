<?php

    require_once('../app/core/init.php');

    if (isset($_POST['ccn'])) {


        $db->prep("UPDATE `UserAcct` SET `CardNumber`= :value1, `CardExp`= :value2, `CardSec`= :value3  WHERE `AcctID` = :value4");
        $db->bind(":value1", $_POST['ccn']);
        $db->bind(":value2", $_POST['cce']);
        $db->bind(":value3", $_POST['ccs']);
        $db->bind(":value4", $_SESSION['Shopper']['AcctID']);
        $result = $db->runQuery();

        $_SESSION['Shopper']['CardNumber'] = $_POST['ccn'];
        $_SESSION['Shopper']['CardExp'] = $_POST['cce'];
        $_SESSION['Shopper']['CardSec'] = $_POST['ccs'];

        echo json_encode(["resp" => "true"]);
        //echo json_encode(array("resp" => "true"));

    }