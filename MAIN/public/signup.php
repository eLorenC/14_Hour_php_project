<?php
    /**
     * Created by PhpStorm.
     * User: ericl_000
     * Date: 5/10/2016
     * Time: 10:54 PM
     */

    require_once('../app/core/init.php');

    if (isset($_POST)) {

        $FName = filter_input(INPUT_POST, 'FName', FILTER_SANITIZE_STRING);
        $LName = filter_input(INPUT_POST, 'LName', FILTER_SANITIZE_STRING);

        $UserName = filter_input(INPUT_POST, 'UserName', FILTER_SANITIZE_STRING);
        $Password = $_POST['Password'];

        $EMail = $_POST['EMail'];

        $data = array(
            "FName" => $FName,
            "LName" => $LName,
            "UserName" => $UserName,
            "Password" => $Password,
            "EMail" => $EMail
        );


        $signup = $auth->createUserAccount($data);

        if($signup) {
            header('Location: index.php');
        }

    }