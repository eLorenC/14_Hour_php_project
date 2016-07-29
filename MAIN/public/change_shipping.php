<?php

    require_once('../app/core/init.php');

    if (isset($_POST['ad'])) {


        $db->prep("UPDATE `UserAcct` SET `Address`= :value1, `Street`= :value2, `City`= :value3, `State`= :value4, `Zip`= :value5 WHERE `AcctID` = :value6");
        $db->bind(":value1", $_POST['ad']);
        $db->bind(":value2", $_POST['str']);
        $db->bind(":value3", $_POST['ci']);
        $db->bind(":value4", $_POST['st']);
        $db->bind(":value5", $_POST['zi']);
        $db->bind(":value6", $_SESSION['Shopper']['AcctID']);
        $result = $db->runQuery();

        $_SESSION['Shopper']['Address'] = $_POST['ad'];
        $_SESSION['Shopper']['Street'] = $_POST['str'];
        $_SESSION['Shopper']['City'] = $_POST['ci'];
        $_SESSION['Shopper']['State'] = $_POST['st'];
        $_SESSION['Shopper']['Zip'] = $_POST['zi'];

        echo json_encode(["resp" => "true"]);
        //echo json_encode(array("resp" => "true"));

    }