<?php

/**
 * 
 * Update Sheep Status Form Handler
 */

    if (isset($_POST["update-status"])) {
        $sheepId = $_POST["sheep-id"];
        $status = $_POST["new-status"]; 

        include_once '../../../config/db.php';
        include_once '../../Models/Sheep.class.php';
        
        
        $sheep = new Sheep();
        $sheep->updateSheepStatus($sheepId, $status);

        $sheep = null;
        unset($sheep);

        header("location: ../../../public/userPanel.php?dest=sheepRegC&msg=statusupdated");
        exit();
    }
    else {
        header("location: ../../../public/userPanel.php?error=invalidaccess");
        exit();
    }
?>