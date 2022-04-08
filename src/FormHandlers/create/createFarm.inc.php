<?php
/**
 * 
 * Create Farm Form Handler
 */

    if (isset($_POST["create-farm"])) {
        
        $farmName = $_POST["farm-name"];
        $farmLocation = $_POST["farm-location"];
        $id = $_POST["userId"];

        include_once '../../../config/db.php';
        include_once '../../Models/Farm.class.php';

        $farm = new Farm();
        $farm->createFarm($farmName, $farmLocation, $id);

        $farm = null;
        unset($farm);
        header("location: ../../../public/userPanel.php?dest=farmC&msg=farmadded");
        exit();
    }
    else {
        header("location: ../../public/userPanel.php#farmC?error=invalidaccess");
        exit();
    }
?>