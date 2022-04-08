<?php
    spl_autoload_register('myAutoLoader');

    function myAutoLoader($className){
        $path = "../src/Models/";
        $extension = ".class.php";
        $fileName = $path . $className . $extension;

        if (!file_exists($fileName)) {
            echo "error1234";
            return false;
        }

        include_once $path . $className . $extension;
    }
?>