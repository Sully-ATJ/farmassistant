<?php

/**
 * 
 * Update Sheep Info Form Handler
 */

    if (isset($_POST["update-info"])) {
        $sheepId = $_POST["sheep-id"];
        $localId = $_POST["new-local-id"];
        $govId = $_POST["new-gov-id"];
        $status = $_POST["new-status"];
        
        

        include_once '../../../config/db.php';
        include_once '../../Models/Sheep.class.php';
        
        
        $sheep = new sheep();
        $sheep->updateSheepInfo($sheepId, $localId, $govId, $status);

        $sheep = null;
        unset($sheep);

        header("location: ../../../public/userPanel.php?dest=sheepRegC");
        exit();
    }
    else {
        header("location: ../../../public/userPanel.php?error=invalidaccess");
        exit();
    }
?>