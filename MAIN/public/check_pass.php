<?php
    /**
     * Created by PhpStorm.
     * User: ericl_000
     * Date: 5/11/2016
     * Time: 7:47 PM
     */

    require_once('../app/core/init.php');

    if (isset($_POST['pass'])) {

        $db->prep("SELECT `Password` FROM `UserAcct` WHERE `AcctID` = :value");
        $db->bind(":value", $_SESSION['Shopper']['AcctID']);
        $result = $db->runQuery()->getFirst();

        if($hash->hashCheck($_POST['pass'], $result['Password'])) {
            echo json_encode(array("resp" => "true"));
        } else {
            echo json_encode(array("resp" => "false"));
        }

    }