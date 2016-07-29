<?php
    require_once('../app/core/init.php');

    if (isset($_POST)) {

        $UserName = filter_input(INPUT_POST, 'UserName', FILTER_SANITIZE_STRING);
        $Password = $_POST['Password'];

        $signin = $auth->signin(array(
            "UserName" => $UserName,
            "Password" => $Password
        ));

        if ($signin) {
            $_SESSION['ADMIN_USER'] = array("Role => 1");
            header('Location: index.php');
        }
        else {
            header('Location: index.php');
        }

    }