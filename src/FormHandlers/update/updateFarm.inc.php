<?php
/**
 * 
 * Create Farm Form Handler
 */

    if (isset($_POST["update-farm"])) {
        $farmId = $_POST["farm-id"];
        $newFarmName = $_POST["farm-name"];
        $newFarmLocation = $_POST["farm-location"];
     

        include_once '../../../config/db.php';
        include_once '../../Models/Farm.class.php';

        $farm = new Farm();
        $farm->updateFarmInfo($farmId, $newFarmName, $newFarmLocation);

        $farm = null;
        unset($farm);
        header("location: ../../../public/userPanel.php?dest=farmC&msg=farmupdated");
        exit();
    }
    else {
        header("location: ../../../public/userPanel.php#farmC?error=invalidaccess");
        exit();
    }
?>