<?php

/**
 * 
 * Update Sheep Local Id Form Handler
 */

    if (isset($_POST["update-local-id"])) {
        $sheepId = $_POST["sheep-id"];
        $localId = $_POST["new-local-id"];

        include_once '../../../config/db.php';
        include_once '../../Models/Sheep.class.php';
        
        
        $sheep = new Sheep();
        $sheep->updateSheepLocalId($sheepId, $localId);

        $sheep = null;
        unset($sheep);

        header("location: ../../../public/userPanel.php?dest=sheepRegC&msg=localidupdated");
        exit();
    }
    else {
        header("location: ../../../public/userPanel.php?error=invalidaccess");
        exit();
    }
?>