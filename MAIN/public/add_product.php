<?php
    require_once('../app/core/init.php');

    if (isset($_POST['ProductID'])) {

        $qty = (isset($_POST['qty'])===true)? $_POST['qty'] : 1;

        $db->prep("SELECT * FROM `products` WHERE `ProductID` = :value");
        $db->bind(":value", $_POST['ProductID']);
        $result = $db->runQuery()->getFirst();

        if (isset($result) && $result['Inventory'] >= $qty) {
            $addProduct = array(
                "ProductID" => $result['ProductID'],
                "Name" => $result['Name'],
                "Description" => $result['Description'],
                "Price" => $result['Price'],
                "Quantity" => $qty
            );

            $updateInventory = ($result['Inventory'] - $qty);

            $db->prep("UPDATE `products` SET `Inventory` = :value WHERE `ProductID` = :value1");
            $db->bind(":value", $updateInventory);
            $db->bind(":value1", $_POST['ProductID']);
            $db->runQuery();

        }

        $inCart = false;

        if (isset($_SESSION['CART'])===true) {
            if (count($_SESSION['CART'])>0) {
                for($i=0; $i<count($_SESSION['CART']); $i++) {
                    if($_SESSION['CART'][$i]['ProductID'] == $_POST['ProductID']) {
                        $_SESSION['CART'][$i]['Quantity'] += $qty;
                        $inCart = true;
                        break;
                    }
                }

                if (!$inCart) {
                    $_SESSION['CART'][] = $addProduct;
                }

            }
            else {
                $_SESSION['CART'][] = $addProduct;
            }
        }

        $_POST = array();
        unset($qty);

            echo json_encode(array("resp" => "true"));
    }