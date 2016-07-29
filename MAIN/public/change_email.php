<?php

    require_once('../app/core/init.php');

    if (isset($_POST['email'])) {

        $db->prep("UPDATE `UserAcct` SET `EMail` = :value WHERE `AcctID` = :value1");
        $db->bind(":value", $_POST['email']);
        $db->bind(":value1", $_SESSION['Shopper']['AcctID']);
        $result = $db->runQuery();

        $db->prep("SELECT `EMail` FROM `UserAcct` WHERE `AcctID` = :value");
        $db->bind(":value", $_SESSION['Shopper']['AcctID']);
        $result = $db->runQuery()->getFirst();

        if($_POST['email'] === $result['EMail']) {
            echo json_encode(array("resp" => "true", "uemail" => $result['EMail']));
        } else {
            echo json_encode(array("resp" => "false"));
        }
    }