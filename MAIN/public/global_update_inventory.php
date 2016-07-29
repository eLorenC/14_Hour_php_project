<?php

    require_once('../app/core/init.php');

    if (isset($_POST)) {
        $file_name = $_FILES['ImagePath']['name'];
        $file_size = $_FILES['ImagePath']['size'];
        $file_tmp  = $_FILES['ImagePath']['tmp_name'];
        $file_type = $_FILES['ImagePath']['type'];
        $file_ext  = substr($file_name, strrpos($file_name, '.'));

        // Add as many extensions as you would like
        switch (strtolower($_FILES['ImagePath']['type'])) {
            //allowed file types
            case 'image/png':                           // png image file
            case 'image/gif':                           // gif image file
            case 'image/jpeg':                          // jpeg image file
            case 'image/jpg':                           // jpeg image file
            case 'text/plain':                          // plain text file
            case 'text/html':                           // html file
            case 'application/x-zip-compressed':        // zipped || compressed file
            case 'application/pdf':                     // pdf (xml)
            case 'application/msword':
            case 'application/vnd.ms-excel':
            case 'video/mp4':
                break;
            default:
                die('Unsupported File!'); //output error
        }

        try {

            $db_file = array("name" =>  $file_name, "type" => $file_type, "filename" => "uploads/" . $file_name);

            try {

                $db->prep("INSERT INTO `products`(`Name`,`Description`,`Inventory`, `Price`, `ImagePath`) VALUES(:value, :value1, :value2, :value3, :value4)");
                $db->bind(":value",  $_POST['Name']);
                $db->bind(":value1", $_POST['Description']);
                $db->bind(":value2", $_POST['Inventory']);
                $db->bind(":value3", $_POST['Price']);
                $db->bind(":value4", $db_file['filename']);
                $result = $db->runQuery();

            } catch (Exception $error) {
                $file_error_log = fopen("../../log/log.txt", "w") or die("Unable to open file");
                $log_text = "\n" . date("H:i:s Y-m-d") . "///" . $error->getLine() . "///" . $error->getMessage() . "///" . $error->getTraceAsString() . "||| \n";

                fwrite($file_error_log, $log_text);
                fclose($file_error_log);
            }


            move_uploaded_file($file_tmp, "uploads/" . $file_name);

        } catch (Exception $error) {
            $file_error_log = fopen("../../log/log.txt", "w") or die("Unable to open file");
            $log_text = "\n" . date("H:i:s Y-m-d") . "///" . $error->getLine() . "///" . $error->getMessage() . "///" . $error->getTraceAsString() . "||| \n";

            fwrite($file_error_log, $log_text);
            fclose($file_error_log);
        }
    }

    echo true;