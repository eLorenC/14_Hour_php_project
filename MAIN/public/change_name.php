<?php

    require_once('../app/core/init.php');

    if (isset($_POST['fname'])) {


        $db->prep("UPDATE `UserAcct` SET `FName`= :value1, `LName`= :value2, `UserName`= :value3 WHERE `AcctID` = :value4");
        $db->bind(":value1", $_POST['fname']);
        $db->bind(":value2", $_POST['lname']);
        $db->bind(":value3", $_POST['uname']);
        $db->bind(":value4", $_SESSION['Shopper']['AcctID']);
        $result = $db->runQuery();

        $_SESSION['Shopper']['FName'] = $_POST['fname'];
        $_SESSION['Shopper']['LName'] = $_POST['lname'];
        $_SESSION['Shopper']['UserName'] = $_POST['uname'];

        echo json_encode(["resp" => "true"]);
        //echo json_encode(array("resp" => "true"));

    }