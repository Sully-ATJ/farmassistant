<?php

/**
 * 
 * Delete Sales Record for Cow Form Handler
 */

    if (isset($_POST["delete-farm"])) {
        $farmName = $_POST["farm-name"];
        $farmLocation = $_POST["farm-location"];
        
    
        include_once '../../../config/db.php';
        include_once '../../Models/Farm.class.php';
        
        
        $farm = new Farm();
        $farm->deleteFarm($farmName, $farmLocation);

        $farm = null;
        unset($farm);

        header("location: ../../../public/userPanel.php?dest=farmC&msg=farmdeleted");
        exit();
    }
    else {
        header("location: ../../../public/userPanel.php?error=invalidaccess");
        exit();
    }
?>