<?php

/**
 * 
 * Update Sheep Gov Id Form Handler
 */

    if (isset($_POST["update-gov-id"])) {
        $sheepId = $_POST["sheep-id"];
        $govId = $_POST["new-gov-id"];

        include_once '../../../config/db.php';
        include_once '../../Models/Sheep.class.php';
        
        $sheep = new Sheep();
        $sheep->updateSheepGovId($sheepId, $govId);

        $sheep = null;
        unset($sheep);

        header("location: ../../../public/userPanel.php?dest=sheepRegC&msg=govidupdated");
        exit();
    }
    else {
        header("location: ../../../public/userPanel.php?error=invalidaccess");
        exit();
    }
?>