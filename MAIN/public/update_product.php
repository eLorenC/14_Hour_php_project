<?php
    require_once('../app/core/init.php');

    if (isset($_POST['ProductID'])) {

        if (isset($_SESSION['CART'])===true) {

            if (count($_SESSION['CART'])>0) {

                for($i=0; $i<count($_SESSION['CART']); $i++) {

                    if($_SESSION['CART'][$i]['ProductID'] == $_POST['ProductID']) {

                        if ($_POST['Quantity']==0) {

                            $addBack = $_SESSION['CART'][$i]['Quantity'];
                            unset($_SESSION['CART'][$i]);
                            $_SESSION['CART'] = array_values($_SESSION['CART']);

                        } elseif ($_SESSION['CART'][$i]['Quantity'] > $_POST['Quantity']) {

                            $addDifference = ($_SESSION['CART'][$i]['Quantity'] - $_POST['Quantity']);
                            $_SESSION['CART'][$i]['Quantity'] = $_POST['Quantity'];

                        } elseif ($_SESSION['CART'][$i]['Quantity'] < $_POST['Quantity']) {

                            $subDifference = ($_POST['Quantity'] - $_SESSION['CART'][$i]['Quantity']);
                            $_SESSION['CART'][$i]['Quantity'] = $_POST['Quantity'];
                        }
                        break;
                    }
                }
            }
        }

        if(isset($addBack)) {
            $db->prep("UPDATE `products` SET `Inventory` = (`Inventory` + :value) WHERE `ProductID` = :value1");
            $db->bind(":value", $addBack);
            $db->bind(":value1", $_POST['ProductID']);
        } elseif ($addDifference) {
            $db->prep("UPDATE `products` SET `Inventory` = (`Inventory` + :value) WHERE `ProductID` = :value1");
            $db->bind(":value", $addDifference);
            $db->bind(":value1", $_POST['ProductID']);
        } elseif ($subDifference) {
            $db->prep("UPDATE `products` SET `Inventory` = (`Inventory` - :value) WHERE `ProductID` = :value1");
            $db->bind(":value", $subDifference);
            $db->bind(":value1", $_POST['ProductID']);
        }

        $result = $db->runQuery();

        $_POST = array();
        unset($qty);

        echo json_encode(array("resp" => "true"));
    }